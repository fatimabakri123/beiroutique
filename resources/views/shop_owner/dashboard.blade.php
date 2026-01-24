<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Shop Owner Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f9f7f4;
    color: #3e2a1f;
    margin: 0;
    padding: 0;
}
.navbar-main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #8B5E3C;
    color: #fff;
    padding: 10px 20px;
}
.navbar-main .logo {
    font-weight: bold;
    font-size: 1.2rem;
}
.navbar-main a {
    color: #fff;
    text-decoration: none;
}
.dashboard-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}
.shop-info {
    background: #fff2e6;
    padding: 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
}
.shop-info img {
    height: 80px;
    border-radius: 50%;
    margin-right: 20px;
}
.shop-info .details {
    flex: 1;
}
.shop-info .details h2 {
    margin: 0 0 5px 0;
}
.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: transform 0.3s;
}
.stat-card:hover {
    transform: translateY(-5px);
}
.stat-card h3 {
    margin: 0;
    font-size: 1.8rem;
    color: #C08A56;
}
.stat-card p {
    margin: 5px 0 0 0;
    font-weight: 500;
    color: #8B5E3C;
}
.table-container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    overflow-x: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table th, table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}
table th {
    background-color: #8B5E3C;
    color: #fff;
}
.add-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #C08A56;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
}
.add-btn:hover {
    background-color: #8B5E3C;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #fff;
    padding: 20px;
    width: 350px;
    border-radius: 10px;
    animation: fade 0.3s ease;
}

.close {
    float: right;
    font-size: 24px;
    cursor: pointer;
}

@keyframes fade {
    from {transform: scale(0.8); opacity: 0;}
    to   {transform: scale(1); opacity: 1;}
}

/* Modal content */
.modal-content {
    background: #fff;
    padding: 20px;
    width: 500px; /* wider to fit grid */
    max-width: 90%; /* responsive on small screens */
    border-radius: 10px;
    animation: fade 0.3s ease;
    box-sizing: border-box;
    max-height: 90vh; /* keep it inside viewport */
    overflow-y: auto; /* scroll if content is too tall */
}

/* Modal Form Grid */
#productForm {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* two columns */
    gap: 15px;
}

/* Make certain fields span both columns (full width) */
#productForm textarea,
#productForm select,
#productForm input[name="product_name"],
#productForm input[type="file"],
#productForm button {
    grid-column: span 2;
}

/* Inputs and textarea styling */
#productForm input,
#productForm select,
#productForm textarea {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 0.95rem;
    background: #fff;
    color: #3e2a1f;
    box-sizing: border-box;
    width: 100%; /* important to stay inside grid */
}

/* Focus effect */
#productForm input:focus,
#productForm select:focus,
#productForm textarea:focus {
    border-color: #C08A56;
    outline: none;
}

/* Submit button styling */
#productForm button {
    background-color: #C08A56;
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s;
    grid-column: span 2;
}

#productForm button:hover {
    background-color: #8B5E3C;
}

.action-btn {
    padding: 8px 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s;
    margin-right: 5px;
}

/* Edit button */
.edit-btn {
    background-color: #C08A56;
    color: #fff;
}

.edit-btn:hover {
    background-color: #8B5E3C;
    transform: scale(1.05);
}

/* Delete button */
.delete-btn {
    background-color: #E74C3C;
    color: #fff;
}

.delete-btn:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}

}

/* Edit Profile Button */
.edit-profile-btn {
    background-color: #4e73df; /* blue */
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: 0.25s ease;
    text-decoration: none;
    display: inline-block;
}

.edit-profile-btn:hover {
    background-color: #2e59d9;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}

.edit-profile-btn:active {
    transform: scale(0.97);
}

/* Modal styling (for edit shop) */
#editShopModal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

#editShopModal .modal-content {
    background: #fff;
    padding: 25px;
    width: 500px;
    max-width: 90%;
    border-radius: 10px;
    animation: fade 0.3s ease;
    box-sizing: border-box;
    max-height: 90vh;
    overflow-y: auto;
}

#editShopForm input, 
#editShopForm button {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 100%;
    margin-bottom: 10px;
    font-size: 0.95rem;
}

