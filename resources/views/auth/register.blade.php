@extends('layouts.master')
@section('title', 'User Registration')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
@endpush
@section('main-content')
<main>
    <div class="container-fluid" id="root">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> >  User Registration</span>
        </div>
        @isset(Auth::user()->role->permission['permission']['user']['add'])
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-user-plus me-1"></i> Add New User</div>
                {{-- <a href="{{ route('table') }}" class="btn btn-addnew"> <i class="fa fa-file-alt"></i> view all</a> --}}
            </div>
            
            <div class="card-body table-card-body">
                <div class="row">
                    <form @submit.prevent="saveData">
                        <div class="row">
                            <div class="success col-md-4" v-if="show">
                                <div class="alert alert-success">@{{ success }}</div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-1 col-form-label">Name</label>
                                <div class="col-sm-3">
                                    <input type="text" min="0" v-model="user.name" class="form-control form-control-sm" id="inputName">
                                </div>

                                <label for="inputCP" class="col-sm-1 col-form-label">Select Role</label>
                                <div class="col-sm-3 d-flex">
                                    <v-select v-bind:options="roles" v-model="role" label="name" class="w-100"></v-select>
                                </div>

                                <label for="inputEmail" class="col-sm-1 col-form-label">Email</label>
                                <div class="col-sm-3">
                                    <input type="email" v-model="user.email" class="form-control form-control-sm" id="inputEmail">
                                </div>

                                <label for="inputUsername" class="col-sm-1 col-form-label">Username</label>
                                <div class="col-sm-3">
                                    <input type="text" v-model="user.username" class="form-control form-control-sm" id="inputUsername">
                                </div>

                                <label for="inputPassword" class="col-sm-1 col-form-label">Password</label>
                                <div class="col-sm-3">
                                    <input type="password" v-model="user.password" class="form-control form-control-sm" id="inputPassword">
                                </div>

                                <label for="inputImage" class="col-sm-1 col-form-label">Image</label>
                                <div class="col-sm-3">
                                    <input type="file" class="form-control form-control-sm" id="inputImage" @@change="onChangeMainImage" ref="image">
                                </div>
                                <label for="inputImage" class="col-sm-1 col-form-label">User Type</label>
                                <div class="col-sm-3">
                                    {{-- <label for="is_factory"><input type="checkbox" v-model="is_factory" id="is_factory" :value="true" style="display: none;"> Is Factory</label>&nbsp; --}}
                                    <label for="is_merchant"><input type="checkbox" v-model="is_merchant" :value="true" id="is_merchant"> Is Merchant</label>&nbsp;

                                    <label for="is_gm"><input type="checkbox" v-model="is_gm" :value="true" id="is_gm"> Is GM</label> &nbsp;

                                    <label for="is_coordinator"><input type="checkbox" v-model="is_coordinator" :value="true" id="is_coordinator"> Sample Coordinator</label>&nbsp;

                                    <label for="is_wash_coordinator"><input type="checkbox" v-model="is_wash_coordinator" :value="true" id="is_wash_coordinator"> Wash Coordinator</label>&nbsp;

                                    <label for="finishing_coordinator"><input type="checkbox" v-model="finishing_coordinator" :value="true" id="finishing_coordinator"> Finishing Coordinator</label>&nbsp;

                                    <label for="wash_unit"><input type="checkbox" v-model="wash_unit" :value="true" id="wash_unit"> Wash Unit</label>&nbsp;

                                    <label for="cad_deg"><input type="checkbox" v-model="cad_deg" :value="true" id="cad_deg"> CAD Designer</label>&nbsp;
                                </div>
                                <div class="col-sm-1"></div>
                                <div class="col-sm-3" :style="{display: is_factory == true ? '' : 'none' }">
                                    <v-select v-bind:options="factories" v-model="selectedFactory" label="name" class="w-100"></v-select>
                                </div>
                                <div class="col-sm-3" :style="{display: is_merchant == true ? '' : 'none' }">
                                    <v-select v-bind:options="merchants" v-model="selectedMerchant" label="name" placeholder="Select Merchant" class="w-100"></v-select>
                                </div>
                                <div class="col-sm-3" :style="{display: is_coordinator == true ? '' : 'none' }">
                                    <v-select v-bind:options="coordinators" v-model="selectedCoordinator" placeholder="Select Coordinator" label="name" class="w-100"></v-select>
                                </div>
                                <div class="col-sm-3" :style="{display: is_gm == true ? '' : 'none' }">
                                    <v-select v-bind:options="gms" v-model="selectedGm" placeholder="Select Gm" label="name" class="w-100"></v-select>
                                </div>
                                <div class="col-sm-3" :style="{display: is_wash_coordinator == true ? '' : 'none' }">
                                    <v-select v-bind:options="washCoordinators" v-model="washCoordinator" placeholder="Wash Coordinator" label="name" class="w-100"></v-select>
                                </div>
                                <div class="col-sm-3" :style="{display: finishing_coordinator == true ? '' : 'none' }">
                                    <v-select v-bind:options="finishCoordinators" v-model="finishCoordinator" placeholder="Finishing Coordinator" label="name" class="w-100"></v-select>
                                </div>
                                <div class="col-sm-3" :style="{display: wash_unit == true ? '' : 'none' }">
                                    <v-select v-bind:options="washUnits" v-model="washUnit" placeholder="Wash Unit" label="name" class="w-100"></v-select>
                                </div>
                                <div class="col-sm-3" :style="{display: cad_deg == true ? '' : 'none' }">
                                    <v-select v-bind:options="cads" v-model="cad" placeholder="CAD Desinger" label="name" class="w-100"></v-select>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="clearfix">
                            <div class="text-end m-auto">
                                <button type="reset" class="btn btn-dark">Reset</button>
                                <button type="submit" class="btn btn-primary" v-if="user.id == null" :disabled="onProcess ? true : false">Submit</button>
                                <button type="submit" class="btn btn-primary" v-else :disabled="onProcess ? true : false"> Update</button>
                            </div>
                        </div>
                    </form>    
                </div>
            </div>
        </div>  
        @endisset
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i>All User List</div>
                <a href="{{ route('home') }}" class="btn btn-addnew"> <i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </div>
            <div class="card-body table-card-body">
                <div v-if="errors.length">
                    <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                </div>
                <table class="table table-bordered table-hover">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>UserName</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @isset(Auth::user()->role->permission['permission']['user']['list'])
                    <tbody class="text-center">
                        <tr v-for="(item, i) in users" :key="i">
                            <td>@{{ item.sl }}</td>
                            <td>@{{ item.name }}</td>
                            <td>@{{ item.role.name }}</td>
                            <td>@{{ item.email }}</td>
                            <td>@{{ item.username }}</td>
                            <td class="text-center">
                                @isset(Auth::user()->role->permission['permission']['user']['edit'])
                                    <button class="btn btn-edit" @@click.prevent="editUser(item)"><i class="fas fa-pencil-alt"></i></button>
                                @endisset
                                @isset(Auth::user()->role->permission['permission']['user']['delete'])
                                    <button style="display: none;" :style="{display: item.id == 1 ? 'none' : ''}" @@click.prevent="deleteUser(item.id)" class="btn btn-delete"><i class="fa fa-trash"></i></button>
                                @endisset
                            </td>
                        </tr>
                    </tbody>
                    @endisset
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
            user: {
                id: null,
                name: '',
                email: '',
                username: '',
                password: '',
                role_id: null,
                factory_id: null,
                merchant_id: null,
                coordinator_id: null,
                wash_coordinator_id: null,
                finishing_coordinator_id: null,
                wash_unit_id: null,
                cad_id: null,
                gm: null,
            },
            errors: [],
            users: [],
            factories: [],
            selectedFactory: null,
            merchants:[],
            selectedMerchant: null,
            coordinators: [],
            selectedCoordinator: null,
            gms: [],
            selectedGm: null,
            washCoordinators: [],
            washCoordinator: null,
            finishCoordinators: [],
            finishCoordinator: null,
            washUnits: [],
            washUnit: null,
            cads: [],
            cad: null,
            show: false,
            success: '',
            imageFile: null,
            image: '',
            roles: [],
            role: null,
            onProcess: false,
            is_factory: false,
            is_merchant: false,
            is_gm: false,
            is_coordinator: false,
            is_wash_coordinator: false,
            finishing_coordinator: false,
            wash_unit: false,
            cad_deg: false,
        },

        watch: {
            role(role) {
                if(role == undefined) return;
                this.user.role_id = role.id
            },
            // selectedFactory(factory) {
            //     if(factory == undefined) return;
            //     this.user.selectedFactory = factory.id
            // }
        },

        created() {
            this.getUser();
            this.getRoles();
            this.getFactory();
            this.getMerchant();
            this.getGms();
            this.getCoordinators();
            this.getWashCoordinators();
            this.getFinishingCoordinators();
            this.getWashUnits();
            this.getCads();
        },

        methods: {
            getRoles() {
                axios.post('get_role').then(res => {
                    this.roles = res.data;
                })
            },
            getFactory() {
                axios.post('/get_factory').then(res => {
                    this.factories = res.data;
                })
            },
            getMerchant() {
                axios.post('/get_merchant').then(res => {
                    this.merchants = res.data;
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
                    this.finishCoordinators = res.data;
                })
            },
            getWashUnits() {
                axios.post('/get_wash_unit')
                .then(res => {
                    this.washUnits = res.data;
                })
            },
            getCads() {
                axios.post('/get_cads')
                .then(res => {
                    this.cads = res.data;
                })
            },
            onChangeMainImage() {
                if(event.target.files == undefined || event.target.files.length < 1) {
                    this.imageFile = null;
                    this.image = '';
                    return;
                }

                this.imageFile = event.target.files[0];
                this.image = URL.createObjectURL(event.target.files[0]);
            },
            getUser() {
                axios.get('/get_user')
                .then(res => {
                    this.users = res.data.map((item, sl) => {
                        item.sl = sl + 1
                        return item;
                    });
                })
            },
            saveData() {
                this.errors = [];

                // if (this.image == '') {
                //     this.errors.push("Image is required !")
                // }

                if(this.errors.length) {
                    setTimeout( () => {
                        this.errors = [];
                    }, 3000);
                    return;
                }

                this.user.factory_id = this.selectedFactory == null ? '' : this.selectedFactory.id;
                this.user.merchant_id = this.selectedMerchant == null ? '' : this.selectedMerchant.id;
                this.user.gm = this.selectedGm == null ? '' : this.selectedGm.id;
                this.user.coordinator_id = this.selectedCoordinator == null ? '' : this.selectedCoordinator.id;
                this.user.merchant_id = this.selectedMerchant == null ? '' : this.selectedMerchant.id;
                this.user.wash_coordinator_id = this.washCoordinator == null ? '' : this.washCoordinator.id;
                this.user.finishing_coordinator_id = this.finishCoordinator == null ? '' : this.finishCoordinator.id;
                this.user.wash_unit_id = this.washUnit == null ? '' : this.washUnit.id;
                this.user.cad_id =  this.cad == null ? '' : this.cad.id;

                let fd = new FormData();

                Object.keys(this.user).map((k) => {
                    fd.append(k, this.user[k])
                })

                if (this.imageFile) fd.append('image', this.imageFile)

                this.onProcess = true;
                // console.log(this.slider)
                let url = '';
                if(this.user.id != null) {
                    url = '/update_user';
                }
                else {
                    url = '/save_user';
                    delete this.user.id;
                }

                axios.post(url , fd).then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    this.resetForm();
                    this.getUser();
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
            editUser(user) {
                console.log(user);
                Object.keys(this.user).forEach(item => {
                    this.user[item] = user[item]
                })
                this.image = user.image
                this.role = this.roles.find(item => item.id == user.role_id)
                this.selectedCoordinator = this.coordinators.find(item => item.id == user.coordinator_id);
                this.selectedGm = this.gms.find(item => item.id == user.gm);
                this.washCoordinator = this.washCoordinators.find(item => item.id == user.wash_coordinator_id);
                this.finishCoordinator = this.finishCoordinators.find(item => item.id == user.finishing_coordinator_id);
                this.washUnit = this.washUnits.find(item => item.id == user.wash_unit_id);
                this.cad = this.cads.find(item => item.id == user.cad_id);
                this.selectedMerchant = this.merchants.find(item => item.id == user.merchant_id);

                this.is_gm = user.gm == null ? false : true;
                this.is_coordinator = user.coordinator_id == null ? false : true;
                this.is_wash_coordinator = user.wash_coordinator_id == null ? false : true;
                this.finishing_coordinator = user.finishing_coordinator_id == null ? false : true;
                this.wash_unit = user.wash_unit_id == null ? false : true;
                this.cad_deg = user.cad_id == null ? false : true;
                this.is_merchant = user.merchant_id == null ? false : true;
                this.user.password = ''
            },
            deleteUser(id) {
                if (confirm('Are You Sure? You Want to Delete this?')) {
                    axios.post('/delete_user', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getUser();
                    })
                }
            },
            resetForm() {
                this.user = {
                    id: null,
                    name: '',
                    email: '',
                    username: '',
                    password: '',
                    role_id: null,
                    factory_id: null,
                    merchant_id: null,
                    gm: '',
                }
                this.image = '';
                this.$refs.image.value = '';
                this.role = null;
                this.is_factory = false;
                this.is_merchant = false;
                this.is_gm = false;
                this.is_coordinator = false;
                this.is_wash_coordinator = false,
                this.finishing_coordinator = false,
                this.wash_unit = false,
                this.cad_deg = false,
                this.selectedCoordinator = null;
                this.washCoordinator = null;
                this.finishCoordinator = null;
                this.washUnit = null;
                this.cad = null;
            }
        }
    })
</script>
@endpush