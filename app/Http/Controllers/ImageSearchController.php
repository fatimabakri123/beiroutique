<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImageSearchController extends Controller
{
    public function search(Request $request)
    {
       $request->validate([
        'image' => 'required|image|max:5120', // max 5MB
    ]);

    $image = $request->file('image');
    $path = $image->store('uploads', 'public');

    // حاليًا نرجع اسم الملف للتجربة
    return back()->with('message', 'File uploaded: ' . $path);
    }
}
