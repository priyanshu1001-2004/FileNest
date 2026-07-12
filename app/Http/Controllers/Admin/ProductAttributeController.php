<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of attributes (Read-Only for Admin).
     */
    public function index(Product $product)
    {
        try {
            $attributes = $product->attributes()->orderBy('sort_order')->get();
            
            return view('admin.products.attributes.index', compact('product', 'attributes'));
            
        } catch (\Exception $e) {
            Log::error('Attribute Index Error: ' . $e->getMessage());
            
            return back()->with('error', 'Unable to load attributes.');
        }
    }
}