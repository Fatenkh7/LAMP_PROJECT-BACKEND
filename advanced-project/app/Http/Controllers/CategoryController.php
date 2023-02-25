<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function addcategory(Request $request){
        try {
            $data = $request->only('name');
            $validator = Validator::make($data, [
                'name'=>'required|string|min:3|max:255',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $category = new Category();
            $name = $request->input('name');
            $category->name = $name;
            $category->save();
            return response()->json([
                'message' => 'Category created successfully'
            ]);
        }
        catch(\Exception $e) {
            return $e->getMessage();
          }
     
    }
    public function index(Request $request){
        try {
            $data = $request->only('name');
            $validator = Validator::make($data, [
                'name'=>'required|string|min:3|max:255',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                return $errors;
            }
        $category = Category::all();
        return response()->json(([
            'message' => $category,
        ]));
    }
    catch(\Exception $e) {
        return $e->getMessage();
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
