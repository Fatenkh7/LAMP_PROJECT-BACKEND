<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

class AdminController extends Controller
{
    // Add Admin
    public function addAdmin(Request $request) {

        try {
            // Data validation 
            $data = $request->only('first_name', 'last_name', 'username', 'email', 'password','is_super');
            $validator = Validator::make($data, [
                'first_name'=>'required|string|min:3|max:255',
                'last_name'=>'required|string|min:3|max:255',
                'username'=>'required|unique:admins|min:3|max:255',
                'is_super'=>'required|boolean',
                'email'=>'required|string|email|max:255|unique:admins',
                'password'=>'required|min:8',
            ]);
            if($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }

            $admin = new Admin;
            $firstname = $request->input('first_name');
            $lastname = $request->input('last_name');
            $username = $request->input('username');
            $is_super = $request->input('is_super');
            $email = $request->input('email');
            $password = $request->input('password');

            $admin->first_name = $firstname;
            $admin->last_name = $lastname;
            $admin->username = $username;
            $admin->is_super = $is_super;
            $admin->email = $email;
            $admin->password = Hash::make($password);

            $admin->save();
            return response()->json([
                'message' => 'Admin created successfully'
            ]);
        }
        catch (\Exception $e) {
        return $e->getMessage();
        }
    }

    // Get Admin By ID
    public function getAdminById(Request $request, $id) {
        try {
            // Check if the id is valid
            if (!is_numeric($id) | !$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Admin ID'
                ], 400);
            }

            // Check if Admin exists
            $admin = Admin::find($id);
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin not found'
                ], 404);
            }

            $admin = Admin::find($id);
            return response()->json([
                'message' => $admin
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    // Get all Admins
    public function getAllAdmins(Request $request) {
        try {
            $admin = Admin::paginate(5);
            return response()->json([
                'message' => $admin
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Update Admin By ID
    public function editAdmin(Request $request, $id) {
        try {
            // Check if the id is valid
            if (!is_numeric($id) | !$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Admin ID'
                ], 400);
            }

            // Check if Admin exists
            $admin = Admin::find($id);
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin not found'
                ], 404);
            }

            // Data validation 
            $data = $request->only('first_name', 'last_name', 'username', 'email', 'password');
            $validator = Validator::make($data, [
                'first_name'=>'required|string|min:3|max:255',
                'last_name'=>'required|string|min:3|max:255',
                'username'=>'required|unique:admins|min:3|max:255',
                'is_super'=>'required|boolean',
                'email'=>'required|string|email|max:255|unique:admins',
                'password'=>'required|min:8',
            ]);
            if($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }

            $admin = Admin::find($id);
            $firstname = $request->input('first_name');
            $lastname = $request->input('last_name');
            $username = $request->input('username');
            $is_super = $request->input('is_super');
            $email = $request->input('email');
            $password = $request->input('password');

            $admin->first_name = $firstname;
            $admin->last_name = $lastname;
            $admin->username = $username;
            $admin->is_super=$is_super;
            $admin->email = $email;
            $admin->password = Hash::make($password);

            $admin->update();
            // $inputs = $request->except('_method');
            // $admin->update($inputs);

            return response()->json([
                'message' => 'Admin updated successfully',
                'admin' => $admin,
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Delete Admin By ID
    public function deleteAdmin(Request $request, $id) {
        try {
            // Check if the id is valid
            if (!is_numeric($id) | !$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Admin ID'
                ], 400);
            }

            // Check if Admin exists
            $admin = Admin::find($id);
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Admin not found'
                ], 404);
            }

            $admin = Admin::find($id);
            $admin->delete();
            return response()->json([
                'message' => 'Admin deleted successfully',
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
