<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\User;
use App\Utils;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    use Utils;
    public function register() 
    {
        return view('auth.register');
    }

    public function getUser()
    {
        return User::with(['role', 'coordinator'])->latest()->get();
    }

    public function SaveUser(Request $request)
    {
        // dd($request->all());
        $res = new stdClass();
        try {
            // return $request->all();
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->role_id = $request->role_id;
            $user->merchant_id = $request->merchant_id;
            $user->coordinator_id = $request->coordinator_id;
            $user->wash_coordinator_id = $request->wash_coordinator_id;
            $user->finishing_coordinator_id = $request->finishing_coordinator_id;
            $user->wash_unit_id = $request->wash_unit_id;
            $user->cad_id = $request->cad_id;
            $user->gm = $request->gm;
            $user->image = $this->imageUpload($request, 'image', 'uploads/user');
            $user->save();
            $res->message = 'Successfully Saved!';
        } catch (\Exception $e) {
            $res->message = 'Failed !' . 'someThing went wrong!'.$e->getMessage();
        }
        return response(['message' => $res->message]);
    }

    public function updateUser(Request $request)
    {
        $res = new stdClass();
        try {

            $user = User::find($request->id);

            $userImage = $user->image;
            if ($request->hasFile('image')) {
                if (!empty($user->image) && file_exists($user->image)) unlink($user->image);
                $userImage = $this->imageUpload($request, 'image', 'uploads/user');
            } 
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->role_id = $request->role_id;
            $user->password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->coordinator_id = $request->coordinator_id;
            $user->merchant_id = $request->merchant_id;
            $user->wash_coordinator_id = $request->wash_coordinator_id;
            $user->finishing_coordinator_id = $request->finishing_coordinator_id;
            $user->wash_unit_id = $request->wash_unit_id;
            $user->cad_id = $request->cad_id;
            $user->gm = $request->gm;
            $user->image = $userImage;
            $user->save();
            $res->message = 'Successfully Update!';

        } catch (\Exception $e) {

            $res->message = 'Failed!' . $e->getMessage();
        }
        return response(['message' => $res->message]);
    }

    public function deleteUser(Request $request)
    {
        $res = new stdClass();
        try {
            $user = User::find($request->id);
            $user->delete();
            $res->message = 'Delete Success';
        } catch (\Exception $e) {
            $res->message = 'Failed' . $e->getMessage();
        }
        return response(['message' => $res->message ]);
    }
}
