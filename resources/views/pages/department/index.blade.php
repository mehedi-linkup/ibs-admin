@extends('layouts.master')
@section('title', 'Department List')
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
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Department</span>
        </div>
        <div class="card my-3">
            <div class="card-header pb-0 d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i>Department List</div>
                <div class="float-end ms-auto">
                    <input type="text" class="form-control filter-box" v-model="filter" placeholder="Search..">
                </div>
                @isset(Auth::user()->role->permission['permission']['department']['add'])
                <div class="mx-2">
                    <button type="button" class="btn btn-addnew" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fa fa-plus"></i> add new</button>
                </div>
                @endisset
            </div>
            <div class="card-body table-card-body">
                <div class="success col-md-4" v-if="show">
                    <div class="alert alert-success">@{{ success }}</div>
                </div>
                <div class="table-responsive">
                    @isset(Auth::user()->role->permission['permission']['buyer']['list'])
                    <tbody class="text-center">
                        <datatable :columns="columns" :data="departments" :filter-by="filter">
                            <template scope="{ row }">
                                <tr class="text-center">
                                    <td>@{{ row.sl }}</td>
                                    <td>@{{ row.name }}</td>
                                    <td>
                                        @{{ row.created_at | formatDateTime('DD-MM-YYYY') }} @{{ row.created_at | formatDateTime('h:mm A') }}
                                    </td>
                                    <td class="text-center">
                                        @isset(Auth::user()->role->permission['permission']['department']['edit'])
                                            <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-edit" @@click.prevent="editDepartment(row)"><i class="fas fa-pencil-alt"></i></button>
                                        @endisset
                                        @isset(Auth::user()->role->permission['permission']['department']['delete'])
                                            <button class="btn btn-delete" @@click.prevent="deleteDepartment(row.id)"><i class="fa fa-trash"></i></button>
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
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form @submit.prevent="saveData">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add New Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="inpuName" class="col-sm-4 ">Department Name</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="department.name" class="form-control form-control-sm" id="inpuName">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-if="department.id == null" :disabled="onProcess ? true : false ">Save</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-else :disabled="onProcess ? true : false ">Update</button>
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
        el: '#root',
        data: {
            department: {
                id: null,
                name: '',
                slug: '',
                user_id: null,
                user_ip: '',
            },
            departments: [],
            errors: [],
            success: '',
            show: false,
            onProcess : false,
            columns: [
                { label: 'SL', field: 'sl', align: 'center', filterable: false },
                { label: 'Name', field: 'name', align: 'center' },
                { label: 'Created At', field: 'created_at', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 12,
            filter: ''

        },
        filters: {
            formatDateTime(dt, format) {
                return dt == '' || dt == null ? '' : moment(dt).format(format);
            }
        },
        created() {
            this.getDepartment();
        },
        methods: {
            getDepartment() {
                axios.post('/get_department')
                .then(res => {
                    this.departments = res.data.map((item, sl) => {
                        item.sl = sl + 1
                        return item;
                    });
                })
            },
            saveData() {
                this.errors = [];
                if (this.department.name == '') {
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
                if(this.department.id != null) {
                    url = '/update_department';
                }
                else {
                    url = '/save_department';
                    delete this.department.id;
                }
                axios.post(url , this.department)
                .then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    this.resetForm();
                    this.getDepartment();
                    this.onProcess = false;
                    $('#staticBackdrop').modal('hide')
                    setTimeout(() => {
                        this.success = '';
                        this.show = false;
                    }, 3000)
                })
                .catch(err => {
                    console.log(err.response.data.message)
                })
            },
            editDepartment(department) {
                Object.keys(this.department).forEach(item => {
                    this.department[item] = department[item]
                })
                console.log(department)
            },
            deleteDepartment(id) {
                if (confirm('Are You Sure? You Want to Delete this?')) {
                    axios.post('/delete_department', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getDepartment();
                    })
                }
            },
            resetForm() {
                this.department.id = null;
                this.department.name = '';
                this.department.slug = '';
                this.department.user_id = null;
                this.department.user_ip = '';
            }
        },
    })
</script>
@endpush