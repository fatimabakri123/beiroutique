<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::user(); // get the logged-in admin
        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
         // optional avatar
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

      
        $admin->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
