@extends('layouts.master')
@section('title', 'Role List')
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Permission</span>
        </div>
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fa fa-user-tag me-1"></i> Select Permission</div>
                {{-- <button type="button" class="btn btn-addnew" data-bs-toggle="modal" data-bs-target="#RoleModal"> <i class="fa fa-plus"></i> add new</button> --}}
            </div>
            <div class="card-body table-card-body">
                @if(Auth::user()->username == 'SuperAdmin')
                <form action="{{route('permission.store')}}" method="POST">
                    @csrf
                    <div class="col-md-10 mx-auto my-2">
                        @if (session('error'))
                            <div class="alert alert-danger mt-2 col-md-12">{{ session('error') }}</div>
                        @endif
                        
                        @if (session('success'))
                            <div class="alert alert-success mt-2 col-md-12">{{ session('success') }}</div>
                        @endif
                        <div class="form-group">
                            <label for="">Select a Role <span class="text-danger"> *</span></label>
                            <select name="role_id" class="form-control">
                                <option value="">--- Please select ---</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mt-3">
                                <thead class="text-center bg-light">
                                    <tr>
                                        <th>Permission</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>List</th>
                                        <th>Input-1</th>
                                        <th>Input-2</th>
                                        <th>Input-3</th>
                                        <th>Input-4</th>
                                        <th>Input-5</th>
                                        <th>Input-6</th>
                                        <th>Input-7</th>
                                        <th>Insert/Input-8</th>
                                        <th>Reset</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td class="text-start">Select All</td>
                                        <td><input type="checkbox"  id="select-all" /></td>
                                        <td colspan="13"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Roles</td>
                                        <td><input type="checkbox" name="permission[role][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[role][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[role][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[role][list]" value="1"></td>
                                        <td rowspan="12"></td>
                                        <td rowspan="12"></td>
                                        <td rowspan="12"></td>
                                        <td rowspan="12"></td>
                                        <td rowspan="12"></td>
                                        <td rowspan="12"></td>
                                        <td rowspan="12"></td>
                                        <td rowspan="12"></td>
                                        <td rowspan="12"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Permissions</td>
                                        <td><input type="checkbox" name="permission[permission][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[permission][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[permission][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[permission][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Users</td>
                                        <td><input type="checkbox" name="permission[user][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[user][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[user][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[user][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Buyer</td>
                                        <td><input type="checkbox" name="permission[buyer][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[buyer][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[buyer][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[buyer][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Factory</td>
                                        <td><input type="checkbox" name="permission[factory][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[factory][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[factory][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[factory][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Merchant</td>
                                        <td><input type="checkbox" name="permission[merchant][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[merchant][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[merchant][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[merchant][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Supplier</td>
                                        <td><input type="checkbox" name="permission[supplier][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[supplier][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[supplier][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[supplier][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">GM</td>
                                        <td><input type="checkbox" name="permission[gm][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[gm][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[gm][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[gm][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Sample Name</td>
                                        <td><input type="checkbox" name="permission[sample_name][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_name][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_name][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_name][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Color</td>
                                        <td><input type="checkbox" name="permission[color][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[color][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[color][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[color][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Unit</td>
                                        <td><input type="checkbox" name="permission[unit][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[unit][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[unit][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[unit][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Department</td>
                                        <td><input type="checkbox" name="permission[department][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[department][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[department][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[department][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Product</td>
                                        <td><input type="checkbox" name="permission[product][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[product][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[product][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[product][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Product Data</td>
                                        <td><input type="checkbox" name="permission[product_data][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[product_data][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[product_data][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[product_data][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Order</td>
                                        <td><input type="checkbox" name="permission[order][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Order Data</td>
                                        <td><input type="checkbox" name="permission[order_data][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_data][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_data][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_data][list]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Order Details</td>
                                        <td><input type="checkbox" name="permission[order_details][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_details][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_details][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_details][list]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_details][input]" value="1"></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Order Details Data</td>
                                        <td><input type="checkbox" name="permission[order_details_data][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_details_data][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_details_data][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[order_details_data][list]" value="1"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Sample Cor</td>
                                        <td><input type="checkbox" name="permission[coordinator][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[coordinator][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[coordinator][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[coordinator][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Wash Cor</td>
                                        <td><input type="checkbox" name="permission[wash_coordinator][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[wash_coordinator][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[wash_coordinator][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[wash_coordinator][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Finishing Cor</td>
                                        <td><input type="checkbox" name="permission[finish_coordinator][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[finish_coordinator][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[finish_coordinator][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[finish_coordinator][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Wash Unit</td>
                                        <td><input type="checkbox" name="permission[wash_unit][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[wash_unit][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[wash_unit][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[wash_unit][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">CAD Designer</td>
                                        <td><input type="checkbox" name="permission[cad_designer][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[cad_designer][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[cad_designer][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[cad_designer][list]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Sample</td>
                                        <td><input type="checkbox" name="permission[sample][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample][list]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample][cad]" value="1"></td>
                                        <td colspan="8"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Sample Data</td>
                                        <td><input type="checkbox" name="permission[sample_data][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][list]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-1]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-2]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-3]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-4]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-5]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-6]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-7]" value="1"></td>
                                        <td><input type="checkbox" name="permission[sample_data][sample_insert]" value="1"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Materials Data</td>
                                        <td><input type="checkbox" name="permission[meterials_data][add]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][edit]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][delete]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][list]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-1]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-2]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-3]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-4]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-5]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-6]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-7]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-8]" value="1"></td>
                                        <td><input type="checkbox" name="permission[meterials_data][reset]" value="1"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                @endif
                <div class="col-md-6 mx-auto">
                    <div class="card my-3">
                        <div class="card-header d-flex justify-content-between">
                            <div class="table-head"><i class="fas fa-table me-1"></i>Permission List</div>
                        </div>
                        <div class="card-body table-card-body">
                            <table class="table table-bordered table-hover">
                                <thead class="text-center bg-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @isset(Auth::user()->role->permission['permission']['permission']['list'])
                                <tbody class="text-center">
                                    @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->role->name }}</td>
                                        <td class="text-center">
                                            @if ($permission->role->id != 1)
                                            @csrf
                                            @method('DELETE')
                                            @isset(Auth::user()->role->permission['permission']['permission']['edit'])
                                                <a href="{{route('permission.edit',$permission->id)}}" class="btn btn-edit"><i class="fas fa-pencil-alt"></i></a>
                                            @endisset

                                            @isset(Auth::user()->role->permission['permission']['permission']['delete'])
                                                <button class="btn btn-delete" onclick="if(confirm('Are you sure? You want to delete this?')){ event.preventDefault(); document.getElementById('delete-form-{{ $permission->id }}').submit(); } else { event.preventDefault();}"><i class="fa fa-trash"></i></button>
                                                <form id="delete-form-{{ $permission->id }}" action="{{route('permission.destroy',$permission->id)}}" style="display: none;" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endisset
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endisset
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</main>
@endsection
@push('js')
<script>
    // flash message timer
    $("document").ready(function(){
        setTimeout(function(){
            $("div.alert").remove();
        }, 3000 ); // 5 secs
    });

    // Listen for click on toggle checkbox
    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;                       
            });
        }
    }); 
</script>
@endpush