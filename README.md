# Beiroutique 🛍️

**All You Need, In One Place.**

Beiroutique is an online fashion marketplace developed as a Computer Science graduation project. The platform aims to connect local Lebanese shops with customers, providing a convenient shopping experience through one marketplace.

## ✨ Features

- **Multi-role authentication:** Separate experiences for customers, shop owners, and administrators.
- **Product Marketplace:** Browse products offered by different local shops.
- **Shop Management:** Tools for shop owners to manage their products and store information.
- **Admin Dashboard:** Manage and oversee marketplace activities.
- **Customer Loyalty Program:** Reward eligible customers with discounts based on order history and revenue.
- **Product Search:** Search functionality to help customers discover products.
- **Responsive Interface:** Designed to provide a user-friendly shopping experience.

## 🛠️ Tech Stack

- **Backend:** Laravel, PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript, and Laravel Blade
- **Authentication & Authorization:** Role-based access control
- **Additional Tools:** Python-based image search and product similarity features

## 👥 User Roles

- **Customer:** Browse products and shop through the marketplace.
- **Shop Owner:** Manage shop products and information.
- **Administrator:** Oversee users, shops, and marketplace operations.

## ⚙️ Installation

### Prerequisites

- PHP 8.2 or compatible version
- Composer
- MySQL
- Node.js and npm

### Setup

1. Clone the repository:

   ```bash
   git clone https://github.com/fatimabakri123/beiroutique.git
   ```

2. Navigate to the project directory:

   ```bash
   cd beiroutique
   ```

3. Install PHP dependencies:

   ```bash
   composer install
   ```

4. Create your environment file:

   ```bash
   cp .env.example .env
   ```

5. Generate the application key:

   ```bash
   php artisan key:generate
   ```

6. Configure your database credentials in `.env`.

7. Run database migrations:

   ```bash
   php artisan migrate
   ```

8. Install frontend dependencies:

   ```bash
   npm install
   npm run build
   ```

9. Start the development server:

   ```bash
   php artisan serve
   ```

## 🔐 Environment Configuration

Configure your local `.env` file with your database settings and any required API credentials.

**Never commit your `.env` file or expose passwords, API keys, or other secrets.**

## 🎓 Project Purpose

Beiroutique was developed as a graduation project to explore e-commerce development, marketplace management, database design, authentication, and product discovery.

## 👩‍💻 Author

**Fatima Ali Bakri**

- GitHub: [@fatimabakri123](https://github.com/fatimabakri123)

---

*Built with Laravel and MySQL.*
