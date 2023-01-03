<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function index()
    {
        return view('pages.content.unit');
    }

    public function getUnit()
    {
        return Unit::get();
    }

    public function saveUnit(Request $request)
    {
        $res = new stdClass();
        try {
            $unit = new Unit();
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

    public function UpdateUnit(Request $request)
    {
        $res = new stdClass();
        try {
            $unit = Unit::find($request->id);
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

    public function deleteUnit(Request $request)
    {
        $res = new stdClass();
        try {
            $unit = Unit::find($request->id);
            if($unit->orderDetails->count() > 0) {
                $res->message = 'At first need to delete this Unit OrderDetails!!';
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
