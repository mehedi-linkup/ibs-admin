<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\WashUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WashingUnitController extends Controller
{
    public function index()
    {
        return view('pages.content.washUnit');
    }

    public function getWashUnit()
    {
        return WashUnit::get();
    }

    public function store(Request $request)
    {
        $res = new stdClass();
        try {
            $unit = new WashUnit();
            $unit->name = $request->name;
            $unit->user_id = Auth::user()->id;
            $unit->user_ip = $request->ip();
            $unit->save();
            $res->message = 'Insert Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function Update(Request $request)
    {
        $res = new stdClass();
        try {
            $unit = WashUnit::find($request->id);
            $unit->name = $request->name;
            $unit->user_id = Auth::user()->id;
            $unit->user_ip = $request->ip();
            $unit->save();
            $res->message = 'Update Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function delete(Request $request)
    {
        $res = new stdClass();
        try {
            $unit = WashUnit::find($request->id);
            if($unit->samples->count() > 0) {
                $res->message = 'At first need to delete this wash unit Orders!!';
            } else {
                $unit->delete();
                $res->message = 'Delete Success !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