#editShopForm button {
    background-color: #4e73df;
    color: #fff;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: 0.25s ease;
}

#editShopForm button:hover {
    background-color: #2e59d9;
}

/* Edit Shop Modal button matches theme */
#editShopForm button {
    background-color: #C08A56;  /* brown/orange theme */
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s;
    width: 100%;
}

#editShopForm button:hover {
    background-color: #8B5E3C;  /* darker brown on hover */
}

.sale-all-btn {
    margin-bottom: 25px;
    align-self: flex-start;
}

#viewMoreOrders {
    display: inline-block;
    padding: 10px 20px;
    background-color: #C08A56; /* your dashboard theme */
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    text-decoration: none;
    text-align: center;
    margin-top: 15px;
}

#viewMoreOrders:hover {
    background-color: #8B5E3C; /* slightly darker on hover */
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}

#viewMoreOrders:active {
    transform: scale(0.97);
}

.add-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 25px;
    background-color: #C08A56; /* your dashboard theme */
    color: #fff;
    font-weight: 600;
    font-size: 15px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-decoration: none;
    gap: 8px; /* spacing between icon and text */
}

.add-btn:hover {
    background-color: #8B5E3C; /* slightly darker on hover */
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

.add-btn:active {
    transform: scale(0.97);
}

.view-more-products {
    display: inline-flex;
    align-items: center;
    gap: 6px;               /* slightly smaller gap between text and icon */
    padding: 8px 16px;       /* smaller padding */
    font-weight: 600;
    font-size: 0.85rem;      /* smaller text */
    color: #C08A56;          /* dashboard accent color */
    background: #fff;        /* card-like feel */
    border-radius: 6px;      /* slightly smaller radius */
    box-shadow: 0 2px 6px rgba(192,138,86,0.2); /* subtle colored shadow */
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;            /* remove default button border */
}

.view-more-products:hover {
    color: #fff;
    background-color: #C08A56;
    box-shadow: 0 4px 10px rgba(192,138,86,0.25); /* softer hover shadow */
    transform: translateY(-1px); /* smaller hover lift */
}

.view-more-products i {
    transition: transform 0.3s;
    font-size: 0.8rem;        /* smaller arrow */
}

.view-more-products:hover i {
    transform: translateX(4px); /* smaller arrow move */
}

/* Sale button styling */
#saleForm button {
    background-color: #C08A56; /* brown/orange theme */
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s;
    width: 100%; /* full width */
}

#saleForm button:hover {
    background-color: #8B5E3C; /* darker brown on hover */
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.1); /* soft shadow */
}

</style>
</head>
<body>
     @php use Illuminate\Support\Str; @endphp

<!-- Navbar -->
<nav class="navbar-main">
    <div class="logo">Shop Owner Dashboard</div>
    <div><i class="fa fa-sign-out"></i><a href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   Logout
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form></div>
</nav>

<div class="dashboard-container">

    <!-- Shop Info -->
    <div class="shop-info">
      <img id="shopLogo" src="{{ $shop->logo_url ? asset('storage/' . $shop->logo_url) : asset('image/default.jpg') }}" alt="Shop Logo">


        <div class="details">
            <h2 id="shopName">{{ $shop->shop_name ?? 'Your Shop Name' }}</h2>
            <p id="shopDescription">{{ $shop->description ?? 'Your shop description goes here' }}</p>
            <p>Email: <span id="shopEmail">{{ $shop->contact_email ?? 'contact@example.com' }}</span> | Phone: <span id="shopPhone">{{ $shop->contact_phone ?? 'N/A' }}</span></p>
        </div>
       <a href="#" class="add-btn" onclick="openEditShop()">Edit Shop</a>


    </div>

    <!-- Stats Cards -->
    <div class="stats-cards">
    <div class="stat-card">
        <h3>{{ $totalProducts }}</h3>
        <p>Total Products</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalOrders }}</h3>
        <p>Total Orders</p>
    </div>
    <div class="stat-card">
        <h3>${{ number_format($totalRevenue, 2) }}</h3>
        <p>Total Revenue</p>
    </div>
    <div class="stat-card">
        <h3>{{ $lowStock }}</h3>
        <p>Low Stock</p>
    </div>
</div>


   <!-- Products Table -->
