<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductAttributeSeeder extends Seeder
{
    public function run(): void
    {
        // Get products directly from database
        $products = DB::table('products')->limit(10)->get();

        if ($products->isEmpty()) {
            $this->command->error('❌ No products found!');
            return;
        }

        $this->command->info('📦 Seeding product attributes...');

        // Clear existing attributes
        DB::table('product_attributes')->truncate();

        $attributeSets = [
            'ebook' => [
                ['key' => 'pages', 'label' => 'Pages', 'type' => 'number'],
                ['key' => 'isbn', 'label' => 'ISBN', 'type' => 'text'],
                ['key' => 'language', 'label' => 'Language', 'type' => 'text'],
                ['key' => 'edition', 'label' => 'Edition', 'type' => 'number'],
            ],
            'template' => [
                ['key' => 'software', 'label' => 'Software', 'type' => 'text'],
                ['key' => 'format', 'label' => 'Format', 'type' => 'text'],
                ['key' => 'license', 'label' => 'License', 'type' => 'text'],
                ['key' => 'dimensions', 'label' => 'Dimensions', 'type' => 'text'],
            ],
            'video_course' => [
                ['key' => 'duration', 'label' => 'Duration', 'type' => 'text'],
                ['key' => 'lessons', 'label' => 'Lessons', 'type' => 'number'],
                ['key' => 'level', 'label' => 'Level', 'type' => 'text'],
                ['key' => 'certificate', 'label' => 'Certificate', 'type' => 'text'],
            ],
            'software' => [
                ['key' => 'version', 'label' => 'Version', 'type' => 'text'],
                ['key' => 'os', 'label' => 'Operating System', 'type' => 'text'],
                ['key' => 'license_type', 'label' => 'License Type', 'type' => 'text'],
            ],
            'design_asset' => [
                ['key' => 'format', 'label' => 'Format', 'type' => 'text'],
                ['key' => 'resolution', 'label' => 'Resolution', 'type' => 'text'],
                ['key' => 'color_mode', 'label' => 'Color Mode', 'type' => 'text'],
            ],
            'audio' => [
                ['key' => 'duration', 'label' => 'Duration', 'type' => 'text'],
                ['key' => 'quality', 'label' => 'Quality', 'type' => 'text'],
                ['key' => 'genre', 'label' => 'Genre', 'type' => 'text'],
            ],
            'other' => [
                ['key' => 'description', 'label' => 'Description', 'type' => 'text'],
                ['key' => 'features', 'label' => 'Features', 'type' => 'text'],
            ],
        ];

        $totalAttributes = 0;

        foreach ($products as $product) {
            // Skip if no product type
            if (!$product->product_type) {
                continue;
            }

            // Get attribute set
            $attributes = $attributeSets[$product->product_type] ?? $attributeSets['other'];

            foreach ($attributes as $index => $attr) {
                $value = $this->generateValue($attr['key'], $attr['type']);

                DB::table('product_attributes')->insert([
                    'product_id' => $product->id,
                    'category_id' => $product->category_id ?? null,
                    'key' => $attr['key'],
                    'label' => $attr['label'],
                    'type' => $attr['type'],
                    'value_text' => is_string($value) ? $value : null,
                    'value_number' => is_numeric($value) ? $value : null,
                    'value_boolean' => null,
                    'value_date' => null,
                    'value_json' => null,
                    'selected_options' => null,
                    'options' => null,
                    'file_path' => null,
                    'file_name' => null,
                    'file_size' => null,
                    'mime_type' => null,
                    'sort_order' => $index,
                    'is_required' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $totalAttributes++;
            }

            $this->command->info("✅ Added " . count($attributes) . " attributes for: {$product->title}");
        }

        $this->command->info('✅ Product attributes seeded successfully!');
        $this->command->info('📊 Total attributes: ' . $totalAttributes);
    }

    private function generateValue(string $key, string $type)
    {
        $textValues = [
            'pages' => rand(100, 500),
            'isbn' => '978-3-16-148410-' . rand(0, 9),
            'language' => ['English', 'Spanish', 'French', 'German', 'Hindi'][rand(0, 4)],
            'edition' => rand(1, 5),
            'software' => ['Figma', 'Adobe XD', 'Sketch', 'Photoshop', 'Illustrator'][rand(0, 4)],
            'format' => ['PDF', 'EPUB', 'ZIP', 'RAR', 'SVG', 'PNG'][rand(0, 5)],
            'license' => ['Personal', 'Commercial', 'Extended', 'Unlimited'][rand(0, 3)],
            'dimensions' => rand(800, 2000) . 'x' . rand(600, 1500),
            'duration' => rand(1, 20) . ' hours',
            'lessons' => rand(10, 60),
            'level' => ['Beginner', 'Intermediate', 'Advanced', 'All Levels'][rand(0, 3)],
            'certificate' => ['Yes', 'No'][rand(0, 1)],
            'version' => 'v' . rand(1, 5) . '.' . rand(0, 9),
            'os' => ['Windows', 'macOS', 'Linux', 'All'][rand(0, 3)],
            'license_type' => ['Single', 'Multi-User', 'Enterprise'][rand(0, 2)],
            'resolution' => rand(72, 300) . ' DPI',
            'color_mode' => ['RGB', 'CMYK'][rand(0, 1)],
            'quality' => ['128kbps', '192kbps', '320kbps', 'Lossless'][rand(0, 3)],
            'genre' => ['Rock', 'Pop', 'Jazz', 'Classical', 'Electronic'][rand(0, 4)],
            'description' => 'Sample description for product',
            'features' => 'Feature 1, Feature 2, Feature 3',
        ];

        if ($type === 'number') {
            return is_numeric($textValues[$key] ?? rand(1, 100)) ? $textValues[$key] : rand(1, 100);
        }

        return $textValues[$key] ?? 'Sample ' . ucfirst(str_replace('_', ' ', $key));
    }
}