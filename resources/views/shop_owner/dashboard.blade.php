@extends('shop_owner.layout')

@section('title', 'Dashboard')

@section('content')

<title>Shop Owner Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<style>
/* ===============================
   THEME VARIABLES
================================ */
/* ===============================
   THEME
================================ */
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

/* ===============================
   BASE
================================ */
body {
  font-family: "Poppins", sans-serif;
  background: var(--bg-light);
  color: var(--text-dark);
  margin: 0;
}

/* ===============================
   NAVBAR
================================ */
.navbar-main {
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  color: #fff;
  padding: 14px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* ===============================
   MAIN CONTAINER
================================ */
.dashboard-container {
  width: 100%;
  max-width: 100%; /* no limit */
  margin: 0;       /* remove centering */
  padding: 20px;   /* keep some padding from edges */
  box-sizing: border-box; /* include padding in width */
}

/* ===============================
   SHOP INFO
================================ */
.shop-info {
    background: #fff;                  /* clean professional background */
    padding: 35px 40px;                /* taller card */
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 35px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
    flex-wrap: wrap;                    /* responsive wrapping */
    position: relative;                 /* keeps edit button in flow */
    margin-bottom: 35px;               /* space below so stats cards are visible */
    transition: transform 0.3s, box-shadow 0.3s;
}

.shop-info:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 45px rgba(0,0,0,0.18);
}

