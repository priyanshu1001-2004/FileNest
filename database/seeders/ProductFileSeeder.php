<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductFileSeeder extends Seeder
{
    public function run(): void
    {
        // Get products
        $products = DB::table('products')->limit(5)->get();

        if ($products->isEmpty()) {
            $this->command->error('❌ No products found! Please run ProductSeeder first.');
            return;
        }

        // Clear existing files
        DB::table('product_files')->truncate();

        $fileTypes = ['main', 'preview', 'sample', 'documentation'];
        $totalFiles = 0;

        foreach ($products as $product) {
            // Create 2-3 files per product
            $count = rand(2, 3);
            
            for ($i = 0; $i < $count; $i++) {
                $fileType = $fileTypes[array_rand($fileTypes)];
                $extensions = ['pdf', 'docx', 'xlsx', 'pptx', 'txt', 'zip', 'png', 'jpg'];
                $ext = $extensions[array_rand($extensions)];
                
                $fileName = $product->slug . '-' . uniqid() . '.' . $ext;
                $originalName = 'sample-' . ($i + 1) . '.' . $ext;
                $path = 'products/' . $product->id . '/files/' . $fileName;

                // Create a dummy file in storage (small text file)
                $dummyContent = "This is a sample file for product: " . $product->title . "\n";
                $dummyContent .= "File Type: " . $fileType . "\n";
                $dummyContent .= "Created: " . now() . "\n";
                
                Storage::disk('public')->put($path, $dummyContent);

                DB::table('product_files')->insert([
                    'product_id' => $product->id,
                    'file_name' => $fileName,
                    'original_name' => $originalName,
                    'file_path' => $path,
                    'file_url' => Storage::url($path),
                    'file_size' => strlen($dummyContent),
                    'mime_type' => 'text/plain',
                    'file_hash' => hash('sha256', $dummyContent),
                    'file_type' => $fileType,
                    'download_limit' => rand(5, 20),
                    'download_count' => 0,
                    'is_active' => true,
                    'is_protected' => true,
                    'is_public' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $totalFiles++;
            }

            $this->command->info("✅ Added " . $count . " files for product: {$product->title}");
        }

        $this->command->info('✅ Product files seeded successfully!');
        $this->command->info('📊 Total files: ' . $totalFiles);
    }
}