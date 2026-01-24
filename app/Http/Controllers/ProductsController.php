<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\products;
use App\Models\Subcategory;
use App\Models\Customer;
use App\Models\Shop;
use App\Models\Orders;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SaleAppliedNotification;
use App\Notifications\SaleAppliedMail;


class ProductsController extends Controller
{
   public function byCategory(Request $request, $id)
{
    $category = categories::with('subcategories')->findOrFail($id);

    $products = products::where('category_id', $id);

    // filters (price, size, color...)
    if ($request->price) {
        $products->where(function($q) use ($request){
            foreach ($request->price as $range) {
                if ($range == 'under_50') $q->orWhere('price','<',50);
                if ($range == '50_100') $q->orWhereBetween('price',[50,100]);
                if ($range == '100_200') $q->orWhereBetween('price',[100,200]);
            }
        });
    }

    if ($request->sort == 'price_low_high') {
        $products->orderBy('price','ASC');
    }

    if ($request->sort == 'price_high_low') {
        $products->orderBy('price','DESC');
    }

    $products = $products->paginate(12);
    $categories = categories::all();

    return view('products.byCategory', compact(
        'category',
        'products',
        'categories'
    ));
}

public function bySubcategory($id)
{
    $subcategory = Subcategory::with('category')->findOrFail($id);
    $category = $subcategory->category; // parent category

    $products = products::where('subcategory_id', $id)->get();

    return view('products.byCategory', compact('subcategory', 'category', 'products'));
}


    public function index(Request $request)
{
    $products = products::query();

    // ⭐ 1. Price Filter
    if ($request->price) {
        $products->where(function($query) use ($request) {
            foreach ($request->price as $priceRange) {

                if ($priceRange == 'under_50') {
                    $query->orWhere('price', '<', 50);
                }

                if ($priceRange == '50_100') {
                    $query->orWhereBetween('price', [50, 100]);
                }

                if ($priceRange == '100_200') {
                    $query->orWhereBetween('price', [100, 200]);
                }
            }
        });
    }

    // ⭐ 2. Color Filter (assuming color is comma or JSON)
    if ($request->color) {
        $products->where(function($query) use ($request) {
            foreach ($request->color as $color) {
                $query->orWhere('color', 'LIKE', "%$color%");
            }
        });
    }

    // ⭐ 3. Size Filter
    if ($request->size) {
        $products->where(function($query) use ($request) {
            foreach ($request->size as $size) {
                $query->orWhere('size', 'LIKE', "%$size%");
            }
        });
    }

    // ⭐ 4. Sorting
    if ($request->sort == 'latest') {
        $products->orderBy('created_at', 'DESC');
    }

    if ($request->sort == 'price_low_high') {
        $products->orderBy('price', 'ASC');
    }

    if ($request->sort == 'price_high_low') {
        $products->orderBy('price', 'DESC');
    }

    
    $products = $products->paginate(12);

    return view('products.index', compact('products'));
}
public function show($id)
{
    $product = products::with('reviews.customer')->findOrFail($id); // get product with reviews and customer info
    return view('products.show', compact('product'));
}
public function storeAjax(Request $request)
{
    $shopOwner = auth()->user()->shopOwner;
    $shop = $shopOwner?->shops()->first();

    if (!$shop) {
        return response()->json(['success' => false, 'message' => 'No shop found'], 400);
    }

    // 1️⃣ Create product WITHOUT notification
    $product = Products::create([
        'shop_id' => $shop->shop_id,
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'product_name' => $request->product_name,
        'description' => $request->description,
        'price' => $request->price,
        'stock_quantity' => $request->stock_quantity,
        'size' => $request->size ? json_encode(explode(',', $request->size)) : null,
        'color' => $request->color ? json_encode(explode(',', $request->color)) : null,
        'sku' => $request->sku,
        'barcode' => $request->barcode,
        'is_on_sale' => $request->is_on_sale ?? 0,
        'discount_value' => $request->discount_value ?? 0,
    ]);

    // 2️⃣ Upload image AFTER create
    if ($request->hasFile('image_url')) {
        $path = $request->file('image_url')->store('products', 'public');
        $product->image_url = $path;
        $product->save();
    }

    // 3️⃣ IMPORTANT 🔥 reload model from DB
    $product->refresh();

    // 4️⃣ Send notification (NOW image exists)
    $customers = Customer::all();
    Notification::send($customers, new NewProductNotification($product));

    return response()->json([
        'success' => true,
        'product' => $product
    ]);
}

public function destroyAjax($id)
{
    $product = products::find($id);
    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found']);
    }
    $product->delete();
    return response()->json(['success' => true, 'message' => 'Product deleted']);
}

public function editAjax($id)
{
    $product = products::find($id);

    if(!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    return response()->json([
        'success' => true,
        'product' => $product
    ]);
}

public function updateAjax(Request $request, $id)
{
    $product = products::find($id);
    $product->subcategory_id = $request->subcategory_id;


    if(!$product){
        return response()->json(['success' => false, 'message' => 'Product not found']);
    }

    $product->product_name = $request->product_name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->discount_value = $request->discount_value;
    $product->stock_quantity = $request->stock_quantity;
    $product->category_id = $request->category_id;
    $product->subcategory_id = $request->subcategory_id; 
    $product->sku = $request->sku;
    $product->size = $request->size;
    $product->color = $request->color;

    if($request->hasFile('image_url')){
        $product->image_url = $request->file('image_url')->store('products', 'public');
    }

    $product->save();

    return response()->json(['success' => true, 'message' => 'Product updated successfully']);
}

public function saleAll(Request $request)
{
    try {
        $user = auth()->user();

        if (!$user->shopOwner) {
            return response()->json(['success' => false, 'message' => 'No shop owner found.']);
        }

        $shop = $user->shopOwner->shops()->first();
        if (!$shop) {
            return response()->json(['success' => false, 'message' => 'No shop found.']);
        }

        $percentage = $request->discount_percentage;
        if (!$percentage || $percentage <= 0 || $percentage > 100) {
            return response()->json(['success' => false, 'message' => 'Invalid percentage']);
        }

        // Apply discount to all products
        foreach ($shop->products as $product) {
            $discountPrice = round($product->price * (1 - $percentage / 100), 2);
            $product->update([
                'is_on_sale' => true,
                'discount_value' => $discountPrice
            ]);
        }

        // --- Notify all customers (in-app notification only) ---
        $customers = Customer::all();
        Notification::send($customers, new SaleAppliedNotification($shop->shop_name, $percentage));

        // --- Send email notification to just ONE email ---
        $adminEmail = 'fatima9ali10@gmail.com'; // put your desired email here
        Notification::route('mail', $adminEmail)
            ->notify(new SaleAppliedNotification($shop->shop_name, $percentage));

        return response()->json([
            'success' => true,
            'message' => "All products are now on sale with $percentage% off! Customers notified and email sent to $adminEmail"
        ]);

    } catch (\Exception $e) {
        \Log::error('Sale all error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    }
}


public function create()
{
    $categories = categories::all();
    $subcategories = Subcategory::all();

    return view('shopowner.products.create', compact('categories', 'subcategories'));
}



  public function allProducts()
{
    $user = auth()->user();
    $shop = $user->shop ?? $user->shopOwner?->shops()->first();

    if (!$shop) {
        abort(404, "Shop not found for this user.");
    }

    $products = $shop->products()->with('category', 'subcategory')->paginate(12);

    $categories = \App\Models\categories::all();
    $subcategories = \App\Models\Subcategory::all();

    return view('shop_owner.products.all', compact('shop', 'products', 'categories', 'subcategories'));
}


}