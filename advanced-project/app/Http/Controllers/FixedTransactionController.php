<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FixedTransaction;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

use App\Models\Admin;
use App\Models\Currency;
use App\Models\Category;
use App\Models\FixedKey;

class FixedTransactionController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $fixed_transaction = FixedTransaction::all();
            return response()->json([
                'message' => $fixed_transaction
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving fixed transaction from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving fixed transaction',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getById(Request $request, $id)
    {
        try {
            $fixed_transaction = FixedTransaction::findOrFail($id);
            return response()->json([
                'message' => $fixed_transaction
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving getting fixed transaction from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'fixed transaction not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function getBy(Request $request, $type, $category, $schedule) {
        try {
            $fixed = FixedTransaction::query();
    
            // Filter by type
            if ($type != 'all') {
                $fixed->where('type', $type);
            }
    
            // Filter by category
            if ($category != 'all') {
                $fixed->whereHas('category', function($q) use ($category) {
                    $q->where('category', $category);
                });
            }            
    
            // Filter by schedule
            if ($schedule != 'all') {
                $fixed->where('schedule', $schedule);
            }
    
            // Get the filtered fixed transactions
            $filteredFixed = $fixed->get();
    
            return response()->json([
                'status' => 200,
                'data' => $filteredFixed
            ]);
        } catch(QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving fixed transactions from database'
            ]);
        }
    }
    
    
    
    public function addfixedTrans(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'amount' => 'required|integer',
                'date_time' => 'required|date',
                'type' => 'required|in:income,expense',
                'schedule' => 'required|in:yearly,monthly,weekly',
                'admins_id' => 'required|exists:admins,id',
                'categories_id' => 'required|exists:categories,id',
                'currencies_id' => 'required|exists:currencies,id',
                'fixed_keys_id' => 'required|exists:fixed_keys,id',

            ]);

            $new_fixed_transaction = new FixedTransaction();
            $title = $request->input('title');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $date_time = $request->input('date_time');
            $type = $request->input('type');
            $schedule = $request->input('schedule');
            $admins_id = $request->input('admins_id');
            $admins = Admin::find($admins_id);

            $categories_id = $request->input('categories_id');
            $categories = Category::find($categories_id);

            $currencies_id = $request->input('currencies_id');
            $currencies = Currency::find($currencies_id);

            $fixed_keys_id = $request->input('fixed_keys_id');
            $fixed_keys = FixedKey::find($fixed_keys_id);

            $new_fixed_transaction->title = $title;
            $new_fixed_transaction->description = $description;
            $new_fixed_transaction->amount = $amount;
            $new_fixed_transaction->date_time = $date_time;
            $new_fixed_transaction->type = $type;
            $new_fixed_transaction->schedule = $schedule;
            $new_fixed_transaction->admins()->associate($admins);
            $new_fixed_transaction->categories()->associate($categories);
            $new_fixed_transaction->currencies()->associate($currencies);
            $new_fixed_transaction->fixed_keys()->associate($fixed_keys);

            $new_fixed_transaction->save();
            return response()->json([
                'message' => 'Fixed transaction created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function editFixedById(Request $request, $id)
    {
        try {
            // Check if the $id correct
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Fixed transaction ID'
                ], 400);
            }

            // Check if the profit_goal exists
            $fixed_transaction = FixedTransaction::find($id);
            if (!$fixed_transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'profit goal not found'
                ], 404);
            }

            // Validate the request inputs
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:35',
                'description' => 'required|integer',
                'amount' => 'required|integer',
                'date_time' => 'required|date',
                'type' => 'required|in:income,expense',
                'schedule' => 'required|in:yearly,monthly,weekly',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update the profit_goal
            $fixed_transaction->title = $request->input('title');
            $fixed_transaction->description = $request->input('description');
            $fixed_transaction->amount = $request->input('amount');
            $fixed_transaction->date_time = $request->input('date_time');
            $fixed_transaction->type = $request->input('type');
            $fixed_transaction->schedule = $request->input('schedule');
            $fixed_transaction->save();

            return response()->json([
                'success' => true,
                'message' => 'Fixed Transaction updated successfully',
                'Fixed Transaction' => $fixed_transaction,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error editing Fixed Transaction from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating Fixed Transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
