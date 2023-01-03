<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('pages.department.index');
    }

    public function getDepartment()
    {
        return Department::get();
    }

    public function saveDepartment(Request $request)
    {
        $res = new stdClass();
        try {
            $slug = Str::slug($request->name);
            $department = new Department();
            $department->name = $request->name;
            $department->slug = $slug;
            $department->user_id = Auth::user()->id;
            $department->user_ip = $request->ip();
            $department->save();
            $res->message = 'Insert Success';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function UpdateDepartment(Request $request)
    {
        $res = new stdClass();
        try {
            $slug = Str::slug($request->name);
            $department = Department::find($request->id);
            $department->name = $request->name;
            $department->slug = $slug;
            $department->user_id = Auth::user()->id;
            $department->user_ip = $request->ip();
            $department->save();
            $res->message = 'Update Success';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

    public function deleteDepartment(Request $request)
    {
        $res = new stdClass();
        try {
            $department = Department::find($request->id);
            $department->delete();
            $res->message = 'Delete Success';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }

}
