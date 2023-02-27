<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function addcategory(Request $request){
        try {
            $data = $request->only('category','category_description');
            $validator = Validator::make($data, [
                'category'=>'required|string|min:3|max:25',
                'category_description'=>'required|string|min:3|max:350',
                'admins_id' => 'required|exists:admins,id',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $category = new Category();
            $admins_id = $request->input('admins_id');
            $admins = Admin::find($admins_id);
            $category->admins()->associate($admins);
            $category = $request->input('category');
            $category->category = $category;
            $category_description = $request->input('category_description');
            $category->category_description = $category_description;
           
            $category->save();
            return response()->json([
                'message' => 'Category created successfully'
            ]);
        }
        catch(\Exception $e) {
            return $e->getMessage();
          }
     
    }
    public function getAll(Request $request){
        try {
            $category = Category::all();
            return response()->json([
                'message' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving category',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getcategory(Request $request, $id) {
        try {
            $data = $request->only('category','category_description');
            $validator = Validator::make($data, [
                'category'=>'required|string|min:3|max:27',
                'category_description'=>'required|string|min:3|max:350',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $category = Category::find($id)->get();
        return response()->json([
            'message' => $category,
        ]);
        }
        catch(\Exception $e) {
            return $e->getMessage();
          }
      
        
    }
    public function editcategory(Request $request, $id) {
        try {
            $data = $request->only('category','category_description');
            $validator = Validator::make($data, [
                'category'=>'required|string|min:3|max:27',
                'category_description'=>'required|string|min:3|max:350',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $category = Category::find($id);
            $inputs = $request->except('_method');
            $category->update($inputs);
    
            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category,
            ]);
        }
        catch(\Exception $e) {
            return $e->getMessage();
          }
     
    }
    public function deletecategory(Request $request, $id) {
        try {
            $data = $request->only('category','category_description');
            $validator = Validator::make($data, [
                'category'=>'required|string|min:3|max:27',
                'category_description'=>'required|string|min:3|max:350',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $category = Category::find($id);
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully',
            ]);
        
        }
        catch(\Exception $e) {
            return $e->getMessage();
          }
       
    }
    
}
