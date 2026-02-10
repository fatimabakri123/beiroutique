<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>All Products - {{ $shop->shop_name ?? 'Your Shop' }}</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<style>
:root {
  --primary: #5b2a86;
  --secondary: #1f7bb8eb;
  --accent: #8f3f9beb;
  --bg-light: #f5f7fb;
  --white: #ffffff;
  --text-dark: #1e1b4b;
  --text-muted: #6b7280;
  --border-soft: rgba(226,232,240,0.8);
  --shadow-soft: 0 12px 30px rgba(91, 42, 134, 0.15);
}

/* Base Styles */
body { 
  font-family:'Poppins', sans-serif; 
  background: var(--bg-light); 
  color: var(--text-dark); 
  margin:0; 
  padding:0; 
}

/* Navbar - Bigger like dashboard */
.navbar-main { 
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  color: #fff;
  padding: 20px 40px; /* taller and wider like dashboard */
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.navbar-main .logo { 
  font-size: 2rem; /* bigger text like dashboard */
  font-weight: 700;
  letter-spacing: 1px;
}
.navbar-main a { 
  color: var(--white); 
  text-decoration:none;
  font-size: 1.25rem; /* bigger link text */
  font-weight: 600;
  margin-left: 10px;
}
.navbar-main .fa-sign-out {
  font-size: 1.3rem; /* bigger icon */
  margin-right: 5px;
  vertical-align: middle;
}

/* Dashboard container */
.dashboard-container { 
  width: 100%;
  max-width: 100%;
  margin: 0;
  padding: 20px;
  box-sizing: border-box;
}

/* Table container - match dashboard */
.table-container { 
  background: var(--white); 
  padding: 25px;
  border-radius: 14px;
  margin-bottom: 40px;
  box-shadow: var(--shadow-soft);
}

/* Table header - match dashboard */
.table-container h2 {
  font-size: 2rem; /* bigger title */
  font-weight: 700;
  margin-bottom: 20px;
  color: var(--primary);
}

/* Products Table - BIGGER like dashboard */
#productsTable {
  width: 100%;
  border-collapse: collapse;
  font-size: 1.1rem; /* bigger font */
}

#productsTable th {
  background: var(--primary);
  color: #fff;
  padding: 20px; /* bigger padding like dashboard */
  font-size: 1.3rem; /* bigger header text */
  font-weight: 700;
  text-align: left;
}

#productsTable td {
  padding: 18px 20px; /* bigger cells like dashboard */
  border-bottom: 1px solid var(--border-soft);
  font-size: 1.05rem; /* bigger content text */
  vertical-align: middle;
}

/* Product image slider - bigger like dashboard */
.image-slider {
  position: relative;
  width: 160px; /* bigger like dashboard */
  height: 160px; /* bigger like dashboard */
}

.slider-image {
  width: 160px; /* bigger like dashboard */
  height: 160px; /* bigger like dashboard */
  object-fit: cover;
  border-radius: 12px; /* softer corners like dashboard */
}

.slider-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(0,0,0,0.5);
  color: white;
  border: none;
  padding: 4px 8px;
  cursor: pointer;
  border-radius: 50%;
  font-size: 14px;
}

.slider-btn.left { left: 4px; }
.slider-btn.right { right: 4px; }

/* Product name - bigger */
#productsTable strong {
  font-size: 1.2rem; /* bigger like dashboard */
  font-weight: 700;
}

/* Price styling - bigger like dashboard */
#productsTable td strong {
  font-size: 1.4rem; /* bigger price text */
  font-weight: 700;
}

#productsTable td:nth-child(2) { /* Price column */
  font-size: 1.4rem;
  font-weight: 700;
}

/* Sale price */
#productsTable td span[style*="color:red"] {
  font-size: 1.2rem; /* bigger sale price */
  font-weight: 600;
}

/* Stock quantity - bigger */
#productsTable td:nth-child(3) {
  font-size: 1.2rem; /* bigger stock text */
  font-weight: 600;
}

/* On Sale toggle - bigger like dashboard */
.sale-toggle {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 1.2rem; /* bigger text */
  font-weight: 600;
}

.sale-toggle input[type="checkbox"] {
  width: 20px; /* bigger checkbox */
  height: 20px; /* bigger checkbox */
  cursor: pointer;
}

/* Action buttons - bigger like dashboard */
#productsTable button {
  font-size: 1.1rem; /* bigger button text */
  padding: 8px 12px; /* bigger button size */
  border-radius: 6px;
  cursor: pointer;
  border: none;
  margin: 0 4px;
  transition: all 0.3s ease;
}

.edit-btn {
  background-color: #4CAF50;
  color: white;
}

.delete-btn {
  background-color: #f44336;
  color: white;
}

