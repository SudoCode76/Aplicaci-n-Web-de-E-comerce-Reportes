<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'row_id';
    protected $fillable = [
        'order_id',
        'order_date',
        'ship_date',
        'ship_mode',
        'customer_id',
        'segment',
        'postal_code',
        'product_id',
        'sales',
        'quantity',
        'discount',
        'profit',
    ];

    // Relación con Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relación con location
    public function location()
    {
        return $this->belongsTo(Location::class, 'postal_code');
    }

    // Relación con Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
