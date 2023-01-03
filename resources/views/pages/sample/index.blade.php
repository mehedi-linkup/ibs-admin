@extends('layouts.master')
@section('title', 'Sample List')
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
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Sample List</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i>All Sample List</div>
    
                <div class="float-end ms-auto mb-0 pe-2">
                    <input type="text" class="form-control filter-box shadow-none" v-model="filter" placeholder="Search..">
                </div>
                <div>
                    @if(Auth::user()->username == 'SuperAdmin')
                    <a href="{{ route('sample-file-export') }}" class="btn btn-primary btn-sm shadow-none">Excel Sheet</a> 
                    @endif
                    @isset(Auth::user()->role->permission['permission']['sample']['add'])
                        <button type="button" class="btn btn-addnew shadow-none" data-bs-toggle="modal" data-bs-target="#SampleEntry"> <i class="fa fa-plus"></i> add new</button>
                    @endisset
                </div>
            </div>
            <div class="card-body table-card-body">
                    <div class="success col-md-4" v-if="show">
                        <div class="alert alert-success">@{{ success }}</div>
                    </div>
                   
                    @isset(Auth::user()->role->permission['permission']['sample']['list'])
                    <tbody class="text-center" id="ProductData">
                        <datatable :columns="columns" :data="samples" :filter-by="filter">
                            <template scope="{ row }">
                                <tr class="text-center">
                                    <td>@{{ row.id }}</td>
                                    <td>@{{ row.user.name }}</td>
                                    <td>@{{ row.gm.name }}</td>
                                    <td>@{{ row.buyer.name }}</td>
                                    <td>@{{ row.coordinator.name }}</td>
                                    <td>@{{ row.wash_coordinator.name }}</td>
                                    <td>@{{ row.finishing_coordinator.name }}</td>
                                    <td>@{{ row.cad.name }}</td>
                                    <td>@{{ row.cad_done_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.cad_done_time | formatDateTime('DD/MM/YYYY h:mm a') }}</td>
                                    <td>@{{ row.style_no }}</td>
                                    <td>@{{ row.item_name }}</td>
                                    {{-- <td>@{{ row.design_no}}</td> --}}
                                    <td>
                                        @isset(Auth::user()->role->permission['permission']['sample_data']['add'])
                                            <button data-bs-toggle="modal" data-bs-target="#SampleData" class="btn btn-edit shadow-none" @@click.prevent="addSampleData(row.id)">input</button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['sample']['cad'])
                                            <button data-bs-toggle="modal" data-bs-target="#CadData" class="btn btn-input-1 shadow-none" @@click.prevent="addCadData(row)">cad</button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['sample']['edit'])
                                            <button data-bs-toggle="modal" data-bs-target="#SampleEntry" class="btn btn-edit shadow-none" @@click.prevent="EditSample(row)"><i class="fas fa-pencil-alt"></i></button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['sample']['delete'])
                                            <button class="btn btn-delete shadow-none" @@click.prevent="deleteSample(row.id)"><i class="fa fa-trash"></i></button>
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
    <div class="modal fade" id="SampleEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SampleEntryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form  @submit.prevent="saveSample">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Add New Sample</h5>
                        <button type="button" @@click="resetSample" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group row">
                            {{-- <input type="hidden" name="id" id="InputId"> --}}
                            <label for="inputGm" class="col-sm-4">GM</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="gms" v-model="selectedGm" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>
                            <label for="inputBuyer" class="col-sm-4">Buyer</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="buyers" v-model="selectedBuyer" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBase" class="col-sm-4">Sample Cor</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="coordinators" v-model="selectedCoordinator" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBase" class="col-sm-4">Wash Cor</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="washCoordinators" v-model="washCoordinator" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBase" class="col-sm-4">Finishing Cor</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="finishingCoordinators" v-model="finishCoordinator" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputBase" class="col-sm-4">CAD Deg</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="cads" v-model="selectedCad" label="name" class="w-100" placeholder="--select one--"></v-select>
                            </div>

                            <label for="inputDescrip" class="col-sm-4">Style No</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="sample.style_no" class="form-control form-control-sm shadow-none" id="inputDescrip" required>
                            </div>

                            <label for="inputDesign" class="col-sm-4">Item Name</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="sample.item_name" class="form-control form-control-sm shadow-none" id="inputDesign" required>
                            </div>

                            <label for="inputDesign" class="col-sm-4">Design Remarks</label>
                            <div class="col-sm-8">
                                <textarea v-model="sample.design_no" class="form-control form-control-sm shadow-none" id="inputDesign" required cols="2" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @@click="resetSample" class="btn btn-dark btn-sm shadow-none">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm shadow-none" v-if="sample.id == null" :disabled="onProcess ? true : false">Save</button>
                        <button type="submit" class="btn btn-primary btn-sm shadow-none" v-else :disabled="onProcess ? true : false">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="SampleData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SampleDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form @submit.prevent="saveSampleData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Sample Data Entry</h5>
                        <button type="button" @@click="resetForm" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group" v-for="(addSample, ind) in SampleData.filter(item => item.active)" :key="ind">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label for="sample_name" class="col-form-label">Sample Name</label>
                                    <select class="w-100 selectpicker shadow-none" v-model="addSample.sample_name_id" id="sample_name" required>
                                        <option value="">--select one--</option>
                                        <option v-for="item in sampleNames" :value="item.id">@{{ item.name }}</option>
                                    </select>
                                </div>
    
                                <div class="col-sm-2">
                                    <label for="inputSmv" class="col-form-label">Sample Type</label>
                                    <select v-model="addSample.sample_type" class="form-control form-control-sm shadow-none" id="inputSmv" required>
                                        <option value="">--select one--</option>
                                        <option value="DVS">DVS</option>
                                        <option value="COS">COS</option>
                                        <option value="PFHS">PFHS</option>
                                    </select>
                                </div>
    
                                <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label">Fabric Code</label>
                                    <input type="text" v-model="addSample.fabric_code" class="form-control form-control-sm shadow-none" id="inputEff" required>
                                </div>
    
                                <div class="col-sm-2">
                                    <label for="supplier" class="col-form-label">Color</label>
                                    <select class="w-100 selectpicker shadow-none" v-model="addSample.color_id" id="supplier" required>
                                        <option value="">--select one--</option>
                                        <option v-for="color in colors" :value="color.id">@{{ color.name }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 px-0">
                                    <label for="size" class="col-form-label">Size</label>
                                    <input type="text" v-model="addSample.size" class="form-control form-control-sm shadow-none" id="size" required>
                                </div>
                                <div class="col-sm-1 pe-0">
                                    <label for="qty" class="col-form-label">Quantity</label>
                                    <input type="number" min="0" v-model="addSample.quantity" class="form-control form-control-sm shadow-none" id="qty" required>
                                </div>
                                <div class="col-sm-2">
                                    <label for="req" class="col-form-label">Wash Unit</label>
                                    <select class="form-control shadow-none" v-model="addSample.wash_unit_id">
                                        <option value="">--select one--</option>
                                        <option v-for="unit in washUnits" :value="unit.id">@{{ unit.name }}</option>
                                    </select>
                                </div>
                                <div class="col-sm-2" style="display: none;">
                                    <label for="req" class="col-form-label">REQ Date</label>
                                    <input type="datetime-local" v-model="addSample.req_sent_date" class="form-control form-control-sm shadow-none" id="req" required readonly>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Wash</label>
                                    <textarea v-model="addSample.wash" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Print/Emb</label>
                                    <textarea v-model="addSample.print_emb" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Support Fab</label>
                                    <textarea v-model="addSample.support_fab" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Thread</label>
                                    <textarea v-model="addSample.thread" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Trims & Acc</label>
                                    <textarea v-model="addSample.trims_and_acc" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Others-1</label>
                                    <textarea v-model="addSample.other_one" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Others-2</label>
                                    <textarea v-model="addSample.other_two" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <label for="remark" class="col-form-label">Remarks</label>
                                    <textarea v-model="addSample.remarks" class="form-control form-control-sm shadow-none" id="remark" required id="" cols="1" rows="1"></textarea>
                                </div>
                                <div class="col-sm-2">
                                    <label for="excelFile" class="col-form-label">Excel File</label>
                                    <input type="file" ref="fileupload" class="form-control form-control-sm shadow-none" id="excelFile" @@change="onChangeFile(ind)" required>
                                </div>
    
                                <div class="col-sm-1 px-0">
                                    <label for="inputTod" class="col-form-label">Action</label><br>
                                    <button type="button" class="btn btn-primary btn-sm shadow-none" @@click="SamplePush()"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm shadow-none" @@click="addSample.active = false" v-if="ind != 0"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <P>(Pocketing// Waist Contrast//Top Thread// BBN Thread// Overlock Thread// BARTACK Thread// Lining Thread// Zipper// Contrast// Padding// Lining// Binding//Sherpa// Quilting// Interlining// Interlining// Main Label// Size Label// Care Label// Button// Buckle// Rivet// Adjust Elastic// Plain Elastic// Twill Tape// Lather patch)</P>
                        <button type="button" @@click="reset" class="btn btn-dark btn-sm shadow-none">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm shadow-none" :disabled="onProcess ? true : false ">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Cad data  -->
    <div class="modal fade" id="CadData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="CadDataLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveSample">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Cad Done Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="doneTime" class="col-form-label pt-0">Done Time</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="datetime-local" v-model="sample.cad_done_time" class="form-control form-control-sm shadow-none" id="doneTime" >
                                    @else
                                        <input type="datetime-local" v-model="sample.cad_done_time" class="form-control form-control-sm shadow-none" id="doneTime" required readonly>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label for="doneDate" class="col-form-label pt-0">Done Date</label>
                                    @if (Auth::user()->id == 1)
                                        <input type="date" v-model="sample.cad_done_date" class="form-control form-control-sm" id="doneDate" required>
                                    @else
                                        <input type="date" v-model="sample.cad_done_date" class="form-control form-control-sm" id="doneDate" :readonly="sample.cad_done_date != null " required>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (Auth::user()->id == 1)
                            <button type="button" @@click="ReqReset" class="btn btn-dark btn-sm">Reset</button>
                        @else
                            <button :disabled="sample.cad_done_date != null" type="button" @@click="ReqReset" class="btn btn-dark btn-sm">Reset</button>
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
            sample: {
                id: null,
                buyer_id: null,
                item_name: '',
                style_no: '',
                design_no: '',
                coordinator_id: null,
                wash_coordinator_id: null,
                finishing_coordinator_id: null,
                cad_id: null,
                gm_id: null,
                cad_done_date: '',
                cad_done_time: ''
            },

            onProcess:false,
            errors: [],

            SampleData: [
                {
                    id: null,
                    sample_name_id: '',
                    sample_type: '',
                    fabric_code: '',
                    color_id: '',
                    wash_unit_id: '',
                    size: '',
                    quantity: '',
                    req_sent_date: moment().format("YYYY-MM-DD HH:mm:ss"),
                    wash: '',
                    print_emb: '',
                    support_fab: '',
                    thread: '',
                    trims_and_acc: '',
                    other_one: '',
                    other_two: '',
                    remarks: '',
                    file: null,
                    active: true,
                }
            ],
            show: false,
            success: '',
            samples : [],
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
            finishingCoordinators: [],
            finishCoordinator: null,
            cads: [],
            selectedCad: null,
            sampleId: null,
			selectedFile: null,
            curUser: "<?php echo Auth::user()->id ?>",

            columns: [
                { label: 'PDSL', field: 'id', align: 'center', filterable: false },
                { label: 'From', field: 'user.name', align: 'center' },
                { label: 'GM', field: 'gm.name', align: 'center' },
                { label: 'Buyer', field: 'buyer.name', align: 'center' },
                { label: 'Sample Cor', field: 'coordinator.name', align: 'center' },
                { label: 'Wash Cor', field: 'wash_coordinator.name', align: 'center' },
                { label: 'Finishing Cor', field: 'finishing_coordinator.name', align: 'center' },
                { label: 'CAD Deg', field: 'cad.name', align: 'center' },
                { label: 'Done Date', field: 'cad_done_date', align: 'center' },
                { label: 'Done Time', field: 'cad_done_time', align: 'center' },
                { label: 'Style No', field: 'style_no', align: 'center' },
                { label: 'Item Name', field: 'item_name', align: 'center' },
                // { label: 'Design No', field: 'design_no', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 100,
            filter: ''
        },

        created() {
            this.getSample();
            this.getBuyer();
            this.getCoordinators();
            this.getColors();
            this.getSampleNames();
            this.getGms();
            this.getWashCoordinators();
            this.getFinishingCoordinators();
            this.getCads();
            this.getWashUnits();
        },
        filters: {
            formatDateTime(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },
        methods: {
            onChangeFile(ind){
				if(event.target.files.length > 0){
					this.selectedFile = event.target.files[0];
				} else {
					this.selectedFile = null;
				}

                this.SampleData[ind].file = this.selectedFile;
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
            
            getFinishingCoordinators() {
                axios.post('/get_finishing_coordinator')
                .then(res => {
                    this.finishingCoordinators = res.data;
                })
            },

            getCads() {
                axios.post('/get_cads')
                .then(res => {
                    this.cads = res.data;
                })
            },

            getSample() {
                axios.post('/get_samples').then(res => {
                    this.samples = res.data.map((item, sl) => {
                        item.sl = sl + 1;
                        return item;
                    })
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

            saveSample() {
                this.errors = [];
                if (this.selectedGm == null) {
                    alert("Please Select GM!")
                    return
                }
                if (this.selectedBuyer == null) {
                    alert("Please Select Buyer!")
                    return
                }
                if (this.selectedCoordinator == null) {
                    alert("Please Select Coordinator!")
                    return;
                }
                if (this.washCoordinator == null) {
                    alert("Please Select Wash Coordinator!")
                    return;
                }
                if (this.finishCoordinator == null) {
                    alert("Please Select Finishing Coordinator!")
                    return;
                }
                if (this.selectedCad == null) {
                    alert("Please Select Cad Desiner!")
                    return;
                }

                if(this.errors.length) {
                    setTimeout( () => {
                        this.errors = [];
                    }, 3000);
                    return;
                }

                this.onProcess = true;

                this.sample.buyer_id = this.selectedBuyer.id;
                this.sample.coordinator_id = this.selectedCoordinator.id;
                this.sample.gm_id = this.selectedGm.id;
                this.sample.wash_coordinator_id = this.washCoordinator.id;
                this.sample.finishing_coordinator_id = this.finishCoordinator.id;
                this.sample.cad_id = this.selectedCad.id;

                let url = '/save_sample';
                if(this.sample.id != null) {
                    url = '/update_sample';
                }
                
                axios.post(url, this.sample).then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    this.resetSample();
                    this.getSample();
                    $('#SampleEntry').modal('hide');
                    $('#CadData').modal('hide');
                    this.onProcess = false;
                    setTimeout(() => {
                        this.success = '';
                        this.show = false;
                    }, 3000)
                })
            },

            EditSample(sample) {
                Object.keys(this.sample).forEach(item => {
                    this.sample[item] = sample[item]
                })
                this.selectedBuyer = {
                    id: sample.buyer_id,
                    name: sample.buyer.name
                }
                this.selectedGm = {
                    id: sample.gm_id,
                    name: sample.gm.name
                }
                this.selectedCoordinator = {
                    id: sample.coordinator_id,
                    name: sample.coordinator.name
                }
                this.washCoordinator = {
                    id: sample.wash_coordinator_id,
                    name: sample.wash_coordinator.name
                }
                this.finishCoordinator = {
                    id: sample.finishing_coordinator_id,
                    name: sample.finishing_coordinator.name,
                }
                this.selectedCad = {
                    id: sample.cad_id,
                    name: sample.cad.name
                }
            },

            addCadData(sample) {
                Object.keys(this.sample).forEach(item => {
                    this.sample[item] = sample[item]
                })
                this.selectedBuyer = {
                    id: sample.buyer_id,
                    name: sample.buyer.name
                }
                this.selectedGm = {
                    id: sample.gm_id,
                    name: sample.gm.name
                }
                this.selectedCoordinator = {
                    id: sample.coordinator_id,
                    name: sample.coordinator.name
                }
                this.washCoordinator = {
                    id: sample.wash_coordinator_id,
                    name: sample.wash_coordinator.name
                }
                this.finishCoordinator = {
                    id: sample.finishing_coordinator_id,
                    name: sample.finishing_coordinator.name,
                }
                this.selectedCad = {
                    id: sample.cad_id,
                    name: sample.cad.name
                }
                sample.cad_done_time != null ? sample.cad_done_time : this.sample.cad_done_time = moment().format("YYYY-MM-DD HH:mm");
            },

            deleteSample(id) {
                if (confirm('Are You Sure? You Want to Delete this?')) {
                    axios.post('/delete_sample', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getSample();
                    })
                }
            },

            addSampleData(id) {
                this.sampleId = id;
            },

            SamplePush() {
                
                this.SampleData.push({
                    id: null,
                    sample_name: this.SampleData[0].sample_name,
                    sample_type: this.SampleData[0].sample_type,
                    fabric_code: this.SampleData[0].fabric_code,
                    color_id: this.SampleData[0].color_id,
                    wash_unit_id: this.SampleData[0].wash_unit_id,
                    size: this.SampleData[0].size,
                    quantity: this.SampleData[0].quantity,
                    req_sent_date: this.SampleData[0].req_sent_date,
                    wash: his.SampleData[0].wash,
                    print_emb: his.SampleData[0].print_emb,
                    support_fab: his.SampleData[0].support_fab,
                    thread: his.SampleData[0].thread,
                    trims_and_acc: his.SampleData[0].trims_and_acc,
                    other_one: his.SampleData[0].other_one,
                    other_two: his.SampleData[0].other_two,
                    remarks: this.SampleData[0].remarks,
                    file: null,
                    active: true
                })
            },

            saveSampleData() {
                this.errors = [];

                if(this.errors.length) {
                    setTimeout( () => {
                        this.errors = [];
                    }, 3000);
                    return;
                }
                this.onProcess = true;

                let formData = new FormData();
				this.SampleData.forEach(function(sample, ind){
					if(sample.hasOwnProperty('file')){
						formData.append('file_'+ind, sample.file);
					}
				});
				formData.append('sample', JSON.stringify(this.SampleData));
				formData.append('sampleId', this.sampleId);

                axios.post('/save_sample_data' , formData)
                .then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    $('#SampleData').modal('hide');
                    this.resetForm();
                    setTimeout(() => {
                        this.success = '';
                        console.log(this.success);
                        this.show = false;
                    }, 1000)
                    this.onProcess = false;
                })
                .catch(err => {
                    console.log(err.response.data.message)
                })
            },

            resetSample(){
                this.sample = {
                    id: null,
                    buyer_id: null,
                    item_name: '',
                    style_no: '',
                    design_no: '',
                    coordinator_id: null,
                    wash_coordinator_id: null,
                    finishing_coordinator_id: null,
                    cad_id: null,
                    gm_id: null,
                    cad_done_date: '',
                    cad_done_time: ''
                }
                this.selectedBuyer = null;
                this.selectedCoordinator = null;
                this.selectedGm = null;
                this.washCoordinator = null;
                this.finishCoordinator = null;
                this.selectedCad = null;
            },
            resetForm()
            {
                this.SampleData = [
                    {
                        id: null,
                        sample_name: '',
                        sample_type: '',
                        fabric_code: '',
                        color_id: '',
                        wash_unit_id: '',
                        size: '',
                        quantity: '',
                        req_sent_date: moment().format("YYYY-MM-DD HH:mm:ss"),
                        wash: '',
                        print_emb: '',
                        support_fab: '',
                        thread: '',
                        trims_and_acc: '',
                        other_one: '',
                        other_two: '',
                        remarks: '',
                        file: null,
                        active: true
                    }
                ]
                this.sampleId = null;
                this.selectedFile = null;
                document.getElementById("excelFile").value = null;
            },
            reset() {
                this.SampleData = [
                    {
                        id: null,
                        sample_name: '',
                        sample_type: '',
                        fabric_code: '',
                        color_id: '',
                        wash_unit_id: '',
                        size: '',
                        quantity: '',
                        req_sent_date: moment().format("YYYY-MM-DD HH:mm:ss"),
                        wash: '',
                        print_emb: '',
                        support_fab: '',
                        thread: '',
                        trims_and_acc: '',
                        other_one: '',
                        other_two: '',
                        remarks: '',
                        file: null,
                        active: true
                    }
                ]
                document.getElementById("excelFile").value = null;
            },
            ReqReset() {
                this.sample.cad_done_date = null;
            }
        }
    });
</script>
@endpush
