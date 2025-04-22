<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        {
            $categories = [
                'Electronics',
                'Fashion',
                'Home Appliances',
                'Books',
                'Sports',
                'Toys',
                'Groceries',
                'Beauty & Personal Care',
                'Health',
                'Automotive',
                'Food & Beverages',
                'Furniture',
                'Pet Supplies',
                'Baby Products',
                'Jewelry',
                'Gardening',
                'Music & Instruments',
                'Office Supplies',
                'Outdoor & Adventure',
                'Technology'
            ];

            foreach ($categories as $index => $name) {
                Category::create([
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . ($index + 1),
                    'image' => 'categories/' . Str::slug($name) . '.jpg',
                    'parent_id' => null,  // You can assign a parent ID if necessary
                    'meta_title' => $name . ' - Best Products Online',
                    'meta_description' => 'Shop the best ' . $name . ' online. Available at the best prices.',
                    'meta_keywords' => $name . ', online shopping, buy ' . $name,
                    'image_alt_text' => $name . ' image',
                ]);
            }
        }
    }
}
