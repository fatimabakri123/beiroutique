<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories;
use App\Models\Shop;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WhishlistController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\ShopOwnerController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminShopOwnerController;
use App\Http\Controllers\Admin\AdminShopController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminPaymentMethodController;
use App\Http\Controllers\Admin\AdminDeliveryMethodController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SearchController;
use App\Notifications\AdminMessage;
use App\Http\Controllers\ReportController;
use App\Notifications\SaleAppliedNotification;




/*
|--------------------------------------------------------------------------
| Main Home Page (with Categories)
|--------------------------------------------------------------------------
*/


Route::get('/', function () {
    
    // Categories sorted
    $categories = Categories::orderByRaw("
        CASE 
            WHEN category_name = 'Women' THEN 1
            WHEN category_name = 'Men' THEN 2
            WHEN category_name = 'Kids' THEN 3
            ELSE 4
        END
    ")->orderBy('category_name')->get();

    // Get all active shops
    $shops = Shop::where('is_active', true)->get();

    return view('index', compact('categories', 'shops'));
})->name('index');


/*
|--------------------------------------------------------------------------
| Category & Product Routes
|--------------------------------------------------------------------------
*/
Route::get('/categories/{id}/products', [ProductsController::class, 'byCategory'])
    ->name('category.products');

    /*
|--------------------------------------------------------------------------
| Category & Subcategory Routes
|--------------------------------------------------------------------------
*/

Route::get('/category/{id}', [ProductsController::class, 'byCategory'])
    ->name('category.show');

// web.php
Route::get('/subcategory/{id}', [CategoriesController::class, 'showSubcategory'])->name('subcategory.show');


/*
|--------------------------------------------------------------------------
| Authentication (Register & Login)
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin & Shop Owner Dashboards
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', fn() => view('admin.dashboard'))
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

Route::get('/shop/dashboard', fn() => view('shop.dashboard'))
    ->middleware(['auth', 'role:shop_owner'])
    ->name('shop.dashboard');

/*
|--------------------------------------------------------------------------
| Customer Dashboard & Pages
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.home');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::post('/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.update');

    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/cart', [CustomerController::class, 'cart'])->name('customer.cart');
   
    Route::get('/reviews', [CustomerController::class, 'reviews'])->name('customer.reviews');
   Route::get('/customer/notifications', [CustomerController::class, 'notifications'])->name('customer.notifications');

});




/*
|--------------------------------------------------------------------------
| Wishlist & Cart
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WhishlistController::class, 'view'])->name('wishlist.view');
    Route::post('/wishlist/toggle/{product_id}', [WhishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::post('/cart/add/{product}', [CartsController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product}', [CartsController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Static Pages
|--------------------------------------------------------------------------
*/
Route::get('/bio', fn() => view('about'))->name('bio');
Route::middleware(['auth'])->group(function () {
    Route::get('/customer/wishlist', [WhishlistController::class, 'view'])
        ->name('customer.wishlist');
});
Route::get('/shop-owner/dashboard', function () {
  return view('shop_owner.dashboard');
})->name('shop_owner.dashboard');

Route::get('/shop/{id}/edit', [ShopController::class, 'edit'])->name('shop.edit');
Route::put('/shop/{id}', [ShopController::class, 'update'])->name('shop.update');
// pick order
// Show product order page
Route::get('/order/{product}', [OrdersController::class, 'show'])

->name('order.show');

// Store order
Route::post('/order/{product}', [OrdersController::class, 'store'])
->middleware('auth')
->name('order.store');

//
//|--------------------------------------------------------------------------
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
///////////////////
////shopowner


////23\11


Route::middleware(['auth'])->group(function() {
  
    Route::patch('/cart/{item}/update', [CartSController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart/{item}/remove', [CartSController::class, 'remove'])->name('cart.remove');
});
//|--------------------------------------------------------------------------
Route::middleware('auth')->group(function() {
    Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::post('/customer/update-profile', [CustomerController::class, 'updateProfile'])->name('customer.updateProfile');
});

Route::post('/customer/update-password', [CustomerController::class, 'updatePassword'])
    ->name('customer.updatePassword')
    ->middleware('auth');
/////////////////////////////////////////////////////////////////////////////
// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function(){
    // Inside your admin group
Route::get('/products/pending', [AdminProductController::class, 'pending'])
    ->name('admin.products.pending');
    
    Route::post('products/{product}/reject', [AdminProductController::class,'reject'])->name('admin.products.reject');

Route::resource('products', AdminProductController::class)->except(['create','store','edit']);


    Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');
    ////users
    Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
      Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');
});


    // Customers
    Route::resource('customers', AdminCustomerController::class)->except(['create','store']);
    Route::post('customers/{customer}/toggle-status',[AdminCustomerController::class,'toggleStatus'])->name('customers.toggleStatus');
 Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
   Route::get('/customers/{id}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');
 Route::delete('/customers/{id}', [AdminCustomerController::class, 'destroy'])->name('admin.customers.destroy');
Route::get('/admin/customers/{id}/toggle-status', [AdminCustomerController::class, 'toggleStatus'])
    ->name('admin.customers.toggleStatus');

    // Shop Owners
    Route::resource('shopowners', AdminShopOwnerController::class)->except(['create','store']);
    Route::post('shopowners/{shopowner}/toggle-status',[AdminShopOwnerController::class,'toggleStatus'])->name('shopowners.toggleStatus');
    Route::get('/shopowners', [AdminShopOwnerController::class, 'index'])->name('admin.shopowners.index');
Route::get('/shopowners/{id}', [AdminShopOwnerController::class, 'show'])
     ->name('admin.shopowners.show');
Route::delete('/shopowners/{id}', [AdminShopOwnerController::class, 'destroy'])
    ->name('admin.shopowners.destroy'); 
    // Shops
    Route::resource('shops', AdminShopController::class)->except(['create','store']);
    Route::post('shops/{shop}/approve',[AdminShopController::class,'approve'])->name('shops.approve');
    Route::get('/shops', [AdminShopController::class, 'index'])->name('admin.shops.index');
    Route::get('/shops/{id}', [AdminShopController::class, 'show'])->name('admin.shops.show');
   
    // Products
    Route::resource('products', AdminProductController::class)->except(['create','store','edit']);
    Route::post('products/{product}/approve',[AdminProductController::class,'approve'])->name('products.approve');
    Route::post('products/{product}/reject',[AdminProductController::class,'reject'])->name('products.reject');
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
   
    Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('admin.products.show');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

Route::post('products/{product}/approve', [AdminProductController::class,'approve'])->name('admin.products.approve');
Route::post('products/{product}/reject', [AdminProductController::class,'reject'])->name('admin.products.reject');
    // Orders
    Route::resource('orders', AdminOrderController::class)->only(['index','show','destroy']);
    Route::post('orders/{order}/update-status',[AdminOrderController::class,'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    // Reports
    Route::resource('reports', AdminReportController::class)->only(['index','show','destroy']);
    Route::post('reports/{report}/resolve',[AdminReportController::class,'resolve'])->name('reports.resolve');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    // Notifications
    Route::resource('notifications', AdminNotificationController::class)->only(['index']);
    Route::post('notifications/send',[AdminNotificationController::class,'send'])->name('notifications.send');
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    // Payment & Delivery
    Route::resource('payment_methods', AdminPaymentMethodController::class)->only(['index','store']);
    Route::post('payment_methods/{id}/toggle',[AdminPaymentMethodController::class,'toggle'])->name('payment_methods.toggle');
    Route::get('/payment_methods', [AdminPaymentMethodController::class, 'index'])->name('admin.payment_methods.index');
    Route::resource('delivery_methods', AdminDeliveryMethodController::class)->only(['index','store']);
    Route::post('delivery_methods/{id}/toggle',[AdminDeliveryMethodController::class,'toggle'])->name('delivery_methods.toggle');
    Route::get('/delivery_methods', [AdminDeliveryMethodController::class, 'index'])->name('admin.delivery_methods.index');


    // Settings
    Route::get('settings',[AdminSettingsController::class,'index'])->name('admin.settings.index');
    Route::post('settings/save',[AdminSettingsController::class,'save'])->name('admin.settings.save');
     Route::get('/profile',[AdminProfileController::class,'index'])->name('admin.profile');
       Route::post('/profile/update',[AdminProfileController::class,'update'])->name('admin.profile.update');
    // Payment Methods
Route::get('/payment_methods', [AdminPaymentMethodController::class, 'index'])
    ->name('admin.payment_methods.index');

Route::post('/payment_methods', [AdminPaymentMethodController::class, 'store'])
    ->name('admin.payment_methods.store');

Route::post('/payment_methods/{id}/toggle', [AdminPaymentMethodController::class, 'toggle'])
    ->name('admin.payment_methods.toggle');

// Delivery Methods
Route::get('/delivery_methods', [AdminDeliveryMethodController::class, 'index'])
    ->name('admin.delivery_methods.index');

Route::post('/delivery_methods', [AdminDeliveryMethodController::class, 'store'])
    ->name('admin.delivery_methods.store');

Route::post('/delivery_methods/{id}/toggle', [AdminDeliveryMethodController::class, 'toggle'])
    ->name('admin.delivery_methods.toggle');

// Notifications

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/notifications', [AdminNotificationController::class, 'index'])
        ->name('admin.notifications.index');

    Route::post('/notifications/send', [AdminNotificationController::class, 'send'])
        ->name('admin.notifications.send');
});
////search admin

Route::get('admin/search', [\App\Http\Controllers\Admin\SearchController::class, 'index'])
    ->name('admin.search')
    ->middleware('auth');


});

