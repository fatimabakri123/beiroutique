<form action="{{ route('report.store') }}" method="POST">
    @csrf

    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
    <input type="hidden" name="product_id" value="{{ $product->product_id }}">

    <label>Issue Type</label>
    <select name="issue_type" required>
        <option value="damaged">Damaged product</option>
        <option value="wrong">Wrong item</option>
        <option value="missing">Missing item</option>
        <option value="not_as_described">Not as described</option>
    </select>

    <label>Description</label>
    <textarea name="description" required></textarea>

    <button type="submit">Submit Report</button>
    <style>
        /* ================= REPORT FORM ================= */
form {
    max-width: 520px;
    margin: 40px auto;
    padding: 35px 40px;
    background: #ffffff;
    border-radius: 22px;
    box-shadow: 0 15px 45px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', Tahoma, sans-serif;
}

/* ================= LABELS ================= */
form label {
    display: block;
    margin-bottom: 8px;
    font-size: 15px;
    font-weight: 700;
    color: #6b3f12;
    letter-spacing: 0.3px;
}

/* ================= SELECT & TEXTAREA ================= */
form select,
form textarea {
    width: 100%;
    padding: 14px 16px;
    border-radius: 14px;
    border: 1.5px solid #e0d6cc;
    background: #faf7f4;
    font-size: 14px;
    color: #333;
    margin-bottom: 22px;
    transition: all 0.25s ease;
}

/* Focus Effect */
form select:focus,
form textarea:focus {
    outline: none;
    border-color: #8B5E34;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(139,94,52,0.15);
}

/* Textarea size */
form textarea {
    min-height: 130px;
    resize: vertical;
}

/* ================= SUBMIT BUTTON ================= */
form button {
    width: 100%;
    padding: 14px;
    border-radius: 16px;
    border: none;
    background: linear-gradient(135deg, #8B5E34, #B07A4A);
    color: #ffffff;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 0.6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Hover */
form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(139,94,52,0.35);
    background: linear-gradient(135deg, #7a4e28, #a56f3f);
}

/* Active */
form button:active {
    transform: scale(0.98);
}

/* ================= MOBILE ================= */
@media (max-width: 600px) {
    form {
        padding: 25px;
    }
}
</style>
</form>
