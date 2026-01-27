import pickle
import numpy as np


# توليد embedding وهمي (مثلاً 512-dim vector لكل منتج)
product_embeddings = {}
for pid in product_ids:
    embedding = np.random.rand(512)  # vector وهمي
    product_embeddings[pid] = embedding


with open('product_embeddings.pkl', 'wb') as f:
    pickle.dump(product_embeddings, f)

print("product_embeddings.pkl created successfully!")
