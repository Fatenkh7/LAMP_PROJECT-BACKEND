<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    public function addAdmin(Request $request) {
        $admin = new Admin;
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');

        $admin->first_name = $firstname;
        $admin->last_name = $lastname;
        $admin->username = $username;
        $admin->email = $email;
        $admin->password = Hash::make($password);

        $admin->save();
        return response()->json([
            'message' => 'Admin created successfully'
        ]);
    }

    public function getAdmin(Request $request, $id) {
        $admin = Admin::find($id)->get();
        return response()->json([
            'message' => $admin
        ]);
    }

    public function editAdmin(Request $request, $id) {
        $admin = Admin::find($id);
        $inputs = $request->except('_method');
        $admin->update($inputs);

        return response()->json([
            'message' => 'Admin updated successfully',
            'admin' => $admin,
        ]);
    }

    public function deleteAdmin(Request $request, $id) {
        $admin = Admin::find($id);
        $admin->delete();
        return response()->json([
            'message' => 'Admin deleted successfully',
        ]);
    }
}
