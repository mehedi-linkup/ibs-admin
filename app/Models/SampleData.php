<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SampleData extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarder = [];

    public function sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function sample_name()
    {
        return $this->belongsTo(SampleName::class, 'sample_name_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function washUnit() 
    {
        return $this->belongsTo(WashUnit::class, 'wash_unit_id', 'id');
    }
}
