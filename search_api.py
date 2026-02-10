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

product_ids = []
embeddings = []
subcats = []

IMAGE_DIR = r"C:\Users\user\Downloads\graduation4 (2) (6)\graduation4\graduation\style\storage\app\public\products"

print("Generating embeddings...")

for r in rows:
    path = r.get("image_url")

    if not path or not isinstance(path, str):
        continue

    if path.startswith("products/"):
        path = path.split("/", 1)[1]

    img_path = os.path.join(IMAGE_DIR, path)

    if not os.path.exists(img_path):
        print("❌ Image not found:", img_path)
        continue

    try:
        img = Image.open(img_path).convert("RGB")
        img_t = preprocess(img).unsqueeze(0)

        with torch.no_grad():
            emb = model(img_t).squeeze().numpy()

        embeddings.append(emb)
        product_ids.append(r["product_id"])
        subcats.append(r["subcategory_id"])

    except Exception as e:
        print("🔥 Error loading image:", img_path, e)

embeddings = np.array(embeddings)
print("Ready. Total valid images:", len(embeddings))

# ------------------ 3. API ------------------
@app.route("/search/image", methods=["POST"])
def search_image():
    file = request.files["image"]
    temp = "temp.jpg"
    file.save(temp)

    img = Image.open(temp).convert("RGB")
    img_t = preprocess(img).unsqueeze(0)

    with torch.no_grad():
        q_emb = model(img_t).squeeze().numpy()

    sims = cosine_similarity([q_emb], embeddings)[0]

    idx = sorted(range(len(sims)), key=lambda i: sims[i], reverse=True)[:15]

    # 🔴 Reject weak match
    if len(idx) == 0 or sims[idx[0]] < 0.75:
        print("❌ No confident match")
        os.remove(temp)
        return jsonify({
            "subcategory": None,
            "product_ids": []
        })

    main_idx = idx[0]
    main_subcat = subcats[main_idx]

    filtered = [
        product_ids[i]
        for i in idx
        if subcats[i] == main_subcat and sims[i] >= 0.75
    ]

    os.remove(temp)

    print("Detected subcategory:", main_subcat)
    print("Products:", filtered)

    return jsonify({
        "subcategory": int(main_subcat),
        "product_ids": filtered
    })


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5050)
