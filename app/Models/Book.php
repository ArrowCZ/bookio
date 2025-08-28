<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        $exchangeRate = 0.041; // Example exchange rate
        $priceInEuros = $this->price * $exchangeRate;
        return number_format($priceInEuros, 2) . ' €';
    }

}
