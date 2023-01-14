<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Sample;
use App\Models\SampleData;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SampleController extends Controller
{
    use Utils;
    public function index()
    {
        return view('pages.sample.index');
    }

    public function InactiveData()
    {
        return view('pages.sample.inactive');
    }

    public function getSample()
    {
        $sample = Sample::with(['buyer' => function($b) {
            $b->select('id', 'name');
        }, 'coordinator' => function($c) {
            $c->select('id', 'name');
        }, 'gm' => function($g) {
            $g->select('id', 'name');
        }, 'user' => function($u) {
            $u->select('id', 'name');
        }, 'washCoordinator' => function($wc) {
            $wc->select('id', 'name');
        }, 'finishingCoordinator' => function($fc) {
            $fc->select('id', 'name');
        }, 'cad' => function($c) {
            $c->select('id', 'name');
        }]);

        if(isset(Auth::user()->coordinator_id) && Auth::user()->coordinator_id != null) {
            $sample = $sample->where('coordinator_id', Auth::user()->coordinator_id);
        }
        if(isset(Auth::user()->gm) && Auth::user()->gm != null) {
            $sample = $sample->where('gm_id', Auth::user()->gm);
        }
        if(isset(Auth::user()->wash_coordinator_id) && Auth::user()->wash_coordinator_id != null) {
            $sample = $sample->where('wash_coordinator_id', Auth::user()->wash_coordinator_id);
        }
        if(isset(Auth::user()->finishing_coordinator_id) && Auth::user()->finishing_coordinator_id != null) {
            $sample = $sample->where('finishing_coordinator_id', Auth::user()->finishing_coordinator_id);
        }
        if(isset(Auth::user()->cad_id) && Auth::user()->cad_id != null) {
            $sample = $sample->where('cad_id', Auth::user()->cad_id);
        }
        if(isset(Auth::user()->id) && Auth::user()->id != 1 && Auth::user()->gm == null && Auth::user()->coordinator_id == null  && Auth::user()->wash_coordinator_id == null && Auth::user()->finishing_coordinator_id == null && Auth::user()->cad_id == null && Auth::user()->wash_unit_id == null) {
            $sample = $sample->where('user_id', Auth::user()->id);
        }
        
        return $sample = $sample->latest()->get();
    }

    public function saveSample(Request $request)
    {
        $res = new stdClass();
        try {
            $sample = new Sample();
            $sample->gm_id = $request->gm_id;
            $sample->buyer_id = $request->buyer_id;
            $sample->item_name = $request->item_name;
            $sample->style_no = $request->style_no;
            $sample->coordinator_id = $request->coordinator_id;
            $sample->wash_coordinator_id = $request->wash_coordinator_id;
            $sample->finishing_coordinator_id = $request->finishing_coordinator_id;
            $sample->cad_id = $request->cad_id;
            $sample->design_no = $request->design_no;
            $sample->user_id = Auth::user()->id;
            $sample->user_ip = $request->ip();
            $sample->save();
            $res->message = 'Sample Insert Success !!';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function updateSample(Request $request)
    {
        $res = new stdClass();
        try {
            $sample = Sample::findOrFail($request->id);
            $sample->gm_id = $request->gm_id;
            $sample->buyer_id = $request->buyer_id;
            $sample->item_name = $request->item_name;
            $sample->style_no = $request->style_no;
            $sample->coordinator_id = $request->coordinator_id;
            $sample->wash_coordinator_id = $request->wash_coordinator_id;
            $sample->finishing_coordinator_id = $request->finishing_coordinator_id;
            $sample->cad_id = $request->cad_id;
            $sample->cad_done_date= $request->cad_done_date;
            $sample->cad_done_time= $request->cad_done_time;
            $sample->design_no = $request->design_no;
            $sample->user_ip = $request->ip();
            $sample->save();
            $res->message = 'Sample Update Success !!';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function deleteSample(Request $request)
    {
        $res = new stdClass();
        try {
            $sample = Sample::find($request->id);
            $sample->delete();
            $res->message = 'Delete Success !!';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function AddSampleData(Request $request)
    {
        // dd($request->file('file_0'));
        $res = new stdClass();
        try {
            // $data = json_decode($request->sample);
            $sample = json_decode($request->sample);

            foreach($sample as $ind => $value){
                $sampleData = new SampleData();
                $sampleData->sample_name_id = $value->sample_name_id;
                $sampleData->sample_type = $value->sample_type;
                $sampleData->fabric_code = $value->fabric_code;
                $sampleData->color_id = $value->color_id;
                $sampleData->wash_unit_id = $value->wash_unit_id;
                $sampleData->size = $value->size;
                $sampleData->quantity = $value->quantity;
                $sampleData->req_sent_date = $value->req_sent_date;
                $sampleData->wash = $value->wash;
                $sampleData->print_emb = $value->print_emb;
                $sampleData->support_fab = $value->support_fab;
                $sampleData->thread = $value->thread;
                $sampleData->trims_and_acc = $value->trims_and_acc;
                $sampleData->other_one = $value->other_one;
                $sampleData->other_two = $value->other_two;
                $sampleData->remarks = $value->remarks;
                $sampleData->sample_id = $request->sampleId;
                $sampleData->file = $this->imageUpload($request, 'file_'.$ind, 'uploads/file');
                $sampleData->user_id = Auth::user()->id;
                $sampleData->user_ip = $request->ip();
                $sampleData->save();
            }
            
            $res->message = 'Successfully Saved !!';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!'.$e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function SampleData() 
    {
        return view('pages.sample.sampleData');
    }

    public function GetSampleData() 
    {
        $sampleData = SampleData::with(['sample', 'sample_name',
        'color' => function($c) {
            $c->select('id', 'name');
        }, 'user' => function($u) {
            $u->select('id', 'name');
        }, 'washUnit' => function($wu){
            $wu->select('id', 'name');
        } , 'sample.buyer' => function($b) {
            $b->select('id', 'name');
        }, 'sample.gm' => function($g) {
            $g->select('id', 'name');
        }, 'sample.coordinator' => function($c) {
            $c->select('id', 'name');
        }, 'sample.washCoordinator' => function($wc) {
            $wc->select('id', 'name');
        }, 'sample.finishingCoordinator' => function($fc) {
            $fc->select('id', 'name');
        }, 'sample.cad' => function($c) {
            $c->select('id', 'name');
        }]);

        if(isset(Auth::user()->coordinator_id) && Auth::user()->coordinator_id != null) {
            $sampleData = $sampleData->whereHas('sample', function($s){
                $s->where('coordinator_id', Auth::user()->coordinator_id);
            });
        }
        if(isset(Auth::user()->gm) && Auth::user()->gm != null) {
            $sampleData = $sampleData->whereHas('sample', function($s){
                $s->where('gm_id', Auth::user()->gm);
            });
        }
        if(isset(Auth::user()->wash_coordinator_id) && Auth::user()->wash_coordinator_id != null) {
            $sampleData = $sampleData->whereHas('sample', function($s){
                $s->where('wash_coordinator_id', Auth::user()->wash_coordinator_id);
            });
        }
        if(isset(Auth::user()->finishing_coordinator_id) && Auth::user()->finishing_coordinator_id != null) {
            $sampleData = $sampleData->whereHas('sample', function($s){
                $s->where('finishing_coordinator_id', Auth::user()->finishing_coordinator_id);
            });
        }
        if(isset(Auth::user()->cad_id) && Auth::user()->cad_id != null) {
            $sampleData = $sampleData->whereHas('sample', function($s){
                $s->where('cad_id', Auth::user()->cad_id);
            });
        }
        if(isset(Auth::user()->wash_unit_id) && Auth::user()->wash_unit_id != null) {
            $sampleData = $sampleData->where('wash_unit_id', Auth::user()->wash_unit_id);
        }
        if(isset(Auth::user()->id) && Auth::user()->id != 1 && Auth::user()->gm == null && Auth::user()->coordinator_id == null && Auth::user()->wash_coordinator_id == null && Auth::user()->finishing_coordinator_id == null && Auth::user()->cad_id == null && Auth::user()->wash_unit_id == null) {
            $sampleData = $sampleData->where('user_id', Auth::user()->id);
        }
        return $sampleData = $sampleData->orderBy('id', 'DESC')->get();
    }

    public function UpdateSampleData(Request $request)
    {
        // dd($request->sample);
        $res = new stdClass();
        try {
            $sample = json_decode($request->sample);
            $sampleData = SampleData::find($sample->id);

            $ExcelFile = $sampleData->file;
            if ($request->hasFile('file')) {
                if (!empty($sampleData->file) && file_exists($sampleData->file)) 
                    unlink($sampleData->file);
                $ExcelFile = $this->imageUpload($request, 'file', 'uploads/file');
            }

            $sampleData->sample_name_id = $sample->sample_name_id;
            $sampleData->sample_type = $sample->sample_type;
            $sampleData->fabric_code = $sample->fabric_code;
            $sampleData->color_id = $sample->color_id;
            $sampleData->wash_unit_id = $sample->wash_unit_id;
            $sampleData->size = $sample->size;
            $sampleData->quantity = $sample->quantity;
            $sampleData->req_sent_date = $sample->req_sent_date;
            $sampleData->req_accept_date = $sample->req_accept_date;
            $sampleData->sewing_date = $sample->sewing_date;
            $sampleData->sample_delivery_date = $sample->sample_delivery_date;
            $sampleData->actual_delivery_date = $sample->actual_delivery_date;
            $sampleData->sent_finish = $sample->sent_finish;
            $sampleData->merchant_receive = $sample->merchant_receive;
            $sampleData->shrinkage_time = $sample->shrinkage_time;
            $sampleData->shrinkage_date = $sample->shrinkage_date;
            $sampleData->materials_date = $sample->materials_date;
            $sampleData->materials_time = $sample->materials_time;
            $sampleData->priority_date = $sample->priority_date;
            $sampleData->priority_time = $sample->priority_time;
            $sampleData->wash = $sample->wash;
            $sampleData->print_emb = $sample->print_emb;
            $sampleData->support_fab = $sample->support_fab;
            $sampleData->thread = $sample->thread;
            $sampleData->trims_and_acc = $sample->trims_and_acc;
            $sampleData->other_one = $sample->other_one;
            $sampleData->other_two = $sample->other_two;
            $sampleData->remarks = $sample->remarks;
            $sampleData->file = $ExcelFile;
            $sampleData->user_ip = $request->ip();
            $sampleData->save();
            $res->message = 'Successfully Update !!';
        } catch (\Exception $e) {
            $res->message = $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function DeleteSampleData(Request $request)
    {
        $res = new stdClass();
        try {
            $sample_data = SampleData::find($request->id);
            $sample_data->delete();
            $res->message = 'Delete Success';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function CancelSampleData(Request $request)
    {
        $res = new stdClass();
        try {
            $sample_data = SampleData::find($request->id);
            $sample_data->status = 'd';
            $sample_data->save();
            $res->message = 'Sample Data Cancel';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function ActiveSampleData(Request $request)
    {
        $res = new stdClass();
        try {
            $sample_data = SampleData::find($request->id);
            $sample_data->active = 1;
            $sample_data->save();
            $res->message = 'Sample Data Active';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function InactiveSampleData(Request $request)
    {
        $res = new stdClass();
        try {
            $sample_data = SampleData::find($request->id);
            $sample_data->active = 0;
            $sample_data->save();
            $res->message = 'Sample Data Inactive';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function BlankData() 
    {
        // return Auth::user()->role->permission;
        return view('pages.sample.blank_data');
    }

    public function GetBlankData(Request $request)
    {
        $sampleData = SampleData::with(['sample', 'sample_name',
        'color' => function($c) {
            $c->select('id', 'name');
        }, 'user' => function($u) {
            $u->select('id', 'name');
        }, 'washUnit' => function($wu){
            $wu->select('id', 'name');
        }, 'sample.buyer' => function($b) {
            $b->select('id', 'name');
        }, 'sample.gm' => function($g) {
            $g->select('id', 'name');
        }, 'sample.coordinator' => function($c) {
            $c->select('id', 'name');
        },'sample.washCoordinator' => function($wc) {
            $wc->select('id', 'name');
        }, 'sample.finishingCoordinator' => function($fc) {
            $fc->select('id', 'name');
        }, 'sample.cad' => function($c) {
            $c->select('id', 'name');
        }])->where('active', 1);

        if(isset(Auth::user()->coordinator_id) && Auth::user()->coordinator_id != null) {
            $sampleData = $sampleData->whereHas('sample', function($s) {
                $s->where('coordinator_id', Auth::user()->coordinator_id);
            });
        }
        if(isset(Auth::user()->gm) && Auth::user()->gm != null) {
            $sampleData = $sampleData->whereHas('sample', function($s){
                $s->where('gm_id', Auth::user()->gm);
            });
        }
       
        if(isset(Auth::user()->wash_coordinator_id) && Auth::user()->wash_coordinator_id != null) {
            $sampleData = $sampleData->whereHas('sample', function($s) {
                $s->where('wash_coordinator_id', Auth::user()->wash_coordinator_id);
            });
        }
        if(isset(Auth::user()->finishing_coordinator_id) && Auth::user()->finishing_coordinator_id != null) {
            $sampleData = $sampleData->whereHas('sample', function($s){
                $s->where('finishing_coordinator_id', Auth::user()->finishing_coordinator_id);
            });
        }
        
        if(isset(Auth::user()->cad_id) && Auth::user()->cad_id != null) {
            $sampleData = $sampleData->whereHas('sample', function($s){
                $s->where('cad_id', Auth::user()->cad_id);
            });
        }

        if(isset(Auth::user()->wash_unit_id) && Auth::user()->wash_unit_id != null) {
            $sampleData = $sampleData->where('wash_unit_id', Auth::user()->wash_unit_id);
        }
        
        if(isset(Auth::user()->id) && (Auth::user()->role_id != 1 && Auth::user()->role_id != 4) && Auth::user()->gm == null && Auth::user()->coordinator_id == null && Auth::user()->wash_coordinator_id == null && Auth::user()->finishing_coordinator_id == null && Auth::user()->cad_id == null && Auth::user()->wash_unit_id == null) {
            $sampleData = $sampleData->where('user_id', Auth::user()->id);
        }

        if(isset($request->searchType) && $request->searchType == 'req_date'){
            $sampleData = $sampleData->whereNull('req_accept_date');
        }

        if(isset($request->searchType) && $request->searchType == 'sewing_date'){
            $sampleData = $sampleData->whereNull('sewing_date');
        }

        if(isset($request->searchType) && $request->searchType == 'delivery_date'){
            $sampleData = $sampleData->whereNull('sample_delivery_date');
        }

        if(isset($request->searchType) && $request->searchType == 'to_finish'){
            $sampleData = $sampleData->whereNull('sent_finish');
        }

        if(isset($request->searchType) && $request->searchType == 'to_merchant'){
            $sampleData = $sampleData->whereNull('merchant_receive');
        }

        if(isset($request->searchType) && $request->searchType == 'received_date'){
            $sampleData = $sampleData->whereNull('actual_delivery_date');
        }
        if(isset($request->searchType) && $request->searchType == 'priority_date'){
            $sampleData = $sampleData->whereNull('priority_date');
        }
        // if( Auth::user()->role_id == 4) {
        //     $sampleData = $sampleData->whereNull('merchant_receive');
        //     $sampleData = $sampleData->whereNull('sent_finish');
        //     $sampleData = $sampleData->whereNull('sample_delivery_date');
        // }
        return $sampleData = $sampleData->orderBy('id', 'DESC')->get();
       
    }

    public function insert(Request $request)
    {
        $res = new stdClass();
        try {
            $insert = SampleData::find($request->id);
            $sampleData = new SampleData();
            $sampleData->sample_name_id = $insert->sample_name_id;
            $sampleData->sample_type = $insert->sample_type;
            $sampleData->fabric_code = $insert->fabric_code;
            $sampleData->color_id = $insert->color_id;
            $sampleData->wash_unit_id = $insert->wash_unit_id;
            $sampleData->size = $insert->size;
            $sampleData->quantity = $insert->quantity;
            $sampleData->req_sent_date = $insert->req_sent_date;
            $sampleData->req_accept_date = $insert->req_accept_date;
            $sampleData->sewing_date = $insert->sewing_date;
            $sampleData->sample_delivery_date = $insert->sample_delivery_date;
            $sampleData->actual_delivery_date = $insert->actual_delivery_date;
            $sampleData->sent_finish = $insert->sent_finish;
            $sampleData->merchant_receive = $insert->merchant_receive;
            $sampleData->shrinkage_date = $insert->shrinkage_date;
            $sampleData->shrinkage_time = $insert->shrinkage_time;
            $sampleData->materials_date = $insert->materials_date;
            $sampleData->materials_time = $insert->materials_time;
            $sampleData->wash = $insert->wash;
            $sampleData->print_emb = $insert->print_emb;
            $sampleData->support_fab = $insert->support_fab;
            $sampleData->thread = $insert->thread;
            $sampleData->trims_and_acc = $insert->trims_and_acc;
            $sampleData->other_one = $insert->other_one;
            $sampleData->other_two = $insert->other_two;
            $sampleData->remarks = $insert->remarks;
            $sampleData->sample_id = $insert->sample_id;
            $sampleData->file = $insert->file;
            $sampleData->user_id = Auth::user()->id;
            $sampleData->user_ip = $request->ip();
            $sampleData->save();
            $res->message = 'Sample Data Insert';
        } catch (\Exception $e) {
            $res->message = 'Something went wrong!';
        }
        return response(['message' => $res->message ]);
    }

    public function sampleDataView($id){
        $sample_data = SampleData::with(['sample', 'sample_name',
        'color' => function($c) {
            $c->select('id', 'name');
        }, 'washUnit' => function($wu){
            $wu->select('id', 'name');
        }, 'user' => function($u) {
            $u->select('id', 'name');
        }, 'sample.buyer' => function($b) {
            $b->select('id', 'name');
        }, 'sample.gm' => function($g) {
            $g->select('id', 'name');
        }, 'sample.coordinator' => function($c) {
            $c->select('id', 'name');
        }, 'sample.washCoordinator' => function($wc) {
            $wc->select('id', 'name');
        }, 'sample.finishingCoordinator' => function($fc) {
            $fc->select('id', 'name');
        }, 'sample.cad' => function($c) {
            $c->select('id', 'name');
        }])->where('id', $id)->first();
        return view('pages.sample.view', compact('sample_data'));
    }
}