.shop-info img {
    width: 130px;                       /* bigger logo */
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ddd;
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.shop-info .details {
    flex: 1;
    min-width: 0;                       /* allows text ellipsis in flex */
}

.shop-info .details h2 {
    font-size: 2.2rem;                  /* bigger shop name */
    font-weight: 700;
    margin: 0 0 10px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.shop-info .details p {
    font-size: 1.1rem;                  /* larger description */
    margin: 5px 0;
    color: #555;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.edit-shop-btn {
    position: relative;                 /* inside card flow */
    background-color: #6a2fb0;
    color: #fff;
    border: none;
    padding: 12px 24px;                 /* bigger button */
    border-radius: 10px;
    font-size: 1rem;                    /* larger text */
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    height: fit-content;
}

.edit-shop-btn:hover {
    background-color: #8f3f9b;
    transform: translateY(-2px);
}

@media (max-width: 700px) {
    .shop-info {
        flex-direction: column;
        align-items: flex-start;
        padding: 25px;
        gap: 20px;
    }

    .edit-shop-btn {
        align-self: flex-end;
    }

    .shop-info img {
        width: 110px;
        height: 110px;
    }

    .shop-info .details h2 {
        font-size: 1.8rem;
    }

    .shop-info .details p {
        font-size: 1rem;
    }
}

.edit-shop-btn {
    position: relative;          /* keeps it in card flow */
    background-color: #6a2fb0;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    height: fit-content;
}

.edit-shop-btn:hover {
    background-color: #8f3f9b;
    transform: translateY(-2px);
}

@media (max-width: 700px) {
    .shop-info {
        flex-direction: column;
        align-items: flex-start;
        padding: 20px;
        gap: 15px;
    }

    .edit-shop-btn {
        align-self: flex-end;
    }

    .shop-info img {
        width: 100px;
        height: 100px;
    }

    .shop-info .details h2 {
        font-size: 1.6rem;
    }

    .shop-info .details p {
        font-size: 0.95rem;
    }
}
/* ===============================
   STATS
================================ */
.stats-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 25px;
  width: 100%; /* add this */
}

.table-container {
  width: 100%; /* add this */
}

.stat-card {
  background: #fff;
  padding: 25px;
  border-radius: 14px;
  text-align: center;
  box-shadow: var(--shadow-soft);
}

.stat-card h3 {
  font-size: 2.5rem; /* bigger number */
  color: var(--secondary);
  margin-bottom: 10px; /* more spacing */
  font-weight: 700; /* bolder */
}

.stat-card p {
  font-size: 1.25rem; /* bigger label */
  color: #555;         /* softer color */
  font-weight: 500;    /* semi-bold */
  margin: 0;           /* optional cleanup */
}

.stat-card {
  background: #fff;
  padding: 30px 25px; /* more padding */
  border-radius: 14px;
  text-align: center;
  box-shadow: var(--shadow-soft);
  transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

/* ===============================
   TABLES
================================ */
.table-container {
  background: #fff;
  padding: 25px;
  border-radius: 14px;
  margin-bottom: 40px;
  box-shadow: var(--shadow-soft);
}

table {
  width: 100%;
  border-collapse: collapse;
}

th {
  background: var(--primary);
  color: #fff;
  padding: 14px;
  text-align: left;
}

td {
  padding: 14px;
  border-bottom: 1px solid var(--border-soft);
}

/* ===============================
   BUTTONS
================================ */
button,
.add-btn {
  background: linear-gradient(135deg, var(--secondary), var(--accent));
  color: #fff;
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.25s;
}

button:hover,
.add-btn:hover {
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  transform: translateY(-2px);
}

/* ===============================
   FORMS
================================ */
input,
select,
textarea {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  border: 1px solid var(--border-soft);
  margin-bottom: 15px;
}

input:focus,
select:focus,
textarea:focus {
  border-color: var(--secondary);
  box-shadow: 0 0 0 3px rgba(31,123,184,0.2);
  outline: none;
}

/* ===============================
   MODALS
================================ */
.modal {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-content {
  background: #fff;
  padding: 30px;
  border-radius: 14px;
  width: 90%;
  max-width: 520px;
  animation: fade 0.3s ease;
}

@keyframes fade {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

/* ===============================
   VIEW MORE BUTTON
================================ */
.view-more-products {
  margin-top: 20px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 8px;
  background: #fff;
  color: var(--secondary);
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  transition: 0.3s;
}

.view-more-products:hover {
  background: var(--secondary);
  color: #fff;
}

/* ===============================
   RESPONSIVE
================================ */
@media (max-width: 768px) {
  .shop-info {
    flex-direction: column;
    text-align: center;
  }

  .stats-cards {
    grid-template-columns: 1fr;
  }
}

/* FIX MODAL CLOSE BUTTON */
.modal-content {
  position: relative; /* REQUIRED */
}

/* Close (X) button */
.close {
  position: absolute;
  top: 14px;
  right: 18px;
  font-size: 24px;
  font-weight: bold;
  color: #555;
  cursor: pointer;
  background: #f3f4f6;
  border-radius: 50%;
  width: 34px;
  height: 34px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.2s;
  z-index: 10;
}

.close:hover {
  background: var(--secondary);
  color: white;
  transform: scale(1.05);
}

.shop-info {
    position: relative; /* so the button can be absolutely positioned */
    background: white;
    padding: 20px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 20px;
}

.edit-shop-btn {
    position: absolute;   /* position inside the card */
    top: 20px;            /* distance from top of card */
    right: 20px;          /* distance from right of card */
    background-color: #C08A56;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    z-index: 10;          /* ensures it’s above other elements */
}

.edit-shop-btn:hover {
    background-color: #8B5E3C;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}

.edit-shop-btn:active {
    transform: scale(0.97);
}
.table-container {
    margin-bottom: 40px;
}

.hidden-section {
    display: none;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

.dashboard-section {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 24px;
    cursor: pointer;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
}

.section-header h2 {
    margin: 0;
    font-size: 1.4rem;
}

.section-header .toggle-icon {
    font-weight: bold;
    transition: transform 0.3s ease;
}

.section-content {
    padding: 20px 24px;
    display: none; /* Hidden by default */
    background: #f9f9f9;
}

.section-content form input {
    margin-bottom: 15px;
}

.dashboard-section {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.section-header {
    width: 100%;
    padding: 18px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    font-size: 1.2rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: background 0.3s, transform 0.3s;
    border-radius: 0;
}

.section-header:hover {
    background: linear-gradient(135deg, var(--secondary), var(--accent));
}

.section-header .toggle-icon {
    transition: transform 0.3s ease;
    font-size: 1.2rem;
}

.section-content {
    padding: 20px 24px;
    display: none; /* Hidden by default */
    background: #f9f9f9;
    border-top: 1px solid #eee;
}

.section-content form input {
    margin-bottom: 15px;
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* Put All Products on Sale button spacing */
.sale-all-btn {
    margin-top: 15px; /* adds space above the button */
    margin-bottom: 20px; /* optional: adds space below before the table */
}

.add-btn {
    margin-top: 10px; /* smaller space from table */
}

.view-more-products {
    display: inline-flex;          /* keep icon and text aligned */
    align-items: center;
    gap: 6px;                      /* space between text and icon */
    padding: 8px 16px;             /* nicer clickable area */
    border-radius: 8px;            /* rounded corners */
    background: #fff;               /* white background */
    color: var(--secondary);        /* matches your theme */
    text-decoration: none;          /* remove underline */
    font-weight: 500;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1); /* subtle shadow */
    transition: 0.3s;
}

.view-more-products:hover {
    background: var(--secondary);
    color: #fff;                   /* invert text on hover */
    transform: translateY(-2px);   /* small lift effect */
    text-decoration: none;         /* ensure no underline on hover */
}

.dashboard-section.loyalty {
    margin-top: 30px; /* adds space from the stats cards */
}

.navbar-main {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    padding: 20px 40px; /* taller and wider */
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* subtle shadow for depth */
}

.navbar-main .logo {
    font-size: 1.6rem;   /* bigger and more visible */
    font-weight: 600;
    letter-spacing: 1px;
}

input[type="checkbox"] {
    width: auto !important;
    display: inline-block !important;
    margin: 0;
}
.status-pending {
    color: #856404;
    background-color: #fff3cd;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
    display: inline-block;
}

.status-delivered {
    color: #155724;
    background-color: #d4edda;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
    display: inline-block;
}

.status-cancelled {
    color: #721c24;
    background-color: #f8d7da;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
    display: inline-block;
}


.status-shipped {
    color: #0c5460;
    background-color: #d1ecf1;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
    display: inline-block;
}
.status-processing {
    color: #0c1ccd;
    background-color: #d1ecf1;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
    display: inline-block;
}
.status-cancelled {
    color: #cd0c0c;
    background-color: #d1ecf1;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
    display: inline-block;
}

.image-slider {
    position: relative;
    width: 120px;
    height: 120px;
}

.slider-image {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
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

.slider-btn.left {
    left: 4px;
}

.slider-btn.right {
    right: 4px;
}
/* ===============================
   PAGINATION STYLE
================================ */
/* ===============================
   PAGINATION STYLE (TEXT)
================================ */
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

.pagination .disabled span {
    opacity: 0.4;
}

.pagination li a {
    font-size: 14px !important;
}

.pagination li a::before,
.pagination li a::after {
    content: none !important;
}


/* Modal common styles */
.modal {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-content {
  background: #fff;
  padding: 30px;
  border-radius: 14px;
  width: 90%;
  max-width: 400px;
  animation: fade 0.3s ease;
  position: relative;
}

.close {
  position: absolute;
  top: 12px;
  right: 12px;
  font-size: 24px;
  cursor: pointer;
  font-weight: bold;
  color: #555;
  background: #f3f4f6;
  border-radius: 50%;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.close:hover {
  background: #8f3f9b;
  color: white;
}

.modal-content input {
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
}

.modal-content button {
  margin-top: 15px;
  padding: 10px 16px;
  border-radius: 6px;
  border: none;
  background-color: #6a2fb0;
  color: #fff;
  cursor: pointer;

}

.modal-content button:hover {
  background-color: #8f3f9b;
}

/* Button */
.loyalty-btn {
    background-color: var(--purple-dark);
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
}

/* Modal background */
.modal {
    display: none; /* hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

/* Modal content */
.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 25px;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    position: relative;
}

/* Close button */
.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 1.5rem;
    cursor: pointer;
}


.shop-actions {
    display: flex;
    flex-direction: column; /* stack buttons vertically */
    gap: 12px;              /* space between buttons */
    margin-top: 15px;       /* optional: spacing from shop details */
}

.edit-shop-btn {
    position: relative;     /* remove absolute positioning */
    width: fit-content;     /* keep button width to content */
    background-color: #C08A56;
    color: #fff;
    border: none;
    padding: 12px 25px;     /* slightly bigger for visual consistency */
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.edit-shop-btn:hover {
    background-color: #8B5E3C;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}

.shop-actions {
    display: flex;
    flex-direction: column; /* stack buttons vertically */
    gap: 12px;              /* space between buttons */
    margin-top: 15px;       /* optional: spacing from shop details */
}

.edit-shop-btn {
    position: relative;     /* remove absolute positioning */
    width: fit-content;     /* keep button width to content */
    background-color: #C08A56;
    color: #fff;
    border: none;
    padding: 12px 25px;     /* slightly bigger for visual consistency */
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.edit-shop-btn:hover {
    background-color: #8B5E3C;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}

.shop-info {
    display: flex;
    justify-content: space-between;  /* details left, buttons right */
    align-items: center;             /* vertical centering */
    padding: 20px 30px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
    gap: 20px;
}

.shop-details {
    display: flex;
    align-items: center;
    gap: 20px;
}

.details-text {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.shop-actions {
    display: flex;
    flex-direction: column;         /* stack buttons vertically */
    justify-content: center;        /* vertical center in parent */
    gap: 12px;                      /* space between buttons */
}

.shop-btn {
    min-width: 160px;               /* same width for both */
    padding: 12px 20px;
    background-color: #5b2a86;      /* same color for all */
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.shop-btn:hover {
    background-color: #8B5E3C;
    transform: translateY(-2px);
}

.shop-actions {
    display: flex;
    flex-direction: column;        /* stack buttons vertically */
    justify-content: center;       /* vertical center in parent */
    gap: 12px;                     /* space between buttons */
}

.shop-btn {
    width: 230px;                  /* slightly smaller width */
    padding: 16px 20px;            /* taller height */
    font-size: 1.1rem;             /* bigger text */
    font-weight: 600;
    background: linear-gradient(90deg, #5b2a86, #8f3f9b); /* match your existing gradient */
    color: #fff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.shop-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* Bigger products table */
#productsTable th {
    font-size: 1.3rem;
    padding: 20px;
}

#productsTable td {
    font-size: 1.05rem;
    padding: 18px;
}

.image-slider {
    position: relative;
    width: 160px;
    height: 160px;
}

.slider-image {
    width: 160px;
    height: 160px;
    object-fit: cover;
    border-radius: 12px;
}

#productsTable tr {
    vertical-align: middle;
}
#productsTable button {
    font-size: 1rem;
    padding: 8px 12px;
    border-radius: 8px;
}


#productsTable strong {
    font-size: 1.2rem;
}

/* Make numbers bigger in products table */
#productsTable td {
    font-size: 1.1rem;
}

#productsTable td strong {
    font-size: 1.25rem;   /* main price bigger */
    font-weight: 700;
}

/* Price styling */
#productsTable td strong {
    font-size: 1.4rem;
    
}
/* Stock quantity */
#productsTable td:nth-child(3) {
    font-size: 1.2rem;
    font-weight: 600;
}

/* On Sale Badge */
.sale-badge {
    display: inline-block;
    padding: 6px 14px;
    font-size: 1rem;
    font-weight: 700;
    border-radius: 20px;
    text-align: center;
}

/* Green for ON SALE */
.sale-badge.yes {
    background: #e6fff2;
    color: #00a65a;
    border: 2px solid #00a65a;
}

/* Gray for NO SALE */
.sale-badge.no {
    background: #f2f2f2;
    color: #666;
    border: 2px solid #ccc;
}

/* Make On Sale toggle bigger */
.sale-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.2rem;   /* Bigger text */
    font-weight: 600;
}

/* Make checkbox bigger */
.sale-toggle input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

#productsTable td button {
    font-size: 1.1rem;     /* bigger text */
    padding: 8px 12px;     /* bigger size */
    border-radius: 6px;    /* soft corners */
}

#product-section h2 {
    font-size: 2rem;         /* bigger text */
    font-weight: 700;        /* bold */
    margin-bottom: 20px;     /* space below */
    color: var(--primary);   /* theme color */
}

.sale-all-btn {
    font-size: 1.1rem;       /* bigger text */
    padding: 12px 22px;      /* bigger clickable area */
    border-radius: 10px;     /* nice rounded corners */
    font-weight: 600;
    margin-bottom: 25px;     /* space from table */
}
#product-section {
    margin-top: 40px;  /* space between stats cards and table */
}

/* Buttons / Links in Product Header */
.view-more-products,
.add-btn {
    font-size: 1.2rem;         /* bigger text */
    padding: 10px 18px;        /* bigger clickable area */
    font-weight: 600;
    border-radius: 8px;        /* slightly rounded */
    text-decoration: none;     /* remove underline from link */
    display: flex;
    align-items: center;
    gap: 6px;                  /* space between text and icon */
    transition: all 0.2s ease;
}

.add-btn {
    cursor: pointer;
    background-color: var(--primary-color, #5b2a86); /* optional color */
    color: white;
    border: none;
}

.add-btn:hover {
    transform: scale(1.05);
}

.view-more-products:hover {
    transform: scale(1.05);
}

//* ===============================
   ORDERS TABLE BIGGER & BOLDER
================================ */
#ordersTable {
    width: 100%;
    border-collapse: collapse;
    font-size: 1.1rem;         /* bigger font */
}

#ordersTable th,
#ordersTable td {
    padding: 18px 20px;        /* bigger cells */
    font-size: 1.15rem;        /* slightly bigger text */
}

#ordersTable th {
    font-weight: 700;           /* bolder headers */
    font-size: 1.25rem;         /* bigger header text */
    color: #fff;                /* white text */
    background: var(--primary); /* same theme color as products table headers */
    text-align: left;
}

#ordersTable td {
    font-weight: 600;           /* make table content bolder */
    color: #1e1b4b;             /* dark color, like products table */
}

#ordersTable tr {
    vertical-align: middle;     /* keep cells centered */
}

