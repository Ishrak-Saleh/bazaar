<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'name' => 'System Admin',
            'email' => 'admin@bazaar.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $vendor1 = User::create([
            'first_name' => 'Ahsan',
            'last_name' => 'Habib',
            'name' => 'Ahsan Habib',
            'email' => 'vendor1@bazaar.test',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'vendor_status' => 'approved',
            'store_name' => 'Ahsan Fresh Mart',
        ]);

        $vendor2 = User::create([
            'first_name' => 'Tasnim',
            'last_name' => 'Rahman',
            'name' => 'Tasnim Rahman',
            'email' => 'vendor2@bazaar.test',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'vendor_status' => 'approved',
            'store_name' => 'Tasnim Harvest House',
        ]);

        User::create([
            'first_name' => 'Customer',
            'last_name' => 'One',
            'name' => 'Customer One',
            'email' => 'customer@bazaar.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $categories = collect([
            'Fruits',
            'Vegetables',
            'Organic Greens',
            'Seasonal Specialties',
        ])->map(function ($name) {
            return Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'is_active' => true,
            ]);
        });

        $categoryMap = $categories->keyBy('name');

        $products = [
            [
                'vendor_id' => $vendor1->id,
                'category_id' => $categoryMap['Fruits']->id,
                'name' => 'Rajshahi Fazli Mangoes',
                'description' => 'Sweet, thick-pulped mangoes sourced from Rajshahi orchards.',
                'price' => 180,
                'stock' => 45,
                'slug' => 'rajshahi-fazli-mangoes',
                'image' => 'rajshahi-fazli-mangoes.jpeg',
            ],
            [
                'vendor_id' => $vendor1->id,
                'category_id' => $categoryMap['Organic Greens']->id,
                'name' => 'Srimangal Fresh Palong Shak',
                'description' => 'Crisp, nutrient-dense spinach leaves picked fresh.',
                'price' => 45,
                'stock' => 24,
                'slug' => 'srimangal-fresh-palong-shak',
                'image' => 'srimangal-palong-shak.jpg',
            ],
            [
                'vendor_id' => $vendor2->id,
                'category_id' => $categoryMap['Fruits']->id,
                'name' => 'Narsingdi Sagar Bananas',
                'description' => 'Naturally sweet bananas with a soft creamy bite.',
                'price' => 90,
                'stock' => 60,
                'slug' => 'narsingdi-sagar-bananas',
                'image' => 'narsingdi-sagar-bananas.jpg',
            ],
            [
                'vendor_id' => $vendor2->id,
                'category_id' => $categoryMap['Vegetables']->id,
                'name' => 'Munshiganj Native Vine Tomatoes',
                'description' => 'Firm, juicy tomatoes for salad and curry.',
                'price' => 110,
                'stock' => 50,
                'slug' => 'munshiganj-native-vine-tomatoes',
                'image' => 'munshiganj-vine-tomatoes.jpg',
            ],
            [
                'vendor_id' => $vendor1->id,
                'category_id' => $categoryMap['Vegetables']->id,
                'name' => 'Panchagarh Broccoli Florets',
                'description' => 'Fresh broccoli with tight green florets.',
                'price' => 160,
                'stock' => 18,
                'slug' => 'panchagarh-broccoli-florets',
                'image' => 'panchagarh-broccoli.jpg',
            ],
            [
                'vendor_id' => $vendor2->id,
                'category_id' => $categoryMap['Fruits']->id,
                'name' => 'Jessore Long Stem Baigun',
                'description' => 'Glossy deep-purple eggplants with soft flesh.',
                'price' => 95,
                'stock' => 35,
                'slug' => 'jessore-long-stem-baigun',
                'image' => 'long-stem-baigun.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'vendor_id' => $product['vendor_id'],
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'image_path' => $product['image'],
                'is_active' => true,
            ]);
        }
    }
}