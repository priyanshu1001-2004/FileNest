<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = [
        'product_id', 'category_id',
        'key', 'label', 'type',
        'value_text', 'value_number', 'value_boolean', 'value_date', 'value_json',
        'options', 'selected_options',
        'file_path', 'file_name', 'file_size', 'mime_type',
        'sort_order', 'is_required'
    ];

    protected $casts = [
        'options' => 'array',
        'selected_options' => 'array',
        'value_json' => 'array',
        'is_required' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ==================== HELPERS ====================
    
    public function getValue()
    {
        return match ($this->type) {
            'text', 'textarea' => $this->value_text,
            'number', 'decimal' => $this->value_number,
            'boolean' => $this->value_boolean,
            'date' => $this->value_date,
            'json' => $this->value_json,
            'select', 'multiselect' => $this->selected_options,
            'file' => $this->file_path,
            default => $this->value_text,
        };
    }

    public function getDisplayValue()
    {
        $value = $this->getValue();
        
        if ($this->type === 'boolean') {
            return $value ? 'Yes' : 'No';
        }
        
        if (in_array($this->type, ['select', 'multiselect']) && $this->selected_options) {
            return implode(', ', $this->selected_options);
        }
        
        if ($this->type === 'file' && $this->file_name) {
            return $this->file_name;
        }
        
        return $value;
    }

    public function getFileUrl()
    {
        if ($this->type === 'file' && $this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }
}