<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.role.index');
    }

    public function getRole(Request $request)
    {
        return Role::all();
    }

    public function saveRole(Request $request)
    {
        $res = new stdClass();
        try {
            $slug = Str::slug($request->name);
            $role = new Role();
            $role->name = $request->name;
            $role->slug = $slug;
            $role->user_id = Auth::user()->id;
            $role->user_ip = $request->ip();
            $role->save();
            $res->message = 'Insert Success';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function UpdateRole(Request $request)
    {
        $res = new stdClass();
        try {
            $slug = Str::slug($request->name);
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->slug = $slug;
            $role->user_id = Auth::user()->id;
            $role->user_ip = $request->ip();
            $role->save();
            $res->message = 'Update Success';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteRole(Request $request)
    {
        $res = new stdClass();
        try {
            $role = Role::find($request->id);
            $role->delete();
            $res->message = 'Delete Success';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
