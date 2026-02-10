<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories;
use App\Models\Shop;
use App\Models\products as Product;
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
use App\Http\Controllers\Admin\AdminSubcategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Notifications\AdminMessage;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RecommendationController;
use App\Notifications\SaleAppliedNotification;




/*
|--------------------------------------------------------------------------
| Main Home Page (with Categories)
|--------------------------------------------------------------------------
*/






Route::get('/', function () {
      $deals = Product::where('is_on_sale', 1)
                    ->orderBy('discount_value', 'desc')
                    ->take(8) 
                    ->get();
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
       $topProducts = Product::with('shop')
            ->select([
                'products.*',
                DB::raw('(SELECT COALESCE(SUM(order_items.quantity), 0) 
                          FROM order_items 
                          INNER JOIN orders ON order_items.order_id = orders.order_id 
                          WHERE order_items.product_id = products.product_id 
                          AND orders.order_status = "delivered") as sold_qty'),
                DB::raw('(SELECT COALESCE(SUM(order_items.price_at_purchase * order_items.quantity), 0) 
                          FROM order_items 
                          INNER JOIN orders ON order_items.order_id = orders.order_id 
                          WHERE order_items.product_id = products.product_id 
                          AND orders.order_status = "delivered") as total_revenue')
            ])
            ->orderByDesc('sold_qty')
            ->limit(5)
            ->get();
    return view('index', compact('categories', 'shops','deals', 'topProducts'));
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

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

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

Route::post('/cart/add/{product}', [CartsController::class, 'add'])
    ->name('cart.add');
   

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

//Route::get('/shop/{id}/edit', [ShopController::class, 'edit'])->name('shop.edit');
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
Route::get('/products', [ProductsController::class, 'index'])->name('products.index')->middleware('auth');
///////////////////
////shopowner

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {

    // Notifications
    

});

////23\11


Route::middleware(['auth'])->group(function() {
    Route::get('notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::delete('notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');
    Route::post('notifications/send', [AdminNotificationController::class, 'send'])->name('notifications.send');
  
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
    Route::delete('notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('notifications.destroy');

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
    Route::delete('/admin/shops/{shop}', [AdminShopController::class, 'destroy'])->name('admin.shops.destroy');

   
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
   
    // Notifications
   // Route::resource('notifications', AdminNotificationController::class)->only(['index']);
   // Route::post('notifications/send',[AdminNotificationController::class,'send'])->name('notifications.send');
   // Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    
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
Route::get('/product/{id}', [ProductsController::class, 'show'])
    ->name('product.show');
   
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
    return view('faq'); // resources/views/faq.blade.php
});
Route::post('/faq/ask', [AIChatController::class, 'faq']);
/////////////////////////////////////////


Route::middleware('auth')->group(function () {
    Route::post('/wishlist/toggle/{product}', [WhishlistController::class, 'toggle'])
        ->name('customer.wishlist.toggle');
});
// web.php

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
//Route::post('/search/image', [App\Http\Controllers\SearchController::class, 'imageSearch'])
   //  ->name('image.search');

//Route::post('/admin/notifications/send', 
 //   [AdminNotificationController::class, 'send']
//)->name('notifications.send');
/////////////////////////////////
//16/1
//Route::prefix('admin')->group(function () {
//    Route::get('notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
//    Route::delete('notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');
//});


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
//use App\Http\Controllers\Admin\ChatController;

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

use App\Http\Controllers\AiChatController;



//Route::post('/ai/chat', [AiChatController::class, 'chat'])->name('ai.chat');


Route::get('/ai', function () {
    return view('ai.chat');
});
///////////////////////////26/1
Route::middleware('auth')->group(function () {
   
    Route::get('/chat/{user}', [ChatController::class, 'start'])->name('chat.start');

    
    Route::post('/chat/send', [MessageController::class, 'send'])->name('chat.send');

    
    Route::get('/chat/fetch/{chat}', [MessageController::class, 'fetch'])->name('chat.fetch');
});
use App\Http\Controllers\ShopChatController;
Route::middleware('auth')->group(function () {

    // Shop owner dashboard: see all chats with customers
    Route::get('/shop/chats', [ShopChatController::class, 'index'])->name('shop.chats');

    // Open a chat with a customer
    Route::get('/shop/chat/{chat}', [ShopChatController::class, 'show'])->name('shop.chat.show');

    // Send message (same as before)
    Route::post('/chat/send', [MessageController::class, 'send'])->name('chat.send');

    // Fetch messages
    Route::get('/chat/fetch/{chat}', [MessageController::class, 'fetch'])->name('chat.fetch');
});

// web.php


Route::middleware('auth')->post('/ai-chat', [RecommendationController::class, 'chat'])->name('ai-chat');

Route::post('/search/image', [SearchController::class, 'search'])->name('search.image');
use App\Http\Controllers\SaleController;

Route::get('/sale', [SaleController::class, 'index'])->name('sale');
Route::get('/shop/dashboard', [ShopController::class, 'dashboard'])->name('shop.dashboard');


Route::get('/shop/profile/edit', [ShopController::class, 'editProfile'])
    ->name('shop.profile.edit');

Route::post('/shop/profile/update', [ShopController::class, 'updateProfile'])
    ->name('shop.profile.update');

    Route::get('/shop-owner/statistics', [ShopController::class, 'stats'])
    ->name('shop_owner.statistics');

    // Show edit form for a product
Route::get('/shop/products/{product}/edit', [ShopController::class, 'editProduct'])
    ->name('shop.product.edit');

// Update product stock
Route::post('/shop/products/{product}/update-stock', [ShopController::class, 'updateProductStock'])
    ->name('shop.product.update-stock');
    Route::get('/shop/stats', [ShopController::class, 'stats'])->name('shop.stats');

    Route::get('/shop/products/{product}/edit', [ShopController::class, 'editProduct'])
    ->name('shop.product.edit');

Route::post('/shop/products/{product}/update-stock', [ShopController::class, 'updateProductStock'])
    ->name('shop.product.update-stock');

Route::get('/shop/stats', [ShopController::class, 'stats'])->name('shop.stats');

Route::post('/shop/loyalty-settings', [App\Http\Controllers\LoyaltySettingController::class, 'save'])
    ->name('shop.loyalty.save');

////////////////////
Route::post('/stripe/create', [App\Http\Controllers\StripeController::class, 'charge'])->name('stripe.create');
Route::get('/chat/{user}', [ChatController::class, 'start'])->name('chat.customer');
Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
//////////////////////////////////
Route::get('/cart/all', [CartsController::class, 'allCarts'])->name('cart.all');
use App\Http\Controllers\StripeController;

Route::post('/stripe/charge', [StripeController::class, 'charge'])->name('stripe.charge');

Route::middleware(['auth'])->group(function () {

    Route::get('/shop_owner/notifications', 
        [ShopOwnerController::class, 'notifications']
    )->name('shopowner.notifications');

});

Route::get('/shop/stats', [ShopController::class, 'stats'])->name('shop.stats');

Route::post('/shop/loyalty-settings', [App\Http\Controllers\LoyaltySettingController::class, 'save'])
    ->name('shop.loyalty.save');

    //////////////////////////
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Edit review (show form)

// Update review (submit form)
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');


Route::post('/save-redirect-url', function (Request $request) {
    session(['redirect_after_login' => $request->url]);
    session(['product_id' => $request->product_id]);
    return response()->json(['success' => true]);
})->name('save.redirect.url');

  // routes/web.php


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/subcategories', [AdminSubcategoryController::class, 'index'])
        ->name('admin.subcategories');

    Route::post('/subcategories/store', [AdminSubcategoryController::class, 'store'])
        ->name('admin.subcategories.store');
    Route::delete('/subcategories/{id}', [AdminSubcategoryController::class, 'destroy'])
        ->name('admin.subcategories.destroy');
        Route::get('/subcategories/{id}/edit', [AdminSubcategoryController::class, 'edit'])
        ->name('admin.subcategories.edit');
   Route::put('/subcategories/{id}', [AdminSubcategoryController::class, 'update'])
    ->name('admin.subcategories.update');


});


// web.php
Route::post('/ai-faq', [AIController::class, 'faq'])->name('ai.faq');

Route::middleware(['auth'])->group(function () {

    Route::get('/shop_owner/notifications', 
        [ShopOwnerController::class, 'notifications']
    )->name('shopowner.notifications');

});

Route::post('/shop/product/{product}/update-stock',
    [ProductsController::class, 'updateStock'])
    ->name('shop.product.update-stock');

Route::post('/notifications/{notification}/mark-as-read', function ($notificationId) {
    $notification = auth()->user()->notifications()->where('id', $notificationId)->first();
    
    if ($notification) {
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }
    
    return response()->json(['success' => false], 404);
})->middleware('auth');

// In routes/web.php
Route::get('/shop/notifications', [ShopOwnerController::class, 'notifications'])
    ->name('shop.notifications')
    ->middleware('auth');