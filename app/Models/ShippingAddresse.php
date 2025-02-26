<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddresse extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'postcode',
        'city',
    ];

    public function order() {
        return $this->hasMany(Order::class);
    }
}
