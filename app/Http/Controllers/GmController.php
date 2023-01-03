<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Gm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GmController extends Controller
{
    public function index()
    {
        return view('pages.content.gm');
    }

    public function getData()
    {
        return Gm::get();
    }

    public function store(Request $request)
    {
        $res = new stdClass();
        try {
            $gm = new Gm();
            $gm->name = $request->name;
            $gm->user_id = Auth::user()->id;
            $gm->user_ip = $request->ip();
            $gm->save();
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
            $gm = Gm::find($request->id);
            $gm->name = $request->name;
            $gm->user_id = Auth::user()->id;
            $gm->user_ip = $request->ip();
            $gm->save();
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
            $gm = Gm::find($request->id);
            if($gm->samples->count() > 0) {
                $res->message = 'At first need to delete this gm Orders!!';
            } else {
                $gm->delete();
                $res->message = 'Delete Success !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