/* Status badges stay same colors but bolder text */
.status-pending,
.status-delivered,
.status-cancelled,
.status-shipped,
.status-processing {
    font-weight: 700;           /* bolder text */
    padding: 6px 10px;          /* slightly bigger badge */
    border-radius: 8px;         /* softer corners */
    font-size: 1.05rem;         /* slightly bigger */
}

/* View More Orders button bigger like products table */
#viewMoreOrders {
    font-size: 1.2rem;          /* bigger text */
    padding: 12px 22px;         /* bigger clickable area */
    border-radius: 10px;
    font-weight: 600;
}


/* Navbar logo and text bigger */
.navbar-main .logo {
    font-size: 2rem;        /* bigger text */
    font-weight: 700;       /* bolder */
    letter-spacing: 1px;    /* subtle spacing */
}

/* Logout link bigger and more clickable */
.navbar-main a {
    font-size: 1.25rem;     /* bigger link text */
    font-weight: 600;       /* semi-bold */
    color: #fff;            /* keep white */
    text-decoration: none;
    margin-left: 10px;      /* spacing from icon */
}

.navbar-main a:hover {
    text-decoration: underline;
}

/* Logout icon bigger */
.navbar-main .fa-sign-out {
    font-size: 1.3rem;      /* bigger icon */
    margin-right: 5px;
    vertical-align: middle; /* aligns with text */
}

