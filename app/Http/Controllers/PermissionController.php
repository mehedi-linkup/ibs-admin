<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('pages.permission.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'role_id'=>'required|unique:permissions',
        ]);
        Permission::create($request->all());
        session()->flash('success', 'Permission Create successfully!');
        return back();
    }

    public function edit(Permission $permission)
    {
        $roles = Role::all();
        return  view('pages.permission.edit',compact('permission', 'roles'));
    }

 
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'role_id'=>'required|unique:permissions,role_id,'.$permission->id,
        ]);
        $permission->update($request->all());
        session()->flash('success', 'Permission Updated successfully!');
        return redirect()->route('permission.index');
    }

  
    public function destroy(Permission $permission)
    {
        $permission->delete();
        session()->flash('success', 'Permission Delete successfully!');
        return redirect()->route('permission.index');
    }
}
