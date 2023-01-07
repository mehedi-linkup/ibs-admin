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
                <a href="{{ route('permission.index') }}" class="btn btn-addnew"> Permission List</a>
            </div>
            <div class="card-body table-card-body">
                <form action="{{route('permission.update', $permission)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-10 mx-auto my-2">
                        <div class="form-group">
                            <label for="">Select a Role <span class="text-danger"> *</span></label>
                            <select name="role_id" class="form-control">
                                <option value="">--- Please select ---</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{ $role->id == $permission->role_id ? 'selected' : '' }}>{{$role->name}}</option>
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
                                        <th>Input-8</th>
                                        <th>Insert</th>
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
                                        <td><input type="checkbox" name="permission[role][add]"  @isset($permission['permission']['role']['add']) checked @endisset value="1"></td>
                                        <td><input type="checkbox" name="permission[role][edit]"  @isset($permission['permission']['role']['edit']) checked @endisset value="1"></td>
                                        <td><input type="checkbox" name="permission[role][delete]"  @isset($permission['permission']['role']['delete']) checked @endisset value="1"></td>
                                        <td><input type="checkbox" name="permission[role][list]"  @isset($permission['permission']['role']['list']) checked @endisset value="1"></td>
                                        <td rowspan="12"></td>
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
                                        <td><input type="checkbox" name="permission[permission][add]" value="1"  @isset($permission['permission']['permission']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[permission][edit]" value="1"  @isset($permission['permission']['permission']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[permission][delete]" value="1"  @isset($permission['permission']['permission']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[permission][list]" value="1"  @isset($permission['permission']['permission']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Users</td>
                                        <td><input type="checkbox" name="permission[user][add]" value="1"  @isset($permission['permission']['user']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[user][edit]" value="1"  @isset($permission['permission']['user']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[user][delete]" value="1"  @isset($permission['permission']['user']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[user][list]" value="1"  @isset($permission['permission']['user']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Buyer</td>
                                        <td><input type="checkbox" name="permission[buyer][add]" value="1" @isset($permission['permission']['buyer']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[buyer][edit]" value="1" @isset($permission['permission']['buyer']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[buyer][delete]" value="1" @isset($permission['permission']['buyer']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[buyer][list]" value="1" @isset($permission['permission']['buyer']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Factory</td>
                                        <td><input type="checkbox" name="permission[factory][add]" value="1" @isset($permission['permission']['factory']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[factory][edit]" value="1" @isset($permission['permission']['factory']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[factory][delete]" value="1" @isset($permission['permission']['factory']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[factory][list]" value="1" @isset($permission['permission']['factory']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Merchant</td>
                                        <td><input type="checkbox" name="permission[merchant][add]" value="1" @isset($permission['permission']['merchant']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[merchant][edit]" value="1" @isset($permission['permission']['merchant']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[merchant][delete]" value="1" @isset($permission['permission']['merchant']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[merchant][list]" value="1" @isset($permission['permission']['merchant']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Supplier</td>
                                        <td><input type="checkbox" name="permission[supplier][add]" value="1" @isset($permission['permission']['supplier']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[supplier][edit]" value="1" @isset($permission['permission']['supplier']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[supplier][delete]" value="1" @isset($permission['permission']['supplier']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[supplier][list]" value="1" @isset($permission['permission']['supplier']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">GM</td>
                                        <td><input type="checkbox" name="permission[gm][add]" value="1" @isset($permission['permission']['gm']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[gm][edit]" value="1" @isset($permission['permission']['gm']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[gm][delete]" value="1" @isset($permission['permission']['gm']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[gm][list]" value="1" @isset($permission['permission']['gm']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Sample Name</td>
                                        <td><input type="checkbox" name="permission[sample_name][add]" value="1" @isset($permission['permission']['sample_name']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_name][edit]" value="1" @isset($permission['permission']['sample_name']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_name][delete]" value="1" @isset($permission['permission']['sample_name']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_name][list]" value="1" @isset($permission['permission']['sample_name']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Color</td>
                                        <td><input type="checkbox" name="permission[color][add]" value="1" @isset($permission['permission']['color']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[color][edit]" value="1" @isset($permission['permission']['color']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[color][delete]" value="1" @isset($permission['permission']['color']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[color][list]" value="1" @isset($permission['permission']['color']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Unit</td>
                                        <td><input type="checkbox" name="permission[unit][add]" value="1" @isset($permission['permission']['unit']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[unit][edit]" value="1" @isset($permission['permission']['unit']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[unit][delete]" value="1" @isset($permission['permission']['unit']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[unit][list]" value="1" @isset($permission['permission']['unit']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Department</td>
                                        <td><input type="checkbox" name="permission[department][add]" value="1" @isset($permission['permission']['department']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[department][edit]" value="1" @isset($permission['permission']['department']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[department][delete]" value="1" @isset($permission['permission']['department']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[department][list]" value="1" @isset($permission['permission']['department']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Product</td>
                                        <td><input type="checkbox" name="permission[product][add]" value="1" @isset($permission['permission']['product']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[product][edit]" value="1" @isset($permission['permission']['product']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[product][delete]" value="1" @isset($permission['permission']['product']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[product][list]" value="1" @isset($permission['permission']['product']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Product Data</td>
                                        <td><input type="checkbox" name="permission[product_data][add]" value="1" @isset($permission['permission']['product_data']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[product_data][edit]" value="1" @isset($permission['permission']['product_data']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[product_data][delete]" value="1" @isset($permission['permission']['product_data']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[product_data][list]" value="1" @isset($permission['permission']['product_data']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Order</td>
                                        <td><input type="checkbox" name="permission[order][add]" value="1" @isset($permission['permission']['order']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order][edit]" value="1" @isset($permission['permission']['order']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order][delete]" value="1" @isset($permission['permission']['order']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order][list]" value="1" @isset($permission['permission']['order']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Order Data</td>
                                        <td><input type="checkbox" name="permission[order_data][add]" value="1" @isset($permission['permission']['order_data']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_data][edit]" value="1" @isset($permission['permission']['order_data']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_data][delete]" value="1" @isset($permission['permission']['order_data']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_data][list]" value="1" @isset($permission['permission']['order_data']['list']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Order Details</td>
                                        <td><input type="checkbox" name="permission[order_details][add]" value="1" @isset($permission['permission']['order_details']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_details][edit]" value="1" @isset($permission['permission']['order_details']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_details][delete]" value="1" @isset($permission['permission']['order_details']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_details][list]" value="1" @isset($permission['permission']['order_details']['list']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_details][input]" value="1" @isset($permission['permission']['order_details']['input']) checked @endisset></td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="text-start">Order Details Data</td>
                                        <td><input type="checkbox" name="permission[order_details_data][add]" value="1" @isset($permission['permission']['order_details_data']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_details_data][edit]" value="1" @isset($permission['permission']['order_details_data']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_details_data][delete]" value="1" @isset($permission['permission']['order_details_data']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[order_details_data][list]" value="1" @isset($permission['permission']['order_details_data']['list']) checked @endisset></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Coordinator</td>
                                        <td><input type="checkbox" name="permission[coordinator][add]" value="1" @isset($permission['permission']['coordinator']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[coordinator][edit]" value="1" @isset($permission['permission']['coordinator']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[coordinator][delete]" value="1" @isset($permission['permission']['coordinator']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[coordinator][list]" value="1" @isset($permission['permission']['coordinator']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Wash Coordinator</td>
                                        <td><input type="checkbox" name="permission[wash_coordinator][add]" value="1" @isset($permission['permission']['wash_coordinator']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[wash_coordinator][edit]" value="1" @isset($permission['permission']['wash_coordinator']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[wash_coordinator][delete]" value="1" @isset($permission['permission']['wash_coordinator']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[wash_coordinator][list]" value="1" @isset($permission['permission']['wash_coordinator']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Finishing Coordinator</td>
                                        <td><input type="checkbox" name="permission[finish_coordinator][add]" value="1" @isset($permission['permission']['finish_coordinator']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[finish_coordinator][edit]" value="1" @isset($permission['permission']['finish_coordinator']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[finish_coordinator][delete]" value="1" @isset($permission['permission']['finish_coordinator']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[finish_coordinator][list]" value="1" @isset($permission['permission']['finish_coordinator']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Wash Unit</td>
                                        <td><input type="checkbox" name="permission[wash_unit][add]" value="1" @isset($permission['permission']['wash_unit']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[wash_unit][edit]" value="1" @isset($permission['permission']['wash_unit']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[wash_unit][delete]" value="1" @isset($permission['permission']['wash_unit']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[wash_unit][list]" value="1" @isset($permission['permission']['wash_unit']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">CAD Designer</td>
                                        <td><input type="checkbox" name="permission[cad_designer][add]" value="1" @isset($permission['permission']['cad_designer']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[cad_designer][edit]" value="1" @isset($permission['permission']['cad_designer']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[cad_designer][delete]" value="1" @isset($permission['permission']['cad_designer']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[cad_designer][list]" value="1" @isset($permission['permission']['cad_designer']['list']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Sample</td>
                                        <td><input type="checkbox" name="permission[sample][add]" value="1" @isset($permission['permission']['sample']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample][edit]" value="1" @isset($permission['permission']['sample']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample][delete]" value="1" @isset($permission['permission']['sample']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample][list]" value="1" @isset($permission['permission']['sample']['list']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample][cad]" value="1" @isset($permission['permission']['sample']['cad']) checked @endisset></td>
                                        <td colspan="9"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Sample Data</td>
                                        <td><input type="checkbox" name="permission[sample_data][add]" value="1" @isset($permission['permission']['sample_data']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][edit]" value="1" @isset($permission['permission']['sample_data']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][delete]" value="1" @isset($permission['permission']['sample_data']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][list]" value="1" @isset($permission['permission']['sample_data']['list']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-1]" value="1" @isset($permission['permission']['sample_data']['input-1']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-2]" value="1" @isset($permission['permission']['sample_data']['input-2']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-3]" value="1" @isset($permission['permission']['sample_data']['input-3']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-4]" value="1" @isset($permission['permission']['sample_data']['input-4']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-5]" value="1" @isset($permission['permission']['sample_data']['input-5']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-6]" value="1" @isset($permission['permission']['sample_data']['input-6']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-7]" value="1" @isset($permission['permission']['sample_data']['input-7']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][input-8]" value="1" @isset($permission['permission']['sample_data']['input-8']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][sample_insert]" value="1" @isset($permission['permission']['sample_data']['sample_insert']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[sample_data][reset]" value="1" @isset($permission['permission']['sample_data']['reset']) checked @endisset></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Materials Data</td>
                                        <td><input type="checkbox" name="permission[meterials_data][add]" value="1" @isset($permission['permission']['meterials_data']['add']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][edit]" value="1" @isset($permission['permission']['meterials_data']['edit']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][delete]" value="1" @isset($permission['permission']['meterials_data']['delete']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][list]" value="1" @isset($permission['permission']['meterials_data']['list']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-1]" value="1" @isset($permission['permission']['meterials_data']['input-1']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-2]" value="1" @isset($permission['permission']['meterials_data']['input-2']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-3]" value="1" @isset($permission['permission']['meterials_data']['input-3']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-4]" value="1" @isset($permission['permission']['meterials_data']['input-4']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-5]" value="1" @isset($permission['permission']['meterials_data']['input-5']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-6]" value="1" @isset($permission['permission']['meterials_data']['input-6']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-7]" value="1" @isset($permission['permission']['meterials_data']['input-7']) checked @endisset></td>
                                        <td><input type="checkbox" name="permission[meterials_data][input-8]" value="1" @isset($permission['permission']['meterials_data']['input-8']) checked @endisset></td>
                                        <td></td>
                                        <td><input type="checkbox" name="permission[meterials_data][reset]" value="1" @isset($permission['permission']['meterials_data']['reset']) checked @endisset></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</main>
@endsection
@push('js')
<script>
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