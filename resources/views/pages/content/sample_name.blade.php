@extends('layouts.master')
@section('title', 'Sample Name List')
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Sample Name</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-table me-1"></i> Sample Name List</div>
                @isset(Auth::user()->role->permission['permission']['sample_name']['add'])
                    <button type="button" class="btn btn-addnew shadow-none" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="fa fa-plus"></i> add new</button>
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
                            <th>Sample Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @isset(Auth::user()->role->permission['permission']['sample_name']['list'])
                    <tbody class="text-center">
                        <tr v-for="(item, i) in samples" :key="i">
                            <td>@{{ item.sl }}</td>
                            <td>@{{ item.name }}</td>
                            <td>
                                @{{ item.created_at | formatDateTime('DD-MM-YYYY') }} @{{ item.created_at | formatDateTime('h:mm A') }}
                            </td>
                            <td class="text-center">
                                @isset(Auth::user()->role->permission['permission']['sample_name']['edit'])
                                    <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-edit shadow-none" @@click.prevent="editSampleName(item)"><i class="fas fa-pencil-alt"></i></button>
                                @endisset
                                @isset(Auth::user()->role->permission['permission']['sample_name']['delete'])
                                    <button class="btn btn-delete shadow-none" @@click.prevent="deleteSampleName(item.id)"><i class="fa fa-trash"></i></button>
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
                        <h5 class="modal-title" id="staticBackdropLabel">Add Sample Name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length">
                            <div class="alert alert-danger" v-for="(error, i) in errors" :key="i">@{{ error }}</div>
                        </div>
                        <div class="form-group row">
                            <label for="inpuName" class="col-sm-4 ">Smaple Name</label>
                            <div class="col-sm-8">
                                <input type="text" v-model="sample.name" class="form-control form-control-sm shadow-none" id="inpuName">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-dark btn-sm shadow-none">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm shadow-none" v-if="sample.id == null" :disabled="onProcess ? true : false">Save</button>
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
            sample: {
                id: null,
                name: '',
            },
            samples: [],
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
            this.getSamples();
        },
        methods: {
            getSamples() {
                axios.post('/get_sample_name')
                .then(res => {
                    this.samples = res.data.map((item, sl) => {
                        item.sl = sl + 1
                        return item;
                    });
                })
            },
            saveData() {
                this.errors = [];
                if (this.sample.name == '') {
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
                if(this.sample.id != null) {
                    url = '/update_sample_name';
                }
                else {
                    url = '/save_sample_name';
                    delete this.sample.id;
                }
                axios.post(url , this.sample)
                .then(res => {
                    this.success = res.data.message;
                    this.show = true;
                    this.resetForm();
                    this.getSamples();
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
            editSampleName(sample) {
                Object.keys(this.sample).forEach(item => {
                    this.sample[item] = sample[item]
                })
                console.log(sample)
            },
            deleteSampleName(id) {
                if (confirm('Are You Sure? You Want to Delete this?')) {
                    axios.post('/delete_sample_name', {id: id})
                    .then(res => {
                        let r = res.data
                        alert(r.message);
                        this.getSamples();
                    })
                }
            },
            resetForm() {
                this.sample = {
                    id: null,
                    name: '',
                }
            }
        },
    })
</script>
@endpush