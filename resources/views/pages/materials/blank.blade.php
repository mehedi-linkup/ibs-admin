@extends('layouts.master')
@section('title', 'Materials List')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
    <style>
        .pagination li{
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
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{ route('home') }}">Home</a> > Sample List</span>
        </div>
        <div class="card">
            <form @@submit.prevent="getMaterials">
                <div class="form-group row">
                    <div class="col-md-1"><label for="inputSmv" class="col-form-label"><strong>Search Type :</strong></label></div>
                    <div class="col-sm-2">
                        <select class="form-control shadow-none" v-model="searchType" id="supplier">
                            <option value="">--select one--</option>
                            <option value="fabric_sent">Fabric Sent</option>
                            <option value="receive_date">Received Date</option>
                            <option value="shrinkage_sent">Sent to Shrinkage</option>
                            <option value="shrinkage_receive">Shrinkage Receive</option>
                            <option value="fabric_type">Wash/Non Wash</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-sm shadow-none">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i>All Materials List</div>
    
                <div class="float-end ms-auto mb-0 pe-2">
                    <input type="text" class="form-control filter-box shadow-none" v-model="filter" placeholder="Search..">
                </div>
                <div>
                    {{-- @if(Auth::user()->username == 'SuperAdmin')
                    <a href="{{ route('sample-file-export') }}" class="btn btn-primary btn-sm shadow-none">Excel Sheet</a> 
                    @endif --}}
                    {{-- @isset(Auth::user()->role->permission['permission']['meterials_data']['add'])
                        <button type="button" class="btn btn-addnew shadow-none" data-bs-toggle="modal" data-bs-target="#MaterialsEntry"> <i class="fa fa-plus"></i> add new</button>
                    @endisset --}}
                </div>
            </div>
            <div class="card-body table-card-body">
                <div class="success col-md-4" v-if="show">
                    <div class="alert alert-success">@{{ success }}</div>
                </div>
                
                @isset(Auth::user()->role->permission['permission']['meterials_data']['list'])
                <tbody class="text-center" id="ProductData">
                    <datatable :columns="columns" :data="materials" :filter-by="filter">
                        <template scope="{ row }">
                            <tr class="text-center">
                                <td>@{{ row.id }}</td>
                                <td>@{{ row.merchant.name }}</td>
                                <td>@{{ row.gm.name }}</td>
                                <td>@{{ row.coordinator.name }}</td>
                                <td>@{{ row.wash_coordinator.name }}</td>
                                <td>@{{ row.wash_unit.name }}</td>
                                <td>@{{ row.cad.name }}</td>
                                <td>@{{ row.buyer.name }}</td>
                                <td>@{{ row.supplier.name }}</td>
                                <td>@{{ row.fabric_ref }}</td>
                                <td>@{{ row.cw }}</td>
                                <td>@{{ row.fabric_sent | formatDateTime('DD/MM/YYYY') }}</td>
                                <td>@{{ row.quantity }}</td>
                                <td>@{{ row.fabric_type }}</td>
                                <td>@{{ row.receive_date | formatDateTime('DD/MM/YYYY') }}</td>
                                <td>@{{ row.receive_qty }}</td>
                                <td>@{{ row.shrinkage_sent | formatDateTime('DD/MM/YYYY') }}</td>
                                <td>@{{ row.shrinkage_receive | formatDateTime('DD/MM/YYYY') }}</td>
                                <td>@{{ row.used_materials_sum_use_qty }}</td>
                                <td>@{{ row.receive_qty - row.used_materials_sum_use_qty }}</td>
                                <td>@{{ row.sent_store | formatDateTime('DD/MM/YYYY') }}</td>
                                <td>@{{ row.store_qty }}</td>
                                <td>
                                    <span>@{{ row.reset_date | formatDateTime('DD/MM/YYYY') }}</span>
                                   
                                </td>
                                <td>
                                    <a :href="`/materials/view/${row.id}`" class="btn btn-view shadow-none"><i class="fa fa-eye"></i></a>
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['edit'])
                                        <button data-bs-toggle="modal" data-bs-target="#MaterialsEntry" class="btn btn-edit shadow-none" @@click.prevent="EditMaterial(row)"><i class="fas fa-pencil-alt"></i></button>
                                    @endisset
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['input-1'])
                                        <button data-bs-toggle="modal" data-bs-target="#InputOne" class="btn btn-input-one shadow-none" @@click.prevent="AwSent(row)">input-1</button>
                                    @endisset
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['input-2'])
                                        <button data-bs-toggle="modal" data-bs-target="#InputTwo" class="btn btn-input-two shadow-none" @@click.prevent="FebricSent(row)">input-2</button>
                                    @endisset
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['input-3'])
                                        <button data-bs-toggle="modal" data-bs-target="#InputThree" class="btn btn-input-three shadow-none" @@click.prevent="EditReceive(row)">input-3</button>
                                    @endisset
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['input-4'])
                                        <button data-bs-toggle="modal" data-bs-target="#InputFour" class="btn btn-input-four shadow-none" @@click.prevent="ShrinkageSent(row)">input-4</button>
                                    @endisset
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['input-5'])
                                        <button data-bs-toggle="modal" data-bs-target="#InputFive" class="btn btn-input-five shadow-none" @@click.prevent="EditSection(row)">input-5</button>
                                    @endisset
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['input-6'])
                                        <button data-bs-toggle="modal" data-bs-target="#InputSix" class="btn btn-input-six shadow-none" @@click.prevent="ShrinkageReceive(row)">input-6</button>
                                    @endisset
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['input-7'])
                                        <button data-bs-toggle="modal" data-bs-target="#InputSeven" class="btn btn-input-seven shadow-none" @@click.prevent="UseQuantity(row.id)">input-7</button>
                                    @endisset
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['input-8'])
                                        <button data-bs-toggle="modal" data-bs-target="#InputEight" class="btn btn-input-eight shadow-none" @@click.prevent="SendToStore(row)">input-8</button>
                                    @endisset
                                    
                                    <button data-bs-toggle="modal" data-bs-target="#ViewUsed" style="display: none;" :style="{ display: row.used_materials_sum_use_qty > 0 ? '' :  'none' }" class="btn btn-edit shadow-none" @@click.prevent="ViewUsedQty(row.id)" >Used</button>
                                    
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['reset'])
                                        <button v-if="row.sent_store != null" class="btn btn-delete shadow-none" @@click.prevent="ResetData(row.id)">Reset</button>
                                    @endisset
                                    @isset(Auth::user()->role->permission['permission']['meterials_data']['delete'])
                                        <button class="btn btn-delete shadow-none" @@click.prevent="deleteMaterial(row.id)"><i class="fa fa-trash"></i></button>
                                    @endisset

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

    <!-- Modal -->
    <div class="modal fade" id="MaterialsEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="MaterialsEntryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form  @submit.prevent="saveMaterials">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Add New Sample</h5>
                        <button type="button" @@click="resetMaterials" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group row">
                            {{-- <input type="hidden" name="id" id="InputId"> --}}
                            @if (Auth::user()->id == 1)
                            <label for="inputGm" class="col-sm-4">Merchant</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="merchants" v-model="selectedMerchant"  label="name" class="w-100" placeholder="--select one--" :disabled="curUser != '' && curUser !=null"></v-select>
                            </div>
                            @else
                            <label for="inputGm" class="col-sm-4"></label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="merchants" v-model="selectedMerchant" hidden label="name" class="w-100" placeholder="--select one--" :disabled="curUser != '' && curUser !=null"></v-select>
                            </div>
                            @endif
                           
                            <label for="inputGm" class="col-sm-4">GM</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="gms" v-model="selectedGm" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBase" class="col-sm-4">Sample Cor</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="coordinators" v-model="selectedCoordinator" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBase" class="col-sm-4">Wash Cor</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="washCoordinators" v-model="washCoordinator" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBase" class="col-sm-4">Wash Unit</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="washUnits" v-model="washUnit" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBase" class="col-sm-4">CAD Cor</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="cads" v-model="selectedCad" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBuyer" class="col-sm-4">Buyer</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="buyers" v-model="selectedBuyer" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBuyer" class="col-sm-4">Supplier</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="suppliers" v-model="selectedSupplier" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="favref" class="col-sm-4">Fabric reference</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="material.fabric_ref" class="form-control form-control-sm shadow-none" id="favref" required>
                            </div>

                            <label for="Remaks-1" class="col-sm-4">Composition</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="material.composition" class="form-control form-control-sm shadow-none" id="inputDesign" required>
                            </div>

                            <label for="inputDesign" class="col-sm-4">Remarks-1</label>
                            <div class="col-sm-8">
                                <textarea v-model="material.remarks1" class="form-control form-control-sm shadow-none" id="Remaks-1" required cols="2" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @@click="resetMaterials" class="btn btn-dark btn-sm shadow-none">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm shadow-none" v-if="material.id == null" :disabled="onProcess ? true : false">Save</button>
                        <button type="submit" class="btn btn-primary btn-sm shadow-none" v-else :disabled="onProcess ? true : false">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Input-1  -->
    <div class="modal fade" id="InputOne" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="InputOneLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveMaterials">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Insert Page</h5>
                        <button type="button" @@click="resetMaterials" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="cw" class="col-form-label pt-0">CW</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="text" v-model="material.cw" class="form-control form-control-sm shadow-none" id="cw" required>
                                    @else
                                        <input type="text" v-model="material.cw" class="form-control form-control-sm shadow-none" id="cw" :readonly="material.in_one_status == 'a'"  required>
                                 
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="bw" class="col-form-label pt-0">BW</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="text" v-model="material.bw" class="form-control form-control-sm shadow-none" id="bw" required>
                                    @else
                                        <input type="text" v-model="material.bw" class="form-control form-control-sm shadow-none" id="bw" :readonly="material.in_one_status == 'a'"  required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="aw" class="col-form-label pt-0">AW</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="text" v-model="material.aw" class="form-control form-control-sm shadow-none" id="aw"  required>
                                    @else
                                        <input type="text" v-model="material.aw" class="form-control form-control-sm shadow-none" id="aw" :readonly="material.in_one_status == 'a'" required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @@click="inputoneReset" class="btn btn-dark btn-sm" :disabled="loginUser != 1 && material.in_one_status == 'a'">Reset</button>

                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                       
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Input-2  -->
    <div class="modal fade" id="InputTwo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="InputTwoLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveMaterials">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Insert Page</h5>
                        <button type="button" @@click="resetMaterials" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="fabric_sent" class="col-form-label pt-0">Fabric sent</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="material.fabric_sent" class="form-control form-control-sm shadow-none" id="fabric_sent" required>
                                    @else
                                        <input type="date" v-model="material.fabric_sent" class="form-control form-control-sm shadow-none" id="fabric_sent" :readonly="material.in_two_status == 'a'" required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="time" class="col-form-label pt-0">Time</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="time" v-model="material.time" class="form-control form-control-sm shadow-none" id="time" required>
                                    @else
                                        <input type="time" v-model="material.time" class="form-control form-control-sm shadow-none" id="time" :readonly="material.in_two_status == 'a'" required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="update_time" class="col-form-label pt-0">Update Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="material.update_time" class="form-control form-control-sm shadow-none" id="update_time" required>
                                    @else
                                        <input type="datetime-local" v-model="material.update_time" class="form-control form-control-sm shadow-none" id="update_time" readonly required>
                                    @endif
                                </div>
                       
                                <div class="col-sm-6">
                                    <label for="quantity" class="col-form-label pt-0">Quantity</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="number" min="1"   v-model="material.quantity" class="form-control form-control-sm shadow-none" id="quantity" required>
                                    @else
                                        <input type="number" min="1"  v-model="material.quantity" class="form-control form-control-sm shadow-none" id="quantity" :readonly="material.in_two_status == 'a'" required>

                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="type" class="col-form-label pt-0">Wash/Non-Wash</label>
                                    @if (Auth::user()->id == 1)
                                        <select v-model="material.fabric_type" class="form-select form-control form-control-sm shadow-none" id="type" required>
                                            <option value="">--select one--</option>
                                            <option value="Wash">Wash</option>
                                            <option value="Non-wash">Non wash</option>
                                        </select>
                                    @else
                                        <select v-model="material.fabric_type" class="form-control form-control-sm shadow-none form-select" id="type" :disabled="material.in_two_status == 'a'" required>
                                            <option value="">--select one--</option>
                                            <option value="Wash">Wash</option>
                                            <option value="Non-wash">Non wash</option>
                                        </select>
                                   
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" @@click="inputtwoReset" class="btn btn-dark btn-sm" :disabled="loginUser != 1 && material.in_two_status == 'a'" >Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Input-3  -->
    <div class="modal fade" id="InputThree" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="InputThreeLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveMaterials">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Insert Page</h5>
                        <button type="button" @@click="resetMaterials" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="receive_date" class="col-form-label pt-0">Received Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="material.receive_date" class="form-control form-control-sm shadow-none" id="receive_date" required>
                                    @else
                                        <input type="date" v-model="material.receive_date" class="form-control form-control-sm shadow-none" id="receive_date" :readonly="material.in_three_status == 'a'" required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="receive_update_date" class="col-form-label pt-0">Update Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="material.receive_update_date" class="form-control form-control-sm shadow-none" id="receive_update_date" required>
                                    @else
                                        <input type="datetime-local" v-model="material.receive_update_date" class="form-control form-control-sm shadow-none" id="receive_update_date" readonly  required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="receive_qty" class="col-form-label pt-0">Receive Qty</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="number" min="1" v-model="material.receive_qty" class="form-control form-control-sm shadow-none" id="receive_qty" required>
                                    @else
                                        <input type="number" min="1" v-model="material.receive_qty" class="form-control form-control-sm shadow-none" id="receive_qty" :readonly="material.in_three_status == 'a'" required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @@click="inputthreeReset" class="btn btn-dark btn-sm" :disabled="loginUser != 1 && material.in_three_status == 'a'">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Input-4  -->
    <div class="modal fade" id="InputFour" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="InputFourLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveMaterials">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Insert Shrinkage sent</h5>
                        <button type="button" @@click="resetMaterials" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="shrinkage_sent" class="col-form-label pt-0">Shrinkage sent</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="material.shrinkage_sent" class="form-control form-control-sm shadow-none" id="shrinkage_sent" required>
                                    @else
                                        <input type="date" v-model="material.shrinkage_sent" class="form-control form-control-sm shadow-none" id="shrinkage_sent" :readonly="material.in_four_status == 'a'" required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="shrinkage_time" class="col-form-label pt-0">Shrinkage Time</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="time" v-model="material.shrinkage_time" class="form-control form-control-sm shadow-none" id="shrinkage_time" required>
                                    @else
                                        <input type="time" v-model="material.shrinkage_time" class="form-control form-control-sm shadow-none" id="shrinkage_time" :readonly="material.in_four_status == 'a'" required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="shrinkage_update_date" class="col-form-label pt-0">Update Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="material.shrinkage_update_date" class="form-control form-control-sm shadow-none" id="shrinkage_update_date" required>
                                    @else
                                        <input type="datetime-local" v-model="material.shrinkage_update_date" class="form-control form-control-sm shadow-none" id="shrinkage_update_date" readonly required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @@click="inputfourReset" class="btn btn-dark btn-sm" :disabled="loginUser != 1 && material.in_four_status == 'a'">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Input-5  -->
    <div class="modal fade" id="InputFive" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="InputFiveLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveMaterials">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Insert Page</h5>
                        <button type="button" @@click="resetMaterials" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="return_to_section" class="col-form-label pt-0">Return To Section</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="material.return_to_section" class="form-control form-control-sm shadow-none" id="return_to_section" required>
                                    @else
                                        <input type="date" v-model="material.return_to_section" class="form-control form-control-sm shadow-none" id="return_to_section"  :readonly="material.in_five_status == 'a'"  required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="return_to_time" class="col-form-label pt-0">Update Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="material.return_to_time" class="form-control form-control-sm shadow-none" id="return_to_time" required>
                                    @else
                                        <input type="datetime-local" v-model="material.return_to_time" class="form-control form-control-sm shadow-none" id="return_to_time" readonly  required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @@click="inputfiveReset" class="btn btn-dark btn-sm" :disabled="loginUser != 1 && material.in_five_status == 'a'">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Input-6  -->
    <div class="modal fade" id="InputSix" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="InputSixLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveMaterials">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Insert Shrinkage Received</h5>
                        <button type="button" @@click="resetMaterials" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="shrinkage_receive" class="col-form-label pt-0">Shrinkage Received</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="material.shrinkage_receive" class="form-control form-control-sm shadow-none" id="shrinkage_receive" required>
                                    @else
                                        <input type="date" v-model="material.shrinkage_receive" class="form-control form-control-sm shadow-none" id="shrinkage_receive" :readonly="material.in_six_status == 'a'" required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="shrinkage_receive_time" class="col-form-label pt-0">Shrinkage Time</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="time" v-model="material.shrinkage_receive_time" class="form-control form-control-sm shadow-none" id="shrinkage_receive_time" required>
                                    @else
                                        <input type="time" v-model="material.shrinkage_receive_time" class="form-control form-control-sm shadow-none" id="shrinkage_receive_time" :readonly="material.in_six_status == 'a'"  required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="shrinkage_receive_update" class="col-form-label pt-0">Update Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="material.shrinkage_receive_update" class="form-control form-control-sm shadow-none" id="shrinkage_receive_update" required>
                                    @else
                                        <input type="datetime-local" v-model="material.shrinkage_receive_update" class="form-control form-control-sm shadow-none" id="shrinkage_receive_update" readonly required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="shrinkage_length" class="col-form-label pt-0">Shrinkage length</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="text" v-model="material.shrinkage_length" class="form-control form-control-sm shadow-none" id="shrinkage_length" required>
                                    @else
                                        <input type="text" v-model="material.shrinkage_length" class="form-control form-control-sm shadow-none" id="shrinkage_length" :readonly="material.in_six_status == 'a'" required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="shrinkage_width" class="col-form-label pt-0">Shrinkge width</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="text" v-model="material.shrinkage_width" class="form-control form-control-sm shadow-none" id="shrinkage_width" required>
                                    @else
                                        <input type="text" v-model="material.shrinkage_width" class="form-control form-control-sm shadow-none" id="shrinkage_width" :readonly="material.in_six_status == 'a'" required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @@click="inputsixReset" class="btn btn-dark btn-sm" :disabled="loginUser != 1 && material.in_six_status == 'a'">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal for Input-7  -->
    <div class="modal fade" id="InputSeven" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="InputSevenLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveUseQty">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Insert Used Quantity</h5>
                        <button type="button" @@click="resetMaterials" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="use_qty" class="col-form-label pt-0">Use Quantity</label>

                                    <input type="number" min="0" v-model="useQty.use_qty" class="form-control form-control-sm shadow-none" id="use_qty" required>

                                    <label for="remarks2" class="col-form-label pt-0">SSL No</label>
                                    <textarea v-model="useQty.remarks2" class="form-control form-control-sm shadow-none" id="remarks2" cols="2" rows="2" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @@click="inputsevenReset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Input-8  -->
    <div class="modal fade" id="InputEight" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="InputEightLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveMaterials">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Insert for Store</h5>
                        <button type="button" @@click="resetMaterials" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="sent_store" class="col-form-label pt-0">Sent To Store</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="material.sent_store" class="form-control form-control-sm shadow-none" id="sent_store" required>
                                    @else
                                        <input type="date" v-model="material.sent_store" class="form-control form-control-sm shadow-none" id="sent_store" :readonly="material.in_eight_status == 'a'" required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="update_store" class="col-form-label pt-0">Update Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="material.update_store" class="form-control form-control-sm shadow-none" id="update_store" required>
                                    @else
                                        <input type="datetime-local" v-model="material.update_store" class="form-control form-control-sm shadow-none" id="update_store" readonly  required>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="store_qty" class="col-form-label pt-0">Store Qty</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="number" min="1" v-model="material.store_qty" class="form-control form-control-sm shadow-none" id="store_qty" required>
                                    @else
                                        <input type="number" min="1" v-model="material.store_qty" class="form-control form-control-sm shadow-none" id="store_qty" :readonly="material.in_eight_status == 'a'" required>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @@click="inputeightReset" class="btn btn-dark btn-sm" :disabled="loginUser != 1 && material.in_eight_status == 'a'">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- View Used Materials Qty -->
    <div class="modal fade" id="ViewUsed" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ViewUsedLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Used Quantity List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>FSSl</th>
                                    <th>Use Qty</th>
                                    <th>SSL No</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="used in usesquantities">
                                    <td>@{{ used.id }}</td>
                                    <td>@{{ used.material_id }}</td>
                                    <td>@{{ used.use_qty }}</td>
                                    <td>@{{ used.remarks2 }}</td>
                                    <td>@{{ used.created_at | formatDateTime('DD/MM/YYYY HH:mm A') }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total:</th>
                                    <th>@{{ usesquantities.reduce((prev, curr) => {return prev + parseFloat(curr.use_qty)}, 0) }}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
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
            material: {
                id: null,
                merchant_id: null,
                gm_id: null,
                coordinator_id: null,
                wash_coordinator_id: null,
                wash_unit_id: null,
                cad_id: null,
                buyer_id: null,
                supplier_id: null,
                fabric_ref: '',
                composition: '',
                remarks1: '',
                cw: '',
                bw: '',
                aw: '',
                in_one_status: '',
                fabric_sent: '',
                time: '',
                update_time: '',
                quantity: '',
                in_two_status: '',
                fabric_type: '',
                receive_date: '',
                receive_update_date: '',
                receive_qty: '',
                in_three_status: '',
                shrinkage_sent: '',
                shrinkage_time: '',
                in_four_status: '',
                shrinkage_update_date: '',
                return_to_section: '',
                in_five_status: '',
                return_to_time: '',
                shrinkage_receive: '',
                shrinkage_receive_time: '',
                shrinkage_receive_update: '',
                shrinkage_length: '',
                shrinkage_width: '',
                in_six_status: '',
                sent_store: '',
                update_store: '',
                store_qty: '',
                in_eight_status: '',
            },

            useQty: {
                id: null,
                use_qty: '',
                remarks2: ''
            },
            usesquantities: [],

            onProcess:false,
            errors: [],

            show: false,
            success: '',
            materials : [],
            buyers:[],
            selectedBuyer: null,
            coordinators: [],
            selectedCoordinator: null,
            colors: [],
            selectedColor: null,
            washUnits: [],
            washUnit: null,
            gms: [],
            selectedGm: null,
            sampleNames: [],
            selectedSampleName: null,
            washCoordinators: [],
            washCoordinator: null,
            cads: [],
            selectedCad: null,
            merchants: [],
            selectedMerchant: null,
            suppliers: [],
            selectedSupplier: null,
            materialsId: null,
            curUser: "{{ Auth::user()->merchant_id }}",
            loginUser: "{{ Auth::user()->id }}",
            searchType: '',
            columns: [
                { label: 'SL', field: 'id', align: 'center', filterable: false },
                { label: 'Merchant', field: 'merchant.name', align: 'center' },
                { label: 'GM', field: 'gm.name', align: 'center' },
                { label: 'Sample Cor', field: 'coordinator.name', align: 'center' },
                { label: 'Wash Cor', field: 'wash_coordinator.name', align: 'center' },
                { label: 'Wash Unit', field: 'wash_unit.name', align: 'center' },
                { label: 'CAD Cor', field: 'cad.name', align: 'center' },
                { label: 'Buyer', field: 'buyer.name', align: 'center' },
                { label: 'Supplier', field: 'supplier.name', align: 'center' },
                { label: 'Fabric reference', field: 'fabric_ref', align: 'center' },
                { label: 'cw', field: 'cw', align: 'center' },
                { label: 'Fabric Sent', field: 'fabric_sent', align: 'center' },
                { label: 'Quantity', field: 'quantity', align: 'center' },
                { label: 'Wash/Non-Wash', field: 'fabric_type', align: 'center' },
                { label: 'Received Date', field: 'receive_date', align: 'center' },
                { label: 'Received Qty', field: 'receive_qty', align: 'center' },
                { label: 'Sent To Shrinkage', field: 'shrinkage_sent', align: 'center' },
                { label: 'Shrinkage Receive', field: 'shrinkage_receive', align: 'center' },
                { label: 'Use Qty', field: 'used_materials_sum_use_qty', align: 'center' },
                { label: 'Balance Qty', field: 'used_materials_sum_use_qty', align: 'center' },
                { label: 'To Store', field: 'sent_store', align: 'center' },
                { label: 'Store Qty', field: 'store_qty', align: 'center' },
                { label: 'Re-set Date', field: 'reset_date', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 100,
            filter: ''
        },

        async created() {
            this.getMaterials();
            await this.getMerchants();
            this.getBuyer();
            this.getCoordinators();
            this.getColors();
            this.getSampleNames();
            this.getGms();
            this.getWashCoordinators();
            this.getCads();
            this.getWashUnits();
            this.getSuppliers();
            this.ViewUsedQty();

            if(this.curUser != '' && this.curUser != null) {
                this.selectedMerchant = this.merchants.find(item => item.id == this.curUser)
            }
        },
        filters: {
            formatDateTime(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },
        methods: {
            async getMerchants() {
                await axios.post('/get_merchant')
                .then(res => {
                    this.merchants = res.data;
                })
            },

            getBuyer() {
                axios.post('/get_buyer').then(res => {
                    this.buyers = res.data;
                })
            },

            getSampleNames() {
                axios.post('/get_sample_name').then(res => {
                    this.sampleNames = res.data;
                })
            },

            getGms() {
                axios.post('/get_gm').then(res => {
                    this.gms = res.data;
                })
            },

            getCoordinators() {
                axios.post('/get_coordinator').then(res => {
                    this.coordinators = res.data;
                })
            },

            getWashCoordinators() {
                axios.post('/get_wash_coordinator')
                .then(res => {
                    this.washCoordinators = res.data;
                })
            },
            
            getCads() {
                axios.post('/get_cads')
                .then(res => {
                    this.cads = res.data;
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

            getSuppliers() {
                axios.post('/get_supplier')
                .then(res => {
                    this.suppliers = res.data;
                })
            },

            getMaterials() {
                axios.post('/get_materias', {searchType: this.searchType})
                .then(res => {
                    this.materials = res.data.map((item, sl) => {
                        item.sl = sl + 1;
                        return item;
                    })
                })
            },

            saveMaterials() {
                this.errors = [];

                if(this.selectedMerchant == null) {
                    alert("Please Select Merchant!")
                    return
                }
                if (this.selectedGm == null) {
                    alert("Please Select GM!")
                    return
                }
                if (this.selectedBuyer == null) {
                    alert("Please Select Buyer!")
                    return
                }
                if (this.selectedCoordinator == null) {
                    alert("Please Select Sample Coordinator!")
                    return;
                }

                if (this.washCoordinator == null) {
                    alert("Please Select Wash Coordinator!")
                    return;
                }
                
                if (this.selectedCad == null) {
                    alert("Please Select Cad Coordinator!")
                    return;
                }

                if(this.washUnit == null) {
                    alert("Please Select Wash Unit!")
                    return;
                }

                if(this.selectedSupplier == null) {
                    alert("Please Select Supplier!")
                    return;
                }


                if(this.errors.length) {
                    setTimeout( () => {
                        this.errors = [];
                    }, 3000);
                    return;
                }

                this.onProcess = true;

                this.material.merchant_id = this.selectedMerchant.id;
                this.material.gm_id = this.selectedGm.id;
                this.material.coordinator_id = this.selectedCoordinator.id;
                this.material.wash_coordinator_id = this.washCoordinator.id;
                this.material.wash_unit_id = this.washUnit.id;
                this.material.cad_id = this.selectedCad.id;
                this.material.buyer_id = this.selectedBuyer.id;
                this.material.supplier_id = this.selectedSupplier.id;

                let url = '/save_materias';
                if(this.material.id != null) {
                    url = '/update_materias';
                }
                
                axios.post(url, this.material).then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    this.resetMaterials();
                    this.getMaterials();
                    $('#MaterialsEntry').modal('hide');
                    $('#InputOne').modal('hide');
                    $('#InputTwo').modal('hide');
                    $('#InputThree').modal('hide');
                    $('#InputFour').modal('hide');
                    $('#InputFive').modal('hide');
                    $('#InputSix').modal('hide');
                    $('#InputSeven').modal('hide');
                    $('#InputEight').modal('hide');
                    this.onProcess = false;
                    setTimeout(() => {
                        this.success = '';
                        this.show = false;
                    }, 3000)
                })
            },

            EditMaterial(material) {
                Object.keys(this.material).forEach(item => {
                    this.material[item] = material[item]
                })

                this.selectedMerchant = {
                    id: material.merchant_id,
                    name: material.merchant.name
                }
                this.selectedGm = {
                    id: material.gm_id,
                    name: material.gm.name
                }
                this.selectedCoordinator = {
                    id: material.coordinator_id,
                    name: material.coordinator.name
                }
                this.washCoordinator = {
                    id: material.wash_coordinator_id,
                    name: material.wash_coordinator.name
                }
                this.washUnit = {
                    id: material.wash_unit_id,
                    name: material.wash_unit.name,
                }
                this.selectedCad = {
                    id: material.cad_id,
                    name: material.cad.name
                }
                this.selectedBuyer = {
                    id: material.buyer_id,
                    name: material.buyer.name
                }
                this.selectedSupplier = {
                    id: material.supplier_id,
                    name:material.supplier.name
                }
            },

            AwSent(material) {
                this.EditMaterial(material);
                // material.in_one_status == 'a' ? this.material.in_one_status = 'a' : material.in_one_status
            },

            FebricSent(material) {
                this.EditMaterial(material);
                // material.fabric_sent != null ? material.fabric_sent : this.material.fabric_sent = moment().format("YYYY-MM-DD");
                material.update_time != null ? material.update_time : this.material.update_time = moment().format("YYYY-MM-DD HH:mm");
                // material.time != null ? material.time : this.material.time = moment().format("HH:mm");
            },

            EditReceive(material) {
                this.EditMaterial(material);

                // material.receive_date != null ? material.receive_date : this.material.receive_date = moment().format("YYYY-MM-DD");
                material.receive_update_date != null ? material.receive_update_date : this.material.receive_update_date = moment().format("YYYY-MM-DD HH:mm");
            },

            ShrinkageSent(material) {
                this.EditMaterial(material);

                // material.shrinkage_sent != null ? material.shrinkage_sent : this.material.shrinkage_sent = moment().format("YYYY-MM-DD");
                material.shrinkage_update_date != null ? material.shrinkage_update_date : this.material.shrinkage_update_date = moment().format("YYYY-MM-DD HH:mm");
                // material.shrinkage_time != null ? material.shrinkage_time : this.material.shrinkage_time = moment().format("HH:mm");
            },

            EditSection(material) {
                this.EditMaterial(material);

                material.return_to_time != null ? material.return_to_time : this.material.return_to_time = moment().format("YYYY-MM-DD HH:mm");
            },

            SendToStore(material) {
                this.EditMaterial(material);

                // material.sent_store != null ? material.sent_store : this.material.sent_store = moment().format("YYYY-MM-DD");
                material.update_store != null ? material.update_store : this.material.update_store = moment().format("YYYY-MM-DD HH:mm");
            },

            ShrinkageReceive(material) {
                this.EditMaterial(material);

                // material.shrinkage_receive_time != null ? material.shrinkage_receive_time : this.material.shrinkage_receive_time = moment().format("HH:mm");
                material.shrinkage_receive_update != null ? material.shrinkage_receive_update : this.material.shrinkage_receive_update = moment().format("YYYY-MM-DD HH:mm");
                console.log(this.material.shrinkage_receive_update)
            },

            UseQuantity(id) {
                this.materialsId = id;
            },

            deleteMaterial(id) {
                if (confirm('Are You Sure? You Want to Delete this?')) {
                    axios.post('/delete_materias', {id: id})
                    .then(res => {
                        let r = res.data;
                        alert(r.message);
                        this.getMaterials();
                    })
                }
            },

            saveUseQty() {
                this.onProcess = true;
                let data = {
                    used: this.useQty,
                    materialsId: this.materialsId
                }
                axios.post('/save_use_qty', data)
                .then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    this.resetQty();
                    this.getMaterials();
                    $('#InputSeven').modal('hide');
                    this.onProcess = false;
                    setTimeout(() => {
                        this.success = '';
                        this.show = false;
                    }, 3000)
                })
            },

            ViewUsedQty(id) {
                axios.post('/get_used_qty', {id: id})
                .then(res => {
                    this.usesquantities = res.data;
                })
            },

            ResetData(id) {
                axios.post('/reset_quantity', {id: id})
                .then(res => {
                    let r = res.data;
                    alert(r.message);
                    this.getMaterials();
                })
            },
              
            inputoneReset(){
                this.material.cw = '';
                this.material.bw = '';
                this.material.aw = '';
            },

            inputtwoReset(){
                this.material.fabric_sent = moment().format("YYYY-MM-DD");
                this.material.time = moment().format("HH:mm");
                this.material.update_time = moment().format("YYYY-MM-DD HH:mm");
                this.material.quantity = '';
                this.material.fabric_type = '';
             
            },
            inputthreeReset(){
                this.material.receive_date = moment().format("YYYY-MM-DD");
                this.material.receive_update_date = moment().format("YYYY-MM-DD HH:mm");
                this.material.receive_qty = '';
            },
            inputfourReset(){
                this.material.shrinkage_sent = moment().format("YYYY-MM-DD");
                this.material.shrinkage_time = moment().format("HH:mm");
                this.material.shrinkage_update_date = moment().format("YYYY-MM-DD HH:mm");
            },
            inputfiveReset(){
                this.material.return_to_section =moment().format("YYYY-MM-DD");
                this.material.return_to_time = moment().format("YYYY-MM-DD HH:mm") ;
             
            },
            inputsixReset(){
                this.material.shrinkage_receive = moment().format("YYYY-MM-DD");
                this.material.shrinkage_receive_time = moment().format("HH:mm");
                this.material.shrinkage_receive_update = moment().format("YYYY-MM-DD HH:mm");
                this.material.shrinkage_length = '';
                this.material.shrinkage_width = '';
            },
            inputsevenReset(){
                this.material.use_qty = '';
                this.material.remarks2 = '';
            },
            inputeightReset(){
                this.material.sent_store = moment().format("YYYY-MM-DD") ;
                this.material.update_store = moment().format("YYYY-MM-DD HH:mm");
                this.material.store_qty = '';
            },
            resetMaterials(){
                this.material = {
                    id: null,
                    merchant_id: null,
                    gm_id: null,
                    coordinator_id: null,
                    wash_coordinator_id: null,
                    wash_unit_id: null,
                    cad_id: null,
                    buyer_id: null,
                    supplier_id: null,
                    fabric_ref: '',
                    composition: '',
                    remarks1: '',
                    cw: '',
                    bw: '',
                    aw: '',
                    in_one_status: '',
                    fabric_sent: '',
                    time: '',
                    update_time: '',
                    quantity: '',
                    in_two_status: '',
                    fabric_type: '',
                    receive_date: '' ,
                    receive_update_date: '',
                    receive_qty: '',
                    in_three_status: '',
                    shrinkage_sent: '',
                    shrinkage_time: '',
                    in_four_status: '',
                    shrinkage_update_date: '',
                    return_to_section: '',
                    in_five_status: '',
                    return_to_time: '',
                    shrinkage_receive: '',
                    shrinkage_receive_time: '',
                    shrinkage_receive_update: '',
                    shrinkage_length: '',
                    shrinkage_width: '',
                    in_six_status: '',
                    sent_store: '',
                    update_store: '',
                    store_qty: '',
                    in_eight_status: '',
                }
                // this.selectedMerchant = this.curUser;
                if(this.curUser != '' && this.curUser != null) {
                this.selectedMerchant = this.merchants.find(item => item.id == this.curUser)
                   }
                this.selectedGm = null;
                this.selectedCoordinator = null;
                this.washCoordinator = null;
                this.washUnit = null;
                this.selectedCad = null;
                this.selectedBuyer = null;
                this.selectedSupplier = null;
            },

            resetQty() {
                this.useQty = {
                    id: null,
                    use_qty: '',
                    remarks2: ''
                }
                this.materialsId = null;
            },
        }
    });
</script>
@endpush
