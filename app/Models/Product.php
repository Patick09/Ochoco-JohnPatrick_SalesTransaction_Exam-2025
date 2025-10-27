<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_code',
        'name',
        'description',
        'category',
        'selling_price',
        'cost_price',
        'stock_quantity',
        'minimum_stock',
        'supplier',
        'status'
    ];

    protected $casts = [
        'selling_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'minimum_stock' => 'integer'
    ];

    // Boot method to generate product code
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->product_code)) {
                $product->product_code = 'PRD-' . strtoupper(uniqid());
            }
        });
    }

    // Relationship with sales
    public function sales()
    {
        return $this->hasMany(Sales::class);
    }

    // Check if product is low stock
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->minimum_stock;
    }

    // Check if product is out of stock
    public function isOutOfStock()
    {
        return $this->stock_quantity <= 0;
    }

    // Get stock status
    public function getStockStatusAttribute()
    {
        if ($this->isOutOfStock()) {
            return 'out_of_stock';
        } elseif ($this->isLowStock()) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for low stock products
    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_quantity <= minimum_stock');
    }

    // Scope for out of stock products
    public function scopeOutOfStock($query)
    {
        return $query->where('stock_quantity', '<=', 0);
    }
}