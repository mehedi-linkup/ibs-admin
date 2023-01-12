@extends('layouts.master')
@section('title', 'Sample Data List')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
    <style>
        .sample {
            background: #78cbf1 !important;
        }
        .sample-data {
            background-color: #8bc34a !important;
        }
        .input-1 {
            background-color: #ff9800 !important;
        }
        .input-2 {
            background-color: #ffeb3b !important;
        }
        .input-3 {
            background-color: #c69fcd !important;
        }

        .pagination li {
            background: #000;
            padding: 2px 10px;
            border-right: 1px solid #fff;
            border-radius: 5px;
        }
        .pagination li.active {
            background: #0d6efd;
            padding: 2px 10px;
            border-right: 1px solid #fff;
            border-radius: 3px;
        }
        .pagination li a {
            color: #fff;
            text-decoration: none;  
        }
        .filter-box {
            width: 100px;
        }
        tr th {
            font-size: 13px;
            line-height: 20px;
        }
        tr td {
            font-size: 15px;
        }
    </style>
@endpush
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Sample Data List</span>
        </div>
        <div class="card">
            <form @@submit.prevent="getSampleData">
                <div class="form-group row">
                    <div class="col-md-1"><label for="inputSmv" class="col-form-label"><strong>Search Type :</strong></label></div>
                    <div class="col-sm-2">
                        <select class="form-control shadow-none" v-model="searchType" id="supplier">
                            <option value="">--select one--</option>
                            <option value="req_date">REQ accepted date</option>
                            <option value="sewing_date">Sewing date</option>
                            <option value="delivery_date">To Wash</option>
                            <option value="to_finish">To Finish</option>
                            <option value="to_merchant">To Merchant</option>
                            <option value="received_date">Received Sample</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i>All Sample Data List</div>
                <div class="float-end ms-auto mb-0">
                    <input type="text" class="form-control filter-box shadow-none" v-model="filter" placeholder="Search..">
                </div>
            </div>
            <div class="card-body table-card-body">
                <div class="table-responsive">
                    <div class="success col-md-4" v-if="show">
                        <div class="alert alert-success">@{{ success }}</div>
                    </div>
                    @isset(Auth::user()->role->permission['permission']['sample_data']['list'])
                    
                    <tbody class="text-center" id="ProductData">
                        <datatable :columns="columns" :data="sampleDatas" :filter-by="filter">
                            <template scope="{ row }">
                                <tr class="text-center">
                                    <td>@{{ row.id }}*@{{ row.sample.id }}</td>
                                    <td>@{{ row.user.name }}</td>
                                    <td>@{{ row.sample.gm.name }}</td>
                                    <td>@{{ row.sample.buyer.name }}</td>
                                    <td>@{{ row.sample.coordinator.name }}</td>
                                    <td>@{{ row.sample.wash_coordinator.name }}</td>
                                    <td>@{{ row.sample.finishing_coordinator.name }}</td>
                                    <td>@{{ row.sample.cad.name }}</td>
                                    <td>@{{ row.sample.cad_done_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.sample.style_no }}</td>
                                    <td>@{{ row.sample.item_name }}</td>
                                    {{-- <td>@{{ row.sample.design_no}}</td> --}}
                                    {{-- <td>@{{ row.sample.coordinator.name }}</td> --}}
                                    <td>@{{ row.sample_name.name }}</td>
                                    <td>@{{ row.sample_type }}</td>
                                    <td>@{{ row.fabric_code }}</td>
                                    <td>@{{ row.color.name }}</td>
                                    <td>@{{ row.wash_unit.name }}</td>
                                    {{-- <td>@{{ row.size }}</td> --}}
                                    <td>@{{ row.quantity }}</td>
                                    <td>@{{ row.req_sent_date | formatDateTime('DD/MM/YYYY h:mm a')}}</td>
                                    <td>@{{ row.shrinkage_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.materials_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    {{-- <td v-if="row.file != null">
                                        <a :href="row.file" download class="btn btn-danger btn-sm shadow-none">Download</a>
                                    </td>
                                    <td v-else> -- </td> --}}
                                    <td>@{{ row.priority_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.priority_time | formatDateTime('DD/MM/YYYY h:mm a') }}</td>
                                    <td>@{{ row.req_accept_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.sewing_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.sample_delivery_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.sent_finish | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.merchant_receive | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.actual_delivery_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    
                                    <td v-if="row.status == 'a'">
                                        <a :href="`sample/view/${row.id}`" class="btn btn-view shadow-none"><i class="fa fa-eye"></i></a>
                                        @isset(Auth::user()->role->permission['permission']['sample_data']['edit'])
                                            @if (Auth::user()->id == 1)
                                                <button data-bs-toggle="modal" data-bs-target="#SampleDataEntry" class="btn btn-edit shadow-none" @@click.prevent="EditSampleData(row)"><i class="fas fa-pencil-alt"></i></button>
                                            @else
                                                <button data-bs-toggle="modal" :style="{display: row.req_accept_date == null || row.sewing_date == null ? '' : 'none' }" data-bs-target="#SampleDataEntry" class="btn btn-edit shadow-none" @@click.prevent="EditSampleData(row)"><i class="fas fa-pencil-alt"></i></button>
                                            @endif
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['input-1'])
                                        <button data-bs-toggle="modal"  data-bs-target="#SampleDataUpdate" class="btn btn-input-1 shadow-none" @@click.prevent="EditReqAcceptDate(row)">input-1</button>
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['input-2'])
                                        <button data-bs-toggle="modal" data-bs-target="#SampleDataDeliUpdate" class="btn btn-input-2 shadow-none" @@click.prevent="EditSampleData(row)">input-2</button>
                                        @endisset
                                        
                                        @isset(Auth::user()->role->permission['permission']['sample_data']['input-3'])
                                        <button data-bs-toggle="modal" data-bs-target="#SampleDataFinalUpdate" class="btn btn-input-3 shadow-none" @@click.prevent="EditSampleData(row)">input-3</button>
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['input-4'])
                                        <button data-bs-toggle="modal" data-bs-target="#SentToFinish" class="btn btn-input-4 shadow-none" @@click.prevent="EditSampleData(row)">input-4</button>
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['input-5'])
                                        <button data-bs-toggle="modal" data-bs-target="#SentToMerchant" class="btn btn-input-5 shadow-none" @@click.prevent="EditSampleData(row)">input-5</button>
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['input-6'])
                                        <button data-bs-toggle="modal" data-bs-target="#Shrinkage" class="btn btn-input-6 shadow-none" @@click.prevent="EditShrinkageDate(row)">input-6</button>
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['input-7'])
                                        <button data-bs-toggle="modal" data-bs-target="#Materials" class="btn btn-input-7 shadow-none" @@click.prevent="EditMaterialsDate(row)">input-7</button>
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['input-8'])
                                        <button data-bs-toggle="modal" data-bs-target="#Priority" class="btn btn-input-8 shadow-none" @@click.prevent="EditPriorityDate(row)">input-8</button>
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['delete'])
                                        <button class="btn btn-delete" @@click.prevent="deleteSampleData(row.id)"><i class="fa fa-trash"></i></button>
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['sample_insert'])
                                        <button class="btn btn-edit" @@click.prevent="insertSampleData(row.id)">insert</button>
                                        @endisset
                                        @if (Auth::user()->id == 1)
                                            <button v-if="row.active == 1" class="btn btn-active shadow-none" @@click.prevent="inactiveSampleData(row.id)">Active</button>
                                            {{-- <button v-if="row.active == 0" class="btn btn-delete" @@click.prevent="activeSampleData(row.id)">Inactive</button> --}}
                                            <button v-if="row.req_accept_date == null" class="btn btn-delete" @@click.prevent="cancelSampleData(row.id)">cancel</button>
                                        @endif
                                    </td>
                                    <td v-else>
                                    </td>
                                </tr>
                            </template>
                        </datatable>
                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
                    </tbody>
                    @endisset
                </div>
            </div>
        </div>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="SampleDataEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SampleDataEntryLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form  @submit.prevent="updateSampleData">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Edit Sample Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label for="inputSmv" class="col-form-label">Sample Name</label>
                                    <select class="w-100 selectpicker shadow-none" v-model="sampleData.sample_name_id" id="supplier" required>
                                        <option value="">--select one--</option>
                                        <option v-for="item in sampleNames" :value="item.id">@{{ item.name }}</option>
                                    </select>
                                </div>
    
                                <div class="col-sm-2">
                                    <label for="inputSmv" class="col-form-label">Sample Type</label>
                                    <select v-model="sampleData.sample_type" class="form-control form-control-sm shadow-none" id="inputSmv" required>
                                        <option value="">--select one--</option>
                                        <option value="DVS">DVS</option>
                                        <option value="COS">COS</option>
                                        <option value="PFHS">PFHS</option>
                                    </select>
                                </div>
    
                                <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label">Fabric Code</label>
                                    <input type="text" v-model="sampleData.fabric_code" class="form-control form-control-sm shadow-none" id="inputEff" required>
                                </div>
    
                                <div class="col-sm-2">
                                    <label for="supplier" class="col-form-label">Color</label>
                                    <select class="w-100 selectpicker shadow-none" v-model="sampleData.color_id" id="supplier" required>
                                        <option value="">--select one--</option>
                                        <option v-for="color in colors" :value="color.id">@{{ color.name }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 px-0">
                                    <label for="size" class="col-form-label">Size</label>
                                    <input type="text" v-model="sampleData.size" class="form-control form-control-sm shadow-none" id="size" required>
                                </div>
                                <div class="col-sm-1 pe-0">
                                    <label for="qty" class="col-form-label">Quantity</label>
                                    <input type="text" v-model="sampleData.quantity" class="form-control form-control-sm shadow-none" id="qty" required>
                                </div>
                                <div class="col-sm-2">
                                    <label for="req" class="col-form-label">Wash Unit</label>
                                    <select class="form-control shadow-none" v-model="sampleData.wash_unit_id">
                                        <option value="">--select one--</option>
                                        <option v-for="unit in washUnits" :value="unit.id">@{{ unit.name }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-2" style="display: none;">
                                    <label for="req" class="col-form-label">REQ Date</label>
                                    <input type="datetime-local" v-model="sampleData.req_sent_date" class="form-control form-control-sm shadow-none" required readonly>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Wash</label>
                                    <textarea v-model="sampleData.wash" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Print/Emb</label>
                                    <textarea v-model="sampleData.print_emb" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Support Fab</label>
                                    <textarea v-model="sampleData.support_fab" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Thread</label>
                                    <textarea v-model="sampleData.thread" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Trims & Acc</label>
                                    <textarea v-model="sampleData.trims_and_acc" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Others-1</label>
                                    <textarea v-model="sampleData.other_one" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Others-2</label>
                                    <textarea v-model="sampleData.other_two" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Remarks</label>
                                    <textarea v-model="sampleData.remarks" class="form-control form-control-sm shadow-none" id="remark" required cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-2">
                                    <label for="file" class="col-form-label">Excel File</label>
                                    <input type="file"  class="form-control form-control-sm shadow-none" id="file" @@change="onChangeFile()">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p>(Pocketing// Waist Contrast//Top Thread// BBN Thread// Overlock Thread// BARTACK Thread// Lining Thread// Zipper// Contrast// Padding// Lining// Binding//Sherpa// Quilting// Interlining// Interlining// Main Label// Size Label// Care Label// Button// Buckle// Rivet// Adjust Elastic// Plain Elastic// Twill Tape// Lather patch)</p>
                        <button type="button" @@click="reset" class="btn btn-dark btn-sm shadow-none">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm shadow-none">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Samole data  -->
    <div class="modal fade" id="SampleDataUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SampleDataUpdateLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="updateSampleData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Sample Data Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="reqdate" class="col-form-label pt-0">Req accepted date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sampleData.req_accept_date" class="form-control form-control-sm" id="reqdate">
                                    @else
                                        <input type="date" v-model="sampleData.req_accept_date" class="form-control form-control-sm" id="reqdate" :readonly="sampleData.req_accept_date != null ">
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="Sewing" class="col-form-label pt-0">Sewing Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sampleData.sewing_date" class="form-control form-control-sm" id="Sewing" required>
                                    @else
                                        <input type="date" v-model="sampleData.sewing_date" class="form-control form-control-sm" id="Sewing" :readonly="sampleData.sewing_date != null" required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (Auth::user()->id == 1)
                            <button type="button" @@click="ReqReset" class="btn btn-dark btn-sm">Reset</button>
                        @else
                            <button :disabled="sampleData.sewing_date != null" type="button" @@click="ReqReset" class="btn btn-dark btn-sm">Reset</button>
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Samole data  -->
    <div class="modal fade" id="SampleDataDeliUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SampleDataDeliUpdateLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="updateSampleData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Sent To Wash</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="inputEff" class="col-form-label pt-0 col-sm-3">Delivered Date</label>
                                <div class="col-sm-9">
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sampleData.sample_delivery_date" class="form-control form-control-sm" id="inputEff" required>
                                    @else
                                        <input type="date" v-model="sampleData.sample_delivery_date" class="form-control form-control-sm" id="inputEff" :readonly="sampleData.sample_delivery_date != null" required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Samole data  -->
    <div class="modal fade" id="SampleDataFinalUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SampleDataFinalUpdateLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="updateSampleData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Receive Sample Date</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="inputEff" class="col-form-label pt-0 col-sm-3">Receive Sample</label>
                                <div class="col-sm-9">
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sampleData.actual_delivery_date" class="form-control form-control-sm" id="inputEff" required>
                                    @else
                                        <input type="date" v-model="sampleData.actual_delivery_date" class="form-control form-control-sm" id="inputEff" :readonly="sampleData.actual_delivery_date != null" required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Sent to Finish  -->
    <div class="modal fade" id="SentToFinish" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SentToFinishLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="updateSampleData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Sent To Finish</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="inputEff" class="col-form-label pt-0 col-sm-3">To Finish</label>
                                <div class="col-sm-9">
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sampleData.sent_finish" class="form-control form-control-sm" id="inputEff" required>
                                    @else
                                        <input type="date" v-model="sampleData.sent_finish" class="form-control form-control-sm" id="inputEff" :readonly="sampleData.sent_finish != null" required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Merchant  -->
    <div class="modal fade" id="SentToMerchant" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SentToMerchantLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="updateSampleData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Sent To Merchant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label for="inputEff" class="col-form-label pt-0 col-sm-3">To Merchant</label>
                                <div class="col-sm-9">
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sampleData.merchant_receive" class="form-control form-control-sm" id="inputEff" required>
                                    @else
                                        <input type="date" v-model="sampleData.merchant_receive" class="form-control form-control-sm" id="inputEff" :readonly="sampleData.merchant_receive != null" required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Shrinkage data  -->
    <div class="modal fade" id="Shrinkage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ShrinkageLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="updateSampleData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Shrinkage Date Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="doneTime" class="col-form-label pt-0">Shrinkage Time</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="sampleData.shrinkage_time" class="form-control form-control-sm shadow-none" id="doneTime" >
                                    @else
                                        <input type="datetime-local" v-model="sampleData.shrinkage_time" class="form-control form-control-sm shadow-none" id="doneTime" required readonly>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="doneDate" class="col-form-label pt-0">Shrinkage Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sampleData.shrinkage_date" class="form-control form-control-sm" id="doneDate" required>
                                    @else
                                        <input type="date" v-model="sampleData.shrinkage_date" class="form-control form-control-sm" id="doneDate" :readonly="sampleData.shrinkage_date != null " required>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (Auth::user()->id == 1)
                            <button type="button" @@click="ShirkageReset" class="btn btn-dark btn-sm">Reset</button>
                        @else
                            <button :disabled="sampleData.shrinkage_date != null" type="button" @@click="ShirkageReset" class="btn btn-dark btn-sm">Reset</button>
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Materials data  -->
    <div class="modal fade" id="Materials" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="MaterialsLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="updateSampleData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Materials Date Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="doneTime" class="col-form-label pt-0">Materials Time</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="sampleData.materials_time" class="form-control form-control-sm shadow-none" id="doneTime" >
                                    @else
                                        <input type="datetime-local" v-model="sampleData.materials_time" class="form-control form-control-sm shadow-none" id="doneTime" required readonly>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="doneDate" class="col-form-label pt-0">Materials Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sampleData.materials_date" class="form-control form-control-sm" id="doneDate" required>
                                    @else
                                        <input type="date" v-model="sampleData.materials_date" class="form-control form-control-sm" id="doneDate" :readonly="sampleData.materials_date != null " required>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (Auth::user()->id == 1)
                            <button type="button" @@click="MaterialsReset" class="btn btn-dark btn-sm">Reset</button>
                        @else
                            <button :disabled="sampleData.materials_date != null" type="button" @@click="MaterialsReset" class="btn btn-dark btn-sm">Reset</button>
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

     <!-- Modal for Priority data  -->
     <div class="modal fade" id="Priority" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="PriorityLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="updateSampleData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Priority Date Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="priorTime" class="col-form-label pt-0">Priority Time</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="sampleData.priority_time" class="form-control form-control-sm shadow-none" id="priorTime" >
                                    @else
                                        <input type="datetime-local" v-model="sampleData.priority_time" class="form-control form-control-sm shadow-none" id="priorTime" readonly>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="priorDate" class="col-form-label pt-0">Priority Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sampleData.priority_date" class="form-control form-control-sm" id="priorityDate">
                                    @else
                                        <input type="date" v-model="sampleData.priority_date" class="form-control form-control-sm" id="priorityDate" :readonly="sampleData.priority_date != null ">
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (@Auth::user()->role->id == 1 || @Auth::user()->role->permission['permission']['sample_data']['reset'])
                            @if(Auth::user()->role->id != 1) 
                            <button type="button" v-if="!sampleData.req_accept_date" @@click="PriorityReset" class="btn btn-dark btn-sm">Reset</button>
                            @else
                            <button type="button" @@click="PriorityReset" class="btn btn-dark btn-sm">Reset</button>
                            @endif
                        @endif
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
@push('js')
<script src="{{ asset('js/vuejs-datatable.js')}}"></script>
<script>
    Vue.component('v-select', VueSelect.VueSelect);
    const app = new Vue({
        el: "#root",
        data: {
            sampleData: {
                id: null,
                sample_name_id: '',
                sample_type: '',
                fabric_code: '',
                color_id: '',
                wash_unit_id: '',
                size: '',
                quantity: 0,
                req_sent_date: '',
                req_accept_date: '',
                sewing_date: '',
                sample_delivery_date: '',
                sent_finish: '',
                merchant_receive: '',
                actual_delivery_date: '',
                shrinkage_time: '',
                shrinkage_date: '',
                materials_time: '',
                materials_date: '',
                priority_date: '',
                priority_time: '',
                wash: '',
                print_emb: '',
                support_fab: '',
                thread: '',
                trims_and_acc: '',
                other_one: '',
                other_two: '',
                remarks: '',
            },
            onProcess:false,
            errors: [],
            show: false,
            success: '',
            sampleDatas : [],
            colors: [],
            washUnits: [],
            washUnit: null,
            sampleNames: [],
            selectedSampleName: null,
            selectedColor: null,
            sampleDataId: null,
            selectedFile: null,
            curUser: "<?php echo Auth::user()->id ?>",
            searchType: '',

            columns: [
                { label: 'SSL*PDSL', field: 'id', align: 'center', filterable: false },
                { label: 'From', field: 'user.name', align: 'center' },
                { label: 'GM', field: 'sample.gm.name', align: 'center' },
                { label: 'Buyer', field: 'sample.buyer.name', align: 'center' },
                { label: 'Sample Cor', field: 'sample.coordinator.name', align: 'center' },
                { label: 'Wash Cor', field: 'sample.wash_coordinator.name', align: 'center' },
                { label: 'Finishing Cor', field: 'sample.finishing_coordinator.name', align: 'center' },
                { label: 'CAD Deg', field: 'sample.cad.name', align: 'center' },
                { label: 'CAD Done', field: 'sample.cad_done_date', align: 'center' },
                { label: 'Style No', field: 'sample.style_no', align: 'center' },
                { label: 'Item Name', field: 'sample.item_name', align: 'center' },
                // { label: 'Design No', field: 'sample.design_no', align: 'center' },
                // { label: 'Coordinator', field: 'sample.coordinator.name', align: 'center' },
                { label: 'Sample Name', field: 'sample_name.name', align: 'center' },
                { label: 'Sample Type', field: 'sample_type', align: 'center' },
                { label: 'Fabric Code', field: 'fabric_code', align: 'center' },
                { label: 'Color', field: 'color.name', align: 'center' },
                { label: 'Wash Unit', field: 'wash_unit.name', align: 'center' },
                // { label: 'Size', field: 'size', align: 'center' },
                { label: 'QTY', field: 'quantity', align: 'center' },
                { label: 'REQ sent', field: 'req_sent_date', align: 'center' },
                { label: 'Shrinkage Date', field: 'shrinkage_date', align: 'center' },
                { label: 'Materials Date', field: 'materials_date', align: 'center' },
                { label: 'Prior Date', field: 'priority_date', align: 'center' },
                { label: 'Prior Date & Time', field: 'priority_time', align: 'center' },
                { label: 'REQ accepted date', field: 'req_accept_date', align: 'center' },
                { label: 'Sewing date', field: 'sewing_date', align: 'center' },
                { label: 'Sent To Wash', field: 'sample_delivery_date', align: 'center' },
                { label: 'To Finish', field: 'sent_finish', align: 'center' },
                { label: 'To Merchant', field: 'merchant_receive', align: 'center' },
                { label: 'Received Sample', field: 'actual_delivery_date', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 100,
            filter: ''
        },

        created() {
            this.getSampleData();
            this.getColors();
            this.getWashUnits();
            this.getSampleNames();
        },
        filters: {
            formatDateTime(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },
        methods: {
            onChangeFile() {
                if(event.target.files == undefined || event.target.files.length < 1) {
                    this.selectedFile = null;
                    return;
                }
                this.selectedFile = event.target.files[0];
            },
            getSampleData() {
                axios.post('/get_blank_data', {searchType: this.searchType})
                .then(res => {
                    // this.sampleDatas
                    let Data = res.data.map((item, sl) => {
                        item.sl = sl + 1
                        return item;
                        this.show = false;
                    });

                  
                    this.sampleDatas = Data.filter((item, sl) => {
                        if(item.merchant_receive == null || item.sample_delivery_date == null || item.sent_finish == null) {
                            return item;
                        }
                    });
                })
            },

            getColors() {
                axios.post('get_color').then(res => {
                    this.colors = res.data;
                })
            },

            getWashUnits()
            {
                axios.post('/get_wash_unit').then(res => {
                    this.washUnits = res.data;
                })
            },

            getSampleNames() {
                axios.post('/get_sample_name').then(res => {
                    this.sampleNames = res.data;
                })
            },

            EditSampleData(sampleData) {
                Object.keys(this.sampleData).forEach(item => {
                    this.sampleData[item] = sampleData[item]
                })
               
                this.selectedColor = {
                    id: sampleData.color_id,
                    name: sampleData.color.name
                }
            },

            EditReqAcceptDate(sampleData) {
                Object.keys(this.sampleData).forEach(item => {
                    this.sampleData[item] = sampleData[item]
                })
                sampleData.req_accept_date != null ? sampleData.req_accept_date : this.sampleData.req_accept_date = moment().format("YYYY-MM-DD");
            },

            EditShrinkageDate(sampleData) {
                Object.keys(this.sampleData).forEach(item => {
                    this.sampleData[item] = sampleData[item]
                })
                sampleData.shrinkage_time != null ? sampleData.shrinkage_time : this.sampleData.shrinkage_time = moment().format("YYYY-MM-DD HH:mm");
            },

            EditMaterialsDate(sampleData) {
                Object.keys(this.sampleData).forEach(item => {
                    this.sampleData[item] = sampleData[item]
                })
                sampleData.materials_time != null ? sampleData.materials_time : this.sampleData.materials_time = moment().format("YYYY-MM-DD HH:mm");
            },
            EditPriorityDate(sampleData) {
                Object.keys(this.sampleData).forEach(item => {
                    this.sampleData[item] = sampleData[item]
                })
                sampleData.priority_time != null ? sampleData.priority_time : this.sampleData.priority_time = moment().format("YYYY-MM-DD HH:mm");
            },
            updateSampleData() {
                this.errors = [];

                if(this.errors.length) {
                    setTimeout( () => {
                        this.errors = [];
                    }, 3000);
                    return;
                }
                this.onProcess = true;

                let formData = new FormData();
                formData.append('sample', JSON.stringify(this.sampleData));
				if (this.selectedFile) formData.append('file', this.selectedFile);
                // Display the key/value pairs
                // for (var pair of formData.entries()) {
                //     console.log(pair[0]+ ', ' + pair[1]); 
                // }
                axios.post('/update_sample_data' , formData)
                .then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    $('#SampleDataEntry').modal('hide');
                    $('#SampleDataUpdate').modal('hide');
                    $('#SampleDataFinalUpdate').modal('hide');
                    $('#SampleDataDeliUpdate').modal('hide');
                    $('#SentToFinish').modal('hide');
                    $('#SentToMerchant').modal('hide');
                    $('#Shrinkage').modal('hide');
                    $('#Materials').modal('hide');
                    $('#Priority').modal('hide');
                    this.onProcess = false;
                    setTimeout(() => {
                        this.success = '';
                        this.resetForm();
                        this.getSampleData();
                        this.show = false;
                    }, 3000)
                })
                .catch(err => {
                    console.log(err.response.data.message)
                })
            },

            deleteSampleData(id) {
                if (confirm('Are You Sure? You Want to Delete this?')) {
                    axios.post('/delete_sample_data', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getSampleData();
                    })
                }
            },

            insertSampleData(id) {
                if (confirm('Are You Sure? You Want to Insert this?')) {
                    axios.post('/insert_sample_data', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getSampleData();
                    })
                }
            },

            cancelSampleData(id) {
                if (confirm('Are You Sure? You Want to Cancel this?')) {
                    axios.post('/cancel_sample_data', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getSampleData();
                    })
                }
            },

            activeSampleData(id) {
                if (confirm('Are You Sure? You Want to Active this?')) {
                    axios.post('/active_sample_data', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getSampleData();
                    })
                }
            },

            inactiveSampleData(id) {
                if (confirm('Are You Sure? You Want to Inactive this?')) {
                    axios.post('/inactive_sample_data', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getSampleData();
                    })
                }
            },

            CopySampleData() {

            },
            resetForm() {
                this.sampleData = {
                    id: null,
                    sample_name_id: '',
                    sample_type: '',
                    fabric_code: '',
                    color_id: '',
                    wash_unit_id: '',
                    size: '',
                    quantity: 0,
                    req_sent_date: '',
                    req_accept_date: moment().format("YYYY-MM-DD HH:mm:ss"),
                    sewing_date: '',
                    sample_delivery_date: '',
                    sent_finish: '',
                    merchant_receive: '',
                    actual_delivery_date: '',
                    shrinkage_time: moment().format("YYYY-MM-DD HH:mm"),
                    shrinkage_date: '',
                    materials_time: moment().format("YYYY-MM-DD HH:mm"),
                    materials_date: '',
                    priority_time: moment().format("YYYY-MM-DD HH:mm"),
                    priority_date: '',
                    file: null,
                    wash: '',
                    print_emb: '',
                    support_fab: '',
                    thread: '',
                    trims_and_acc: '',
                    other_one: '',
                    other_two: '',
                    remarks: '',
                }
            },
            reset() {
                this.sampleData = {
                    id: null,
                    sample_name_id: '',
                    sample_type: '',
                    fabric_code: '',
                    color_id: '',
                    wash_unit_id: '',
                    size: '',
                    quantity: 0,
                    req_sent_date: moment().format("YYYY-MM-DD HH:mm:ss"),
                    file: null,
                    wash: '',
                    print_emb: '',
                    support_fab: '',
                    thread: '',
                    trims_and_acc: '',
                    other_one: '',
                    other_two: '',
                    remarks: '',
                }
            },
            ReqReset() {
                this.sampleData.sewing_date = null;
            },
            ShirkageReset() {
                this.sampleData.shrinkage_date = null;
            },
            MaterialsReset() {
                this.sampleData.materials_date = null;
            },
            PriorityReset() {
                this.sampleData.priority_date = null;
                this.sampleData.priority_time = null;
            }
        }
    });
</script>
@endpush