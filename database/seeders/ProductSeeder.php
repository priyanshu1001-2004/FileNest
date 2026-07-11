<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get first seller and category
        $seller = User::where('role', 1)->first() ?? User::first();
        $category = Category::first();

        if (!$category) {
            $this->command->error('❌ No categories found! Please run CategorySeeder first.');
            return;
        }

        $products = [
            [
                'title' => 'Learn Laravel 11 - Complete Course',
                'description' => 'Master Laravel 11 from beginner to advanced. Build real-world applications.',
                'price' => 49.99,
                'compare_price' => 99.99,
                'product_type' => 'video_course',
                'status' => 'published',
                'is_approved' => true,
            ],
            [
                'title' => 'The Ultimate E-Book Bundle',
                'description' => 'Collection of 10 best-selling e-books on various topics.',
                'price' => 29.99,
                'compare_price' => 59.99,
                'product_type' => 'ebook',
                'status' => 'published',
                'is_approved' => true,
            ],
            [
                'title' => 'Premium Website Template Pack',
                'description' => '50+ responsive website templates for various industries.',
                'price' => 39.99,
                'compare_price' => 79.99,
                'product_type' => 'template',
                'status' => 'published',
                'is_approved' => true,
            ],
            [
                'title' => 'Professional Design Assets',
                'description' => 'Complete design kit with icons, fonts, and UI components.',
                'price' => 24.99,
                'compare_price' => 49.99,
                'product_type' => 'design_asset',
                'status' => 'draft',
                'is_approved' => false,
            ],
        ];

        foreach ($products as $productData) {
            Product::create([
                'seller_id' => $seller->id,
                'category_id' => $category->id,
                'title' => $productData['title'],
                'slug' => Str::slug($productData['title']) . '-' . Str::random(6),
                'description' => $productData['description'],
                'short_description' => Str::limit($productData['description'], 150),
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'product_type' => $productData['product_type'],
                'status' => $productData['status'],
                'is_approved' => $productData['is_approved'],
                'created_by' => $seller->id,
                'updated_by' => $seller->id,
            ]);
        }

        $this->command->info('✅ ' . count($products) . ' products seeded successfully!');
    }
}