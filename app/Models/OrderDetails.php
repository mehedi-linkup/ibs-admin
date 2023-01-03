<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarder = [];

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function orderData()
    {
        return $this->belongsTo(OrderData::class, 'order_data_id', 'id');
    }

    public function orderDetailsDatas()
    {
        return $this->hasMany(OrderDetailsData::class);
    }
}
