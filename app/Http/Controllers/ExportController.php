<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ProductDatas;
use App\Exports\SamplesExport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function productExport() 
    {
        return Excel::download(new ProductsExport, 'order-collection.xlsx');
    }    

    public function sampleExport() 
    {
        return Excel::download(new SamplesExport, 'sample.xlsx');
    }    

    public function ProductDataExport()
    {
        return Excel::download(new ProductDatas, 'order-details-collection.xlsx');
    }
}
