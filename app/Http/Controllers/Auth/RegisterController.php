<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\ShopOwner;
use App\Models\Shop;
use App\Models\Admin;
use App\Models\User;

class RegisterController extends Controller
{
    public function showForm()
    {
        // Categories are no longer needed for shop registration
        return view('auth.register');
    }

   public function store(Request $request)
{
     

    $request->validate([
        'role'      => 'required|in:customer,shop_owner,admin',
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email',
        'username'  => 'nullable|string|max:255|unique:users,username',
        'password'  => 'required|min:6|confirmed',
        
    ]);

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'username' => $request->username ?? $request->name,
        'password' => bcrypt($request->password),
        'role'     => $request->role,
    ]);

    switch ($request->role) {
        case 'customer':
            Customer::create([
                'user_id' => $user->id,
                'phone_number' => $request->customer_phone,
                'address' => $request->customer_address,
                'username' => $request->username ?? $request->name,
            ]);
            break;

       case 'shop_owner':
    $owner = ShopOwner::create([
        'user_id' => $user->id,
        'phone_number' => $request->owner_phone,
    ]);

    
    $logoPath = null;
  if ($request->hasFile('logo_url')) {
    $file = $request->file('logo_url');
    $filename = time() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('public/logos', $filename);
    $logoPath = 'logos/' . $filename;
}


    Shop::create([
        'shop_name' => $request->shop_name,
        'description' => $request->description,
        'logo_url' => $logoPath, 
        'owner_id' => $owner->owner_id,
        'contact_email' => $request->contact_email,
        'contact_phone' => $request->contact_phone,
        'address' => $request->shop_address,
    ]);
    break;


        case 'admin':
            Admin::create([
                'user_id' => $user->id,
                'username' => $request->username ?? $request->name,
            ]);
            break;
    }

    // 👇 
    return redirect()->route('login')->with('success', 'Your account has been created successfully! Please log in.');
}
}