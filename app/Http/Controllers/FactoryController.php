<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Factory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactoryController extends Controller
{
    public function index()
    {
        return view('pages.content.factory');
    }

    public function getFactory()
    {
        return Factory::get();
    }

    public function saveFactory(Request $request)
    {
        $res = new stdClass();
        try {
            $factory = new Factory();
            $factory->name = $request->name;
            $factory->user_id = Auth::user()->id;
            $factory->user_ip = $request->ip();
            $factory->save();
            $res->message = 'Insert Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function UpdateFactory(Request $request)
    {
        $res = new stdClass();
        try {
            $factory = Factory::find($request->id);
            $factory->name = $request->name;
            $factory->user_id = Auth::user()->id;
            $factory->user_ip = $request->ip();
            $factory->save();
            $res->message = 'Update Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteFactory(Request $request)
    {
        $res = new stdClass();
        try {
            $factory = Factory::find($request->id);
            if($factory->orders->count() > 0) {
                $res->message = 'At first need to delete this Factory Orders!!';
            } else {
                $factory->delete();
                $res->message = 'Delete Success !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