.action-btn {
  background-color: #2196F3;
  color: white;
}

#productsTable button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Pagination styling */
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin-top: 25px;
  flex-wrap: wrap;
}

.pagination li {
  list-style: none;
}

.pagination li a,
.pagination li span {
  padding: 10px 18px;
  border-radius: 10px;
  border: 1px solid #ddd;
  background: #fff;
  color: #5b2a86;
  font-weight: 600;
  font-size: 15px;
  text-decoration: none;
  transition: all 0.2s ease;
}

.pagination li a:hover {
  background: #5b2a86;
  color: #fff;
}

.pagination .active span {
  background: #5b2a86;
  color: #fff;
  border-color: #5b2a86;
}

/* Back to Dashboard button */
.add-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 12px 22px; /* bigger button */
  background: linear-gradient(135deg, var(--secondary), var(--accent));
  color: #fff;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1.2rem; /* bigger text */
  cursor: pointer;
  text-decoration: none;
  transition: all 0.3s ease;
  margin-top: 20px;
  border: none;
}

.add-btn:hover {
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  transform: translateY(-2px);
}

/* Modal styles (keep existing) */
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

.modal-content {
    background-color: #fff;
    padding: 35px 45px;
    border-radius: 14px;
    width: 600px;
    max-width: 90%;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    position: relative;
    font-size: 1.15rem;
}

.modal .close {
    position: absolute;
    top: 12px;
    right: 16px;
    font-size: 1.5rem;
    cursor: pointer;
    background: #f3f4f6;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    transition: 0.2s;
}

.modal .close:hover {
    background-color: var(--purple-soft);
    color: white;
    transform: scale(1.05);
}

.modal-content h2 {
    font-size: 2rem;
    margin-bottom: 25px;
    color: var(--primary);
    text-align: center;
}

.modal-content input,
.modal-content textarea,
.modal-content select {
    padding: 14px 16px;
    font-size: 1.15rem;
    border-radius: 8px;
    border: 1px solid var(--border-soft);
    margin-bottom: 20px;
    width: 100%;
    box-sizing: border-box;
}

.modal-content button {
    padding: 14px 30px;
    font-size: 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: var(--primary);
    color: white;
    border: none;
}

.modal-content button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    background-color: var(--secondary);
}

#productForm {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-top: 10px;
}

#productForm textarea,
#productForm select,
#productForm input[name="product_name"],
#productForm input[type="file"],
#productForm button {
    grid-column: span 2;
}

/* Action buttons - match dashboard colors and styling */
#productsTable button {
    font-size: 1.1rem; /* bigger button text */
    padding: 8px 12px; /* bigger button size */
    border-radius: 6px;
    cursor: pointer;
    border: none;
    margin: 0 4px;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, var(--secondary), var(--accent));
    color: #fff;
    font-weight: 600;
}

/* Specific button colors matching dashboard */
#productsTable .edit-btn,
#productsTable .delete-btn,
#productsTable .action-btn {
    background: linear-gradient(135deg, var(--secondary), var(--accent));
    color: #fff;
}

#productsTable button:hover {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Add hover effect for all buttons */
#productsTable .edit-btn:hover,
#productsTable .delete-btn:hover,
#productsTable .action-btn:hover {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
/* Back to Dashboard button - match dashboard styling */
.add-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 12px 22px; /* bigger button */
    background: linear-gradient(135deg, var(--secondary), var(--accent));
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1.2rem; /* bigger text */
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-top: 20px;
    border: none;
}

.add-btn:hover {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}
.modal-content button {
    padding: 14px 30px;
    font-size: 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, var(--secondary), var(--accent));
    color: white;
    border: none;
}

.modal-content button:hover {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

/* Image slider buttons - match dashboard exactly */
.image-slider .slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9) !important; /* Force white background */
    color: #333 !important; /* Force dark text */
    border: none;
    padding: 6px 10px;
    cursor: pointer;
    border-radius: 50%;
    font-size: 16px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    margin: 0 !important; /* Remove button margin */
}

.image-slider .slider-btn:hover {
    background: white !important; /* solid white on hover */
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 3px 8px rgba(0,0,0,0.3);
    color: #333 !important;
}

.slider-btn.left { left: 8px; }
.slider-btn.right { right: 8px; }

/* Add this to your CSS section */
.low-stock-row {
    background-color: #ffebee !important; /* Light red background */
    border-left: 4px solid #f44336 !important; /* Red border on left */
}

.low-stock-row:hover {
    background-color: #ffcdd2 !important; /* Darker red on hover */
}

/* Add these styles to your CSS */
.low-stock-row td {
    font-weight: 600;
}

.low-stock-row td:first-child {
    position: relative;
}