<div class="table-container">
    <h2>Your Products</h2>

<button onclick="openSaleAllModal()" class="add-btn sale-all-btn">💲 Put All Products on Sale</button>

    <table id="productsTable">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
           

            <tr>
                <td>
                    
                  @if(Str::startsWith($product->image_url, 'products/'))
    <img src="{{ asset('storage/' . $product->image_url) }}" 
         style="width:120px; height:120px; object-fit:cover;">
@else
    <img src="{{ asset($product->image_url) }}" 
         style="width:120px; height:120px; object-fit:cover;">
@endif

                    <div>
                        <strong>{{ $product->product_name }}</strong><br>
                        <small>{{ $product->shop->shop_name ?? 'Brand' }}</small>
                    </div>
                </td>
                <td>
                    ${{ $product->price }}
                    @if($product->is_on_sale)
                        <div style="color:red;">Sale: ${{ $product->discount_value }}</div>
                    @endif
                </td>
                <td>{{ $product->stock_quantity }} units</td>
                <td>
                    <input 
    type="checkbox" 
    {{ $product->is_on_sale ? 'checked' : '' }}
    onchange="toggleSale({{ $product->product_id }}, this.checked)">
On Sale

                </td>
                <td>
                    <button onclick="editProduct({{ $product->product_id }})">✏️</button>
                    <button onclick="deleteProduct({{ $product->product_id }})">🗑️</button>
                    <button class="action-btn" onclick="openSaleProduct({{ $product->product_id }})">💲 Sale</button>
                    

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
<a href="{{ route('shop.products.all') }}" class="view-more-products">
    View More Products <i class="fa fa-arrow-right"></i>
</a>



    
</div>

    <button onclick="openAddProduct()" class="add-btn">
    <i class="fa fa-plus"></i> Add New Product
</button>

</div>

<!-- Add Product Modal -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeProductModal()">&times;</span>
        <h2 id="modalTitle">Add / Edit Product</h2>
        <form id="productForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" id="product_id">
            <input type="text" name="product_name" id="product_name" placeholder="Product Name">
            <textarea name="description" id="description" placeholder="Description"></textarea>
            <input type="number" name="price" id="price" placeholder="Price">
            <input type="number" name="stock_quantity" id="stock_quantity" placeholder="Stock">
            <select name="category_id" id="category_id">
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
            <select name="subcategory_id" id="subcategory_id">
    <option value="">Select Subcategory</option>
    @foreach($subcategories as $sub)
        <option value="{{ $sub->subcategory_id }}" data-category="{{ $sub->category_id }}">
            {{ $sub->subcategory_name }}
        </option>
    @endforeach
</select>

            <input type="text" name="sku" id="sku" placeholder="SKU">
            <input type="text" name="size" id="size" placeholder="Sizes (comma-separated)">
            <input type="text" name="color" id="color" placeholder="Colors (comma-separated)">
            <input type="file" name="image_url" id="image_url">
            <button type="button" onclick="saveProduct()">Save</button>
        </form>
    </div>
</div>


    <!-- Recent Orders Table -->
    <div class="table-container">
        <h2>Recent Orders</h2>
        <table id="ordersTable">

           <thead>
    <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Amount</th>
        <th>Status</th>
    </tr>
</thead>

           <tbody>
@forelse($orders as $order)
<tr onclick="window.location='{{ route('shop.orders.show', $order->order_id) }}'"
    style="cursor:pointer;">

    <td>{{ $order->order_id }}</td>
    <td>{{ $order->customer_name ?? 'N/A' }}</td>
    <td>${{ number_format($order->total_amount, 2) }}</td>
    <td>{{ $order->order_status }}</td>
</tr>
@empty
<tr>
    <td colspan="4">No orders found.</td>
</tr>
@endforelse
</tbody>

        </table>
       <button id="viewMoreOrders" class="view-more-products" style="display:none;">
    View More Orders <i class="fa fa-arrow-right"></i>
</button>

    </div>

</div>

