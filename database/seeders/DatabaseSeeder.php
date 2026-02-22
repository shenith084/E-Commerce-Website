<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@shopx.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create Demo Customer
        User::create([
            'name'     => 'John Doe',
            'email'    => 'customer@shopx.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Categories
        $categories = [
            ['name' => 'Electronics',   'slug' => 'electronics',   'description' => 'Electronic devices and accessories'],
            ['name' => 'Clothing',       'slug' => 'clothing',       'description' => 'Fashion and apparel'],
            ['name' => 'Books',          'slug' => 'books',          'description' => 'Books and educational materials'],
            ['name' => 'Home & Living',  'slug' => 'home-living',    'description' => 'Furniture, decor and more'],
            ['name' => 'Sports',         'slug' => 'sports',         'description' => 'Sports equipment and accessories'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Products
        $products = [
            ['category_id' => 1, 'name' => 'Wireless Earbuds',    'slug' => 'wireless-earbuds',    'description' => 'Premium wireless earbuds with noise cancellation.', 'price' => 4999.00, 'stock' => 50, 'is_featured' => true],
            ['category_id' => 1, 'name' => 'Smart Watch',          'slug' => 'smart-watch',          'description' => 'Feature-packed smart watch with health tracking.', 'price' => 12999.00,'stock' => 30, 'is_featured' => true],
            ['category_id' => 1, 'name' => 'Bluetooth Speaker',    'slug' => 'bluetooth-speaker',    'description' => 'Portable waterproof Bluetooth speaker.', 'price' => 3500.00, 'stock' => 40],
            ['category_id' => 2, 'name' => 'Men\'s Polo Shirt',   'slug' => 'mens-polo-shirt',      'description' => 'Comfortable cotton polo shirt for men.', 'price' => 1200.00, 'stock' => 100],
            ['category_id' => 2, 'name' => 'Women\'s Kurti',      'slug' => 'womens-kurti',         'description' => 'Elegant floral print kurti.', 'price' => 1500.00, 'stock' => 80,  'is_featured' => true],
            ['category_id' => 3, 'name' => 'Laravel Best Practices','slug' => 'laravel-best-practices','description' => 'Master Laravel with hands-on projects.', 'price' => 2200.00, 'stock' => 60],
            ['category_id' => 3, 'name' => 'Clean Code',           'slug' => 'clean-code',           'description' => 'A handbook of agile software craftsmanship.', 'price' => 1800.00, 'stock' => 45],
            ['category_id' => 4, 'name' => 'LED Table Lamp',       'slug' => 'led-table-lamp',       'description' => 'Eye-care LED lamp with USB charging port.', 'price' => 2500.00, 'stock' => 35],
            ['category_id' => 4, 'name' => 'Decorative Cushion',   'slug' => 'decorative-cushion',   'description' => 'Soft velvet decorative cushion covers.', 'price' => 650.00,  'stock' => 120],
            ['category_id' => 5, 'name' => 'Yoga Mat',             'slug' => 'yoga-mat',             'description' => 'Non-slip eco-friendly yoga mat.', 'price' => 1900.00, 'stock' => 70, 'is_featured' => true],
            ['category_id' => 5, 'name' => 'Resistance Bands Set', 'slug' => 'resistance-bands-set', 'description' => 'Set of 5 resistance bands for home workouts.', 'price' => 1100.00, 'stock' => 90],
        ];

        foreach ($products as $prod) {
            Product::create(array_merge(['is_active' => true, 'is_featured' => false], $prod));
        }
    }
}
