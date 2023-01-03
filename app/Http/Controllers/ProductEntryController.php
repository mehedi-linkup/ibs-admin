<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\Department;
use App\Models\ProductData;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductEntryController extends Controller
{
    public function index()
    {
        $buyers = Buyer::all();
        $departments = Department::all();
        $products = Product::latest()->get();
        return View('pages.product.index', compact('buyers', 'departments', 'products'));
    }

    public function productData()
    {
        $products = Product::with('buyer', 'department');
        
        if(Auth::user()->role_id != 1) {
            $products = $products->where('user_id', Auth::user()->id);
        }
        
        $products = $products->latest()->get();
        
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cp' => 'required',
            'buyer_id' => 'required',
            'season' => 'required',
            'department_id' => 'required',
            'style_no_or_name' => 'required',
            'description' => 'required',
            'base_top_up' => 'required',
            'fty' => 'required',
            'lc' => 'required',
            'gm' => 'required',
        ]);
        $res = new stdClass();
        if($request->action == 'insert') {
            $product = new Product();
            $product->cp = $request->cp;
            $product->buyer_id = $request->buyer_id;
            $product->season = $request->season;
            $product->department_id = $request->department_id;
            $product->style_no_or_name = $request->style_no_or_name;
            $product->description = $request->description;
            $product->base_top_up = $request->base_top_up;
            $product->fty = $request->fty;
            $product->lc = $request->lc;
            $product->gm = $request->gm;
            $product->user_id = Auth::user()->id;
            $product->user_ip = $request->ip();
            $product->save();
            if($product) {
                $res->message = 'Product Create successfully!';
                return response()->json($product);
            }
            return response(['message' => $res->message]);
            return redirect()->back()->withInput();
        }

        if($request->action == 'update') {
            // return $request;
            $product = Product::find($request->id);
            $product->cp = $request->cp;
            $product->buyer_id = $request->buyer_id;
            $product->season = $request->season;
            $product->department_id = $request->department_id;
            $product->style_no_or_name = $request->style_no_or_name;
            $product->description = $request->description;
            $product->base_top_up = $request->base_top_up;
            $product->fty = $request->fty;
            $product->lc = $request->lc;
            $product->gm = $request->gm;
            $product->user_id = Auth::user()->id;
            $product->user_ip = $request->ip();
            $product->save();
            if($product) {
                $res->message = 'Product Update successfully!';
                return back();
            }
            return response(['message' => $res->message]);
            return redirect()->back()->withInput();
        }
        

    }

    public function getFullProduct(Request $request)
    {
        $products = ProductData::with('product')->latest()->get();
        return view('pages.product.product', compact('products'));
    }

    public function productSearch()
    {
        return view('pages.product.productSearch');
    }

    public function productDataWiseSearch()
    {
        return view('pages.product.productWiseSearch');
    }
    
    public function updateProduct(Request $request)
    {
        $data = Product::where('id', $request->id)->get();
        return json_encode($data);
    }

    public function getSearchResult(Request $request)
    {
        // $product = ProductData::with(['product', 'product.buyer', 'product.department']);
        $clauses = "";

        if(isset($request->buyerId)) {
            $clauses .= " and p.buyer_id = $request->buyerId";
        }

        if(isset($request->departmentId)) {
            $clauses .= " and p.department_id = $request->departmentId";
        }

        if(isset($request->style) && $request->style != '') {
            $clauses .= " and p.style_no_or_name = '$request->style'";
        }

        if($request->dateFrom != '' && $request->dateTo != '') {
            $clauses .= " and date(pd.created_at) between '$request->dateFrom' and '$request->dateTo'";
        }

        $product = DB::select("
            select
                pd.*,
                p.*,
                d.name as department,
                b.name as buyer
            from product_data pd
            left join products p on p.id = pd.product_id 
            left join departments d on d.id = p.department_id
            left join buyers b on b.id = p.buyer_id
            where pd.deleted_at is null
            $clauses
        ");

        return $product;
    }

    public function getProduct(Request $request)
    {
        return Product::all();
    }

    public function destroy(Request $request)
    {
        $res = new stdClass();
        $product = Product::find($request->id);
        if($product->product_data->count() > 0)
        {
           $res->message = 'At First Delete This Product Data!';
        } else {
            $product->delete();
           $res->message = 'Product Delete successfully!';
        }
        return response(['message' => $res->message]);
    }
}