///////
// web.php
Route::get('/checkout', [CartsController::class, 'checkout'])->name('checkout');
Route::post('/checkout/submit', [CartsController::class, 'submitCheckout'])->name('checkout.submit');
////////
//////
//////bycatgory
Route::get('/product/{id}', [ProductsController::class, 'show'])->name('product.show');
Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');
////////////////////////////////////////////////////////////////////////////////////////////////////


////serach bil home page 
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
Route::post('/search', [SearchController::class, 'search'])->name('search');

////////////////////////////////////////////////////////////////////////////////////
//shopowner
Route::get('/shop-owner/dashboard', [ShopOwnerController::class, 'dashboard'])
     ->middleware('auth')
     ->name('shop.dashboard');

     Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::post('/shop/update', [ShopController::class, 'updateShop'])->name('shop.update');

Route::post('/products/store-ajax', [ProductsController::class, 'storeAjax'])
    ->name('products.storeAjax')
    ->middleware('auth');

    Route::delete('/products/{id}', [ProductsController::class, 'destroyAjax'])
    ->name('products.destroyAjax')
    ->middleware('auth');

    Route::get('/products/{id}/edit', [ProductsController::class, 'editAjax'])->name('products.editAjax');
Route::post('/products/{id}/update-ajax', [ProductsController::class, 'updateAjax'])->name('products.updateAjax');
Route::post('/shop/update', [ShopOwnerController::class, 'updateShop'])->name('shop.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/shop-owner/statistics', [\App\Http\Controllers\ShopOwnerController::class, 'statistics'])
        ->name('shop_owner.statistics');
});

