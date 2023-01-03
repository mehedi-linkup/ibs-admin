@extends('layouts.master')
@section('title', 'Product SubTotal')
@section('main-content')
<main>
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Product</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i>Product Full Data</div>
            </div>
            <div class="card-body table-card-body">
                <table id="datatablesSimple">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>SL</th>
                            <th>C/P</th>
                            <th>Buyer</th>
                            <th>Season</th>
                            <th>Dept.</th>
                            <th>Style Number/Name</th>
                            <th>Product Description</th>
                            <th>Base/ Top up/ Reprat</th>
                            <th>FTY</th>
                            <th>L/C</th>
                            <th>SMV</th>
                            <th>EFF%</th>
                            <th>FOB</th>
                            <th>TOD</th>
                            <th>Quantity</th>
                            <th>CM</th>
                            <th>VALUE</th>
                            <th>TOTAL SMH</th>
                            <th>SMH EFF</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($products as $item) 
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product ? $item->product->cp : '' }}</td>
                            <td>{{ $item->product ? $item->product->buyer->name : '' }}</td>
                            <td>{{ $item->product ? $item->product->season : '' }}</td>
                            <td>{{ $item->product ? $item->product->department->name : '' }}</td>
                            <td>{{ $item->product ? $item->product->style_no_or_name : ''}}</td>
                            <td>{{ $item->product ? $item->product->description : ''}}</td>
                            <td>{{ $item->product ? $item->product->base_top_up : '' }}</td>
                            <td>{{ $item->produc ? $item->product->fty : ''}}</td>
                            <td>{{ $item->product ? $item->product->lc : '' }}</td>
                            <td>{{ $item->smv }}</td>
                            <td>{{ $item->eff }}</td>
                            <td>{{ $item->fob }}</td>
                            <td>{{ $item->tod }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format(($item->smv / ($item->eff/100))* 0.045 * 12, 2) }}</td>
                            <td>{{ number_format($item->fob * $item->quantity, 2) }}</td>
                            <td>{{ number_format($item->smv * $item->quantity / 60, 2) }}</td>
                            <td>{{ number_format(($item->smv * $item->quantity / 60) / ($item->eff/100), 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
