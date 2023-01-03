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
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Sample Data List</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i>All Inactive Sample Data List</div>
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
                                    <td>@{{ row.id }}</td>
                                    <td>@{{ row.user.name }}</td>
                                    <td>@{{ row.sample.gm.name }}</td>
                                    <td>@{{ row.sample.buyer.name }}</td>
                                    <td>@{{ row.sample.style_no }}</td>
                                    <td>@{{ row.sample.item_name }}</td>
                                    <td>@{{ row.sample.design_no}}</td>
                                    <td>@{{ row.sample.coordinator.name }}</td>
                                    <td>@{{ row.sample_name.name }}</td>
                                    <td>@{{ row.sample_type }}</td>
                                    <td>@{{ row.fabric_code }}</td>
                                    <td>@{{ row.color.name }}</td>
                                    <td>@{{ row.size }}</td>
                                    <td>@{{ row.quantity }}</td>
                                    <td>@{{ row.req_sent_date | formatDateTime('DD/MM/YYYY h:mm a')}}</td>
                                    <td v-if="row.file != null">
                                        <a :href="row.file" download class="btn btn-danger btn-sm shadow-none">Download</a>
                                    </td>
                                    <td v-else> -- </td>
                                    <td>@{{ row.req_accept_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.sewing_date | formatDateTime('DD/MM/YYYY') }}</td>
                                    <td>@{{ row.sample_delivery_date | formatDateTime('DD/MM/YYYY') }}</td>
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

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['delete'])
                                        <button class="btn btn-delete" @@click.prevent="deleteSampleData(row.id)"><i class="fa fa-trash"></i></button>
                                        @endisset

                                        @isset(Auth::user()->role->permission['permission']['sample_data']['sample_insert'])
                                        <button class="btn btn-edit" @@click.prevent="insertSampleData(row.id)">insert</button>
                                        @endisset

                                        @if (Auth::user()->id == 1)
                                            <button v-if="row.active == 0" class="btn btn-delete" @@click.prevent="activeSampleData(row.id)">Inactive</button>
                                            {{-- <button v-if="row.active == 1" class="btn btn-active" @@click.prevent="inactiveSampleData(row.id)">Active</button> --}}
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
                                    <label for="req" class="col-form-label">REQ Date</label>
                                    <input type="datetime-local" v-model="sampleData.req_sent_date" class="form-control form-control-sm shadow-none" required readonly>
                                </div>
                                <div class="col-sm-4">
                                    <label for="remark" class="col-form-label">Remarks</label>
                                    <textarea v-model="sampleData.remarks" class="form-control form-control-sm shadow-none" id="remark" required cols="2" rows="2"></textarea>
                                </div>
                                <div class="col-sm-2">
                                    <label for="file" class="col-form-label">Excel File</label>
                                    <input type="file"  class="form-control form-control-sm shadow-none" id="file" @@change="onChangeFile()">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
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
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Update Delivery Date</h5>
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
                size: '',
                quantity: 0,
                req_sent_date: '',
                req_accept_date: '',
                sewing_date: '',
                sample_delivery_date: '',
                actual_delivery_date: '',
                remarks: '',
            },
            onProcess:false,
            errors: [],
            show: false,
            success: '',
            sampleDatas : [],
            colors: [],
            sampleNames: [],
            selectedSampleName: null,
            selectedColor: null,
            sampleDataId: null,
            selectedFile: null,
            curUser: "<?php echo Auth::user()->id ?>",

            columns: [
                { label: 'SL', field: 'id', align: 'center', filterable: false },
                { label: 'From', field: 'user.name', align: 'center' },
                { label: 'GM', field: 'sample.gm.name', align: 'center' },
                { label: 'Buyer', field: 'sample.buyer.name', align: 'center' },
                { label: 'Style No', field: 'sample.style_no', align: 'center' },
                { label: 'Item Name', field: 'sample.item_name', align: 'center' },
                { label: 'Design No', field: 'sample.design_no', align: 'center' },
                { label: 'Coordinator', field: 'sample.coordinator.name', align: 'center' },
                { label: 'Sample Name', field: 'sample_name.name', align: 'center' },
                { label: 'Sample Type', field: 'sample_type', align: 'center' },
                { label: 'Fabric Code', field: 'fabric_code', align: 'center' },
                { label: 'Color', field: 'color.name', align: 'center' },
                { label: 'Size', field: 'size', align: 'center' },
                { label: 'QTY', field: 'quantity', align: 'center' },
                { label: 'REQ sent', field: 'req_sent_date', align: 'center' },
                { label: 'Excele File', field: 'file', align: 'center' },
                { label: 'REQ accepted date', field: 'req_accept_date', align: 'center' },
                { label: 'Sewing date', field: 'sewing_date', align: 'center' },
                { label: 'Delivered', field: 'sample_delivery_date', align: 'center' },
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
                axios.post('/get_sample_data')
                .then(res => {
                    this.sampleDatas = res.data.filter(item => item.active == 0);
                    this.show = false;
                })
            },

            getColors() {
                axios.post('get_color').then(res => {
                    this.colors = res.data;
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

                axios.post('/update_sample_data' , formData)
                .then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    $('#SampleDataEntry').modal('hide');
                    $('#SampleDataUpdate').modal('hide');
                    $('#SampleDataFinalUpdate').modal('hide');
                    $('#SampleDataDeliUpdate').modal('hide');
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

            // inactiveSampleData(id) {
            //     if (confirm('Are You Sure? You Want to Inactive this?')) {
            //         axios.post('/inactive_sample_data', {id: id})
            //         .then(res => {
            //             let r = res.data
            //             alert(r.message);
            //             this.getSampleData();
            //         })
            //     }
            // },

            CopySampleData() {

            },
            resetForm() {
                this.sampleData = {
                    id: null,
                    sample_name_id: '',
                    sample_type: '',
                    fabric_code: '',
                    color_id: '',
                    size: '',
                    quantity: 0,
                    req_sent_date: '',
                    req_accept_date: moment().format("YYYY-MM-DD"),
                    sewing_date: '',
                    sample_delivery_date: '',
                    actual_delivery_date: '',
                    file: null,
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
                    size: '',
                    quantity: 0,
                    req_sent_date: moment().format("YYYY-MM-DD HH:mm:ss"),
                    file: null,
                    remarks: '',
                }
            },
            ReqReset() {
                this.sampleData.sewing_date = null;
            }
        }
    });
</script>
@endpush