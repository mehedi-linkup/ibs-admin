<?php

namespace App\Exports;

use App\Models\Sample;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SamplesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sample::all('id', 'gm', 'buyer_id', 'item_name', 'style_no', 'design_no', 'coordinator_id');
    }

    public function headings(): array
    {
        return [
            'SL',
            'GM',
            'Buyer',
            'Style No',
            'Item Name',
            'Design No',
            'Cordinator',
        ];
    }
}
