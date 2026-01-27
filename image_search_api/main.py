from flask import Flask, request, jsonify
import pickle
import numpy as np
import os
import cv2

app = Flask(__name__)

# Load embeddings
file_path = 'product_embeddings.pkl'
if not os.path.exists(file_path):
    raise FileNotFoundError("File product_embeddings.pkl not found!")

with open(file_path, 'rb') as f:
    product_embeddings = pickle.load(f)  # {product_id: embedding_vector}

def get_image_embedding(image_path):
    # هنا حطي أي طريقة بتحوّل الصورة لمتجه embedding
    # مثال placeholder:
    return np.random.rand(512)  # مؤقت

def find_most_similar(image_embedding):
    max_sim = -1
    best_product_id = None
    for product_id, embedding in product_embeddings.items():
        sim = np.dot(image_embedding, embedding) / (np.linalg.norm(image_embedding) * np.linalg.norm(embedding))
        if sim > max_sim:
            max_sim = sim
            best_product_id = product_id
    return best_product_id

@app.route('/search', methods=['POST'])
def search():
    if 'file' not in request.files:
        return jsonify({'error': 'No file uploaded'}), 400

    file = request.files['file']
    temp_path = os.path.join('temp', file.filename)
    os.makedirs('temp', exist_ok=True)
    file.save(temp_path)

    embedding = get_image_embedding(temp_path)
    product_id = find_most_similar(embedding)

    os.remove(temp_path)
    return jsonify({'product_id': product_id})

if __name__ == '__main__':
    app.run(port=8001)
