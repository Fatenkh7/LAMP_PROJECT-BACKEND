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
            $data = $request->only('first_name', 'last_name', 'adminname', 'email', 'password');
            $validator = Validator::make($data, [
                'first_name'=>'required|string|min:3|max:255',
                'last_name'=>'required|string|min:3|max:255',
                'adminname'=>'required|unique:admins|min:3|max:255',
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
            $adminname = $request->input('adminname');
            $email = $request->input('email');
            $password = $request->input('password');

            $admin->first_name = $firstname;
            $admin->last_name = $lastname;
            $admin->adminname = $adminname;
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
            $admin = Admin::all();
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
            // Data validation 
            $data = $request->only('first_name', 'last_name', 'adminname', 'email', 'password');
            $validator = Validator::make($data, [
                'first_name'=>'required|string|min:3|max:255',
                'last_name'=>'required|string|min:3|max:255',
                'adminname'=>'required|unique:admins|min:3|max:255',
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
            $adminname = $request->input('adminname');
            $email = $request->input('email');
            $password = $request->input('password');

            $admin->first_name = $firstname;
            $admin->last_name = $lastname;
            $admin->adminname = $adminname;
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

    public function __construct() {
        $this->middleware('admin:api', ['except' => ['login', 'register','logout','adminProfile']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:admins',
            'username' => 'required|string|max:100|unique:admins',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $admin = Admin::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'admin' => $admin
        ], 201);
    }

    /**
     * Log the admin out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 24*24 * 60,
            'admin' => auth()->user()
        ]);
    }
}
