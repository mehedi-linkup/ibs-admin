<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WashUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarder = [];

    public function samples() 
    {
        return $this->hasMany(Sample::class);
    }
}
