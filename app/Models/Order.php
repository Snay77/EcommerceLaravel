<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'shipping_addresses_id',
    ];

    public function shippingadresse()
    {
        return $this->belongsTo(ShippingAddresse::class, 'shipping_addresses_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity', 'price')->withTimestamps();
    }
}
