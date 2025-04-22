<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            'Super Speaker',
            'Wireless Charger',
            'Smart Thermostat',
            'Bluetooth Headphones',
            'Portable Projector',
            'Gaming Keyboard',
            'Smartwatch Pro',
            'Wireless Mouse',
            '4K Action Camera',
            'Noise Cancelling Earbuds',
            'LED Desk Lamp',
            'Mini Drone',
            'USB-C Hub',
            'Fitness Tracker',
            'VR Headset'
        ];

        foreach ($products as $index => $name) {
            Product::create([
                'name' => $name,
                'slug' => Str::slug($name) . '-' . ($index + 1),
                'short_description' => 'Short description of ' . $name,
                'description' => 'Full product description for ' . $name . '. This includes specs, features, and usage.',
                'regular_price' => rand(50, 300),
                'sale_price' => rand(30, 200),
                'SKU' => 'SKU-' . strtoupper(Str::random(8)),
                'stock_status' => 'instock',
                'featured' => (bool)rand(0, 1),
                'quantity' => rand(5, 50),
                'image' => 'products/' . Str::slug($name) . '.jpg',
                'images' => json_encode(['products/' . Str::slug($name) . '_1.jpg', 'products/' . Str::slug($name) . '_2.jpg']),
                'category_id' => 1,
                'brand_id' => 3,
                'meta_title' => $name . ' - Best Price Online',
                'meta_description' => 'Buy ' . $name . ' with best quality and price. Available now!',
                'meta_keywords' => $name . ', electronics, buy online',
                'image_alt_text' => $name . ' image',
            ]);
        }
    }
}

