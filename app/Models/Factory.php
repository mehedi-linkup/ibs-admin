<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarder = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
