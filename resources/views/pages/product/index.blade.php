@extends('layouts.master')
@section('title', 'Product List')
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > DataTable</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i>All Product List</div>
               <div>
                @if(Auth::user()->username == 'SuperAdmin')
                <a href="{{ route('product-file-export') }}" class="btn btn-primary btn-sm">Excel Sheet</a> 
                @endif
                @isset(Auth::user()->role->permission['permission']['product']['add'])
                    <button type="button" class="btn btn-addnew" data-bs-toggle="modal" data-bs-target="#ProductEntry"> <i class="fa fa-plus"></i> add new</button>
                @endisset
               </div>
            </div>
            <div class="card-body table-card-body">
                <table id="datatablesSimple" class="ProductTable">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>SL</th>
                            <th>C/P</th>
                            <th>Buyer</th>
                            <th>Season</th>
                            <th>Dept.</th>
                            <th>Style Number/Name</th>
                            <th>Product Description</th>
                            <th>Base/ Top up/ Reprat</th>
                            <th>FTY</th>
                            <th>L/C</th>
                            <th>GM</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @isset(Auth::user()->role->permission['permission']['product']['list'])
                    {{-- @if ((Auth::user()->id == 1) || (Auth::user()->id == $item->user_id)) --}}
                    <tbody class="text-center" id="ProductData">
                        

                    </tbody>
                    {{-- @endif --}}
                    @endisset
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ProductEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ProductEntryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="ProductForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fab fa-product-hunt"></i> Add Product Description</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <input type="hidden" name="id" id="InputId">
                            <label for="inputCP" class="col-sm-4">C/P</label>
                            <div class="col-sm-8 d-flex">
                                <select name="cp" id="inputCP" class="form-control form-control-sm" required>
                                    <option value="">--- select one ---</option>
                                    <option value="c">C</option>
                                </select>
                            </div>

                            <label for="inputBuyer" class="col-sm-4">Buyer</label>
                            <div class="col-sm-8">
                                <select name="buyer_id" id="inputBuyer" class="form-control form-control-sm" required>
                                    <option value="">--- select one ---</option>
                                    @foreach ($buyers as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="inputSeasion" class="col-sm-4">Season</label>
                            <div class="col-sm-8">
                                <select name="season" id="inputSeasion" class="form-control form-control-sm" required>
                                    <option value="">--- select one ---</option>
                                    <option value="season-1">Season-1</option>
                                    <option value="season-2">Season-2</option>
                                    <option value="season-3">Season-3</option>
                                    <option value="season-4">Season-4</option>
                                    <option value="season-5">Season-5</option>
                                </select>
                            </div>


                            <label for="inputDept" class="col-sm-4">Department</label>
                            <div class="col-sm-8">
                                <select name="department_id" id="inputDept" class="form-control form-control-sm" required>
                                    <option value="">--- select one ---</option>
                                    @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="inputStyle" class="col-sm-4">Style No/Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="style_no_or_name" class="form-control form-control-sm" id="inputStyle" required>
                            </div>

                            <label for="inputDescrip" class="col-sm-4">Description</label>
                            <div class="col-sm-8">
                                <input type="text" name="description" class="form-control form-control-sm" id="inputDescrip" required>
                            </div>

                            <label for="inputBase" class="col-sm-4">Base/Top Up</label>
                            <div class="col-sm-8">
                                <select name="base_top_up" id="inputBase" class="form-control form-control-sm" required>
                                    <option value="">--- select one ---</option>
                                    <option value="base">BASE</option>
                                    <option value="repeat">Repeat</option>
                                    <option value="flow">FLOW</option>
                                    <option value="new">NEW</option>
                                </select>
                            </div>

                            <label for="inputFTY" class="col-sm-4">FTY</label>
                            <div class="col-sm-8">
                                <select name="fty" id="inputFTY" class="form-control form-control-sm" required>
                                    <option value="">--- select one ---</option>
                                    <option value="mkcl_ehl">MKCL/EHL</option>
                                    <option value="mkcl">MKCL</option>
                                    <option value="ehl">EHL</option>
                                </select>
                            </div>

                            <label for="inputLc" class="col-sm-4">L/C</label>
                            <div class="col-sm-8">
                                <select name="lc" id="inputLc" class="form-control form-control-sm" required>
                                    <option value="">--- select one ---</option>
                                    <option value="mkcl">MKCL</option>
                                    <option value="ehl">EHL</option>
                                    <option value="mdl">MDL</option>
                                    <option value="sgl">SGL</option>
                                </select>
                            </div>

                            <label for="inputGm" class="col-sm-4">GM</label>
                            <div class="col-sm-8">
                                <select name="gm" id="inputGm" class="form-control form-control-sm" required>
                                    <option value="">--- select one ---</option>
                                    <option value="gm-1">GM-1</option>
                                    <option value="gm-2">GM-2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="action" name="action" value="insert">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" >Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ProductDataEntry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ProductDataEntryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form @submit.prevent="saveData">
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
                        <div class="form-group row" v-for="(ProductData, ind) in ProductDatas.filter(item => item.active)" :key="ind">
                            
                            <div class="col-sm-2">
                                <label for="inputSmv" class="col-form-label">SMV</label>
                                <input type="text" v-model="ProductData.smv" class="form-control form-control-sm" id="inputSmv" required>
                            </div>

                            <div class="col-sm-2">
                                <label for="inputEff" class="col-form-label">EFF(%)</label>
                                <input type="text" v-model="ProductData.eff" class="form-control form-control-sm" id="inputEff" required>
                            </div>

                            <div class="col-sm-2">
                                <label for="inputEff" class="col-form-label">FOB</label>
                                <input type="text" v-model="ProductData.fob" class="form-control form-control-sm" id="inputEff" required>
                            </div>

                            <div class="col-sm-2">
                                <label for="inputQuant" class="col-form-label">Quantity</label>
                                <input type="number" v-model="ProductData.quantity" class="form-control form-control-sm" id="inputQuant" min="0" required>
                            </div>

                            <div class="col-sm-3">
                                <label for="inputTod" class="col-form-label">TOD</label>
                                <input type="date" v-model="ProductData.tod" class="form-control form-control-sm" id="inputTod">
                            </div>
                            <div class="col-sm-1 px-0">
                                <label for="inputTod" class="col-form-label">Action</label><br>
                                <button type="button" class="btn btn-primary btn-sm" @@click="productPush()"><i class="fa fa-plus"></i></button>
                                <button type="button" class="btn btn-danger btn-sm" @@click="ProductData.active = false" v-if="ind != 0"><i class="fa fa-trash"></i></button>
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
        var  productId = null;
        function productModel(id) {
            productId = id;
        }
        $(document).on('submit', '#ProductForm', function(e){
            e.preventDefault();
            var cp = $("#inputCP").val();
            var buyer_id = $("#inputBuyer").val();
            var season = $("#inputSeasion").val();
            var department_id = $("#inputDept").val();
            var style_no_or_name = $("#inputStyle").val();
            var description = $("#inputDescrip").val();
            var base_top_up = $("#inputBase").val();
            var fty = $("#inputFTY").val();
            var lc = $("#inputLc").val();
            var gm = $("#inputGm").val();
            var action = $("#action").val();
            var url = "{{ route('product.store') }}";
            var token = "{{ csrf_token() }}";
            var id = $('#InputId').val();
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    cp: cp,
                    buyer_id: buyer_id,
                    season: season,
                    department_id: department_id,
                    style_no_or_name: style_no_or_name,
                    description: description,
                    base_top_up: base_top_up,
                    fty: fty,
                    lc: lc,
                    gm: gm,
                    _token: token,
                    action: action,
                    id: id
                },
                success:function(res){
                    console.log(res.message);
                    $("#ProductForm")[0].reset();
                    $('#ProductEntry').modal('hide');
                    getData(); 
                }
            });
        });

        function getData(){
            $.ajax({
                type: "GET",
                url: "all_product",
                dataType: "json",

                success:function(res){
                    console.log(res);
                    var products = '';
                    res.forEach(data => {
                        products += `
                        <tr>
                            <td>${ data.id }</td>
                            <td>${ data.cp }</td>
                            <td>${ data.buyer.name }</td>
                            <td>${ data.season }</td>
                            <td>${ data.department.name }</td>
                            <td>${ data.style_no_or_name }</td>
                            <td>${ data.description }</td>
                            <td>${ data.base_top_up }</td>
                            <td>${ data.fty }</td>
                            <td>${ data.lc }</td>
                            <td>${ data.gm }</td>
                            <td class="text-center text-nowrap">
                                
                                <button data-bs-toggle="modal" data-bs-target="#ProductDataEntry" class="btn btn-edit" onClick="productModel(${ data.id })">input</button>
                                
                                
                                <button class="btn btn-edit" id="productEdit" data-id="${ data.id }"><i class="fas fa-pencil-alt"></i></button>

                                <button class="btn btn-delete" id="productDelete" data-id="${ data.id }"><i class="fa fa-trash"></i></button>

                            </td>
                        </tr> `
                    });
                    $("#ProductData").html(products);
                    
                }
            })
        }
        getData();

        $(document).on("click", '#productDelete', function(e){
            e.preventDefault();
            if (confirm('Are You Sure? You want to Delete This?')) {
                var id = $(this).attr('data-id');
                var url = "{{ route('delete_product') }}";
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: url,
                    method: 'post',
                    data: {id: id, _token: token},
                    success:function(res){
                        alert(res.message);
                        getData();
                    }
                });
            }
        });

        $(document).on("click", '#productEdit', function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var url = "{{ route('update_product') }}";
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: url,
                method: 'post',
                data: {id: id, _token: token},
                dataType: 'json',
                success:function(res){
                    console.log(res);
                    $('#ProductEntry').modal('show');
                    $('#InputId').val(res[0].id);
                    $('#inputCP').val(res[0].cp);
                    $('#inputBuyer').val(res[0].buyer_id);
                    $('#inputSeasion').val(res[0].season);
                    $('#inputDept').val(res[0].department_id);
                    $('#inputStyle').val(res[0].style_no_or_name);
                    $('#inputDescrip').val(res[0].description);
                    $('#inputBase').val(res[0].base_top_up);
                    $('#inputFTY').val(res[0].fty);
                    $('#inputLc').val(res[0].lc);
                    $('#inputGm').val(res[0].gm);
                    $('#action').val('update');
                }
            });
        });
        const app = new Vue({
            el: "#root",
            data: {
                Produc: {
                    id: null,
                    cp: '',
                    buyer_id: null,
                    season: '',
                    department_id: null,
                    style_no_or_name: '',
                    description: '',
                    base_top_up: '',
                    fty: '',
                    lc: '',
                    gm: '',
                    user_id: null,
                    user_ip: ''
                },
                onProcess:false,
                errors: [],
                ProductDatas: [
                    {
                        id: null,
                        smv: '',
                        eff: '',
                        fob: '',
                        quantity: '',
                        tod: moment().format("YYYY-MM-DD"),
                        user_id: null,
                        user_ip: '',
                        active: true
                    }
                ],
                show: false,
                success: '',
                Producs : [],
            },

            methods: {
                productPush() {
                    this.ProductDatas.push({
                        id: null,
                        smv: '',
                        eff: '',
                        fob: '',
                        quantity: '',
                        tod: moment().format("YYYY-MM-DD"),
                        user_id: null,
                        user_ip: '',
                        active: true
                    })
                },
                saveData() {
                    this.errors = [];

                    if(this.errors.length) {
                        setTimeout( () => {
                            this.errors = [];
                        }, 3000);
                        return;
                    }
                    this.onProcess = true;
                    let data = {
                        product: this.ProductDatas,
                        productId: productId
                    }
                    axios.post('/save_product_data' , data)
                    .then(res => {
                        this.success = res.data.message;
                        this.show = true;
                        $('#ProductDataEntry').modal('hide');
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

                getProduct()
                {
                    axios.post('/get_product')
                    .then(res => {
                        this.departments = res.data.map((item, sl) => {
                            item.sl = sl + 1
                            return item;
                        });
                    })
                }, 

                resetForm()
                {
                    this.ProductDatas = [];
                    this.productPush();
                },
            }
        });
        $("document").ready(function(){
            setTimeout(function(){
                $("div.alert").remove();
            }, 3000 ); // 5 secs
        });
    </script>
@endpush
