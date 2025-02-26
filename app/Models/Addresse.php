<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresse extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'street',
        'postcode',
        'city',
        'is_default',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }


}
