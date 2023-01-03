<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Coordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CordinatorController extends Controller
{
    public function index()
    {
        return view('pages.content.coordinator');
    }

    public function getCoordinator()
    {
        return Coordinator::get();
    }

    public function store(Request $request)
    {
        $res = new stdClass();
        try {
            $coordinator = new Coordinator();
            $coordinator->name = $request->name;
            $coordinator->user_id = Auth::user()->id;
            $coordinator->user_ip = $request->ip();
            $coordinator->save();
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
            $coordinator = Coordinator::find($request->id);
            $coordinator->name = $request->name;
            $coordinator->user_id = Auth::user()->id;
            $coordinator->user_ip = $request->ip();
            $coordinator->save();
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
            $coordinator = Coordinator::find($request->id);
            if($coordinator->samples->count() > 0) {
                $res->message = 'At first need to delete this Coordinator Orders!!';
            } else {
                $coordinator->delete();
                $res->message = 'Delete Success !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
