<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    public function addcategory(Request $request)
    {
        try {
            $data = $request->only('category', 'category_description', 'admins_id');
            $validator = Validator::make($data, [
                'category' => 'required|string|min:3|max:25',
                'category_description' => 'required|string|min:3|max:350',
                'admins_id' => 'required|exists:admins,id',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }

            $admins_id = $request->input('admins_id');
            $admins = Admin::find($admins_id);

            $category = new Category();
            $category->category = $request->input('category');
            $category->category_description = $request->input('category_description');
            $category->admins()->associate($admins);

            $category->save();

            return response()->json([
                'message' => 'Category created successfully'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAll(Request $request)
    {
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
    public function getById(Request $request, $id)
    {
        try {
            // Check if the id is valid
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Category ID'
                ], 400);
            }

            // Check if Category exists
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $category = Category::where('id',$id)->with(['admins'])->get();
            return response()->json([
                'message' => $category
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving getting report from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Report not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function getByCategory(Request $request, $name)
    {
        try {
            // Check if the name is valid
            if (!is_string($name) || !$name) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Category name'
                ], 400);
            }

            // Check if the category exists
            $category = Category::where('category', $name)->paginate(5);
            if ($category->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Categories not found'
                ], 404);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $category
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving Categories',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function editById(Request $request, $id)
    {
        try {
            // Check if the id is valid
            if (!is_numeric($id) || !$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Category ID'
                ], 400);
            }

            // Check if Category exists
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $data = $request->only('category', 'category_description');
            $validator = Validator::make($data, [
                'category' => 'required|string|min:3|max:27',
                'category_description' => 'required|string|min:3|max:350',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $category = Category::find($id);
            $inputs = $request->except('_method');
            $category->update($inputs);

            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $inputs,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function editByName(Request $request, $name)
    {
        try {
            // Check if the name is valid
            if (!is_string($name)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Category Name'
                ], 400);
            }

            // Check if Category exists
            $category = Category::where('category',$name)->get();
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $data = $request->only('category', 'category_description');
            $validator = Validator::make($data, [
                'category' => 'required|string|min:3|max:27',
                'category_description' => 'required|string|min:3|max:350',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $category = Category::where('category', $name);
            $inputs = $request->except('_method');
            $category->update($inputs);

            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $inputs,
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteCategoryById(Request $request, $id)
    {
        try {
            // Check if the id is valid
            if (!is_numeric($id) || !$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Category ID'
                ], 400);
            }

            // Check if Category exists
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $category = Category::find($id);
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully',
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function deleteCategoryByName(Request $request, $name)
    {
        try {
            // Check if the name is valid
            if (!is_string($name)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Category Name'
                ], 400);
            }

            // Check if Category exists
            $category = Category::where('category',$name);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            // $category = Category::where('category', $name);
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully',
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