Route::resource('products', ProductsController::class);

// Single product sale (shop owner sets sale price manually)
Route::post('/shop/apply-sale', [App\Http\Controllers\ShopController::class, 'applySale'])
    ->name('shop.applySale')->middleware('auth');

// All products sale by percentage
Route::post('/products/sale-all', [App\Http\Controllers\ProductsController::class, 'saleAll'])
    ->name('products.saleAll')->middleware('auth');

//
//|--------------------------------------------------------------------------
///Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
///////////////////
////shopowner

Route::get(
    '/shop-owner/orders/{order}',
    [ShopOwnerController::class, 'showOrder']
)->name('shop.orders.show');

Route::put(
    '/shop/orders/{order}/status',
    [ShopOwnerController::class, 'updateOrderStatus']
)->name('shop.orders.updateStatus');
////search admin

Route::get('admin/search', [\App\Http\Controllers\Admin\SearchController::class, 'index'])
    ->name('admin.search')
    ->middleware('auth');
////category
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});



//////////////////////////22/12
Route::delete('/wishlist/{item}', [WhishlistController::class, 'destroy'])->name('wishlist.destroy');
//////////////////////////////////////////////////////////////////////////////////
Route::post('/ask-ai', [App\Http\Controllers\AIChatController::class, 'ask']);


