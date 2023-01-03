@extends('layouts.master')
@section('title', 'Order List')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
@endpush
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Order List</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i>All Order List</div>
               <div>
                @if(Auth::user()->username == 'SuperAdmin')
                <a href="{{ route('product-file-export') }}" class="btn btn-primary btn-sm">Excel Sheet</a> 
                @endif
                @isset(Auth::user()->role->permission['permission']['order']['add'])
                    <button type="button" class="btn btn-addnew" data-bs-toggle="modal" data-bs-target="#OrderEntry"> <i class="fa fa-plus"></i> add new</button>
                @endisset
               </div>
            </div>
            <div class="card-body table-card-body">
                <table class="table table-bordered">
                    <div class="success col-md-4" v-if="show">
                        <div class="alert alert-success">@{{ success }}</div>
                    </div>
                    <thead class="text-center bg-light">
                        <tr>
                            <th>SL</th>
                            <th>Buyer Name</th>
                            <th>Style Description</th>
                            <th>Style Number</th>
                            <th>Merchant Name</th>
                            <th>Factory</th>
                            <th>GM</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @isset(Auth::user()->role->permission['permission']['order']['list'])
                    {{-- @if ((Auth::user()->id == 1) || (Auth::user()->id == $item->user_id)) --}}
                    <tbody class="text-center" id="ProductData">
                        <tr v-for="(item, i) in orders" :key="i">
                            <td>@{{ item.sl }}</td>
                            <td>@{{ item.buyer.name }}</td>
                            <td>@{{ item.style_description }}</td>
                            <td>@{{ item.style_number }}</td>
                            <td>@{{ item.merchant.name }}</td>
                            <td>@{{ item.factory.name }}</td>
                            <td>@{{ item.gm }}</td>
                            <td>
                                @isset(Auth::user()->role->permission['permission']['order_data']['add'])
                                    <button data-bs-toggle="modal" data-bs-target="#OrderData" class="btn btn-edit" @@click.prevent="addOrderData(item.id)">input</button>
                                @endisset
                                @isset(Auth::user()->role->permission['permission']['order']['edit'])
                                    <button data-bs-toggle="modal" data-bs-target="#OrderEntry" class="btn btn-edit" @@click.prevent="editOrder(item)"><i class="fas fa-pencil-alt"></i></button>
                                @endisset
                                @isset(Auth::user()->role->permission['permission']['order']['delete'])
                                    <button class="btn btn-delete" @@click.prevent="deleteOrder(item.id)"><i class="fa fa-trash"></i></button>
                                @endisset
                            </td>
                        </tr>
                    </tbody>
                    {{-- @endif --}}
                    @endisset
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="OrderEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OrderEntryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form  @submit.prevent="saveOrder">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Add New Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group row">
                            {{-- <input type="hidden" name="id" id="InputId"> --}}
                            <label for="inputBuyer" class="col-sm-4">Buyer</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="buyers" v-model="selectedBuyer" label="name" class="w-100"></v-select>
                            </div>

                            <label for="inputStyle" class="col-sm-4">Style Description</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="order.style_description" class="form-control form-control-sm" id="inputStyle" required>
                            </div>

                            <label for="inputDescrip" class="col-sm-4">Style Number</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="order.style_number" class="form-control form-control-sm" id="inputDescrip" required>
                            </div>

                            <label for="inputBase" class="col-sm-4">Merchant name</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="merchants" v-model="selectedMerchant" label="name" class="w-100"></v-select>
                            </div>

                            <label for="inputFTY" class="col-sm-4">Factory</label>
                            <div class="col-sm-8 mb-2">
                                <v-select v-bind:options="factories" v-model="selectedFactory" label="name" class="w-100"></v-select>
                            </div>

                            <label for="inputGm" class="col-sm-4">GM</label>
                            <div class="col-sm-8">
                                <select v-model="order.gm" id="inputGm" class="form-control form-control-sm" required>
                                    <option value="">--- select one ---</option>
                                    <option value="gm-1">GM-1</option>
                                    <option value="gm-2">GM-2</option>
                                    <option value="gm-3">GM-3</option>
                                    <option value="gm-4">GM-4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-if="order.id == null" :disabled="onProcess ? true : false">Save</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-else :disabled="onProcess ? true : false">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="OrderData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="OrderDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form @submit.prevent="saveOrderData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-first-order"></i> Order Data Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group" v-for="(addOrder, ind) in OrderData.filter(item => item.active)" :key="ind">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="inputSmv" class="col-form-label">Item Name</label>
                                    <input type="text" v-model="addOrder.item_name" class="form-control form-control-sm" id="inputSmv" required>
                                </div>
    
                                <div class="col-sm-4">
                                    <label for="inputEff" class="col-form-label">Description</label>
                                    <input type="text" v-model="addOrder.description" class="form-control form-control-sm" id="inputEff" required>
                                </div>
    
                                <div class="col-sm-3">
                                    <label for="supplier" class="col-form-label">Supplier</label>
                                    <select class="w-100 selectpicker" v-model="addOrder.supplier_id" id="supplier" required>
                                        <option v-for="supplier in suppliers" :value="supplier.id">@{{ supplier.name }}</option>
                                    </select>
                                </div>
    
                                <div class="col-sm-1 px-0">
                                    <label for="inputTod" class="col-form-label">Action</label><br>
                                    <button type="button" class="btn btn-primary btn-sm" @@click="orderPush()"><i class="fa fa-plus"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" @@click="addOrder.active = false" v-if="ind != 0"><i class="fa fa-trash"></i></button>
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
<script>
    Vue.component('v-select', VueSelect.VueSelect);
    const app = new Vue({
        el: "#root",
        data: {
            order: {
                id: null,
                buyer_id: null,
                style_description: '',
                style_number: '',
                merchant_id: null,
                factory_id: null,
                gm: '',
            },

            onProcess:false,
            errors: [],
            OrderData: [
                {
                    id: null,
                    item_name: '',
                    description: '',
                    supplier_id: '',
                    active: true
                }
            ],
            show: false,
            success: '',
            orders : [],
            suppliers : [],
            buyers:[],
            selectedBuyer: null,
            merchants: [],
            selectedMerchant: null,
            factories: [],
            selectedFactory: null,
            orderId: null,
        },

        created() {
            this.getOrder();
            this.getBuyer();
            this.getMerchants();
            this.getFactory();
            this.getSupplier();
        },

        methods: {
            getBuyer() {
                axios.post('/get_buyer').then(res => {
                    this.buyers = res.data;
                })
            },
            getSupplier() {
                axios.post('/get_supplier').then(res => {
                    this.suppliers = res.data;
                })
            },
            getMerchants() {
                axios.post('/get_merchant').then(res => {
                    this.merchants = res.data;
                })
            },
            getFactory() {
                axios.post('/get_factory').then(res => {
                    this.factories = res.data;
                })
            },

            getOrder() {
                axios.post('/get_orders').then(res => {
                    this.orders = res.data.map((item, sl) => {
                        item.sl = sl + 1;
                        return item;
                    })
                })
            },

            saveOrder() {
                this.errors = [];
                if (this.selectedBuyer == null) {
                    alert("Please Select Buyer!")
                    return
                }
                if (this.selectedFactory == null) {
                    alert("Please Select Factory!")
                    return;
                }
                if (this.selectedMerchant == null) {
                    alert("Please Select Merchant!")
                    return;
                }

                if(this.errors.length) {
                    setTimeout( () => {
                        this.errors = [];
                    }, 3000);
                    return;
                }

                this.onProcess = true;

                this.order.buyer_id = this.selectedBuyer.id;
                this.order.merchant_id = this.selectedMerchant.id;
                this.order.factory_id = this.selectedFactory.id;

                let url = '/save_order';
                if(this.order.id != null) {
                    url = '/update_order';
                }
                
                axios.post(url, this.order).then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    this.resetOrder();
                    this.getOrder();
                    $('#OrderEntry').modal('hide');
                    this.onProcess = false;
                    setTimeout(() => {
                        this.success = '';
                        this.show = false;
                    }, 3000)
                })
            },

            editOrder(order) {
                Object.keys(this.order).forEach(item => {
                    this.order[item] = order[item]
                })
                this.selectedBuyer = {
                    id: order.buyer_id,
                    name: order.buyer.name
                }
                this.selectedMerchant = {
                    id: order.merchant_id,
                    name: order.merchant.name
                }
                this.selectedFactory = {
                    id: order.factory_id,
                    name: order.factory.name
                }
            },

            deleteOrder(id) {
                if (confirm('Are You Sure? You Want to Delete this?')) {
                    axios.post('/delete_order', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getOrder();
                    })
                }
            },

            addOrderData(id) {
                this.orderId = id;
            },

            orderPush() {
                this.OrderData.push({
                    id: null,
                    item_name: this.OrderData[0].item_name,
                    description: this.OrderData[0].description,
                    supplier_id: this.OrderData.supplier_id,
                    active: true
                })
            },

            saveOrderData() {
                this.errors = [];

                if(this.errors.length) {
                    setTimeout( () => {
                        this.errors = [];
                    }, 3000);
                    return;
                }
                this.onProcess = true;
                let order_data = {
                    order: this.OrderData,
                    orderId: this.orderId
                }
                axios.post('/save_order_data' , order_data)
                .then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    $('#OrderData').modal('hide');
                    this.resetForm();
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

            resetOrder(){
                this.order = {
                    id: null,
                    buyer_id: null,
                    style_description: '',
                    style_number: '',
                    merchant_id: null,
                    factory_id: null,
                    gm: '',
                }
                this.selectedBuyer = null;
                this.selectedFactory = null;
                this.selectedMerchant = null;
            },
            resetForm()
            {
                this.OrderData = [
                    {
                        id: null,
                        item_name: '',
                        description: '',
                        supplier: '',
                        active: true
                    }
                ]
                this.orderId = null;
            }
        }
    });
</script>
@endpush
