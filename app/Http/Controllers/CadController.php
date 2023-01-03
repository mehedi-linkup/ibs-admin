<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Cad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CadController extends Controller
{
    public function index()
    {
        return view('pages.content.cad');
    }

    public function getCads()
    {
        return Cad::get();
    }

    public function store(Request $request)
    {
        $res = new stdClass();
        try {
            $cad = new Cad();
            $cad->name = $request->name;
            $cad->user_id = Auth::user()->id;
            $cad->user_ip = $request->ip();
            $cad->save();
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
            $cad = Cad::find($request->id);
            $cad->name = $request->name;
            $cad->user_id = Auth::user()->id;
            $cad->user_ip = $request->ip();
            $cad->save();
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
            $cad = Cad::find($request->id);
            if($cad->samples->count() > 0) {
                $res->message = 'At first need to delete this wash cad Orders!!';
            } else {
                $cad->delete();
                $res->message = 'Delete Success !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
