<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>All Products - {{ $shop->shop_name ?? 'Your Shop' }}</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<style>
body { font-family:'Poppins', sans-serif; background:#f9f7f4; color:#3e2a1f; margin:0; padding:0; }
.navbar-main { display:flex; justify-content:space-between; align-items:center; background:#8B5E3C; color:#fff; padding:10px 20px; }
.navbar-main .logo { font-weight:bold; font-size:1.2rem; }
.navbar-main a { color:#fff; text-decoration:none; }
.dashboard-container { max-width:1200px; margin:30px auto; padding:0 20px; }
.table-container { background:#fff; padding:20px; border-radius:8px; overflow-x:auto; }
table { width:100%; border-collapse:collapse; }
table th, table td { padding:10px; border-bottom:1px solid #ddd; text-align:left; vertical-align: middle; }
table th { background-color:#8B5E3C; color:#fff; }
img.product-img { width:120px; height:120px; object-fit:cover; border-radius:8px; margin-right:10px; }
.add-btn { display:inline-flex; align-items:center; justify-content:center; padding:10px 20px; background:#C08A56; color:#fff; border-radius:8px; font-weight:500; cursor:pointer; text-decoration:none; transition:all 0.3s; margin-top:10px; }
.add-btn:hover { background:#8B5E3C; transform:translateY(-2px); }

/* Modal overlay */
.modal {
    display: none;           /* Hidden by default */
    position: fixed;         /* Stay in place */
    z-index: 9999;           /* On top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;          /* Scroll if needed */
    background-color: rgba(0,0,0,0.5); /* Semi-transparent background */
    justify-content: center;
    align-items: center;
}

/* Modal content box */
.modal-content {
    background-color: #fff;
    margin: auto;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    position: relative;
}

/* Close button */
.modal .close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}

/* Modal overlay */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

/* Modal content box (dashboard style) */
.modal-content {
    background-color: #f9f7f4;  /* same as dashboard */
    margin: auto;
    padding: 30px 25px;
    border-radius: 15px;         /* rounded corners */
    width: 90%;
    max-width: 600px;
    position: relative;
    box-shadow: 0px 8px 20px rgba(0,0,0,0.2); /* soft shadow */
    font-family: 'Poppins', sans-serif;
}

/* Close button */
.modal .close {
    position: absolute;
    top: 12px;
    right: 15px;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    color: #8B5E3C;
    transition: color 0.3s;
}

.modal .close:hover {
    color: #C08A56;
}

/* Form inside modal */
.modal form input,
.modal form textarea,
.modal form select {
    width: 100%;
    padding: 10px 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
    transition: all 0.2s;
}

.modal form input:focus,
.modal form textarea:focus,
.modal form select:focus {
    outline: none;
    border-color: #C08A56;
    box-shadow: 0 0 5px rgba(192,138,86,0.5);
}

/* Save button */
.modal form button {
    background-color: #C08A56;
    color: #fff;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    margin-top: 12px;
    transition: all 0.3s;
}

.modal form button:hover {
    background-color: #8B5E3C;
    transform: translateY(-1px);
}

/* EDIT PRODUCT MODAL (dashboard style) */
#productModal {
    display: none;           /* hidden by default */
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5); /* semi-transparent overlay */
    justify-content: center;
    align-items: center;
}

#productModal .modal-content {
    background-color: #f9f7f4;  /* same as dashboard */
    padding: 25px 30px;
    border-radius: 15px;        /* same rounded corners as cards */
    width: 90%;
    max-width: 600px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1); /* dashboard card shadow */
    font-family: 'Poppins', sans-serif;
    max-height: 90vh;
    overflow-y: auto;
}

/* Close button */
#productModal .close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #8B5E3C;
    cursor: pointer;
    transition: color 0.3s;
}

#productModal .close:hover {
    color: #C08A56;
}

/* Form grid (2 columns) */
#productForm {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-top: 10px;
}

/* Full width fields */
#productForm textarea,
#productForm select,
#productForm input[name="product_name"],
#productForm input[type="file"],
#productForm button {
    grid-column: span 2;
}

/* Inputs styling */
#productForm input,
#productForm textarea,
#productForm select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 0.95rem;
    background: #fff;
    color: #3e2a1f;
    box-sizing: border-box;
    transition: all 0.2s;
}

#productForm input:focus,
#productForm select:focus,
#productForm textarea:focus {
    border-color: #C08A56;
    outline: none;
    box-shadow: 0 0 5px rgba(192,138,86,0.3);
}

/* Save button styling (dashboard style) */
#productForm button {
    background-color: #C08A56; /* dashboard accent */
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
}

#productForm button:hover {
    background-color: #8B5E3C;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.1);
}

</style>
</head>
<body>

<nav class="navbar-main">
    <div class="logo">{{ $shop->shop_name ?? 'Shop Owner Dashboard' }}</div>
    <div>
        <i class="fa fa-sign-out"></i>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</nav>

<div class="dashboard-container">
    <div class="table-container">
        <h2>All Products</h2>
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
            <td style="display:flex; align-items:center;">
                @if(Str::startsWith($product->image_url, 'products/'))
                    <img src="{{ asset('storage/' . $product->image_url) }}" class="product-img">
                @else
                    <img src="{{ asset($product->image_url) }}" class="product-img">
                @endif
                <div>
                    <strong>{{ $product->product_name }}</strong><br>
                    <small>{{ $shop->shop_name }}</small>
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
                <input type="checkbox" {{ $product->is_on_sale ? 'checked' : '' }} onchange="toggleSale({{ $product->product_id }}, this.checked)">
                On Sale
            </td>
           <td>
    <button class="edit-btn" onclick="editProduct({{ $product->product_id }})">✏️</button>
    <button class="delete-btn" onclick="deleteProduct({{ $product->product_id }})">🗑️</button>
    <button class="action-btn" onclick="openSaleProduct({{ $product->product_id }})">💲 Sale</button>
</td>

        </tr>
        @endforeach
    </tbody>
</table>


        <div style="margin-top:20px;">
            {{ $products->links() }}
        </div>

        <a href="{{ route('shop.dashboard') }}" class="add-btn">
            Back to Dashboard <i class="fa fa-arrow-left"></i>
        </a>
    </div>
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





</script>
</body>
</html>