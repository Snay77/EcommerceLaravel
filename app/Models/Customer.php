<?php

namespace App\Models;

use App\Enums\CustomerGenre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [ //Sert à dire ce que peut modifier le model (je crois)
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'genre',
        'birth_date'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'genre' => CustomerGenre::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart() 
    {
        return $this->hasOne(Cart::class);
    }

    public function addresses() {
        return $this->hasMany(Addresse::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected $with = [
        'user',
    ];
}
