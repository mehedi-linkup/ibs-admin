<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    public function permission()
    {
        return $this->hasOne(Permission::class);
    }

    public function user() 
    {
        return $this->hasOne(User::class);
    }

}
