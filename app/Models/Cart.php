<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function product() {
        return $this->belongsToMany(Product::class)
            ->withPivot("quantity")
            ->withTimestamps();
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
