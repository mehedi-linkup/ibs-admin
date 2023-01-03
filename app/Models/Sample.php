<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sample extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarder = [];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'id');
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class, 'coordinator_id', 'id');
    }

    public function gm()
    {
        return $this->belongsTo(Gm::class, 'gm_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sample_datas()
    {
        return $this->hasMany(SampleData::class);
    }

    public function washCoordinator()
    {
        return $this->belongsTo(WashCoordinator::class, 'wash_coordinator_id', 'id');
    }

    public function finishingCoordinator() 
    {
        return $this->belongsTo(FinishingCoordinator::class, 'finishing_coordinator_id', 'id');
    }

    public function cad()
    {
        return $this->belongsTo(Cad::class, 'cad_id', 'id');
    }
}
