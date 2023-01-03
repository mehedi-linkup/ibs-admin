<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function index()
    {
        return view('pages.content.merchant');
    }

    public function getMerchant()
    {
        return Merchant::get();
    }

    public function saveMerchant(Request $request)
    {
        $res = new stdClass();
        try {
            $merchant = new Merchant();
            $merchant->name = $request->name;
            $merchant->user_id = Auth::user()->id;
            $merchant->user_ip = $request->ip();
            $merchant->save();
            $res->message = 'Insert Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function UpdateMerchant(Request $request)
    {
        $res = new stdClass();
        try {
            $merchant = Merchant::find($request->id);
            $merchant->name = $request->name;
            $merchant->user_id = Auth::user()->id;
            $merchant->user_ip = $request->ip();
            $merchant->save();
            $res->message = 'Update Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteMerchant(Request $request)
    {
        $res = new stdClass();
        try {
            $merchant = Merchant::find($request->id);
            if($merchant->orders->count() > 0) {
                $res->message = 'At first need to delete this Merchant Orders!!';
            } else {
                $merchant->delete();
                $res->message = 'Delete Success !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
