<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SampleName extends Model
{
    use HasFactory, SoftDeletes;

    public function sample_datas()
    {
        return $this->hasMany(SampleData::class);
    }
}
