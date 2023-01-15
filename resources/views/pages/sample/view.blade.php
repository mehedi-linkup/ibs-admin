@extends('layouts.master')
@section('title', 'Sample Data View')
@push('css')
@endpush
@section('main-content')
<main>
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Sample Data View</span>
        </div>
        <div class="row mt-3">
            <div class="col-md-10 offset-md-1">
                <button href="#" id="hide" onclick="printDiv('SampleData')" class="btn btn-primary float-right my-2 ml-2"><i class="fa fa-print mr-1"></i> Print</button>
                <div class="table-responsive" id="SampleData">
                    <h4 class="text-center py-2">Sample Data view</h4>
                    <table class="table table-hober table-bordered">
                        <tr>
                            <th style="width:25%;">SSL*PDSL</th>
                            <td>{{ $sample_data->id }}*{{ $sample_data->sample->id }}</td>
                        </tr>
                        <tr>
                            <th style="width:25%;">Form</th>
                            <td>{{ $sample_data->user->name }}</td>
                        </tr>
                        <tr>
                            <th>GM</th>
                            <td>{{ $sample_data->sample->gm->name }}</td>
                        </tr>
                        <tr>
                            <th>Buyer</th>
                            <td>{{ $sample_data->sample->buyer->name }}</td>
                        </tr>
                       
                        <tr>
                            <th>Sample Cor</th>
                            <td>{{ $sample_data->sample->coordinator->name }}</td>
                        </tr>
                        <tr>
                            <th>Wash Cor</th>
                            <td>{{ $sample_data->sample->washCoordinator->name }}</td>
                        </tr>
                        <tr>
                            <th>Finishing Cor</th>
                            <td>{{ $sample_data->sample->finishingCoordinator->name }}</td>
                        </tr>
                        <tr>
                            <th>CAD Deg</th>
                            <td>{{ $sample_data->sample->cad->name }}</td>
                        </tr>
                        <tr>
                            <th>CAD Done</th>
                            <td>{{ $sample_data->sample->cad_done_date }}</td>
                        </tr>
                        <tr>
                            <th>CAD Remarks</th>
                            <td>{{ $sample_data->sample->design_no }}</td>
                        </tr>
                        <tr>
                            <th>Style No</th>
                            <td>{{ $sample_data->sample->style_no }}</td>
                        </tr>
                        <tr>
                            <th>Item Name</th>
                            <td>{{ $sample_data->sample->item_name }}</td>
                        </tr>
                        {{-- <tr>
                            <th>Design Remarks</th>
                            <td>{{ $sample_data->sample->design_no }}</td>
                        </tr> --}}
                        <tr>
                            <th>Sample Name</th>
                            <td>{{ $sample_data->sample_name->name }}</td>
                        </tr>
                        <tr>
                            <th>Sample Type</th>
                            <td>{{ $sample_data->sample_type }}</td>
                        </tr>
                        <tr>
                            <th>Fabric Code</th>
                            <td>{{ $sample_data->fabric_code }}</td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <td>{{ $sample_data->color->name }}</td>
                        </tr>
                        <tr>
                            <th>Wash Unit</th>
                            <td>{{ $sample_data->washUnit->name }}</td>
                        </tr>
                        <tr>
                            <th>Size</th>
                            <td>{{ $sample_data->size }}</td>
                        </tr>
                        <tr>
                            <th>QTY</th>
                            <td>{{ $sample_data->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Wash Dec</th>
                            <td>{{ $sample_data->wash }}</td>
                        </tr>
                        <tr>
                            <th>Print/Emb</th>
                            <td>{{ $sample_data->print_emb }}</td>
                        </tr>
                        <tr>
                            <th>Support Fab</th>
                            <td>{{ $sample_data->support_fab }}</td>
                        </tr>
                        <tr>
                            <th>Thread</th>
                            <td>{{ $sample_data->thread }}</td>
                        </tr>
                        <tr>
                            <th>Trims & Acc</th>
                            <td>{{ $sample_data->trims_and_acc }}</td>
                        </tr>
                        <tr>
                            <th>Others-1</th>
                            <td>{{ $sample_data->other_one }}</td>
                        </tr>
                        <tr>
                            <th>Others-2</th>
                            <td>{{ $sample_data->other_two }}</td>
                        </tr>
                        <tr>
                            <th>Remarks</th>
                            <td>{{ $sample_data->remarks }}</td>
                        </tr>
                        
                        <tr>
                            <th>REQ sent</th>
                            @if (isset($sample_data->req_sent_date))
                                <td>{{ \Carbon\Carbon::parse($sample_data->req_sent_date)->format('d/m/Y h:i A') }}</td>
                            @else
                                <td>{{ $sample_data->req_sent_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Shrinkage Date</th>
                            @if (isset($sample_data->shrinkage_date))
                                <td>{{ \Carbon\Carbon::parse($sample_data->shrinkage_date)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $sample_data->shrinkage_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Shrinkage Time</th>
                            @if (isset($sample_data->shrinkage_time))
                                <td>{{ \Carbon\Carbon::parse($sample_data->shrinkage_time)->format('d/m/Y h:i A') }}</td>
                            @else
                                <td>{{ $sample_data->shrinkage_time }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Materials Date</th>
                            @if (isset($sample_data->materials_date))
                                <td>{{ \Carbon\Carbon::parse($sample_data->materials_date)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $sample_data->materials_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Materials Update Time</th>
                            @if (isset($sample_data->materials_time))
                                <td>{{ \Carbon\Carbon::parse($sample_data->materials_time)->format('d/m/Y h:i A') }}</td>
                            @else
                                <td>{{ $sample_data->materials_time }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Priority Date</th>
                            @if (isset($sample_data->priority_date))
                                <td>{{ \Carbon\Carbon::parse($sample_data->priority_date)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $sample_data->priority_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Priority Update Time</th>
                            @if (isset($sample_data->priority_time))
                                <td>{{ \Carbon\Carbon::parse($sample_data->priority_time)->format('d/m/Y h:i A') }}</td>
                            @else
                                <td>{{ $sample_data->priority_time }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>REQ accepted date</th>
                            @if (isset($sample_data->req_accept_date))
                                <td>{{ \Carbon\Carbon::parse($sample_data->req_accept_date)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $sample_data->req_accept_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Sewing date</th>
                            @if (isset($sample_data->sewing_date))
                                <td>{{ \Carbon\Carbon::parse($sample_data->sewing_date)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $sample_data->sewing_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Sent To Wash</th>
                            @if (isset($sample_data->sample_delivery_date))
                                <td>{{ \Carbon\Carbon::parse($sample_data->sample_delivery_date)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $sample_data->sample_delivery_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>To Finish</th>
                            @if (isset($sample_data->sent_finish))
                                <td>{{ \Carbon\Carbon::parse($sample_data->sent_finish)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $sample_data->sent_finish }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>To Merchant</th>
                            @if (isset($sample_data->merchant_receive))
                                <td>{{ \Carbon\Carbon::parse($sample_data->merchant_receive)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $sample_data->merchant_receive }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Received Sample</th>
                            @if (isset($sample_data->actual_delivery_date))
                                <td>{{ \Carbon\Carbon::parse($sample_data->actual_delivery_date)->format('d/m/Y') }}</td>
                            @else
                                <td>{{ $sample_data->actual_delivery_date }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Excel File</th>
                            @if (isset($sample_data->file))
                                <td> <a href="https://ibs-cdm.com/{{ $sample_data->file }}" download class="btn btn-danger btn-sm shadow-none">Download</a></td>
                            @else
                                <td>--</td>
                            @endif
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