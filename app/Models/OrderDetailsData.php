<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetailsData extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarder = [];

    public function orderDetails()
    {
        return $this->belongsTo(OrderDetails::class, 'order_details_id', 'id');
    }
}
