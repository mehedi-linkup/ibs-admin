<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materials extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarder = [];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function gm()
    {
        return $this->belongsTo(Gm::class, 'gm_id', 'id');
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class, 'coordinator_id', 'id');
    }

    public function washCoordinator()
    {
        return $this->belongsTo(WashCoordinator::class, 'wash_coordinator_id', 'id');
    }

    public function washUnit() {
        return $this->belongsTo(WashUnit::class, 'wash_unit_id', 'id');
    }

    public function cad()
    {
        return $this->belongsTo(Cad::class, 'cad_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function used_materials()
    {
        return $this->hasMany(UsedMaterials::class, 'material_id', 'id');
    }
}
