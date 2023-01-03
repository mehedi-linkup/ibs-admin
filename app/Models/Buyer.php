<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarder = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'buyer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
