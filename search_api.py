# file: search_api.py
from flask import Flask, request, jsonify
import torch
from torchvision import models, transforms
from PIL import Image
import numpy as np
from sklearn.metrics.pairwise import cosine_similarity
import pymysql
import os
import requests

app = Flask(__name__)

# --- 1. Setup model ---
model = models.resnet50(pretrained=True)
model = torch.nn.Sequential(*list(model.children())[:-1])
model.eval()

preprocess = transforms.Compose([
    transforms.Resize((224,224)),
    transforms.ToTensor(),
    transforms.Normalize(mean=[0.485,0.456,0.406], std=[0.229,0.224,0.225])
])

# --- 2. Connect to your MySQL database ---
db = pymysql.connect(
    host='127.0.0.1',
    user='root',
    password='w7301@fatima#',
    database='beiroutique'
)

cursor = db.cursor(pymysql.cursors.DictCursor)

# --- 3. Load all products ---
cursor.execute("SELECT product_id, image_url FROM products")
rows = cursor.fetchall()  # [{'product_id':1,'image_url':'images/prod1.jpg'}, ...]

product_ids = []
embeddings = []

print("Generating embeddings for all products...")

for row in rows:
    product_ids.append(row['product_id'])
    img_path = os.path.join(
    os.getcwd(),
    'public',
    'storage',
    row['image_url']
     )
    print("Trying:", img_path)


    if not os.path.exists(img_path):
        print(f"Image not found: {img_path}")
        embeddings.append(np.zeros(2048))  # fallback
        continue

    img = Image.open(img_path).convert("RGB")
    img_t = preprocess(img).unsqueeze(0)
    with torch.no_grad():
        emb = model(img_t).squeeze().numpy()
    embeddings.append(emb)

embeddings = np.array(embeddings)
print("Embeddings ready!")

# --- 4. API route ---
@app.route('/search/image', methods=['POST'])
def search_image():
    print(request.files)  # 👈 مهم


    file = request.files['image']
    temp_path = 'temp_uploaded.jpg'
    file.save(temp_path)

    img = Image.open(temp_path).convert("RGB")
    img_t = preprocess(img).unsqueeze(0)
    with torch.no_grad():
        query_emb = model(img_t).squeeze().numpy()

    # compute cosine similarity
    sims = cosine_similarity([query_emb], embeddings)[0]
    top_idx = sims.argsort()[::-1][:5]  # top 5 products

    top_product_ids = [product_ids[i] for i in top_idx]
    os.remove(temp_path)

    print("Top matching products:", top_product_ids)
    return jsonify({'product_ids': top_product_ids})

if __name__ == '__main__':
  
    app.run(host='0.0.0.0', port=5050)


print("Query image path:", temp_path)
print("Product IDs:", product_ids)
print("Embeddings shape:", embeddings.shape)
print("Top similarities:", sims)
print("Top product IDs:", top_product_ids)
