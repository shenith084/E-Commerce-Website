# ShopX E-Commerce Platform

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-5.0-646CFF?style=for-the-badge&logo=vite)](https://vitejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql)](https://www.mysql.com)

A modern, full-featured E-Commerce platform built with **Laravel 11**, featuring a sleek user interface, advanced product management, and secure payment integration.

## 🚀 Key Functionalities

### Customer Features
- **Product Discovery**: Browse products by categories with a responsive shop interface and real-time search.
- **Cart Management**: Add, update, and remove items from a persistent shopping cart.
- **Checkout Flow**: Secure multi-step checkout process with automated order placement.
- **Payment Integration**: Seamless integration with **Payhere** for secure transactions.
- **Order Tracking**: View order history, status updates, and detailed order summaries in the customer dashboard.
- **Wishlist**: Save favorite products for later purchase with easy management.
- **Product Reviews**: Leave star ratings and text feedback on purchased items.
- **User Profile**: Manage account details, avatars, and shipping information.
- **Contact System**: Direct messaging to admin via a dedicated contact form.

### Admin Features
- **Administrative Dashboard**: Real-time overview of sales performance, active orders, and store activity.
- **Inventory Management**: Full CRUD operations for products and categories with image uploads.
- **Order Management**: Monitor and process customer orders, including status updates (Pending to Shipped/Completed).
- **Customer Feedback**: Manage contact messages and moderate product reviews.
- **User Management**: Overview of registered customers and administrative access.

## 🔐 Default Credentials

For testing purposes, you can use the following accounts after seeding the database:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@shopx.com` | `password` |
| **Customer** | `[EMAIL_ADDRESS]` | `password` |

## 🛠️ Technology Stack & Libraries

### Backend & Infrastructure
- **Laravel 11**: Modern PHP framework for robust applications.
- **MySQL**: Relational database for persistent storage.
- **Laravel Breeze**: Secure and customizable authentication system.
- **Stripe/Payhere**: For handling secure online payments.

### Frontend
- **Blade Templates**: Traditional server-side rendering for optimal SEO.
- **Tailwind CSS**: Utility-first styling for a premium, custom aesthetic.
- **Vite**: Modern build tool for lightning-fast frontend development.
- **Alpine.js**: Lightweight JavaScript for interactive UI components.
- **Lucide Icons**: Beautiful, consistent vector icons.

## 💻 Installation & Setup

1. **Clone the project**
   ```bash
   git clone https://github.com/shenith084/E-Commerce-Website.git
   cd e-commerce-website
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   Copy the environment file and configure your database settings:
   ```bash
   cp .env.example .env
   ```
   *Edit `.env` to set your `DB_DATABASE`, `PAYHERE_MERCHANT_ID`, and `PAYHERE_SECRET`.*

4. **Generate Application Key & Database Setup**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```

5. **Start Development Server**
   ```bash
   npm run dev
   # In a new terminal
   php artisan serve
   ```
   Access the app at `http://localhost:8000`.

## 🧪 Testing & Development

### Local Payment Simulation
To facilitate development without needing a live Payhere account, the system includes a **Payment Simulation** mode. When checking out on `localhost`, you can use the built-in test gateway to simulate successful or failed transactions.

### Mail Testing
Emails (verification, order confirmation) are currently configured to use the `log` driver. You can find outgoing emails in `storage/logs/laravel.log`.

## 📂 Codebase Overview

- `app/Http/Controllers`: Business logic controllers.
  - `Admin/`: Management logic for products, orders, and users.
  - `Auth/`: Authentication workflows (Login, Register, Password Reset).
- `app/Models`: Eloquent models defining relationships (User, Product, Order, Category, Review).
- `database/migrations`: Database schema definitions.
- `resources/views`: Blade templates organized by domain.
  - `admin/`: Administrator dashboard and management interfaces.
  - `dashboard/`: Customer account and order management.
  - `shop/`: Product catalog and search.
- `routes/web.php`: Centralized route definitions with middleware protection.

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