/* Recent Orders title */
.table-container h2 {
    font-size: 2rem;      /* bigger title */
    font-weight: 700;     /* bold */
    margin-bottom: 20px;  /* space below the title */
    color: var(--primary); /* match your theme color like products table */
}

/* Modal background (centered) */
.modal {
    display: none; /* hidden by default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Modal content: bigger */
.modal-content {
    background-color: #fff;
    margin: 0 auto;
    padding: 35px 50px;        /* bigger padding */
    border-radius: 14px;
    width: 600px;              /* wider modal */
    max-width: 90%;            /* responsive for smaller screens */
    box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    position: relative;
    font-size: 1.15rem;        /* slightly bigger text */
}

/* Modal heading */
.modal-content h2 {
    font-size: 2rem;           /* bigger heading */
    margin-bottom: 25px;
    color: var(--purple-dark);
    text-align: center;
}

/* Modal inputs */
.modal-content input,
.modal-content textarea,
.modal-content select {
    padding: 14px 16px;
    font-size: 1.15rem;       /* slightly bigger */
    border-radius: 8px;
    border: 1px solid var(--border-soft);
    margin-bottom: 20px;
}

/* Modal buttons */
.modal-content button {
    padding: 14px 30px;
    font-size: 1.25rem;        /* bigger button text */
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-content button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

/* Close button */
.close-btn {
    position: absolute;
    top: 12px;
    right: 16px;
    font-size: 1.5rem;          /* bigger close button */
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

.close-btn:hover {
    background-color: var(--purple-soft);
    color: white;
    transform: scale(1.05);
}
/* Modal background (hidden by default) */
.modal {
    display: none; /* keep hidden until triggered */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);

    justify-content: center;  /* center content */
    align-items: center;      /* vertical center */
}

/* Modal content */
.modal-content {
    background-color: #fff;
    padding: 35px 50px;
    border-radius: 14px;
    width: 600px;
    max-width: 90%;
    box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    position: relative;
    font-size: 1.15rem;
}

/* Modal background */
.modal {
    display: none;              /* hidden by default */
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 1000;

    justify-content: center;    /* horizontal center */
    align-items: center;        /* vertical center */
}

/* When modal is active */
.modal.show {
    display: flex;
}

/* Modal box */
.modal-content {
    background: #fff;
    padding: 35px 45px;
    border-radius: 14px;
    width: 600px;
    max-width: 90%;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    position: relative;

    /* ❌ REMOVE ANY margin: 10% auto */
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

/* Consistent button styles for all dashboard buttons */
.shop-btn, 
.view-more-products,
.add-btn,
.sale-all-btn,
.modal-content button,
.edit-shop-btn {
    background: linear-gradient(135deg, var(--secondary), var(--accent));
    color: #fff;
    border: none;
    padding: 12px 22px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(91, 42, 134, 0.2);
}

.shop-btn:hover,
.view-more-products:hover,
.add-btn:hover,
.sale-all-btn:hover,
.modal-content button:hover,
.edit-shop-btn:hover {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(91, 42, 134, 0.3);
}

.shop-btn:active,
.view-more-products:active,
.add-btn:active,
.sale-all-btn:active,
.modal-content button:active,
.edit-shop-btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 5px rgba(91, 42, 134, 0.2);
}

/* Specific adjustments for each button type */
.shop-btn {
    min-width: 200px;
    height: 52px;
    font-size: 1.15rem;
}

.view-more-products {
    padding: 10px 18px;
}

.add-btn {
    padding: 10px 18px;
}

.sale-all-btn {
    margin-top: 15px;
    margin-bottom: 25px;
}

/* Modal buttons */
.modal-content button {
    padding: 14px 30px;
    font-size: 1.25rem;
    border-radius: 10px;
    width: 100%;
    margin-top: 15px;
}


</style>

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
        <div class="shop-actions">
    <button class="shop-btn" onclick="openEditShop()">
       </i>✏️ Edit Shop
    </button>
    <button class="shop-btn" onclick="openLoyaltyModal()">
        </i>⭐ Loyalty Program
    </button>
</div>

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


<!-- Loyalty Modal -->
<div id="loyaltyModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeLoyaltyModal()">&times;</span>
        <h2>Loyalty Program Settings</h2>
        <form id="loyaltyForm">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->shop_id }}">
            <label>Minimum Orders</label>
            <input type="number" name="min_orders" value="{{ $loyaltySetting->min_orders ?? 5 }}">
            <label>Minimum Revenue ($)</label>
            <input type="number" name="min_revenue" value="{{ $loyaltySetting->min_revenue ?? 200 }}">
            <label>Discount Percentage (%)</label>
            <input type="number" name="discount_percentage" value="{{ $loyaltySetting->discount_percentage ?? 10 }}">
            <button type="button" onclick="saveLoyaltySettings()">Save</button>
        </form>
    </div>
