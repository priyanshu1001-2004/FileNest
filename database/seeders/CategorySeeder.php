<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // ROOT CATEGORIES (Main Groups)
        // ============================================

        $rootCategories = [
            ['name' => 'Documents', 'description' => 'Document files in various formats'],
            ['name' => 'Source Code', 'description' => 'Code repositories and archives'],
            ['name' => 'Design Files', 'description' => 'Design and graphics source files'],
            ['name' => 'Images', 'description' => 'Image and photo files'],
            ['name' => 'Videos', 'description' => 'Video files and content'],
            ['name' => 'Audio', 'description' => 'Audio files and music'],
            ['name' => 'Web Templates', 'description' => 'Website and application templates'],
            ['name' => 'Mobile Apps', 'description' => 'Mobile applications and source code'],
            ['name' => 'Game Assets', 'description' => 'Game development assets'],
            ['name' => 'AI Resources', 'description' => 'AI tools and prompt resources'],
            ['name' => 'Learning Material', 'description' => 'Educational content and courses'],
            ['name' => 'Other Digital Products', 'description' => 'Miscellaneous digital products'],
            ['name' => 'External Delivery', 'description' => 'Products delivered via external links'],
        ];

        $createdCategories = [];

        foreach ($rootCategories as $category) {
            $created = Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'status' => true,
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $createdCategories[Str::slug($category['name'])] = $created;
        }

        // ============================================
        // SUB-CATEGORIES
        // ============================================

        // 1. Documents Sub-Categories
        if (isset($createdCategories['documents'])) {
            $parent = $createdCategories['documents'];
            $subs = [
                ['name' => 'PDF', 'slug' => 'pdf'],
                ['name' => 'DOC / DOCX', 'slug' => 'doc-docx'],
                ['name' => 'PPT / PPTX', 'slug' => 'ppt-pptx'],
                ['name' => 'XLS / XLSX', 'slug' => 'xls-xlsx'],
                ['name' => 'TXT', 'slug' => 'txt'],
                ['name' => 'RTF', 'slug' => 'rtf'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 2. Source Code Sub-Categories
        if (isset($createdCategories['source-code'])) {
            $parent = $createdCategories['source-code'];
            $subs = [
                ['name' => 'ZIP Archive', 'slug' => 'zip'],
                ['name' => 'RAR Archive', 'slug' => 'rar'],
                ['name' => '7Z Archive', 'slug' => '7z'],
                ['name' => 'GitHub Repository', 'slug' => 'github'],
                ['name' => 'GitLab Repository', 'slug' => 'gitlab'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 3. Design Files Sub-Categories
        if (isset($createdCategories['design-files'])) {
            $parent = $createdCategories['design-files'];
            $subs = [
                ['name' => 'PSD (Photoshop)', 'slug' => 'psd'],
                ['name' => 'AI (Illustrator)', 'slug' => 'ai'],
                ['name' => 'FIG (Figma)', 'slug' => 'fig'],
                ['name' => 'XD (Adobe XD)', 'slug' => 'xd'],
                ['name' => 'Sketch', 'slug' => 'sketch'],
                ['name' => 'SVG', 'slug' => 'svg'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 4. Images Sub-Categories
        if (isset($createdCategories['images'])) {
            $parent = $createdCategories['images'];
            $subs = [
                ['name' => 'PNG', 'slug' => 'png'],
                ['name' => 'JPG / JPEG', 'slug' => 'jpg-jpeg'],
                ['name' => 'WEBP', 'slug' => 'webp'],
                ['name' => 'GIF', 'slug' => 'gif'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 5. Videos Sub-Categories
        if (isset($createdCategories['videos'])) {
            $parent = $createdCategories['videos'];
            $subs = [
                ['name' => 'MP4', 'slug' => 'mp4'],
                ['name' => 'MOV', 'slug' => 'mov'],
                ['name' => 'AVI', 'slug' => 'avi'],
                ['name' => 'MKV', 'slug' => 'mkv'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 6. Audio Sub-Categories
        if (isset($createdCategories['audio'])) {
            $parent = $createdCategories['audio'];
            $subs = [
                ['name' => 'MP3', 'slug' => 'mp3'],
                ['name' => 'WAV', 'slug' => 'wav'],
                ['name' => 'AAC', 'slug' => 'aac'],
                ['name' => 'FLAC', 'slug' => 'flac'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 7. Web Templates Sub-Categories
        if (isset($createdCategories['web-templates'])) {
            $parent = $createdCategories['web-templates'];
            $subs = [
                ['name' => 'HTML Template', 'slug' => 'html-template'],
                ['name' => 'React Project', 'slug' => 'react-project'],
                ['name' => 'Vue Project', 'slug' => 'vue-project'],
                ['name' => 'Angular Project', 'slug' => 'angular-project'],
                ['name' => 'WordPress Theme', 'slug' => 'wordpress-theme'],
                ['name' => 'Shopify Theme', 'slug' => 'shopify-theme'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 8. Mobile Apps Sub-Categories
        if (isset($createdCategories['mobile-apps'])) {
            $parent = $createdCategories['mobile-apps'];
            $subs = [
                ['name' => 'APK', 'slug' => 'apk'],
                ['name' => 'AAB', 'slug' => 'aab'],
                ['name' => 'Flutter Project', 'slug' => 'flutter-project'],
                ['name' => 'React Native Project', 'slug' => 'react-native-project'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 9. Game Assets Sub-Categories
        if (isset($createdCategories['game-assets'])) {
            $parent = $createdCategories['game-assets'];
            $subs = [
                ['name' => 'Unity Package', 'slug' => 'unity-package'],
                ['name' => 'Unreal Assets', 'slug' => 'unreal-assets'],
                ['name' => '3D Models', 'slug' => '3d-models'],
                ['name' => 'Sprites', 'slug' => 'sprites'],
                ['name' => 'Game Sounds', 'slug' => 'game-sounds'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 10. AI Resources Sub-Categories
        if (isset($createdCategories['ai-resources'])) {
            $parent = $createdCategories['ai-resources'];
            $subs = [
                ['name' => 'AI Prompt Pack', 'slug' => 'ai-prompt-pack'],
                ['name' => 'ChatGPT Prompts', 'slug' => 'chatgpt-prompts'],
                ['name' => 'Cursor Rules', 'slug' => 'cursor-rules'],
                ['name' => 'Claude Prompts', 'slug' => 'claude-prompts'],
                ['name' => 'AI Workflow Templates', 'slug' => 'ai-workflow-templates'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 11. Learning Material Sub-Categories
        if (isset($createdCategories['learning-material'])) {
            $parent = $createdCategories['learning-material'];
            $subs = [
                ['name' => 'E-books', 'slug' => 'ebooks'],
                ['name' => 'Notes', 'slug' => 'notes'],
                ['name' => 'Courses', 'slug' => 'courses'],
                ['name' => 'Cheat Sheets', 'slug' => 'cheat-sheets'],
                ['name' => 'Question Banks', 'slug' => 'question-banks'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 12. Other Digital Products Sub-Categories
        if (isset($createdCategories['other-digital-products'])) {
            $parent = $createdCategories['other-digital-products'];
            $subs = [
                ['name' => 'Canva Templates', 'slug' => 'canva-templates'],
                ['name' => 'Resume Templates', 'slug' => 'resume-templates'],
                ['name' => 'Notion Templates', 'slug' => 'notion-templates'],
                ['name' => 'Excel Templates', 'slug' => 'excel-templates'],
                ['name' => 'Invoice Templates', 'slug' => 'invoice-templates'],
                ['name' => 'Icons Pack', 'slug' => 'icons-pack'],
                ['name' => 'Fonts', 'slug' => 'fonts'],
                ['name' => 'Lightroom Presets', 'slug' => 'lightroom-presets'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // 13. External Delivery Sub-Categories
        if (isset($createdCategories['external-delivery'])) {
            $parent = $createdCategories['external-delivery'];
            $subs = [
                ['name' => 'Google Drive Link', 'slug' => 'google-drive'],
                ['name' => 'Dropbox Link', 'slug' => 'dropbox'],
                ['name' => 'OneDrive Link', 'slug' => 'onedrive'],
                ['name' => 'GitHub Link', 'slug' => 'github-link'],
                ['name' => 'Mega Link', 'slug' => 'mega'],
                ['name' => 'Direct Download URL', 'slug' => 'direct-url'],
                ['name' => 'YouTube (Private) Link', 'slug' => 'youtube-private'],
                ['name' => 'Custom URL', 'slug' => 'custom-url'],
            ];
            $this->createSubCategories($parent, $subs);
        }

        // ============================================
        // OUTPUT SUMMARY
        // ============================================

        $this->command->info('✅ Categories seeded successfully!');
        $this->command->info('📊 Total Categories: ' . Category::count());
        $this->command->info('📂 Root Categories: ' . Category::whereNull('parent_id')->count());
        $this->command->info('📁 Sub Categories: ' . Category::whereNotNull('parent_id')->count());

        // Show category tree
        $this->command->info("\n📋 Category Structure:");
        $roots = Category::whereNull('parent_id')->with('children')->get();
        foreach ($roots as $root) {
            $this->command->info("  ├── " . $root->name . " (" . $root->children->count() . " sub-categories)");
            foreach ($root->children as $child) {
                $this->command->info("  │   └── " . $child->name);
            }
        }
    }

    /**
     * Helper method to create sub-categories
     */
    private function createSubCategories($parent, array $subs): void
    {
        foreach ($subs as $sub) {
            Category::create([
                'name' => $sub['name'],
                'slug' => $sub['slug'],
                'description' => $sub['name'] . ' category',
                'parent_id' => $parent->id,
                'status' => true,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }   
    }
}
