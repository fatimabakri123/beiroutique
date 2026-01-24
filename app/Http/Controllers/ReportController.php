<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orders as Order;
use App\Models\products as Product;
use App\Models\ReportIssue as Report;

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
        'order_id' => 'required',
        'product_id' => 'required',
        'issue_type' => 'required',
        'description' => 'required',
    ]);

    \App\Models\ReportIssue::create([
        'customer_id' => auth()->user()->customer->customer_id,
        'order_id' => $request->order_id,
        'product_id' => $request->product_id,
        'issue_type' => $request->issue_type,
        'description' => $request->description,
        'status' => 'Pending',
    ]);

    return redirect()->route('customer.orders');

}

}
