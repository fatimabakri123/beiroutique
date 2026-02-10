<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orders as Order;
use App\Models\products as Product;
use App\Models\ReportIssue ;
use App\Notifications\NewProductReport;
use App\Models\ShopOwner;



class ReportController extends Controller
{
public function create($orderId, $productId)
{
    $order = Order::where('order_id', $orderId)
        ->where('customer_id', auth()->user()->customer->customer_id)
        ->firstOrFail();

    $product = Product::findOrFail($productId);

    return view('reports.create', compact('order', 'product'));
}



public function store(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,order_id',
        'product_id' => 'required|exists:products,product_id',
        'issue_type' => 'required|string',
        'description' => 'required|string',
    ]);

    // 1️⃣ Create the report
    $report = ReportIssue::create([
        'customer_id' => auth()->user()->customer->customer_id,
        'order_id' => $request->order_id,
        'product_id' => $request->product_id,
        'issue_type' => $request->issue_type,
        'description' => $request->description,
        'status' => 'Pending',
    ]);

    // 2️⃣ Fetch product with shop and owner relations
    $product = Product::with(['shop.owner.user'])->find($request->product_id);

    if ($product && $product->shop && $product->shop->owner && $product->shop->owner->user) {
        $ownerUser = $product->shop->owner->user;

        // 3️⃣ Prepare data for notification (include product name & image)
        $notificationData = [
            'type' => 'product_report',
            'report_id' => $report->id,
            'product_id' => $product->product_id,
            'product_name' => $product->product_name,
            'product_image' => $product->image_url ? asset('storage/' . $product->image_url) : null,
            'order_id' => $request->order_id,
            'issue_type' => $request->issue_type,
            'description' => $request->description,
            'customer_id' => auth()->user()->customer->customer_id,
            'message' => 'New issue reported for your product',
        ];

        // 4️⃣ Send Notification
        $ownerUser->notify(new \App\Notifications\NewProductReport($report));
    }

    return redirect()->route('customer.orders')->with('success', 'Report submitted successfully!');
}

}