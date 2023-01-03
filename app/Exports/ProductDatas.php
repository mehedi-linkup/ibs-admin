<?php

namespace App\Exports;

use App\Models\OrderDetails;
use App\Models\ProductData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductDatas implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return OrderDetails::all('id', 'order_data_id', 'order_number', 'shipment_date', 'color_id', 'size', 'order_qty', 'unit_id', 'pt_received', 'payment_date', 'tentative_in_house_date', 'received_qty', 'remaining_qty', 'in_house_date', 'task');
    }

    public function headings(): array
    {
        return [
            'SL',
            'Order Data',
            'Po/Order number',
            'Shipment date',
            'Color',
            'Size',
            'Order Qty',
            'Unit in',
            'Pt received',
            'Payment date',
            'Tentative in-house date',
            'Received Qty',
            'Remaining Qty',
            'In-House Date',
            'Task Done',
        ];
    }
}
