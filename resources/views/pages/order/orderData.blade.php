@extends('layouts.master')
@section('title', 'Order Data List')
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
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Order Data</span>
        </div>
        <div class="card my-3">
            <div class="card-header pb-0 d-flex">
                <div class="table-head"><i class="fas fa-table me-1"></i> Order Data List</div>
                
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
                    @isset(Auth::user()->role->permission['permission']['order_data']['list'])
                    <tbody class="text-center">
                        <datatable :columns="columns" :data="OrderDatas" :filter-by="filter">
                            <template scope="{ row }">
                                <tr class="text-center">
                                    <td>@{{ row.sl }}</td>
                                    <td>@{{ row.order.buyer.name }}</td>
                                    <td>@{{ row.order.style_description }}</td>
                                    <td>@{{ row.order.style_number }}</td>
                                    <td>@{{ row.order.merchant.name }}</td>
                                    <td>@{{ row.order.factory.name }}</td>
                                    <td>@{{ row.order.gm }}</td>
                                    <td>@{{ row.item_name }}</td>
                                    <td>@{{ row.description }}</td>
                                    <td>@{{ row.supplier.name }}</td>
                                    {{-- <td>@{{ row.created_at | formatDateTime('DD-MM-YYYY') }}</td> --}}
                                    <td class="text-center">
                                        @isset(Auth::user()->role->permission['permission']['order_details']['add'])
                                            <button data-bs-toggle="modal" data-bs-target="#OrderDetails" class="btn btn-edit" @@click.prevent="addOrderDetails(row.id)">input</button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['order_data']['edit'])
                                            <button data-bs-toggle="modal" data-bs-target="#OrderDataEntry" class="btn btn-edit" @@click.prevent="editData(row)"><i class="fas fa-pencil-alt"></i></button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['order_data']['delete'])
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
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Update Order Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="inputStyle" class="col-sm-4">Item Name</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="OrderData.item_name" class="form-control form-control-sm" id="inputStyle" required>
                            </div>

                            <label for="inputDescrip" class="col-sm-4">Description</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="OrderData.description" class="form-control form-control-sm" id="inputDescrip" required>
                            </div>
                            
                            <label for="inputDescrip" class="col-sm-4">Supplier</label>
                            <div class="col-sm-8">
                                <v-select v-bind:options="suppliers" v-model="selectedSupplier" label="name" class="w-100"></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-if="OrderData.id == null" :disabled="onProcess ? true : false">Save</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-else :disabled="onProcess ? true : false">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for order details  -->
    <div class="modal fade" id="OrderDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OrderDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form @submit.prevent="saveOrderDetails">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Order Details Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group" v-for="(addOrderDetails, ind) in OrderDetails.filter(item => item.active)" :key="ind">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label for="inputSmv" class="col-form-label pt-0">Order Number</label>
                                    <input type="text" v-model="addOrderDetails.order_number" class="form-control form-control-sm" id="inputSmv" required>
                                </div>
    
                                <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label pt-0">Shipment Date</label>
                                    <input type="date" v-model="addOrderDetails.shipment_date" class="form-control form-control-sm" id="inputEff" required>
                                </div>
    
                                <div class="col-sm-5 px-0">
                                    <div class="row">
                                        <div class="col-md-3 pe-0">
                                            <label for="color" class="col-form-label pt-0">Color</label>
                                            <select v-model="addOrderDetails.color_id" id="color" class="w-100 selectpicker" required>
                                                <option v-for="color in colors" :value="color.id">@{{ color.name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 pe-0">
                                            <label for="inputEff" class="col-form-label pt-0">Size</label>
                                            <input type="text" v-model="addOrderDetails.size" class="form-control form-control-sm" id="inputEff">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="inputEff" class="col-form-label pt-0">Order Qty</label>
                                            <input type="number" step="0.01" min="0.00" v-model="addOrderDetails.order_qty" class="form-control form-control-sm"  id="inputEff">
                                        </div>
                                        <div class="col-md-3 ps-0">
                                            <label for="unit" class="col-form-label pt-0">Unit in</label>
                                    
                                            <select v-model="addOrderDetails.unit_id" id="unit" class="w-100 selectpicker" required>
                                                <option v-for="unit in units" :value="unit.id">@{{ unit.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label pt-0">PI Receive date</label>
                                    <input type="date" v-model="addOrderDetails.pt_received" class="form-control form-control-sm" id="inputEff">
                                </div>
                                <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label pt-0">Payment Date</label>
                                    <input type="date" v-model="addOrderDetails.payment_date" class="form-control form-control-sm" id="inputEff">
                                </div> --}}
                                
                                <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label pt-0">Tentative in-house Date</label>
                                    <input type="date" v-model="addOrderDetails.tentative_in_house_date" class="form-control form-control-sm" id="inputEff">
                                </div>
                                {{-- <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label pt-0">Received Quantity</label>
                                    <input type="number" step="0.01" min="0.00" v-model="addOrderDetails.received_qty" class="form-control form-control-sm" v-on:input="RemainingQty(ind)" id="inputEff">
                                </div> --}}
    
                                {{-- <div class="col-sm-2" style="display:none">
                                    <label for="inputEff" class="col-form-label pt-0">Remaining Quantity</label>
                                    <input type="number" step="0.01" min="0.00" v-model="addOrderDetails.remaining_qty" class="form-control form-control-sm" v-on:input="RemainingQty(ind)" id="inputEff" readonly>
                                </div> --}}

                                {{-- <div class="col-sm-2">
                                    <label for="inputEff" class="col-form-label pt-0">In-house Date</label>
                                    <input type="date" v-model="addOrderDetails.in_house_date" class="form-control form-control-sm" id="inputEff">
                                </div>
                                <div class="col-sm-1">
                                    <label for="task" class="col-form-label pt-0">Task</label>
                                    <select v-model="addOrderDetails.task" class="w-100 selectpicker" id="task">
                                        <option value="Executing">Executing</option>
                                        <option value="Done">Done</option>
                                    </select>
                                </div> --}}
                                <div class="col-sm-1 px-0">
                                    <label for="inputTod" class="col-form-label pt-0">Action</label><br>
                                    <button type="button" class="btn btn-primary btn-sm" @@click="orderDetailsPush()"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" @@click="addOrderDetails.active = false" v-if="ind != 0"><i class="fa fa-trash"></i></button>
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
        const app = new Vue({
            el: "#root",
            data: {
                errors: [],
                OrderData: {
                    id: null,
                    item_name: '',
                    description: '',
                    supplier_id: '',
                    active: true
                },
                OrderDatas: [],
                suppliers: [],
                selectedSupplier: null,
                show: false,
                success: '',
                onProcess: false,
                colors: [],
                // selectedColor: null,
                units: [],
                // selectedUnit: null,
                OrderDataId: null,
                OrderDetails: [
                    {
                        id: null,
                        order_number: '',
                        shipment_date: '',
                        color_id: null,
                        size: '',
                        order_qty: 0.00,
                        unit_id: null,
                        // pt_received: '',
                        // payment_date: '',
                        tentative_in_house_date: '',
                        // received_qty: 0.00,
                        // remaining_qty: 0.00,
                        // in_house_date: '',
                        // task: '',
                        active: true
                    }
                ],

                columns: [
                    { label: 'SL', field: 'sl', align: 'center', filterable: false },
                    { label: 'Buyer', field: 'order.buyer.name', align: 'center' },
                    { label: 'Style Description', field: 'order.style_description', align: 'center' },
                    { label: 'Style Number', field: 'order.style_number', align: 'center' },
                    { label: 'Merchant', field: 'order.merchant.name', align: 'center' },
                    { label: 'Factory', field: 'order.factory.name', align: 'center' },
                    { label: 'GM', field: 'order.gm', align: 'center' },
                    { label: 'Item Name', field: 'item_name', align: 'center' },
                    { label: 'Description', field: 'description', align: 'center' },
                    { label: 'Supplier', field: 'supplier.name', align: 'center' },
                    // { label: 'Crated At', field: 'created_at', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 100,
                filter: ''
            },
            created() {
                this.getData();
                this.getColors();
                this.getUnits();
                this.getSupplier();
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
                    axios.post('/get_order_data')
                    .then(res => {
                        this.OrderDatas = res.data.map((item, sl) => {
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
                    this.OrderData.supplier_id = this.selectedSupplier.id;

                    axios.post('/update_order_data' , this.OrderData)
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
                editData(OrderData) {
                    Object.keys(this.OrderData).forEach(item => {
                        this.OrderData[item] = OrderData[item]
                    })
                    this.selectedSupplier = {
                        id: OrderData.supplier_id,
                        name: OrderData.supplier.name
                    }
                },
                deleteOrderData(id) {
                    if (confirm('Are You Sure? You Want to Delete this?')) {
                        axios.post('/delete_order_data', {id: id})
                        .then(res => {
                            let r = res.data
                            alert(r.message);
                            this.getData();
                        })
                    }
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
                addOrderDetails(id) {
                    this.OrderDataId = id;
                },

                orderDetailsPush() {
                    this.OrderDetails.push({
                        id: null,
                        order_number: this.OrderDetails[0].order_number,
                        shipment_date: this.OrderDetails[0].shipment_date,
                        color_id: null,
                        size: this.OrderDetails[0].size,
                        order_qty: this.OrderDetails[0].order_qty,
                        unit_id: null,
                        // pt_received: this.OrderDetails[0].pt_received,
                        // payment_date: this.OrderDetails[0].payment_date,
                        tentative_in_house_date: this.OrderDetails[0].tentative_in_house_date,
                        // received_qty: this.OrderDetails[0].received_qty,
                        // remaining_qty: this.OrderDetails[0].remaining_qty,
                        // in_house_date: this.OrderDetails[0].in_house_date,
                        // task: this.OrderDetails[0].task,
                        active: true
                    })
                },

                // RemainingQty(ind) {
                //     this.OrderDetails[ind].remaining_qty =  parseFloat(this.OrderDetails[ind].order_qty) - parseFloat(this.OrderDetails[ind].received_qty);
                // },

                async saveOrderDetails() {
                    
                    this.onProcess = true;
                    let data = {
                        orderDetails: this.OrderDetails,
                        OrderDataId: this.OrderDataId
                    }
                    await axios.post('/save_order_details' , data)
                    .then(res => {
                        this.success = res.data.message;
                        this.show = true;
                        $('#OrderDetails').modal('hide');
                        this.resetOrderDetails();
                        this.onProcess = false;
                        setTimeout(() => {
                            this.success = '';
                            this.show = false;
                        }, 3000)
                    })
                    .catch(err => {
                        console.log(err.response.data.message)
                    })
                },

                resetForm() {
                    this.OrderData = {
                        id: null,
                        item_name: '',
                        description: '',
                        supplier: '',
                        active: true
                    }
                },
                resetOrderDetails(){
                    this.OrderDetails = [
                        {
                            id: null,
                            order_number: '',
                            shipment_date: '',
                            color_id: null,
                            size: '',
                            order_qty: 0.00,
                            unit_id: null,
                            // pt_received: '',
                            // payment_date: '',
                            tentative_in_house_date: '',
                            // received_qty: 0.00,
                            // remaining_qty: 0.00,
                            // in_house_date: '',
                            // task: '',
                            active: true
                        }
                    ],
                    this.OrderDataId = null;
                },
                
            }
        });
    </script>
@endpush