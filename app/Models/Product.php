<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'slug',
        'description',
        'price',
        'stock',
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
    ];

    public function getRouteKeyName() {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function coverImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_cover', true);
    }

    public function cart() {
        return $this->belongsToMany(Cart::class);
    }

    public function order() {
        return $this->belongsToMany(Order::class);
    }

    // public function getPriceAttribute($value) // permet d'avoir le prix en €
    // {
    //     return number_format($value / 100, 2, ',', ' ') . ' €';
    // }
}