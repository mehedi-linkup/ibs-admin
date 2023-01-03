<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\SampleName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SampleNameController extends Controller
{
    public function index()
    {
        return view('pages.content.sample_name');
    }

    public function getData()
    {
        return SampleName::get();
    }

    public function store(Request $request)
    {
        $res = new stdClass();
        try {
            $sample_name = new SampleName();
            $sample_name->name = $request->name;
            $sample_name->user_id = Auth::user()->id;
            $sample_name->user_ip = $request->ip();
            $sample_name->save();
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
            $sample_name = SampleName::find($request->id);
            $sample_name->name = $request->name;
            $sample_name->user_id = Auth::user()->id;
            $sample_name->user_ip = $request->ip();
            $sample_name->save();
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
            $sample_name = SampleName::find($request->id);
            $sample_name->delete();
            $res->message = 'Delete Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
