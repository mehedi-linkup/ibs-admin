<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::all('id', 'buyer_id', 'style_description', 'style_number', 'merchant_id', 'factory_id', 'gm');
    }

    public function headings(): array
    {
        return [
            'SL',
            'CP',
            'Style Description',
            'Style Number',
            'Merchant',
            'Factory',
            'GM',
        ];
    }
}
