@extends('layouts.master')
@section('title', 'Order Details List')
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
            line-height: 15px;
        }
        tr td {
            font-size: 14px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
@endpush
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Order Details</span>
        </div>
        <div class="card my-3">
            <div class="card-header pb-0 d-flex">
                <div class="table-head"><i class="fas fa-table me-1"></i> Order Details List</div>
                
                <div class="float-end ms-auto">
                    <input type="text" class="form-control filter-box" v-model="filter" placeholder="Search..">
                </div>
                @if(Auth::user()->username == 'SuperAdmin')
                <div class="mx-2">
                    <a href="{{ route('order-details-export') }}" class="btn btn-primary btn-sm">Excel Sheet</a> 
                </div>
                @endif
            </div>
            <div class="card-body px-0 py-2">
                <div class="success" v-if="show">
                    <div class="alert alert-success">@{{ success }}</div>
                </div>
                <div class="table-responsive">
                    @isset(Auth::user()->role->permission['permission']['order_details']['list'])
                    <tbody class="text-center">
                        <datatable :columns="columns" :data="OrderDetails" :filter-by="filter">
                            <template scope="{ row }">
                                <tr class="text-center">
                                    <td>@{{ row.sl }}</td>
                                    <td>@{{ row.order_data.order.buyer.name }}</td>
                                    <td>@{{ row.order_data.order.style_description }}</td>
                                    <td>@{{ row.order_data.order.style_number }}</td>
                                    <td>@{{ row.order_data.order.merchant.name }}</td>
                                    <td>@{{ row.order_data.order.factory.name }}</td>
                                    <td>@{{ row.order_data.order.gm }}</td>
                                    <td>@{{ row.order_data.item_name }}</td>
                                    <td>@{{ row.order_data.description }}</td>
                                    <td>@{{ row.order_data.supplier.name }}</td>
                                    <td>@{{ row.order_number }}</td>
                                    <td>@{{ row.shipment_date }}</td>
                                    <td>@{{ row.color.name }}</td>
                                    <td>@{{ row.size }}</td>
                                    <td>@{{ row.order_qty }}</td>
                                    <td>@{{ row.unit.name }}</td>
                                    <td>@{{ row.pt_received }}</td>
                                    <td>@{{ row.payment_date }}</td>
                                    <td>@{{ row.tentative_in_house_date }}</td>
                                    <td>@{{ row.order_details_quantity }}</td>
                                    <td>@{{ parseFloat(row.order_qty - row.order_details_quantity) }}</td>
                                    <td>@{{ row.in_house_date }}</td>
                                    <td>@{{ row.task }}</td>
                                    <td class="text-center">
                                        @isset(Auth::user()->role->permission['permission']['order_details_data']['add'])
                                            <button data-bs-toggle="modal" data-bs-target="#OrderDetailsDataInput" class="btn btn-edit" @@click.prevent="addOrderDetailData(row.id)">input</button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['order_details']['input'])
                                            <button data-bs-toggle="modal" data-bs-target="#OrderDetailsDataFourInput" class="btn btn-delete" @@click.prevent="editOrderDetails(row)">input</button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['order_details']['edit'])
                                            <button data-bs-toggle="modal" data-bs-target="#OrderDetails" class="btn btn-edit" @@click.prevent="editOrderDetails(row)"><i class="fas fa-pencil-alt"></i></button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['order_details']['delete'])
                                            <button class="btn btn-delete" @@click.prevent="deleteOrderDetails(row.id)"><i class="fa fa-trash"></i></button>
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
    
    <!-- Modal for order details  -->
    <div class="modal fade" id="OrderDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OrderDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form @submit.prevent="updateOrderDetails">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Order Details Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="inputSmv" class="col-form-label pt-0">Order Number</label>
                                    <input type="text" v-model="OrderDetail.order_number" class="form-control form-control-sm" id="inputSmv" required>
                                </div>
    
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">Shipment Date</label>
                                    <input type="date" v-model="OrderDetail.shipment_date" class="form-control form-control-sm" id="inputEff" required>
                                </div>
    
                                <div class="col-sm-3">
                                    <label for="color" class="col-form-label pt-0">Color</label>
                                    <v-select v-bind:options="colors" v-model="selectedColor" label="name" class="w-100"></v-select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">Size</label>
                                    <input type="text" v-model="OrderDetail.size" class="form-control form-control-sm" id="inputEff">
                                </div>
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">Order Quantity</label>
                                    <input type="number" step="0.01" min="0.00" v-model="OrderDetail.order_qty" class="form-control form-control-sm" v-on:input="RemainingQty" id="inputEff">
                                </div>
                                <div class="col-sm-3">
                                    <label for="unit" class="col-form-label pt-0">Unit in</label>
                                    
                                    <v-select v-bind:options="units" v-model="selectedUnit" label="name" class="w-100"></v-select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">PI Receive date</label>
                                    <input type="date" v-model="OrderDetail.pt_received" class="form-control form-control-sm" id="inputEff">
                                </div>
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">Payment Date</label>
                                    <input type="date" v-model="OrderDetail.payment_date" class="form-control form-control-sm" id="inputEff">
                                </div>
                                
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">Tentative in-house Date</label>
                                    <input type="date" v-model="OrderDetail.tentative_in_house_date" class="form-control form-control-sm" id="inputEff">
                                </div>
                                {{-- <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label pt-0">Received Quantity</label>
                                    <input type="number" step="0.01" min="0.00" v-model="OrderDetail.received_qty" class="form-control form-control-sm" v-on:input="RemainingQty" id="inputEff">
                                </div>
    
                                <div class="col-sm-2" style="display: none;">
                                    <label for="inputEff" class="col-form-label pt-0">Remaining Quantity</label>
                                    <input type="number" step="0.01" min="0.00" v-model="OrderDetail.remaining_qty" class="form-control form-control-sm" v-on:input="RemainingQty" id="inputEff" readonly>
                                </div> --}}
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">In-house Date</label>
                                    <input type="date" v-model="OrderDetail.in_house_date" class="form-control form-control-sm" id="inputEff">
                                </div>
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">Task</label>
                                    <select v-model="OrderDetail.task" class="w-100 selectpicker" id="task">
                                        <option value="Executing">Executing</option>
                                        <option value="Done">Done</option>
                                    </select>
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

    <!-- Modal for order details  -->
    <div class="modal fade" id="OrderDetailsDataFourInput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OrderDetailsDataFourInputLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form @submit.prevent="updateOrderDetails">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Order Details Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">PI Receive date</label>
                                    <input type="date" v-model="OrderDetail.pt_received" class="form-control form-control-sm" id="inputEff" :readonly="OrderDetail.pt_received != null">
                                </div>
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">Payment Date</label>
                                    <input type="date" v-model="OrderDetail.payment_date" class="form-control form-control-sm" id="inputEff" :readonly="OrderDetail.payment_date != null ">
                                </div>
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">In-house Date</label>
                                    <input type="date" v-model="OrderDetail.in_house_date" class="form-control form-control-sm" id="inputEff" :readonly="OrderDetail.in_house_date != null">
                                </div>
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label pt-0">Task</label>
                                    <select v-model="OrderDetail.task" class="w-100 selectpicker" id="task" :disabled="OrderDetail.task != null ? true : false ">
                                        <option value="Existing">Existing</option>
                                        <option value="Done">Done</option>
                                    </select>
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

    <!-- Modal for order details data -->
    <div class="modal fade" id="OrderDetailsDataInput" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OrderDetailsDataInputLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form @submit.prevent="saveOrderDetailsData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Order Details Data Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group" v-for="(detailsData, ind) in OrderDetailsData.filter(item => item.active)" :key="ind">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="date" class="col-form-label">Date</label>
                                    <input type="date" v-model="detailsData.date" class="form-control form-control-sm" id="date" readonly required>
                                </div>
    
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label">Receive Date</label>
                                    <input type="date" v-model="detailsData.receive_date" class="form-control form-control-sm" id="inputEff" required>
                                </div>
    
                                <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label">Receive Quantity</label>
                                    <input type="number" step="0.01" min="0" v-model="detailsData.quantity" class="form-control form-control-sm" id="inputEff" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="inputEff" class="col-form-label">Chalan Number</label>
                                    <input type="text" v-model="detailsData.chalan_number" class="form-control form-control-sm" id="inputEff" required>
                                </div>
    
                                <div class="col-sm-1 px-0">
                                    <label for="inputTod" class="col-form-label">Action</label><br>
                                    <button type="button" class="btn btn-primary btn-sm" @@click="orderDetailsDataPush()"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" @@click="detailsData.active = false" v-if="ind != 0"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false ">Save</button>
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
        var app = new Vue({
            el: "#root",

            data:{
                OrderDetail: {
                    id: null,
                    order_number: '',
                    shipment_date: '',
                    color_id: null,
                    size: '',
                    order_qty: 0.00,
                    unit_id: null,
                    pt_received: '',
                    payment_date: '',
                    tentative_in_house_date: '',
                    // received_qty: 0.00,
                    // remaining_qty: 0.00,
                    in_house_date: '',
                    task: '',
                },
                OrderDetailsData: [
                    {
                        id: null,
                        date: moment().format("YYYY-MM-DD"),
                        receive_date: '',
                        quantity: 0,
                        chalan_number: '',
                        active: true
                    }
                ],
                errors: [],
                show: false,
                success: '',
                colors: [],
                selectedColor: null,
                units:[],
                selectedUnit: null,
                orderDetailsId: null,
                onProcess: false,
                OrderDetails: [],
                columns: [
                    { label: 'SL', field: 'sl', align: 'center', filterable: false },
                    { label: 'Buyer', field: 'order_data.order.buyer.name', align: 'center' },
                    { label: 'Style Description', field: 'order_data.order.style_description', align: 'center' },
                    { label: 'Style Number', field: 'order_data.order.style_number', align: 'center' },
                    { label: 'Merchant', field: 'order_data.order.merchant.name', align: 'center' },
                    { label: 'Factory', field: 'order_data.order.factory.name', align: 'center' },
                    { label: 'GM', field: 'order_data.order.gm', align: 'center' },
                    { label: 'Item Name', field: 'order_data.item_name', align: 'center' },
                    { label: 'Description', field: 'order_data.description', align: 'center' },
                    { label: 'Supplier', field: 'order_data.supplier.name', align: 'center' },

                    { label: 'Po/Order number', field: 'order_number', align: 'center' },
                    { label: 'Shipment date', field: 'shipment_date', align: 'center' },
                    { label: 'Color', field: 'color_id', align: 'center' },
                    { label: 'Size', field: 'size', align: 'center' },
                    { label: 'Order Qty', field: 'order_qty', align: 'center' },
                    { label: 'Unit in', field: 'unit_id', align: 'center' },
                    { label: 'PI received', field: 'pt_received', align: 'center' },
                    { label: 'Payment date', field: 'payment_date', align: 'center' },
                    { label: 'Tentative in-house date', field: 'tentative_in_house_date', align: 'center' },
                    { label: 'Received Qty', field: 'order_details_quantity', align: 'center' },
                    { label: 'Remaining Qty', field: 'remaining_qty', align: 'center' },
                    { label: 'In-House Date', field: 'in_house_date', align: 'center' },
                    { label: 'Task Done', field: 'task', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
            },
            
            created() {
                this.getOrderDetails();
                this.getColors();
                this.getUnits();
            },
            filters: {
                formatDateTime(dt, format) {
                    return dt == '' || dt == null ? '' : moment(dt).format(format);
                }
            },
            methods:{
                getOrderDetails() {
                    axios.post('/get_order_details').then(res => {
                        this.OrderDetails = res.data.map((item, sl) => {
                            item.sl = sl + 1
                            return item;
                        });
                    })
                }, 

                getColors() {
                    axios.post('/get_color').then(res => {
                        this.colors = res.data;
                    })
                },
                getUnits() {
                    axios.post('/get_unit').then(res => {
                        this.units = res.data;
                    })
                },

                RemainingQty() {
                    this.OrderDetail.remaining_qty =  parseFloat(this.OrderDetail.order_qty) - parseFloat(this.OrderDetail.received_qty);
                },

                editOrderDetails(OrderDetail) {
                    Object.keys(this.OrderDetail).forEach(item => {
                        this.OrderDetail[item] = OrderDetail[item]
                    })
                    this.selectedColor = {
                        id: OrderDetail.color_id,
                        name: OrderDetail.color.name,
                    }
                    this.selectedUnit = {
                        id: OrderDetail.unit_id,
                        name: OrderDetail.unit.name
                    }
                },

                updateOrderDetails() {
                    this.errors = [];

                    if(this.errors.length) {
                        setTimeout( () => {
                            this.errors = [];
                        }, 3000);
                        return;
                    }
                    this.onProcess = true;

                    this.OrderDetail.color_id = this.selectedColor.id;
                    this.OrderDetail.unit_id = this.selectedUnit.id;

                    axios.post('/update_order_details' , this.OrderDetail)
                    .then(res => {
                        this.success = res.data.message;
                        this.show = true;
                        $('#OrderDetails').modal('hide');
                        $('#OrderDetailsDataFourInput').modal('hide');
                        this.onProcess = false;
                        this.getOrderDetails();
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

                deleteOrderDetails(id) {
                    if (confirm('Are You Sure? You Want to Delete this?')) {
                        axios.post('/delete_order_details', {id: id})
                        .then(res => {
                            let r = res.data
                            alert(r.message);
                            this.getOrderDetails();
                        })
                    }
                },
                
                addOrderDetailData(id) {
                    this.orderDetailsId = id;
                    console.log(this.orderDetailsId);
                },

                orderDetailsDataPush() {
                    this.OrderDetailsData.push({
                        id: null,
                        date: moment().format("YYYY-MM-DD"),
                        receive_date: moment().format("YYYY-MM-DD"),
                        quantity: this.OrderDetailsData[0].quantity,
                        chalan_number: this.OrderDetailsData[0].chalan_number,
                        active: true
                    })
                },

                saveOrderDetailsData(){
                    this.errors = [];

                    if(this.errors.length) {
                        setTimeout( () => {
                            this.errors = [];
                        }, 3000);
                        return;
                    }
                    this.onProcess = true;
                    let data = {
                        order: this.OrderDetailsData,
                        orderDetailsId: this.orderDetailsId
                    }
                    axios.post('/save_order_details_data' , data)
                    .then(res => {
                        this.success = res.data.message;
                        this.show = true;
                        $('#OrderDetailsDataInput').modal('hide');
                        this.ResetDetailsData();
                        setTimeout(() => {
                            this.success = '';
                            this.show = false;
                        }, 3000)
                        this.onProcess = false;
                    })
                    .catch(err => {
                        console.log(err.response.data.message)
                    })
                },

                resetForm() {
                    this.OrderDetail = {
                        id: null,
                        order_number: '',
                        shipment_date: '',
                        color_id: null,
                        size: '',
                        order_qty: 0.00,
                        unit_id: null,
                        pt_received: '',
                        payment_date: '',
                        tentative_in_house_date: '',
                        // received_qty: 0.00,
                        // remaining_qty: 0.00,
                        in_house_date: '',
                        task: '',
                    }
                },

                ResetDetailsData() {
                    this.OrderDetailsData = [
                        {
                            id: null,
                            date: moment().format("YYYY-MM-DD"),
                            receive_date: moment().format("YYYY-MM-DD"),
                            quantity: 0,
                            chalan_number: '',
                            active: true
                        }
                    ],
                    this.orderDetailsId = null;
                }
            }

        })
    </script>
@endpush