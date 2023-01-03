@extends('layouts.master')
@section('title', 'Materials Data View')
@push('css')
@endpush
@section('main-content')
<main>
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Materials Data View</span>
        </div>
        <div class="row mt-3">
            <div class="col-md-10 offset-md-1">
                <button href="#" id="hide" onclick="printDiv('MaterialsData')" class="btn btn-primary float-right my-2 ml-2"><i class="fa fa-print mr-1"></i> Print</button>
                <div class="table-responsive" id="MaterialsData">
                    <h4 class="text-center py-2">Materials Data view</h4>
                    <table class="table table-hober table-bordered">
                        <tr>
                            <th style="width:25%;">SL</th>
                            <td>{{ $material->id }}</td>
                        </tr>
                        <tr>
                            <th style="width:25%;">Merchant</th>
                            <td>{{ $material->merchant->name }}</td>
                        </tr>
                        <tr>
                            <th>GM</th>
                            <td>{{ $material->gm->name }}</td>
                        </tr>
                        <tr>
                            <th>Sample Cor</th>
                            <td>{{ $material->coordinator->name }}</td>
                        </tr>
                        
                        <tr>
                            <th>Wash Cor</th>
                            <td>{{ $material->washCoordinator->name }}</td>
                        </tr>
                        <tr>
                            <th>Wash Unit</th>
                            <td>{{ $material->washUnit->name }}</td>
                        </tr>
                        <tr>
                            <th>CAD Deg</th>
                            <td>{{ $material->cad->name }}</td>
                        </tr>
                        <tr>
                            <th>Buyer</th>
                            <td>{{ $material->buyer->name }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>{{ $material->supplier->name }}</td>
                        </tr>
                        <tr>
                            <th>Fabric reference</th>
                            <td>{{ $material->fabric_ref }}</td>
                        </tr>
                        <tr>
                            <th>Composition</th>
                            <td>{{ $material->composition }}</td>
                        </tr>
                        <tr>
                            <th>Remarks-1</th>
                            <td>{{ $material->remarks1 }}</td>
                        </tr>
                        <tr>
                            <th>CW</th>
                            <td>{{ $material->cw }}</td>
                        </tr>
                        <tr>
                            <th>BW</th>
                            <td>{{ $material->bw }}</td>
                        </tr>
                        <tr>
                            <th>AW</th>
                            <td>{{ $material->aw }}</td>
                        </tr>
                        <tr>
                            <th>Fabric sent</th>
                            @if (isset($material->fabric_sent))
                                <td>{{ \Carbon\Carbon::parse($material->fabric_sent)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $material->fabric_sent }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Time</th>
                            @if (isset($material->time))
                                <td>{{ \Carbon\Carbon::parse($material->time)->format('h:i:A') }}</td>
                            @else
                                <td>{{ $material->time }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Update Date</th>
                            @if (isset($material->update_time))
                                <td>{{ \Carbon\Carbon::parse($material->update_time)->format('d/m/Y h:s:A') }}</td>
                            @else
                                <td>{{ $material->update_time }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>QTY</th>
                            <td>{{ $material->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Received date</th>
                            @if (isset($material->receive_date))
                                <td>{{ \Carbon\Carbon::parse($material->receive_date)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $material->receive_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Update Date</th>
                            @if (isset($material->receive_update_date))
                                <td>{{ \Carbon\Carbon::parse($material->receive_update_date)->format('d/m/Y h:s:A') }}</td>
                            @else
                                <td>{{ $material->receive_update_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Received QTY</th>
                            <td>{{ $material->receive_qty }}</td>
                        </tr>
                        <tr>
                            <th>Sent to shrinkage</th>
                            @if (isset($material->shrinkage_sent))
                                <td>{{ \Carbon\Carbon::parse($material->shrinkage_sent)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $material->shrinkage_sent }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>shrinkage time</th>
                            @if (isset($material->shrinkage_time))
                                <td>{{ \Carbon\Carbon::parse($material->shrinkage_time)->format('h:i:A') }}</td>
                            @else
                                <td>{{ $material->shrinkage_time }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Update Date</th>
                            @if (isset($material->shrinkage_update_date))
                                <td>{{ \Carbon\Carbon::parse($material->shrinkage_update_date)->format('d/m/Y h:s:A') }}</td>
                            @else
                                <td>{{ $material->shrinkage_update_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Return to section</th>
                            @if (isset($material->return_to_section))
                                <td>{{ \Carbon\Carbon::parse($material->return_to_section)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $material->return_to_section }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Update Date & Time</th>
                            @if (isset($material->return_to_time))
                                <td>{{ \Carbon\Carbon::parse($material->return_to_time)->format('d/m/Y h:s:A') }}</td>
                            @else
                                <td>{{ $material->return_to_time }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Shrinkage Received</th>
                            @if (isset($material->shrinkage_receive))
                                <td>{{ \Carbon\Carbon::parse($material->shrinkage_receive)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $material->shrinkage_receive }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Time</th>
                            @if (isset($material->shrinkage_receive_time))
                                <td>{{ \Carbon\Carbon::parse($material->shrinkage_receive_time)->format('h:i:A') }}</td>
                            @else
                                <td>{{ $material->shrinkage_receive_time }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Update Date</th>
                            @if (isset($material->shrinkage_receive_update))
                                <td>{{ \Carbon\Carbon::parse($material->shrinkage_receive_update)->format('d/m/Y h:s:A') }}</td>
                            @else
                                <td>{{ $material->shrinkage_receive_update }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Shrinkage length</th>
                            <td>{{ $material->shrinkage_length }}</td>
                        </tr>
                        <tr>
                            <th>Shrinkage width</th>
                            <td>{{ $material->shrinkage_width }}</td>
                        </tr>
                        <tr>
                            <th>Used QTY</th>
                            <td>{{ $material->used_materials_sum_use_qty }}</td>
                        </tr>
                        <tr>
                            <th>Balance QTY</th>
                            <td>{{ $material->receive_qty - $material->used_materials_sum_use_qty }}</td>
                        </tr>
                        <tr>
                            <th>Sent to store</th>
                            @if (isset($material->sent_store))
                                <td>{{ \Carbon\Carbon::parse($material->sent_store)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $material->sent_store }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Update date</th>
                            @if (isset($material->update_store))
                                <td>{{ \Carbon\Carbon::parse($material->update_store)->format('d/m/Y h:s:A') }}</td>
                            @else
                                <td>{{ $material->update_store }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Store Qty</th>
                            <td>{{ $material->store_qty }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('js')
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endpush