</div>

    
   <!-- Products Table -->
<div class="table-container" id="product-section">
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
        <tbody id="productsBody">
            @foreach($products as $product)
                 <tr class="{{ $product->stock_quantity < 5 ? 'low-stock-row' : '' }}">
                    <td>
                        <div class="image-slider" data-index="0">
                            @if($product->images->count() > 0)
                                @foreach($product->images as $image)
                                    <img src="{{ asset('storage/'.$image->image_path) }}" class="slider-image" style="display:none;">
                                @endforeach
                                @if($product->images->count() > 1)
                                    <button class="slider-btn left" onclick="prevImage(this)">❮</button>
                                    <button class="slider-btn right" onclick="nextImage(this)">❯</button>
                                @endif
                            @else
                                <img src="{{ asset('image/default.jpg') }}"  style="width:160px;height:160px;object-fit:cover;border-radius:12px;">
                            @endif
                        </div>
                        <div>
                            <strong>{{ $product->product_name }}</strong><br>
                            <small>{{ $product->shop->shop_name ?? 'Brand' }}</small>
                        </div>
                    </td>

                    <td>
                        <div style="display:flex; flex-direction:column; gap:4px;">
                            <strong>${{ $product->price }}</strong>
                            @if($product->is_on_sale)
                                <span style="color:red; font-size:1.2rem; font-weight:600;">Sale: ${{ $product->discount_value }}</span>
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
                        <button onclick="editProduct({{ $product->product_id }})">✏️</button>
                        <button onclick="deleteProduct({{ $product->product_id }})">🗑️</button>
                        <button onclick="openSaleProduct({{ $product->product_id }})">💲 Sale</button>
                        <button onclick="openEditStock({{ $product->product_id }}, {{ $product->stock_quantity }})">📦 Edit Stock</button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

   
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
        <a href="{{ route('shop.products.all') }}" class="view-more-products">
            View More Products <i class="fa fa-arrow-right"></i>
        </a>
        <button onclick="openAddProduct()" class="add-btn">
            <i class="fa fa-plus"></i> Add New Product
        </button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


