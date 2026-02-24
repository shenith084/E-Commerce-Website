# E-Commerce Website

A modern, full-featured E-Commerce platform built with Laravel 11, featuring a clean user interface, advanced product management, and secure payment integration.

## 🚀 Key Functionalities

### Customer Features
- **Product Discovery**: Browse products by categories with a responsive shop interface.
- **Cart Management**: Add, update, and remove items from a persistent shopping cart.
- **Checkout Flow**: Secure multi-step checkout process with order placement.
- **Payment Integration**: Seamless integration with **Payhere** for secure transactions.
- **Order Tracking**: View order history, status updates, and detailed order summaries in the customer dashboard.
- **Wishlist**: Save favorite products for later purchase.
- **Product Reviews**: Leave ratings and feedback on purchased items.
- **User Profile**: Manage account details and shipping information.

### Admin Features
- **Dashboard**: Real-time overview of sales performance and store activity.
- **Inventory Management**: Full CRUD operations for products and categories.
- **Order Management**: Monitor and process customer orders, including status updates.
- **Customer Feedback**: Manage contact messages and product reviews from customers.

## 🛠️ Technology Stack & Libraries

### Backend
- **Laravel 11**: The core PHP framework.
- **MySQL/SQLite**: Database management.
- **Composer**: PHP dependency management.
- **Laravel Breeze**: Robust authentication system.

### Frontend
- **Blade Templates**: Traditional Laravel rendering with modern interactivity.
- **Tailwind CSS**: Utility-first styling for a premium aesthetic.
- **Vite**: Ultra-fast frontend build tool.
- **Alpine.js**: Lightweight JavaScript framework for interactive UI components.
- **Lucide Icons**: Beautiful, consistent SVG icons.

### Third-Party Integrations
- **Payhere**: Payment gateway for sandbox and production transactions.
- **Faker**: For generating realistic test data.

## 💻 Installation & Setup

Follow these steps to get the project running on your local machine:

1. **Clone the project**
   ```bash
   git clone https://github.com/yourusername/e-commerce-website.git
   cd e-commerce-website
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   Copy the example environment file and configure your database and Payhere credentials:
   ```bash
   cp .env.example .env
   ```
   *Edit `.env` to set your `DB_DATABASE`, `PAYHERE_MERCHANT_ID`, and `PAYHERE_SECRET`.*

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Database Setup**
   Run migrations and seed the database with initial data (categories, products, and admin user):
   ```bash
   php artisan migrate --seed
   ```

6. **Compile Assets**
   ```bash
   npm run dev
   ```

7. **Start the Server**
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`.

## 📂 Codebase Overview

- `app/Http/Controllers`: Contains the business logic for both the storefront and admin panel.
  - `Admin/`: Specific logic for administrative management.
  - `Auth/`: Laravel Breeze authentication handlers.
- `database/migrations`: Defines the database schema (Users, Products, Orders, etc.).
- `resources/views`: Blade templates for the entire UI.
  - `dashboard/`: Customer-facing account pages.
  - `admin/`: Admin-facing dashboard and management pages.
- `routes/web.php`: Comprehensive route definitions for public access, customers, and admins.

## 🧭 Navigation Guide

### Storefront
- **Home**: Featured sections and call-to-actions.
- **Shop**: Browse and search through the product catalog.
- **Cart**: Review selected items before checkout.
- **Dashboard**: Accessed via login; contains order history and profile settings.

### Admin Panel
Accessible via `/admin` for users with administration privileges:
- **Products**: Manage the product inventory.
- **Categories**: Organize products into groups.
- **Orders**: View and manage customer transactions.
- **Messages**: Handle inquiries sent via the contact form.

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
