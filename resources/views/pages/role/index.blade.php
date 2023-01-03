@extends('layouts.master')
@section('title', 'Role List')
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Role</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i> All Role List</div>
                @isset(Auth::user()->role->permission['permission']['role']['add'])
                    <button type="button" class="btn btn-addnew" data-bs-toggle="modal" data-bs-target="#RoleModal"> <i class="fa fa-plus"></i> add new</button>
                @endisset
            </div>
            <div class="card-body table-card-body">
                <div class="success col-md-4" v-if="show">
                    <div class="alert alert-success">@{{ success }}</div>
                </div>
                <table class="table table-bordered table-hover">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-for="(item, i) in roles" :key="i">
                            <td>@{{ item.sl }}</td>
                            <td>@{{ item.name }}</td>
                            <td>
                                @{{ item.created_at | formatDateTime('DD-MM-YYYY') }} @{{ item.created_at | formatDateTime('h:mm A') }}
                            </td>
                            <td class="text-center">
                                @isset(Auth::user()->role->permission['permission']['role']['edit'])
                                    <button data-bs-toggle="modal" data-bs-target="#RoleModal" class="btn btn-edit" @@click.prevent="editRole(item)"><i class="fas fa-pencil-alt"></i></button>
                                @endisset
                                @isset(Auth::user()->role->permission['permission']['role']['delete'])
                                    <button class="btn btn-delete" @@click.prevent="deleteRole(item.id)"><i class="fa fa-trash"></i></button>
                                @endisset
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="RoleModal" aria-hidden="true" aria-labelledby="RoleModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form @submit.prevent="saveData">
                    <div class="modal-header">
                        <h5 class="modal-title" id="RoleModalLabel">Add New Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="inpuName" class="col-sm-4">Role Name</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="role.name" class="form-control form-control-sm" id="inpuName" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-if="role.id == null" :disabled="onProcess ? true : false">Save</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-else :disabled="onProcess ? true : false">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</main>
@endsection
@push('js')
<script>
    const app = new Vue({
        el: '#root',
        data: {
            role: {
                id: null,
                name: '',
                slug: '',
                user_id: null,
                user_ip: '',
            },
            roles: [],
            errors: [],
            success: '',
            show: false,
            onProcess:false,

        },
        filters: {
            formatDateTime(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },
        created() {
            this.getRoles();
        },
        methods: {
            getRoles() {
                axios.post('/get_role')
                .then(res => {
                    this.roles = res.data.map((item, sl) => {
                        item.sl = sl + 1
                        return item;
                    });
                })
            },
            async saveData() {
                this.errors = [];
                if (this.role.name == '') {
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
                if(this.role.id != null) {
                    url = '/update_role';
                }
                else {
                    url = '/save_role';
                    delete this.role.id;
                }
                await axios.post(url , this.role)
                .then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    this.resetForm();
                    this.getRoles();
                    $('#RoleModal').modal('hide');
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
            editRole(role) {
                Object.keys(this.role).forEach(item => {
                    this.role[item] = role[item]
                })
                console.log(role)
            },
            deleteRole(id) {
                if (confirm('Are You Sure? You Want to Delete this?')) {
                    axios.post('/delete_role', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getRoles();
                    })
                }
            },
            resetForm() {
                this.role.id = null;
                this.role.name = '';
                this.role.slug = '';
                this.role.user_id = null;
                this.role.user_ip = '';
            }
        },
    })
</script>
@endpush