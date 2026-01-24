<?php

namespace App\Http\Controllers;

use App\Models\review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request, $id)
{
   
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);
 $imagePath = null;

    if ($request->hasFile('image')) {
       
        $imagePath = $request->file('image')->store('reviews', 'public');
    }
    $user=auth()->user();
    if(!$user){
        return redirect()->back()->with('error', 'Please login first');;
    }
    Review::create([
        'customer_id' => auth()->user()->customer->customer_id, // make sure user has customer
        'product_id' => $id,
        'rating' => $request->rating,
        'comment' => $request->comment,
        'image' => $imagePath,
        'review_date' => now(),
    ]);

    return back()->with('success', 'Review added successfully!');
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
   

    /**
     * Display the specified resource.
     */
    public function show(review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function update(Request $request, Review $review)
{
   
    if (auth()->id() !== $review->customer->user_id) {
        abort(403);
    }

    // ✅ Validation
    $request->validate([
        'rating'  => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
        'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // 🖼️ إذا المستخدم رفع صورة جديدة
    if ($request->hasFile('image')) {

        // حذف الصورة القديمة إذا موجودة
        if ($review->image && \Storage::exists($review->image)) {
            \Storage::delete($review->image);
        }

        // حفظ الصورة الجديدة
        $imagePath = $request->file('image')->store('reviews', 'public');

        $review->image = $imagePath;
    }

    // ✏️ تحديث باقي البيانات
    $review->rating  = $request->rating;
    $review->comment = $request->comment;
    $review->save();

    return back()->with('success', 'Review updated successfully');
}


    /**
     * Update the specified resource in storage.
     */
   
    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Review $review)
{
  
    if (
        auth()->id() !== $review->customer->user_id
        && !auth()->user()->is_admin
    ) {
        abort(403);
    }

  
    if ($review->image) {
        \Storage::delete($review->image);
    }

    $review->delete();

    return back()->with('success', 'Review deleted successfully');
}

}