<!-- Edit Shop Modal -->
<div id="editShopModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditShop()">&times;</span>
        <h2>Edit Shop</h2>
        <form id="editShopForm" enctype="multipart/form-data">
            @csrf
            <input type="text" name="shop_name" id="editShopName" placeholder="Shop Name" value="{{ $shop->shop_name ?? '' }}">
            <input type="text" name="description" id="editDescription" placeholder="Description" value="{{ $shop->description ?? '' }}">
            <input type="email" name="contact_email" id="editEmail" placeholder="Contact Email" value="{{ $shop->contact_email ?? '' }}">
            <input type="text" name="contact_phone" id="editPhone" placeholder="Contact Phone" value="{{ $shop->contact_phone ?? '' }}">
            <label>Change Logo:</label>
            <input type="file" name="logo_url" id="editLogo">
            <button type="button" onclick="saveShop()">Save</button>
        </form>
    </div>
</div>

<div id="saleModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSaleModal()">&times;</span>
        <h2 id="saleModalTitle">Put Product(s) on Sale</h2>
        <form id="saleForm">
            @csrf
            <input type="hidden" name="product_id" id="sale_product_id">
            <input type="number" name="discount_value" id="sale_discount_value" placeholder="Sale Price">
            <button type="button" onclick="saveSale()">Apply Sale</button>
        </form>
    </div>
</div>

<!-- Modal for All Products Sale -->
<div id="saleAllModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSaleAllModal()">&times;</span>
        <h2>Put All Products on Sale</h2>
        <form id="saleAllForm">
            @csrf
            <label>Discount Percentage (%):</label>
            <input type="number" name="discount_percentage" id="discount_percentage" min="1" max="100" placeholder="e.g., 30">
            <button type="button" onclick="applySaleAll()">Apply Sale</button>
        </form>
    </div>
</div>





<script>
    let allSubcategories = @json($subcategories);

function openAddProduct(){
    document.getElementById('modalTitle').innerText = "Add Product";
    document.getElementById('productForm').reset();
    document.getElementById('productModal').style.display = 'flex';
}

function editProduct(id){
    fetch(`/products/${id}/edit`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('modalTitle').innerText = "Edit Product";
        document.getElementById('product_id').value = data.product.product_id;
        document.getElementById('product_name').value = data.product.product_name;
        document.getElementById('description').value = data.product.description;
        document.getElementById('price').value = data.product.price;
        document.getElementById('stock_quantity').value = data.product.stock_quantity;
        document.getElementById('category_id').value = data.product.category_id;
        document.getElementById('subcategory_id').value = data.product.subcategory_id;
        document.getElementById('category_id').dispatchEvent(new Event('change'));
        document.getElementById('sku').value = data.product.sku;
        document.getElementById('size').value = data.product.size;
        document.getElementById('color').value = data.product.color;
        document.getElementById('productModal').style.display = 'flex';
    });
}

function closeProductModal(){
    document.getElementById('productModal').style.display = 'none';
}

function saveProduct() {
    let form = document.getElementById('productForm');
    let formData = new FormData(form);

    let productId = document.getElementById('product_id').value;

    let url = productId
        ? `/products/${productId}/update-ajax`
        : "{{ route('products.storeAjax') }}";

    fetch(url, {
        method: "POST",
        body: formData,
        headers: { 
            "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            location.reload();
        } else {
            alert("Error saving product.");
        }
    });
}


function deleteProduct(id){
    if(!confirm("Are you sure you want to delete this product?")) return;

    let url = "{{ route('products.destroyAjax', ':id') }}";
    url = url.replace(':id', id);

    fetch(url, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value,
            "Accept": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(err => console.error(err));
}

function openEditShop() {
    document.getElementById('editShopModal').style.display = 'flex';
}
function closeEditShop() {
    document.getElementById('editShopModal').style.display = 'none';
}

function saveShop() {
    let form = document.getElementById('editShopForm');
    let formData = new FormData(form);
 

    fetch("{{ route('shop.update') }}", {
        method: "POST",
        body: formData,
    
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert("Error updating shop.");
        }
    });
}


function openSaleProduct(id){
    document.getElementById("sale_product_id").value = id;
    document.getElementById("sale_discount_value").value = "";
    document.getElementById("saleModal").style.display = "flex";
}

function closeSaleModal(){
    document.getElementById("saleModal").style.display = "none";
}

