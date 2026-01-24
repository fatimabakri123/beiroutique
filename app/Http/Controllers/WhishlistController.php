<?php

namespace App\Http\Controllers;

use App\Models\whishlist;
use App\Models\WhishlistItem;
use Illuminate\Http\Request;
use App\Models\products;

class WhishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function toggle( $product_id)
{
        $user = auth()->user();

        if (!$user || !$user->customer) {
            return redirect()->route('login')->with('error', 'Please login as customer.');
        }

        $customer = $user->customer;

        // Retrieve or create wishlist for this customer
        $wishlist = Whishlist::firstOrCreate([
            'customer_id' => $customer->customer_id
        ]);

        // Check if this product is already in wishlist
        $existing = WhishlistItem::where('wishlist_id', $wishlist->wishlist_id)
                                ->where('product_id', $product_id)
                                ->first();

        if ($existing) {
            $existing->delete();  // remove
            return back()->with('success', 'Removed from wishlist');
        } else {
            WhishlistItem::create([
                'wishlist_id' => $wishlist->wishlist_id,
                'product_id'  => $product_id
            ]);
            return view('customer.wishlist', compact('wishlist'));
        }
    }

    public function view()
    {
        $user = auth()->user();
        $customer = $user->customer;

        $wishlist = Whishlist::where('customer_id', $customer->customer_id)
                            ->with('items.product')
                            ->first();
         $wishlistCount = $wishlist ? $wishlist->items->count() : 0;

        return view('customer.wishlist', compact('wishlist', 'wishlistCount'));
    }



public function destroy($itemId)
{
    $user = auth()->user();

    if (!$user || !$user->customer) {
        return redirect()->route('login')->with('error', 'Please login as customer.');
    }

    $customer = $user->customer;

    // Retrieve wishlist for this customer
    $wishlist = Whishlist::where('customer_id', $customer->customer_id)
                         ->with('items')
                         ->first();

    if (!$wishlist) {
        return redirect()->back()->with('error', 'No wishlist found.');
    }

    // Find the item
    $item = $wishlist->items()->where('wishlist_item_id', $itemId)->first();

    if (!$item) {
        return redirect()->back()->with('error', 'Item not found in wishlist.');
    }

    $item->delete();

    return redirect()->back()->with('success', 'Item removed from wishlist.');
}

    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(whishlist $whishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(whishlist $whishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, whishlist $whishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

}
