@extends('layouts.master')
@section('title', 'Order Search')
@push('css')
    <style>
        .table th{
            font-size: 13px; 
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Order Search</span>
        </div>
        <div class="card my-3">
            <div class="card-header">
                <form @submit.prevent="getFilterOrder">
                    <div class="form-group row mx-auto">
                        <div class="col-md-3">
                            <label class="px-0 mb-1">Select Byer</label>
                            <v-select v-bind:options="buyers"  v-model="buyer" label="name" class="w-100"></v-select>
                        </div>
                        <div class="col-md-3">
                            <label class="px-0 mb-1">Supplier</label>
                            <v-select v-bind:options="suppliers"  v-model="supplier" label="name" class="w-100"></v-select>
                        </div>
                        <div class="col-md-3">
                            <label class="px-0 mb-1">Factory</label>
                            <v-select v-bind:options="factories"  v-model="factory" label="name" class="w-100"></v-select>
                        </div>
                        
                        <div class="col-md-1 mt-4">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div v-if="orders.length > 0" class="text-end">
                <button class="btn btn-dark btn-sm my-2" type="button" onclick="printById('print__container')">Print Report</button>
            </div>
            <div class="card-body table-card-body table-responsive" v-if="orders.length > 0" id="print__container">
                <table class="table table-bordered table-hover">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>SL</th>
                            <th>Buyer</th>
                            <th>Style Des.</th>
                            <th>Merchant</th>
                            <th>Factory</th>
                            <th>GM</th>
                            <th>Item Name</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Po/Order No.</th>
                            <th>Shipment date</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Order Qty</th>
                            <th>Unit</th>
                            <th>PI received</th>
                            <th>Payment date</th>
                            <th>Tentative in-house</th>
                            <th>Received Qty</th>
                            <th>Remaining Qty</th>
                            <th>In-House Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-for="(item, i) in orders" :key="i">
                            <td>@{{ i + 1 }}</td>
                            <td>@{{ item.buyer }}</td>
                            <td>@{{ item.style_description }}</td>
                            <td>@{{ item.merchant }}</td>
                            <td>@{{ item.factory }}</td>
                            <td>@{{ item.gm }}</td>
                            <td>@{{ item.item_name }}</td>
                            <td>@{{ item.description }}</td>
                            <td>@{{ item.supplier }}</td>
                            <td>@{{ item.order_number }}</td>
                            <td>@{{ item.shipment_date }}</td>
                            <td>@{{ item.color }}</td>
                            <td>@{{ item.size }}</td>
                            <td>@{{ item.order_qty }}</td>
                            <td>@{{ item.unit }}</td>
                            <td>@{{ item.pt_received }}</td>
                            <td>@{{ item.payment_date }}</td>
                            <td>@{{ item.tentative_in_house_date }}</td>
                            <td>@{{ item.received_qty }}</td>
                            <td>@{{ item.remaining_qty }}</td>
                            <td>@{{ item.in_house_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
@push('js')
    <script>
        Vue.component('v-select', VueSelect.VueSelect);
        const app = new Vue({
            el: '#root',
            data: {
                filter: {
                    supplierId: null,
                    buyerId: null,
                    factoryId: null
                },
                orders: [],
                factories: [],
                factory: null,
                buyers: [],
                buyer: null,
                suppliers: [],
                supplier: null
            },

            watch: {
                supplier(supplier) {
                    if(supplier == undefined) return;
                    this.filter.supplierId = supplier.id;
                },
                buyer(buyer) {
                    if (buyer == undefined) return; 
                    this.filter.buyerId = buyer.id;
                },
                factory(factory) {
                    if (factory == undefined) return; 
                    this.filter.factoryId = factory.id;
                }
            },

            created() {
                this.getSupplier();
                this.getBuyer();
                this.getFactory()
            },
            
            methods: {
                getFilterOrder() {
                    axios.post('/get_order_search_result', this.filter)
                    .then(res => {
                        this.orders = res.data;
                    })
                },
                getSupplier() {
                    axios.post('/get_supplier')
                    .then(res => {
                        this.suppliers = res.data
                    })
                },
                getBuyer() {
                    axios.post('/get_buyer')
                    .then(res => {
                        this.buyers = res.data
                    })
                },
                getFactory() {
                    axios.post('/get_factory')
                    .then(res => {
                        this.factories = res.data
                    })
                },
                resetForm() {
                    // this.filter.departmentId = null;
                    // this.filter.buyerId = null;
                    // this.filter.productId = null;
                }
            }
        });

        // print  
        function printById(id)
        {
            var mywindow = window.open('', 'PRINT');
    
            mywindow.document.write(`
            <html><head><title>Order Details Report</title>
            <style>
                body {font-family: sans-serif;}
                table, tr, td,th {border: 1px solid black; padding: 5px 8px; font-size: 14px;}
                table {border-collapse: collapse}
                .font-weight-bold {font-weight: bold}
                .text-center {text-align: center}
                .vertical-align-top {vertical-align: top}
                .text-underline {text-decoration: underline}
                .text-uppercase {text-transform: uppercase}
                .label {width: 115px; display: inline-block; font-weight: bold;}
                .pt__title {display:inline-block; margin-right: 15px; font-weight: bold}
                .pt__box {height: 15px; width: 16px; border: 1px solid; display: inline-block; position: relative; top: 3px; margin-left: 10px; margin-right: 15px;}
                .sign__wrapper {display: flex; margin-top: 70px}
                .sign {width: 33.33%; text-align: center; font-weight: bold; text-decoration: overline}
                .attachment_page {page-break-before: always}
                .attachment__image {object-fit: contain; max-height: 180px}
            </style>
            `);
    
            mywindow.document.write('</head><body onload="loadHandler()">');
            mywindow.document.write(document.getElementById(id).innerHTML);
            mywindow.document.write('</body></html>');
    
            var is_chrome = Boolean(window.chrome);
            if (is_chrome) {
                mywindow.document.execCommand('print');
                mywindow.close();
            } else {
                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10*/
    
                mywindow.print();
                mywindow.close();
            }
        return true;
        }
    </script>
@endpush
