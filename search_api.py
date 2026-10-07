from flask import Flask, request, jsonify
import torch
from torchvision import models, transforms
from PIL import Image
import numpy as np
from sklearn.metrics.pairwise import cosine_similarity
import pymysql
import os

app = Flask(__name__)

# ------------------ 1. Load model ------------------
device = "cpu"
model = models.resnet50(weights=models.ResNet50_Weights.DEFAULT)
model = torch.nn.Sequential(*list(model.children())[:-1])
model.eval()

preprocess = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor(),
    transforms.Normalize(
        mean=[0.485, 0.456, 0.406],
        std=[0.229, 0.224, 0.225]
    )
])

# ------------------ 2. DB ------------------
db = pymysql.connect(
    host='127.0.0.1',
    user='root',
    password='w7301@fatima#',
    database='beiroutique'
)
cursor = db.cursor(pymysql.cursors.DictCursor)

cursor.execute("""
SELECT p.product_id,
       pi.image_path AS image_url,
       p.subcategory_id
FROM products p
JOIN product_images pi ON p.product_id = pi.product_id
""")

rows = cursor.fetchall()
print(f"✅ Total rows from DB: {len(rows)}")

product_ids = []
embeddings = []
subcats = []
image_paths = []  # للتشخيص

IMAGE_DIR = r"C:\Users\user\Downloads\graduation4 (2) (6)\graduation4\graduation\style\storage\app\public\products"

print("🔄 Generating embeddings...")

for r in rows:
    path = r.get("image_url")
    
    if not path or not isinstance(path, str):
        print(f"⚠️ Invalid path: {path}")
        continue

    original_path = path
    if path.startswith("products/"):
        path = path.split("/", 1)[1]

    img_path = os.path.join(IMAGE_DIR, path)
    
    # Save for debugging
    image_paths.append({
        'product_id': r["product_id"],
        'db_path': original_path,
        'processed_path': path,
        'full_path': img_path,
        'exists': os.path.exists(img_path)
    })

    if not os.path.exists(img_path):
        print(f"❌ Image not found: {img_path}")
        continue

    try:
        img = Image.open(img_path).convert("RGB")
        img_t = preprocess(img).unsqueeze(0)

        with torch.no_grad():
            emb = model(img_t).squeeze().numpy()

        embeddings.append(emb)
        product_ids.append(r["product_id"])
        subcats.append(r["subcategory_id"])
        print(f"✅ Loaded: {r['product_id']} - {path}")

    except Exception as e:
        print(f"🔥 Error loading image {img_path}: {e}")

# Print debug info about image paths
print("\n📸 IMAGE PATH DEBUG:")
print(f"Total DB rows: {len(rows)}")
print(f"Successfully loaded: {len(embeddings)}")
print("\nFirst 5 image paths:")
for i, img_info in enumerate(image_paths[:5]):
    print(f"  {i+1}. Product {img_info['product_id']}:")
    print(f"     DB: {img_info['db_path']}")
    print(f"     Full: {img_info['full_path']}")
    print(f"     Exists: {img_info['exists']}")

embeddings = np.array(embeddings)
print(f"\n✅ Ready. Total valid images: {len(embeddings)}")
print(f"✅ Embeddings shape: {embeddings.shape if len(embeddings) > 0 else 'Empty'}")

# ------------------ 3. API ------------------
@app.route("/search/image", methods=["POST"])
def search_image():
    if "image" not in request.files:
        return jsonify({"error": "No image provided"}), 400
    
    file = request.files["image"]
    temp = "temp.jpg"
    file.save(temp)
    
    print(f"\n🔍 Processing uploaded image: {file.filename}")

    try:
        img = Image.open(temp).convert("RGB")
        img_t = preprocess(img).unsqueeze(0)

        with torch.no_grad():
            q_emb = model(img_t).squeeze().numpy()

        if len(embeddings) == 0:
            print("❌ No embeddings in database")
            os.remove(temp)
            return jsonify({
                "subcategory": None,
                "product_ids": []
            })

        sims = cosine_similarity([q_emb], embeddings)[0]
        
        # Get top 30 matches
        top_n = min(30, len(sims))
        idx = sorted(range(len(sims)), key=lambda i: sims[i], reverse=True)[:top_n]
        
        print(f"\n📊 Top 5 similarity scores:")
        for i in range(min(5, len(idx))):
            print(f"   {i+1}. Product {product_ids[idx[i]]}: {sims[idx[i]]:.4f}")
        
        # ✅ THRESHOLD REDUCED FROM 0.75 TO 0.50
        threshold = 0.50
        
        # Get best match
        best_idx = idx[0] if len(idx) > 0 else None
        best_score = sims[best_idx] if best_idx is not None else 0
        
        print(f"\n🎯 Best match score: {best_score:.4f}")
        print(f"⚡ Threshold: {threshold}")
        
        if best_idx is None or best_score < threshold:
            print(f"❌ No confident match (best score: {best_score:.4f} < {threshold})")
            os.remove(temp)
            return jsonify({
                "subcategory": None,
                "product_ids": []
            })

        main_subcat = subcats[best_idx]
        
        # Filter by same subcategory and threshold
        filtered = []
        for i in idx:
            if subcats[i] == main_subcat and sims[i] >= threshold:
                filtered.append(product_ids[i])
        
        print(f"✅ Detected subcategory: {main_subcat}")
        print(f"✅ Found {len(filtered)} products in same category")
        print(f"📦 Products: {filtered[:10]}...")  # Show first 10

        os.remove(temp)
        
        return jsonify({
            "subcategory": int(main_subcat),
            "product_ids": filtered
        })
        
    except Exception as e:
        print(f"🔥 Error processing image: {e}")
        if os.path.exists(temp):
            os.remove(temp)
        return jsonify({"error": str(e)}), 500

@app.route("/debug", methods=["GET"])
def debug():
    """Debug endpoint to check system status"""
    return jsonify({
        "total_db_rows": len(rows),
        "valid_embeddings": len(embeddings),
        "embeddings_shape": embeddings.shape if len(embeddings) > 0 else None,
        "unique_subcategories": len(set(subcats)) if subcats else 0,
        "sample_products": product_ids[:10] if product_ids else []
    })

if __name__ == "__main__":
    print("\n🚀 Starting Image Search API...")
    print(f"📊 Database: beiroutique")
    print(f"📁 Image directory: {IMAGE_DIR}")
    print(f"🎯 Threshold: 0.50 (adjusted lower)")
    app.run(host="0.0.0.0", port=5050, debug=True)