/* Make stock quantity cell stand out more */
.low-stock-row td:nth-child(3) {
    color: #d32f2f;
    font-weight: bold;
    font-size: 1.2rem;
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
                <tr class="{{ $product->stock_quantity < 5 ? 'low-stock-row' : '' }}">
                    <td style="display:flex; align-items:center; gap:15px;">
                        @if($product->images && $product->images->count())
                            <div class="image-slider" data-index="0">
                                @foreach($product->images as $img)
                                    <img
                                        src="{{ asset('storage/' . $img->image_path) }}"
                                        class="slider-image"
                                        style="display:none;"
                                    >
                                @endforeach

                                @if($product->images->count() > 1)
                                    <button class="slider-btn left" onclick="prevImage(this)">❮</button>
                                    <button class="slider-btn right" onclick="nextImage(this)">❯</button>
                                @endif
                            </div>
                        @elseif($product->image_url)
                            @if(Str::startsWith($product->image_url, 'products/'))
                                <img src="{{ asset('storage/' . $product->image_url) }}"
                                     class="slider-image">
                            @else
                                <img src="{{ asset($product->image_url) }}"
                                     class="slider-image">
                            @endif
                        @else
                            <img src="{{ asset('images/no-image.png') }}"
                                 class="slider-image">
                        @endif

                        <div>
                            <strong>{{ $product->product_name }}</strong><br>
                            <small>{{ $shop->shop_name }}</small>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:4px;">
                            <strong>${{ $product->price }}</strong>
                            @if($product->is_on_sale)
                                <span style="color:red; font-size:1.2rem; font-weight:600;">
                                    Sale: ${{ $product->discount_value }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>{{ $product->stock_quantity }} units</td>
                    <td>
                        <label class="sale-toggle">
                            <input type="checkbox" {{ $product->is_on_sale ? 'checked' : '' }} onchange="toggleSale({{ $product->product_id }}, this.checked)">
                            <span>On Sale</span>
                        </label>
                    </td>
                    <td>
                        <button class="edit-btn" onclick="editProduct({{ $product->product_id }})">✏️</button>
                        <button class="delete-btn" onclick="deleteProduct({{ $product->product_id }})">🗑️</button>
                        <button class="action-btn" onclick="openSaleProduct({{ $product->product_id }})">💲 Sale</button>
                          <button onclick="openEditStock({{ $product->product_id }}, {{ $product->stock_quantity }})">📦 Edit Stock</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $products->links() }}
        </div>

        <a href="{{ route('shop.dashboard') }}" class="add-btn">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
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
            <input type="file" name="images[]" id="images" multiple>
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

<!-- Edit Stock Modal -->
<div id="editStockModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditStock()">&times;</span>
        <h2>Edit Stock</h2>
        <form id="editStockForm">
            @csrf
            <input type="hidden" name="product_id" id="editStockProductId">
            <label for="editStockQuantity">Stock Quantity</label>
            <input type="number" name="stock_quantity" id="editStockQuantity" min="0">
            <button type="button" onclick="saveStock()">Update Stock</button>
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
            console.log(data);
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

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".image-slider").forEach(slider => {
            let imgs = slider.querySelectorAll(".slider-image");
            if (imgs.length > 0) imgs[0].style.display = "block";
        });
    });

    function nextImage(btn){
        let slider = btn.parentElement;
        let imgs = slider.querySelectorAll(".slider-image");
        let index = parseInt(slider.dataset.index);

        imgs[index].style.display = "none";
        index = (index + 1) % imgs.length;
        imgs[index].style.display = "block";

        slider.dataset.index = index;
    }

    function prevImage(btn){
        let slider = btn.parentElement;
        let imgs = slider.querySelectorAll(".slider-image");
        let index = parseInt(slider.dataset.index);

        imgs[index].style.display = "none";
        index = (index - 1 + imgs.length) % imgs.length;
        imgs[index].style.display = "block";

        slider.dataset.index = index;
    }

    
function openEditStock(productId, stockQty) {
    document.getElementById('editStockProductId').value = productId;
    document.getElementById('editStockQuantity').value = stockQty;
    document.getElementById('editStockModal').style.display = 'flex';
}

function closeEditStock() {
    document.getElementById('editStockModal').style.display = 'none';
}

function saveStock() {
    let productId = document.getElementById('editStockProductId').value;
    let stockQty = document.getElementById('editStockQuantity').value;
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/shop/product/${productId}/update-stock`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ stock_quantity: stockQty })
    })
    .then(res => {
        if (!res.ok) {
            throw new Error("Server error");
        }
        return res.json();
    })
    .then(data => {
        if (data.success) {
            alert('Stock updated successfully!');
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong updating stock.");
    });
}

</script>
</body>
</html>