$(document).ready(function() {
    initSliders();
});


$(document).on('click', '.ajax-link', function(e){
    e.preventDefault();
    var url = $(this).attr('href');

    $.ajax({
        url: url,
        type: 'GET',
        success: function(response){
           
            $('#productsBody').html($(response).find('#productsBody').html());
            $('#pagination-links').html($(response).find('#pagination-links').html());

          
            initSliders();

     
            $('#product-section')[0].scrollIntoView({ behavior: 'smooth' });
        }
    });
});
</script>


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
            <tr onclick="window.location='{{ route('shop.orders.show', ['order' => $order->order_id, 'return_to' => 'dashboard']) }}'"
                style="cursor:pointer;">
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->customer_name ?? 'N/A' }}</td>
                <td>${{ number_format($order->total_amount, 2) }}</td>
              <td>
    @php
        $statusClass = match(strtolower($order->order_status)) {
            'pending' => 'status-pending',
            'delivered' => 'status-delivered',
            'cancelled' => 'status-cancelled',
            'shipped' => 'status-shipped',
            'processing' => 'status-processing',
             'cancelled' => 'status-cancelled',
            default => ''
        };
    @endphp

    <span class="{{ $statusClass }}">{{ $order->order_status }}</span>
</td>


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

</div> <!-- End of dashboard-container -->

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
            <input type="file" name="images[]" multiple accept="image/*">
            <button type="button" onclick="saveProduct()">Save</button>
        </form>
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

