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
        return $this->belongsTo(ShippingAddresse::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price');
    }
}