Route::get('/faq', function () {
    return view('faq'); // make sure your Blade file is resources/views/faq.blade.php
})->name('faq');
/////////////////////////////////////////


Route::middleware('auth')->group(function () {
    Route::post('/wishlist/toggle/{product}', [WhishlistController::class, 'toggle'])
        ->name('customer.wishlist.toggle');
});
// web.php
//Route::post('/search/image', [SearchController::class, 'imageSearch'])->name('search.image');
/////////////////////////////////////////////////////////////////////
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
    ->name('reviews.destroy');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])
    ->name('reviews.update');
///////
Route::get('/checkout/now/{product}', [OrdersController::class, 'show'])
    ->name('checkout.now')
    ->middleware('auth');
    ///////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //14/1
// routes/web.php
Route::post('/search/image', [App\Http\Controllers\SearchController::class, 'imageSearch'])
     ->name('image.search');

Route::post('/admin/notifications/send', 
    [AdminNotificationController::class, 'send']
)->name('admin.notifications.send');
/////////////////////////////////
//16/1
Route::delete('/admin/notifications/{id}', 
    [App\Http\Controllers\Admin\AdminNotificationController::class, 'destroy']
)->name('admin.notifications.delete');
Route::delete('/admin/notifications', [AdminNotificationController::class, 'destroyAll'])
    ->name('admin.notifications.deleteAll');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/admin/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'index'])
    ->name('admin.profile')
    ->middleware('auth');
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('admin.profile.update');
});

////////////////////////////////////////////
//18/1
////////////////////////////////////
Route::get('/shop/products', [App\Http\Controllers\ProductsController::class, 'allProducts'])
    ->name('shop.products.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/shop/products/all', [ProductsController::class, 'allProducts'])
        ->name('shop.products.all');
});


Route::get('/subcategory/{id}', [CategoriesController::class, 'showSubcategory'])->name('subcategory.show');

Route::get('/categories/{id}/products', [ProductsController::class, 'byCategory'])
    ->name('category.products');

Route::post('/shop/toggle-sale', [ShopController::class, 'toggleSale'])
    ->name('shop.toggleSale');

    Route::get('/shopowner/products/create', [ProductsController::class, 'create'])
    ->name('shopowner.products.create');

 // Shop Owner: All Products Page

 /////
 // Cart routes


//////////////////////////////////////
////////////////////////////////////////////
/////////////////////////20/1
use App\Http\Controllers\ProductSearchController;

Route::post('/image-search', [ProductSearchController::class, 'searchByImage'])->name('image.search');
///////////////////////////////
Route::prefix('admin')->group(function() {
    Route::get('customers/export', [AdminCustomerController::class, 'export'])
        ->name('admin.customers.export');

    Route::resource('customers', AdminCustomerController::class)
        ->names([
            'index' => 'admin.customers.index',
            'show' => 'admin.customers.show',
            'destroy' => 'admin.customers.destroy',
        ]);
});
////////////////////////////////21/1


Route::get('/shop/{shop}', [ShopController::class, 'products'])->name('shop.products');
Route::patch('/status-toggle/{id}', [AdminShopController::class, 'toggleStatus'])->name('status.toggle');
Route::patch('/admin/shops/approve/{id}', [AdminShopController::class, 'approve'])
    ->name('admin.shops.approve');
////////sho onwer and admin chat
use App\Http\Controllers\Admin\ChatController;

Route::prefix('admin')->middleware('auth')->group(function () {
    // Show chat interface
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    
    // Open conversation with a shop owner/admin
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    
    // Send message
    Route::post('/chat/{conversation}/send', [ChatController::class, 'send'])->name('chat.send');
});
///////////////////
// web.php


//////////////////23/1
Route::prefix('customer')->middleware('auth')->group(function() {
    Route::get('/report/{order}/{product}', [ReportController::class, 'create'])
        ->name('reports.create');

    Route::post('/report', [ReportController::class, 'store'])
        ->name('report.store');
});

