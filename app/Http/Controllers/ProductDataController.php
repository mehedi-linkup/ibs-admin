<?php

namespace App\Http\Controllers;

use App\Models\ProductData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class ProductDataController extends Controller
{
    public function index()
    {
        return view('pages.product.productData');
    }
    public function getData(Request $request)
    {
       return $productDatas = ProductData::latest()->get(); 
    }
    public function store(Request $request)
    {
        $res = new stdClass();
        try {
            foreach($request->product as $value) {
                // return print_r($value);
                $productData = new ProductData();
                $productData->smv = $value['smv'];
                $productData->eff = $value['eff'];
                $productData->fob = $value['fob'];
                $productData->quantity = $value['quantity'];
                $productData->tod = $value['tod'];
                $productData->product_id = $request->productId;
                $productData->user_id = Auth::user()->id;
                $productData->user_ip = $request->ip();
                $productData->save();
            }
            $res->message = 'Successfully Saved!';

        } catch (\Exception $e) {
            $res->message = "Failes !" . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function update(Request $request)
    {
        $res = new stdClass();
        try {
            $productData = ProductData::find($request->id);
            $productData->smv = $request->smv;
            $productData->eff = $request->eff;
            $productData->fob = $request->fob;
            $productData->quantity = $request->quantity;
            $productData->tod = $request->tod;
            $productData->product_id = $productData->product_id;
            $productData->user_id = Auth::user()->id;
            $productData->user_ip = $request->ip();
            $productData->save();
            $res->message = 'Successfully Update!';
        } catch (\Exception $e) {
            $res->message = "Failes !" . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteData(Request $request)
    {
        $res = new stdClass();
        try {
            $productData = ProductData::find($request->id);
            $productData->delete();
            $res->message = 'Delete Success';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}



