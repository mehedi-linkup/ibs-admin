<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Materials;
use Illuminate\Http\Request;
use App\Models\UsedMaterials;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MaterialsController extends Controller
{
    public function index()
    {
        return view('pages.materials.index');
    }

    public function getMaterials(Request $request)
    {
        $materials = Materials::with(['merchant' => function($m){
            $m->select('id', 'name');
        }, 'coordinator' => function($c) {
            $c->select('id', 'name');
        }, 'gm' => function($g) {
            $g->select('id', 'name');
        }, 'user' => function($u) {
            $u->select('id', 'name');
        }, 'washCoordinator' => function($wc) {
            $wc->select('id', 'name');
        }, 'washUnit' => function($wu){
            $wu->select('id', 'name');
        }, 'cad' => function($c) {
            $c->select('id', 'name');
        }, 'buyer' => function($b) {
            $b->select('id', 'name');
        }, 'supplier' => function($s) {
            $s->select('id', 'name');
        }])->withSum(['used_materials' => fn ($um) => $um->select(DB::raw('COALESCE(SUM(use_qty), 0)')),
        ], 'use_qty');

        if(isset(Auth::user()->merchant_id) && Auth::user()->merchant_id != null) {
            $materials = $materials->where('merchant_id', Auth::user()->merchant_id);
        }
        if(isset(Auth::user()->gm) && Auth::user()->gm != null) {
            $materials = $materials->where('gm_id', Auth::user()->gm);
        }
        if(isset(Auth::user()->coordinator_id) && Auth::user()->coordinator_id != null) {
            $materials = $materials->where('coordinator_id', Auth::user()->coordinator_id);
        }
        if(isset(Auth::user()->wash_coordinator_id) && Auth::user()->wash_coordinator_id != null) {
            $materials = $materials->where('wash_coordinator_id', Auth::user()->wash_coordinator_id);
        }
        if(isset(Auth::user()->wash_unit_id) && Auth::user()->wash_unit_id != null) {
            $materials = $materials->where('wash_unit_id', Auth::user()->wash_unit_id);
        }
        if(isset(Auth::user()->cad_id) && Auth::user()->cad_id != null) {
            $materials = $materials->where('cad_id', Auth::user()->cad_id);
        }
        if(isset($request->searchType) && $request->searchType == 'fabric_sent'){
            $materials = $materials->whereNull('fabric_sent');
        }
        if(isset($request->searchType) && $request->searchType == 'receive_date'){
            $materials = $materials->whereNull('receive_date');
        }
        if(isset($request->searchType) && $request->searchType == 'shrinkage_sent'){
            $materials = $materials->whereNull('shrinkage_sent');
        }
        if(isset($request->searchType) && $request->searchType == 'shrinkage_receive'){
            $materials = $materials->whereNull('shrinkage_receive');
        }
        if(isset($request->searchType) && $request->searchType == 'fabric_type'){
            $materials = $materials->whereNull('fabric_type');
        }

        return $materials = $materials->latest()->get();
    }

    public function getUsedQty(Request $request)
    {
        $usedquantities =  UsedMaterials::where('material_id', $request->id)->get();
        return $usedquantities;
    }

    public function store(Request $request)
    {
        $res = new stdClass();
        try { 
            $material = new Materials();
            $material->merchant_id = $request->merchant_id;
            $material->gm_id = $request->gm_id;
            $material->coordinator_id = $request->coordinator_id;
            $material->wash_coordinator_id = $request->wash_coordinator_id;
            $material->wash_unit_id = $request->wash_unit_id;
            $material->cad_id = $request->cad_id;
            $material->buyer_id = $request->buyer_id;
            $material->supplier_id = $request->supplier_id;
            $material->fabric_ref = $request->fabric_ref;
            $material->composition = $request->composition;
            $material->remarks1 = $request->remarks1;
            $material->user_id = Auth::user()->id;
            $material->user_ip = $request->ip();
            $material->save();
            $res->message = 'Successfully Saved !!';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function update(Request $request)
    {
        $res = new stdClass();
        try { 
           $material = Materials::find($request->id);
            $material->merchant_id = $request->merchant_id;
            $material->gm_id = $request->gm_id;
            $material->coordinator_id = $request->coordinator_id;
            $material->wash_coordinator_id = $request->wash_coordinator_id;
            $material->wash_unit_id = $request->wash_unit_id;
            $material->cad_id = $request->cad_id;
            $material->buyer_id = $request->buyer_id;
            $material->supplier_id = $request->supplier_id;
            $material->fabric_ref = $request->fabric_ref;
            $material->composition = $request->composition;
            $material->remarks1 = $request->remarks1;
            $material->cw = $request->cw;
            $material->bw = $request->bw;
            $material->aw = $request->aw;
            $material->in_one_status = $request->cw != '' ? 'a' : $request->in_one_status;
            $material->fabric_sent = $request->fabric_sent;
            $material->time = $request->time;
            $material->update_time = $request->update_time;
            $material->quantity = $request->quantity;
            $material->in_two_status = $request->fabric_sent != '' ? 'a' : $request->in_two_status;
            $material->fabric_type = $request->fabric_type;
            $material->receive_date = $request->receive_date;
            $material->receive_update_date = $request->receive_update_date;
            $material->receive_qty = $request->receive_qty;
            $material->in_three_status = $request->receive_date != '' ? 'a' : $request->in_three_status;
            $material->shrinkage_sent = $request->shrinkage_sent;
            $material->shrinkage_time = $request->shrinkage_time;
            $material->in_four_status = $request->shrinkage_sent != '' ? 'a' : $request->in_four_status;
            $material->shrinkage_update_date = $request->shrinkage_update_date;
            $material->return_to_section = $request->return_to_section;
            $material->in_five_status = $request->return_to_section != '' ? 'a' : $request->in_five_status;
            $material->return_to_time = $request->return_to_time;
            $material->shrinkage_receive = $request->shrinkage_receive;
            $material->shrinkage_receive_time = $request->shrinkage_receive_time;
            $material->shrinkage_receive_update = $request->shrinkage_receive_update;
            $material->shrinkage_length = $request->shrinkage_length;
            $material->shrinkage_width = $request->shrinkage_width;
            $material->in_six_status = $request->shrinkage_width != '' ? 'a' : $request->in_six_status;
            $material->sent_store = $request->sent_store;
            $material->update_store = $request->update_store;
            $material->store_qty = $request->store_qty;
            $material->in_eight_status = $request->sent_store != '' ? 'a' : $request->in_eight_status;
            $material->save();
            $res->message = 'Successfully Update !!';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function resetData(Request $request)
    {
        $res = new stdClass();
        try {
            $material = Materials::find($request->id);
            $material->sent_store = null;
            $material->update_store = null;
            $material->store_qty = 0.00;
            $material->reset_date = date('Y-m-d');
            $material->save();
            $res->message = 'Successfully Reset!';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!'.$e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function destroy(Request $request)
    {
        $res = new stdClass();
        try {
            $material = Materials::find($request->id);
            $material->delete();
            $res->message = 'Delete Success !!';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function addUseQty(Request $request)
    {
        $res = new stdClass();
        try {
            $useQty = new UsedMaterials();
            $useQty->material_id = $request->materialsId;
            $useQty->use_qty = $request->used['use_qty'];
            $useQty->remarks2 = $request->used['remarks2'];
            $useQty->user_ip = $request->ip();
            $useQty->user_id = Auth::user()->id;
            $useQty->save();
            $res->message = 'User Quanty Added !!';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!'.$e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function viewMaterials($id)
    {
        $material = Materials::with(['merchant' => function($m){
            $m->select('id', 'name');
        }, 'coordinator' => function($c) {
            $c->select('id', 'name');
        }, 'gm' => function($g) {
            $g->select('id', 'name');
        }, 'user' => function($u) {
            $u->select('id', 'name');
        }, 'washCoordinator' => function($wc) {
            $wc->select('id', 'name');
        }, 'washUnit' => function($wu){
            $wu->select('id', 'name');
        }, 'cad' => function($c) {
            $c->select('id', 'name');
        }, 'buyer' => function($b) {
            $b->select('id', 'name');
        }, 'supplier' => function($s) {
            $s->select('id', 'name');
        }])->withSum(['used_materials' => fn ($um) => $um->select(DB::raw('COALESCE(SUM(use_qty), 0)')),
        ], 'use_qty')->where('id', $id)->first();

        return view('pages.materials.view', compact('material'));
    }

    public function blankMaterials()
    {
        return view('pages.materials.blank');
    }
}
