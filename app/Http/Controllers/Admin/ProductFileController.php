<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductFileController extends Controller
{
    /**
     * Display a listing of files for a product (Read-Only for Admin).
     */
    public function index(Product $product)
    {
        try {
            $files = $product->files()->orderBy('file_type')->get();
            
            return view('admin.products.files.index', compact('product', 'files'));
            
        } catch (\Exception $e) {
            Log::error('Product Files Index Error: ' . $e->getMessage());
            
            return back()->with('error', 'Unable to load files.');
        }
    }

    /**
     * Download a file (Public route - accessible to all).
     */
    public function download(ProductFile $file)
    {
        try {
            if (!Storage::disk('public')->exists($file->file_path)) {
                abort(404, 'File not found.');
            }

            if ($file->is_protected && !auth()->check()) {
                abort(403, 'Login required to download.');
            }

            if (!$file->canDownload()) {
                abort(403, 'Download limit exceeded.');
            }

            $file->incrementDownload();
            
            return Storage::disk('public')->download($file->file_path, $file->original_name);
            
        } catch (\Exception $e) {
            Log::error('File Download Failed: ' . $e->getMessage());
            abort(500, 'Failed to download file.');
        }
    }
}