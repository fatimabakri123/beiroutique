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
        :root {
  --purple-dark: #5b2d8b;
  --purple-soft: #7c4dff;
  --blue-soft: #4f8cff;
  --bg-light: #f5f6fb;
  --white: #ffffff;
  --text-dark: #1f2937;
  --text-muted: #6b7280;
  --border-soft: #e5e7eb;
  --shadow-soft: 0 10px 30px rgba(0,0,0,0.06);
}

        /* ================= REPORT FORM ================= */
/* ================= REPORT FORM ================= */
form {
    max-width: 520px;
    margin: 40px auto;
    padding: 35px 40px;
    background: var(--white);
    border-radius: 22px;
    box-shadow: var(--shadow-soft);
    font-family: 'Segoe UI', Tahoma, sans-serif;
}

/* ================= LABELS ================= */
form label {
    display: block;
    margin-bottom: 8px;
    font-size: 15px;
    font-weight: 700;
    color: var(--purple-dark);
    letter-spacing: 0.3px;
}

/* ================= SELECT & TEXTAREA ================= */
form select,
form textarea {
    width: 100%;
    padding: 14px 16px;
    border-radius: 14px;
    border: 1.5px solid var(--border-soft);
    background: var(--bg-light);
    font-size: 14px;
    color: var(--text-dark);
    margin-bottom: 22px;
    transition: all 0.25s ease;
}

/* Focus Effect */
form select:focus,
form textarea:focus {
    outline: none;
    border-color: var(--purple-dark);
    background: var(--white);
    box-shadow: 0 0 0 3px rgba(139,94,52,0.15); /* optional, or create a variable for this */
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
    background: linear-gradient(135deg, var(--purple-dark), var(--purple-soft));
    color: var(--white);
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 0.6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

/* Hover */
form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(91,45,139,0.35); /* or create a shadow-hover variable */
    background: linear-gradient(135deg, var(--purple-soft), var(--blue-soft));
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
