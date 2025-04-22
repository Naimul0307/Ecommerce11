<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            'Apple',
            'Samsung',
            'Sony',
            'Nike',
            'Adidas',
            'LG',
            'HP',
            'Dell',
            'Canon',
            'Bose',
            'GoPro',
            'Fitbit',
            'Xiaomi',
            'Microsoft',
            'Oppo',
            'Huawei',
            'Lenovo',
            'Asus',
            'JBL',
            'Beats'
        ];

        foreach ($brands as $index => $name) {
            Brand::create([
                'name' => $name,
                'slug' => Str::slug($name) . '-' . ($index + 1),
                'image' => 'brands/' . Str::slug($name) . '.jpg', // Assuming you store brand images in the 'public/brands' directory
                'meta_title' => $name . ' - Shop Best Products Online',
                'meta_description' => 'Buy ' . $name . ' products online at the best prices. Discover top-quality ' . $name . ' items now!',
                'meta_keywords' => $name . ', ' . $name . ' products, buy ' . $name,
                'image_alt_text' => $name . ' brand logo',
            ]);
        }
    }
}
