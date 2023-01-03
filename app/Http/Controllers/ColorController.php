<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorController extends Controller
{
    public function index()
    {
        return view('pages.content.color');
    }

    public function getColor()
    {
        return Color::orderBy('name', 'ASC')->get();
    }

    public function saveColor(Request $request)
    {
        $res = new stdClass();
        try {
            $color = new Color();
            $color->name = $request->name;
            $color->user_id = Auth::user()->id;
            $color->user_ip = $request->ip();
            $color->save();
            $res->message = 'Insert Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function UpdateColor(Request $request)
    {
        $res = new stdClass();
        try {
            $color = Color::find($request->id);
            $color->name = $request->name;
            $color->user_id = Auth::user()->id;
            $color->user_ip = $request->ip();
            $color->save();
            $res->message = 'Update Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteColor(Request $request)
    {
        $res = new stdClass();
        try {
            $color = Color::find($request->id);
            if($color->orderDetails->count() > 0) {
                $res->message = 'At first need to delete this Color OrderDetails!!';
            } else {
                $color->delete();
                $res->message = 'Delete Success !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
