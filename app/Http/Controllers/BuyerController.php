<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Buyer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function index()
    {
        return view('pages.buyer.index');
    }

    public function getBuyer()
    {
        return Buyer::get();
    }

    public function saveBuyer(Request $request)
    {
        $res = new stdClass();
        try {
            $slug = Str::slug($request->name);
            $buyer = new Buyer();
            $buyer->name = $request->name;
            $buyer->slug = $slug;
            $buyer->user_id = Auth::user()->id;
            $buyer->user_ip = $request->ip();
            $buyer->save();
            $res->message = 'Insert Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function UpdateBuyer(Request $request)
    {
        $res = new stdClass();
        try {
            $slug = Str::slug($request->name);
            $buyer = Buyer::find($request->id);
            $buyer->name = $request->name;
            $buyer->slug = $slug;
            $buyer->user_id = Auth::user()->id;
            $buyer->user_ip = $request->ip();
            $buyer->save();
            $res->message = 'Update Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteBuyer(Request $request)
    {
        $res = new stdClass();
        try {
            $buyer = Buyer::find($request->id);
            if($buyer->orders->count() > 0) {
                $res->message = 'At first need to delete this buyer Orders!!';
            } else {
                $buyer->delete();
                $res->message = 'Delete Success !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

}