function saveSale(){
    let formData = new FormData(document.getElementById('saleForm'));

    fetch("{{ route('shop.applySale') }}", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    })
    .catch(err => alert('Server error'));
}


function openSaleAllModal() {
    document.getElementById('saleAllModal').style.display = 'flex';
}

function closeSaleAllModal() {
    document.getElementById('saleAllModal').style.display = 'none';
}
function applySaleAll(){

    let percent = document.getElementById('discount_percentage').value;

    if (percent <= 0 || percent > 100) {
        alert("Enter a valid percentage.");
        return;
    }

    fetch("{{ route('products.saleAll') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content'),
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            discount_percentage: percent
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    })
    .catch(err => {
        console.error(err);
        alert('Request failed');
    });
}

function toggleSale(productId, isOnSale){

    fetch("{{ route('shop.toggleSale') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content'),
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            product_id: productId,
            is_on_sale: isOnSale ? 1 : 0
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);   // <-- IMPORTANT
        if(!data.success){
            alert(data.message);
            location.reload();
        } else {
            location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        alert("Toggle failed");
    });
}

document.getElementById('category_id').addEventListener('change', function() {
    let selected = this.value;
    let subSelect = document.getElementById('subcategory_id');
    let options = subSelect.querySelectorAll('option');

    subSelect.value = "";

    options.forEach(opt => {
        if (!opt.dataset.category) return;

        if (opt.dataset.category === selected) {
            opt.style.display = "block";
        } else {
            opt.style.display = "none";
        }
    });
});

document.getElementById('category_id').addEventListener('change', function () {
    let categoryId = this.value;
    let subSelect = document.getElementById('subcategory_id');

    subSelect.innerHTML = '<option value="">Select Subcategory</option>';

    allSubcategories.forEach(sub => {
        if (sub.category_id == categoryId) {
            let option = document.createElement('option');
            option.value = sub.subcategory_id;
            option.textContent = sub.subcategory_name;
            subSelect.appendChild(option);
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const table = document.getElementById('ordersTable').getElementsByTagName('tbody')[0];
    const rows = Array.from(table.getElementsByTagName('tr'));
    const viewMoreBtn = document.getElementById('viewMoreOrders');

    const rowsPerPage = 4;
    let currentPage = 1;

    function showRows() {
        const totalRows = rows.length;
        const end = currentPage * rowsPerPage;

        rows.forEach((row, index) => {
            row.style.display = index < end ? '' : 'none';
        });

        viewMoreBtn.style.display = end >= totalRows ? 'none' : 'inline-block';
    }

    viewMoreBtn.addEventListener('click', function() {
        currentPage++;
        showRows();
    });

    // Initial display
    showRows();
});

document.addEventListener("DOMContentLoaded", function() {
    // Products table pagination
    const prodTable = document.getElementById('productsTable').getElementsByTagName('tbody')[0];
    const prodRows = Array.from(prodTable.getElementsByTagName('tr'));
    const viewMoreProdBtn = document.getElementById('viewMoreProducts');

    const productsPerPage = 3; // Number of products to show initially
    let currentProductPage = 1;

    function showProductRows() {
        const end = currentProductPage * productsPerPage;

        prodRows.forEach((row, index) => {
            row.style.display = index < end ? '' : 'none';
        });

        viewMoreProdBtn.style.display = end >= prodRows.length ? 'none' : 'inline-block';
    }

    viewMoreProdBtn.addEventListener('click', function() {
        currentProductPage++;
        showProductRows();
    });

    // Initial display
    showProductRows();
});

document.addEventListener("DOMContentLoaded", function() {
    const prodRows = document.querySelectorAll('#productsTable tbody tr');
    const viewMoreBtn = document.querySelector('.view-more-products');

    const productsPerPage = 3; // show 3 initially
    let currentPage = 1;

    function showProductRows() {
        const end = currentPage * productsPerPage;
        prodRows.forEach((row, index) => {
            row.style.display = index < end ? '' : 'none';
        });
        viewMoreBtn.style.display = end >= prodRows.length ? 'none' : 'inline-block';
    }

    viewMoreBtn.addEventListener('click', function() {
        currentPage++;
        showProductRows();
    });

    // initial display
    showProductRows();
});

</script>

</body>
</html>