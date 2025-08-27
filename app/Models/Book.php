<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'description',
        'price',
        'stock',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPriceInEuros(): string
    {
        $exchangeRate = 25; // Example exchange rate
        $priceInEuros = $this->price * $exchangeRate;
        return number_format($priceInEuros, 2) . ' €';
    }

}
