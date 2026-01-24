<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Models\products;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SaleAppliedMail;
use App\Models\User;


class ShopController extends Controller
{
    public function updateShop(Request $request)
    {
        $shopOwner = Auth::user()->shopOwner;
        $shop = Shop::where('owner_id', $shopOwner->owner_id)->first();

        if (!$shop) {
            return response()->json(['success' => false, 'message' => 'Shop not found.']);
        }

        $shop->shop_name = $request->shop_name;
        $shop->description = $request->description;
        $shop->contact_email = $request->contact_email;
        $shop->contact_phone = $request->contact_phone;

        // If logo uploaded
        if ($request->hasFile('logo_url')) {
            $file = $request->file('logo_url');
            $path = $file->store('logos', 'public');
            $shop->logo_url = 'storage/' . $path;
        }

        $shop->save();

        return response()->json([
            'success' => true,
            'shop' => $shop
        ]);
    }

    
 public function applySale(Request $request)
{
    
    $user = auth()->user();
    $shopOwner = $user->shopOwner;

    if (!$shopOwner) {
        return response()->json(['success' => false, 'message' => 'Shop owner not found.'], 403);
    }

    $shop = Shop::where('owner_id', $shopOwner->owner_id)->first();
    if (!$shop) {
        return response()->json(['success' => false, 'message' => 'Shop not found.'], 404);
    }

    $validated = $request->validate([
        'product_id' => 'required|integer',
        'discount_value' => 'required|numeric|min:0.01'
    ]);

    $product = \App\Models\products::where('shop_id', $shop->shop_id)
        ->where('product_id', $validated['product_id'])
        ->first();

    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
    }

    if ($validated['discount_value'] >= $product->price) {
        return response()->json(['success' => false, 'message' => 'Discount must be lower than price.'], 422);
    }

    // فعل Sale
    $product->update([
        'is_on_sale' => true,
        'discount_value' => $validated['discount_value']
    ]);

   
    Mail::to('fatima9ali10@gmail.com')->send(new SaleAppliedMail($shop, $product));

    return response()->json(['success' => true, 'message' => 'Product successfully put on sale and email sent!']);
}


public function toggleSale(Request $request)
{
    
    $user = auth()->user();
    $shopOwner = $user->shopOwner;

    if (!$shopOwner) {
        return response()->json(['success' => false, 'message' => 'You are not registered as a shop owner.'], 403);
    }

    $shop = Shop::where('owner_id', $shopOwner->owner_id)->first();
    if (!$shop) {
        return response()->json(['success' => false, 'message' => 'Shop not found for this owner.'], 404);
    }

    $product = products::where('product_id', $request->product_id)
        ->where('shop_id', $shop->shop_id)
        ->first();

    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product does not belong to your shop.'], 404);
    }

    // Toggle sale
    if ($request->is_on_sale) {
        if (!$product->discount_value) {
            return response()->json(['success' => false, 'message' => 'Set a sale price first.'], 422);
        }

        $product->is_on_sale = 1;
        $product->save(); // حفظ قبل الإيميل

        // إرسال إيميل واحد فقط
        Mail::to('fatima9ali10@gmail.com')->send(new SaleAppliedMail($shop, $product));

        return response()->json(['success' => true, 'message' => 'Sale activated and email sent!']);
    } else {
        $product->is_on_sale = 0;
        $product->discount_value = null;
        $product->save();

        return response()->json(['success' => true, 'message' => 'Sale removed.']);
    }
}


public function products(Shop $shop)
{
    $products = $shop->products()->paginate(12); // ✅ paginate

    return view('shop.products', compact('shop', 'products'));
}

}