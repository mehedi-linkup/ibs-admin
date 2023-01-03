@extends('layouts.master')
@section('title', 'Factory List')
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Factory</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i> Factory List</div>
                @isset(Auth::user()->role->permission['permission']['factory']['add'])
                    <button type="button" class="btn btn-addnew" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fa fa-plus"></i> add new</button>
                @endisset
            </div>
            <div class="card-body table-card-body">
                <table class="table table-bordered table-hover">
                    <div class="success col-md-4" v-if="show">
                        <div class="alert alert-success">@{{ success }}</div>
                    </div>
                    <thead class="text-center bg-light">
                        <tr>
                            <th>SL</th>
                            <th>Factory Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @isset(Auth::user()->role->permission['permission']['factory']['list'])
                    <tbody class="text-center">
                        <tr v-for="(item, i) in factories" :key="i">
                            <td>@{{ item.sl }}</td>
                            <td>@{{ item.name }}</td>
                            <td>
                                @{{ item.created_at | formatDateTime('DD-MM-YYYY') }} @{{ item.created_at | formatDateTime('h:mm A') }}
                            </td>
                            <td class="text-center">
                                @isset(Auth::user()->role->permission['permission']['factory']['edit'])
                                    <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-edit" @@click.prevent="editFactory(item)"><i class="fas fa-pencil-alt"></i></button>
                                @endisset
                                @isset(Auth::user()->role->permission['permission']['factory']['delete'])
                                    <button class="btn btn-delete" @@click.prevent="deleteFactory(item.id)"><i class="fa fa-trash"></i></button>
                                @endisset
                            </td>
                        </tr>
                    </tbody>
                    @endisset
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <form @submit.prevent="saveData">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add New Factory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="inpuName" class="col-sm-4 ">Factory Name</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="factory.name" class="form-control form-control-sm" id="inpuName">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-if="factory.id == null" :disabled="onProcess ? true : false">Save</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-else :disabled="onProcess ? true : false">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
@push('js')
<script>
    const app = new Vue({
        el: '#root',
        data: {
            factory: {
                id: null,
                name: '',
                user_id: null,
                user_ip: '',
            },
            factories: [],
            errors: [],
            success: '',
            show: false,
            onProcess: false,

        },
        filters: {
            formatDateTime(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },
        created() {
            this.getFactory();
        },
        methods: {
            getFactory() {
                axios.post('/get_factory')
                .then(res => {
                    this.factories = res.data.map((item, sl) => {
                        item.sl = sl + 1
                        return item;
                    });
                })
            },
            saveData() {
                this.errors = [];
                if (this.factory.name == '') {
                    this.errors.push("Name is required")
                }

                if(this.errors.length) {
                    setTimeout( () => {
                        this.errors = [];
                    }, 3000);
                    return;
                }

                this.onProcess = true;
                let url = '';
                if(this.factory.id != null) {
                    url = '/update_factory';
                }
                else {
                    url = '/save_factory';
                    delete this.factory.id;
                }
                axios.post(url , this.factory)
                .then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    this.resetForm();
                    this.getFactory();
                    $('#staticBackdrop').modal('hide');
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
            editFactory(factory) {
                Object.keys(this.factory).forEach(item => {
                    this.factory[item] = factory[item]
                })
                console.log(factory)
            },
            deleteFactory(id) {
                if (confirm('Are You Sure? You Want to Delete this?')) {
                    axios.post('/delete_factory', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getFactory();
                    })
                }
            },
            resetForm() {
                this.factory = {
                    id: null,
                    name: '',
                    user_id: null,
                    user_ip: '',
                }
            }
        },
    })
</script>
@endpush