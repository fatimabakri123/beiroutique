<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;

class CustomerAuthController extends Controller

{
    public function showForm()
    {
        $categories = categories::all();
        return view('auth.register', compact('categories'));
    }

    public function store(Request $request)
    {
        // Common validation
        $request->validate([
            'role'      => 'required|in:customer,shop_owner,admin',
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
        ]);

        // Create base user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Branch based on role
        if ($request->role === 'customer') {
            Customer::create([
                'user_id'      => $user->id,
                'first_name'   => $request->first_name ?? null,
                'last_name'    => $request->last_name ?? null,
                'phone_number' => $request->phone_number ?? null,
                'address'      => $request->address ?? null,
            ]);

            auth()->login($user);
            return redirect()->route('customer.dashboard');
        }

        if ($request->role === 'shop_owner') {
            $request->validate([
                'shop_name'   => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
            ]);

            $owner = ShopOwner::create([
                'user_id'      => $user->id,
                'first_name'   => $request->first_name ?? null,
                'last_name'    => $request->last_name ?? null,
                'phone_number' => $request->phone_number ?? null,
            ]);

            Shop::create([
                'name'        => $request->shop_name,
                'category_id' => $request->category_id,
                'owner_id'    => $owner->id,
            ]);

            auth()->login($user);
            return redirect()->route('shop.dashboard');
        }

        if ($request->role === 'admin') {
            Admin::create([
                'user_id'  => $user->id,
                'username' => $request->username ?? $request->name, // fallback
                'role'     => 'admin',
            ]);

            auth()->login($user);
            return redirect()->route('admin.dashboard');
        }
    }
}