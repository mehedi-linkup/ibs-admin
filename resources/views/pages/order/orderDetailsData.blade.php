@extends('layouts.master')
@section('title', 'Order Details Data List')
@push('css')
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
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
@endpush
@section('main-content')
<main id="root">

    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Order Details Data</span>
        </div>
        <div class="card my-3">
            <div class="card-header pb-0 d-flex">
                <div class="table-head"><i class="fas fa-table me-1"></i> Order Details Data List</div>
                
                <div class="float-end ms-auto">
                    <input type="text" class="form-control filter-box" v-model="filter" placeholder="Search..">
                </div>
                @if(Auth::user()->username == 'SuperAdmin')
                {{-- <div class="mx-2">
                    <a href="" class="btn btn-primary btn-sm">Excel Sheet</a> 
                </div> --}}
                @endif
            </div>
            <div class="card-body table-card-body">
                <div class="success" v-if="show">
                    <div class="alert alert-success">@{{ success }}</div>
                </div>
                <div class="table-responsive">
                    @isset(Auth::user()->role->permission['permission']['order_details_data']['list'])
                    <tbody class="text-center">
                        <datatable :columns="columns" :data="OrderDetailsDatas" :filter-by="filter">
                            <template scope="{ row }">
                                <tr class="text-center">
                                    <td>@{{ row.sl }}</td>
                                    <td>@{{ row.order_details.order_number }}</td>
                                    <td>@{{ row.date }}</td>
                                    <td>@{{ row.receive_date }}</td>
                                    <td>@{{ row.quantity }}</td>
                                    <td>@{{ row.chalan_number }}</td>
                                    <td class="text-center">
                                        @isset(Auth::user()->role->permission['permission']['order_details_data']['edit'])
                                            <button data-bs-toggle="modal" data-bs-target="#OrderDataEntry" class="btn btn-edit" @@click.prevent="editData(row)"><i class="fas fa-pencil-alt"></i></button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['order_details_data']['delete'])
                                            <button class="btn btn-delete" @@click.prevent="deleteOrderData(row.id)"><i class="fa fa-trash"></i></button>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="OrderDataEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OrderDataEntryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form  @submit.prevent="UpdateData">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Update Order Detail Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="inputStyle" class="col-sm-4">Date</label>
                            <div class="col-sm-8">
                                <input type="date" v-model="OrderDetailsData.date" class="form-control form-control-sm" id="inputStyle" readonly required>
                            </div>

                            <label for="inputDescrip" class="col-sm-4">Receive Date</label>
                            <div class="col-sm-8">
                                <input type="date" v-model="OrderDetailsData.receive_date" class="form-control form-control-sm" id="inputDescrip" required>
                            </div>
                            <label for="inputDescrip" class="col-sm-4">Receive Quantity</label>
                            <div class="col-sm-8">
                                <input type="numeber" v-model="OrderDetailsData.quantity" class="form-control form-control-sm" id="inputDescrip" required>
                            </div>
                            <label for="inputDescrip" class="col-sm-4">Chalan Number</label>
                            <div class="col-sm-8">
                                <input type="numeber" v-model="OrderDetailsData.chalan_number" class="form-control form-control-sm" id="inputDescrip" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-if="OrderDetailsData.id == null" :disabled="onProcess ? true : false">Save</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-else :disabled="onProcess ? true : false">Update</button>
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
                errors: [],
                OrderDetailsData: {
                    id: null,
                    date: moment().format("YYYY-MM-DD"),
                    receive_date: moment().format("YYYY-MM-DD"),
                    quantity: 0,
                    chalan_number: '',
                },
                OrderDetailsDatas: [],
                show: false,
                success: '',
                onProcess: false,

                columns: [
                    { label: 'SL', field: 'sl', align: 'center', filterable: false },
                    { label: 'Oreder number', field: 'orderDetails.order_number', align: 'center' },
                    { label: 'Date', field: 'date', align: 'center' },
                    { label: 'Receive Date', field: 'receive_date', align: 'center' },
                    { label: 'Quantity', field: 'quantity', align: 'center' },
                    { label: 'Chalan Number', field: 'chalan_number', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 100,
                filter: ''
            },
            created() {
                this.getData();
            },
            filters: {
                formatDateTime(dt, format) {
                    return dt == '' || dt == null ? '' : moment(dt).format(format);
                }
            },
            methods: {
                getSupplier() {
                    axios.post('/get_supplier').then(res => {
                        this.suppliers = res.data;
                    })
                },
                getData() {
                    axios.post('/get_order_details_data')
                    .then(res => {
                        this.OrderDetailsDatas = res.data.map((item, sl) => {
                            item.sl = sl + 1
                            return item;
                            this.show = false;
                        });
                    })
                },
                UpdateData() {
                    this.errors = [];

                    if(this.errors.length) {
                        setTimeout( () => {
                            this.errors = [];
                        }, 3000);
                        return;
                    }
                    this.onProcess = true;

                    axios.post('/update_order_details_data' , this.OrderDetailsData)
                    .then(res => {
                        this.success = res.data.message;
                        this.show = true;
                        $('#OrderDataEntry').modal('hide');
                        this.onProcess = false;
                        this.getData();
                        setTimeout(() => {
                            this.success = '';
                            this.resetForm();
                            this.show = false;
                        }, 3000)
                    })
                    .catch(err => {
                        console.log(err.response.data.message)
                    })
                },
                editData(OrderDetailsData) {
                    console.log(OrderDetailsData);
                    Object.keys(this.OrderDetailsData).forEach(item => {
                        this.OrderDetailsData[item] = OrderDetailsData[item]
                    })
                },

                deleteOrderData(id) {
                    if (confirm('Are You Sure? You Want to Delete this?')) {
                        axios.post('/delete_order_details_data', {id: id})
                        .then(res => {
                            let r = res.data
                            alert(r.message);
                            this.getData();
                        })
                    }
                },
               
                resetForm() {
                    this.OrderDetailsData = {
                        id: null,
                        date: moment().format("YYYY-MM-DD"),
                        receive_date: moment().format("YYYY-MM-DD"),
                        quantity: 0,
                        chalan_number: '',
                    }
                },
            }
        });
    </script>
@endpush