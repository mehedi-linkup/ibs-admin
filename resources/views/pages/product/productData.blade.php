@extends('layouts.master')
@section('title', 'Product Data List')
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
    </style>
@endpush
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > DataTable</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex">
                <div class="table-head"><i class="fas fa-table me-1"></i>All Product Data List</div>
                
                <div class="float-end ms-auto">
                    <input type="text" class="form-control filter-box" v-model="filter" placeholder="Search..">
                </div>
                @if(Auth::user()->username == 'SuperAdmin')
                <div class="mx-2">
                    <a href="{{ route('product-data-file-export') }}" class="btn btn-primary btn-sm">Excel Sheet</a> 
                </div>
                @endif
            </div>
            <div class="card-body table-card-body">
                <div class="success" v-if="show">
                    <div class="alert alert-success">@{{ success }}</div>
                </div>
                <div class="table-responsive">
                    @isset(Auth::user()->role->permission['permission']['product_data']['list'])
                    <tbody class="text-center">
                        <datatable :columns="columns" :data="ProductData" :filter-by="filter">
                            <template scope="{ row }">
                                <tr class="text-center">
                                    <td>@{{ row.sl }}</td>
                                    <td>@{{ row.smv }}</td>
                                    <td>@{{ row.eff }}</td>
                                    <td>@{{ row.fob }}</td>
                                    <td>@{{ row.tod | formatDateTime('DD-MM-YYYY')}}</td>
                                    <td>@{{ row.quantity }}</td>
                                    <td>@{{ parseFloat((row.smv / (row.eff/100))* 0.045 * 12).toFixed(2) }}</td>
                                    <td>@{{ parseFloat(row.fob * row.quantity).toFixed(2) }}</td>
                                    <td>@{{ parseFloat(row.smv * row.quantity / 60).toFixed(2) }}</td>
                                    <td>@{{ parseFloat((row.smv * row.quantity / 60) / (row.eff/100)).toFixed(2)  }}</td>
                                    <td>@{{ row.created_at | formatDateTime('DD-MM-YYYY') }}</td>
                                    <td class="text-center">
                                        @isset(Auth::user()->role->permission['permission']['product_data']['edit'])
                                            <button data-bs-toggle="modal" data-bs-target="#ProductDataEntry" class="btn btn-edit" @@click.prevent="editData(row)"><i class="fas fa-pencil-alt"></i></button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['product_data']['delete'])
                                            <button class="btn btn-delete" @@click.prevent="deleteProductData(row.id)"><i class="fa fa-trash"></i></button>
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
    
    <div class="modal fade" id="ProductDataEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ProductDataEntryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form @submit.prevent="UpdateData">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-product-hunt"></i> Product Data Entry</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="success" v-if="show">
                            <div class="alert alert-success">@{{ success }}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="inputSmv" class="col-form-label">SMV</label>
                                <input type="text" v-model="ProductDatas.smv" class="form-control form-control-sm" id="inputSmv">
                            </div>

                            <div class="col-sm-2">
                                <label for="inputEff" class="col-form-label">EFF(%)</label>
                                <input type="text" v-model="ProductDatas.eff" class="form-control form-control-sm" id="inputEff" required>
                            </div>

                            <div class="col-sm-2">
                                <label for="inputEff" class="col-form-label">FOB</label>
                                <input type="text" v-model="ProductDatas.fob" class="form-control form-control-sm" id="inputEff" required>
                            </div>

                            <div class="col-sm-2">
                                <label for="inputQuant" class="col-form-label">Quantity</label>
                                <input type="number" v-model="ProductDatas.quantity" class="form-control form-control-sm" id="inputQuant" min="0">
                            </div>

                            <div class="col-sm-3">
                                <label for="inputTod" class="col-form-label">TOD</label>
                                <input type="date" v-model="ProductDatas.tod" class="form-control form-control-sm" id="inputTod">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" :disabled="onProcess ? true : false">Update</button>
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
        const app = new Vue({
            el: "#root",
            data: {
                errors: [],
                ProductDatas: {
                    id: null,
                    smv: 0,
                    eff: 0,
                    fob: 0,
                    quantity: 0,
                    tod: '',
                    user_id: null,
                    user_ip: '',
                    active: true
                },
                ProductData: [],
                show: false,
                success: '',
                onProcess: false,
                columns: [
                    { label: 'SL', field: 'sl', align: 'center', filterable: false },
                    { label: 'SMV', field: 'smv', align: 'center' },
                    { label: 'EFF%', field: 'eff', align: 'center' },
                    { label: 'FOB', field: 'fob', align: 'center' },
                    { label: 'TOD', field: 'tod', align: 'center' },
                    { label: 'Quantity', field: 'quantity', align: 'center' },
                    { label: 'CM', align: 'center' },
                    { label: 'VALUE', align: 'center' },
                    { label: 'TOTAL SMH', align: 'center' },
                    { label: 'SMH EFF', align: 'center' },
                    { label: 'Crated At', field: 'created_at', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 100,
                filter: ''
            },
            filters: {
                formatDateTime(dt, format) {
                    return dt == '' || dt == null ? '' : moment(dt).format(format);
                }
            },
            created() {
                this.getData();
            },

            methods: {
                getData() {
                    axios.post('/get_product_data')
                    .then(res => {
                        this.ProductData = res.data.map((item, sl) => {
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

                    axios.post('/update_product_data' , this.ProductDatas)
                    .then(res => {
                        this.success = res.data.message;
                        this.show = true;
                        $('#ProductDataEntry').modal('hide');
                        this.onProcess = false;
                        setTimeout(() => {
                            this.success = '';
                            this.resetForm();
                            this.getData();
                            this.show = false;
                        }, 3000)
                    })
                    .catch(err => {
                        console.log(err.response.data.message)
                    })
                },
                editData(ProductDatas) {
                    Object.keys(this.ProductDatas).forEach(item => {
                        this.ProductDatas[item] = ProductDatas[item]
                    })
                },
                deleteProductData(id) {
                    if (confirm('Are You Sure? You Want to Delete this?')) {
                        axios.post('/delete_product_data', {id: id})
                        .then(res => {
                            let r = res.data
                            alert(r.message);
                            this.getData();
                        })
                    }
                },
                resetForm() {
                    this.ProductDatas.id = null;
                    this.ProductDatas.smv = 0;
                    this.ProductDatas.eff = 0;
                    this.ProductDatas.fob = 0;
                    this.ProductDatas.quantity = 0;
                    this.ProductDatas.tod = 0;
                    this.ProductDatas.active = false;
                }
                
            }
        });
    </script>
@endpush