<!-- Sale Modal -->
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
    // Your JavaScript code here (keep it as is)
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

    function saveLoyaltySettings() {
        let form = document.getElementById('loyaltyForm');
        let formData = new FormData(form);

        fetch("{{ route('shop.loyalty.save') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("✅ Loyalty settings saved!");
            } else {
                alert("❌ Failed to save loyalty settings");
            }
        })
        .catch(err => {
            console.error(err);
            alert("❌ Server error");
        });
    }

    function toggleSection(id) {
        const section = document.getElementById(id);
        const button = section.previousElementSibling;
        const icon = button.querySelector('.toggle-icon');

        if (section.style.display === "none" || section.style.display === "") {
            section.style.display = "block";
            icon.style.transform = "rotate(180deg)";
        } else {
            section.style.display = "none";
            icon.style.transform = "rotate(0deg)";
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".image-slider").forEach(slider => {
        const images = slider.querySelectorAll(".slider-image");
        if (images.length > 0) {
            images[0].style.display = "block";
        }
    });
});

function nextImage(btn) {
    const slider = btn.closest('.image-slider');
    const images = slider.querySelectorAll('.slider-image');
    let index = parseInt(slider.dataset.index);

    images[index].style.display = "none";
    index = (index + 1) % images.length;
    images[index].style.display = "block";

    slider.dataset.index = index;
}

function prevImage(btn) {
    const slider = btn.closest('.image-slider');
    const images = slider.querySelectorAll('.slider-image');
    let index = parseInt(slider.dataset.index);

    images[index].style.display = "none";
    index = (index - 1 + images.length) % images.length;
    images[index].style.display = "block";

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

function openLoyaltyModal() {
    document.getElementById('loyaltyModal').style.display = 'block';
}

function closeLoyaltyModal() {
    document.getElementById('loyaltyModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('loyaltyModal');
    if (event.target === modal) modal.style.display = 'none';
}


</script>

@endsection