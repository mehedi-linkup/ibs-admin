<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        return view('pages.content.supplier');
    }

    public function getSupplier()
    {
        return Supplier::get();
    }

    public function saveSupplier(Request $request)
    {
        $res = new stdClass();
        try {
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->user_id = Auth::user()->id;
            $supplier->user_ip = $request->ip();
            $supplier->save();
            $res->message = 'Insert Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function UpdateSupplier(Request $request)
    {
        $res = new stdClass();
        try {
            $supplier = Supplier::find($request->id);
            $supplier->name = $request->name;
            $supplier->user_id = Auth::user()->id;
            $supplier->user_ip = $request->ip();
            $supplier->save();
            $res->message = 'Update Success !!';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteSupplier(Request $request)
    {
        $res = new stdClass();
        try {
            $supplier = Supplier::find($request->id);
            if($supplier->orderDatas->count() > 0) {
                $res->message = 'At first need to delete this Supplier OrderDatas!!';
            } else {
                $supplier->delete();
                $res->message = 'Delete Success !!';
            }
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
