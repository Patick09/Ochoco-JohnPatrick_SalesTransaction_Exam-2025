<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_name',
        'amount',
        'quantity',
        'total_amount',
        'status',
        'sale_date',
        'sale_time',
        'notes',
        'customer_id',
        'product_id'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'sale_time' => 'datetime:H:i',
        'amount' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    // Each sale belongs to a customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Each sale can belong to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Boot method to generate transaction ID
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($sale) {
            if (empty($sale->transaction_id)) {
                $sale->transaction_id = 'TXN-' . strtoupper(uniqid());
            }
            // Calculate total amount
            $sale->total_amount = $sale->amount * $sale->quantity;
        });

        static::updating(function ($sale) {
            // Recalculate total amount when updating
            $sale->total_amount = $sale->amount * $sale->quantity;
        });
    }
}
