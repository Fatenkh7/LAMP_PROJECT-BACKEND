<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FixedTransaction;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


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

    public function getBy(Request $request)
{
    $validatedData = $request->validate([
        'type' => 'in:'.implode(',', FixedTransaction::$allowedTypes),
        'categories_id' => 'exists:categories,id',
        'schedule' => 'in:'.implode(',', FixedTransaction::$allowedSchedule),
        'admins_id' => 'exists:admins,id',
        'fixed_keys_id' => 'exists:fixed_keys,id',
        'is_paid' => 'in:'.implode(',', FixedTransaction::$allowedPaid),
    ]);
    try {
        $fixed = FixedTransaction::query();

        // Filter by type
        if ($request->has('type') && in_array($request->input('type'), FixedTransaction::$allowedTypes)) {
            $fixed->where('type', $request->input('type'));
        }else

        // Filter by category
        if ($request->has('categories_id')) {
            $fixed->where('categories_id', $request->input('categories_id'));
        }

        // Filter by schedule
        if ($request->has('schedule') && in_array($request->input('schedule'), FixedTransaction::$allowedSchedule)) {
            $fixed->where('schedule', $request->input('schedule'));
        }

        // Filter by admins
        if ($request->has('admins_id')) {
            $fixed->where('admins_id', $request->input('admins_id'));
        }

        // Filter by fixed keys
        if ($request->has('fixed_keys_id')) {
            $fixed->where('fixed_keys_id', $request->input('fixed_keys_id'));
        }

        // Filter by paid
        if ($request->has('is_paid')) {
            $fixed->where('is_paid', $request->input('is_paid'), FixedTransaction::$allowedPaid);
        }

        // Get the filtered fixed transactions
        $filteredFixed = $fixed->get();

        return response()->json([
            'success' => true,
            'data' => $filteredFixed
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}




    public function addfixedTrans(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|string|max:35',
                'description' => 'required|string|max:255',
                'amount' => 'required|integer',
                'date_time' => 'required|date',
                'type' => 'required|in:income,expense',
                'schedule' => 'required|in:yearly,monthly,weekly',
                'is_paid' => 'boolean',
                'admins_id' => 'required|exists:admins,id',
                'categories_id' => 'required|exists:categories,id',
                'currencies_id' => 'required|exists:currencies,id',
                'fixed_keys_id' => 'required|exists:fixed_keys,id',
            ]);

            $new_fixed_transaction = new FixedTransaction();

            $new_fixed_transaction->title = $request->input('title');
            $new_fixed_transaction->description = $request->input('description');
            $new_fixed_transaction->amount = $request->input('amount');
            $new_fixed_transaction->date_time = $request->input('date_time');
            $new_fixed_transaction->type = $request->input('type');
            $new_fixed_transaction->schedule = $request->input('schedule');
            $new_fixed_transaction->is_paid = false;
            $new_fixed_transaction->admins()->associate(Admin::find($request->input('admins_id')));
            $new_fixed_transaction->categories()->associate(Category::find($request->input('categories_id')));
            $new_fixed_transaction->currencies()->associate(Currency::find($request->input('currencies_id')));
            $new_fixed_transaction->fixed_keys()->associate(FixedKey::find($request->input('fixed_keys_id')));
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
                    'message' => 'Fixed transaction not found'
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
                'is_paid' => 'boolean',
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
            $fixed_transaction->is_paid = $request->input('is_paid');
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


    public function editBy(Request $request, $type, $category, $schedule, $admin, $fixed_keys, $is_paid)
    {
        try {
            $fixed = FixedTransaction::query();

            // Filter by type
            if ($type != 'all') {
                $fixed->where('type', $type);
            }

            // Filter by category
            if ($category != 'all') {
                $fixed->whereHas('categories', function ($query) use ($category) {
                    $query->where('id', $category);
                });
            }

            // Filter by schedule
            if ($schedule != 'all') {
                $fixed->where('schedule', $schedule);
            }

            //filter by admins
            if ($admin != 'all') {
                $fixed->whereHas('admins', function ($query) use ($admin) {
                    $query->where('id', $admin);
                });
            }

            //filter by fixed keys
            if ($fixed_keys != 'all') {
                $fixed->whereHas('fixed_keys', function ($query) use ($fixed_keys) {
                    $query->where('id', $fixed_keys);
                });
            }

            //filter by paid
            if ($is_paid != 'all') {
                $fixed->where('is_paid', false);
            }
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:35',
                'description' => 'required|string',
                'amount' => 'required|numeric',
                'date_time' => 'required|date',
                'type' => 'required|in:income,expense',
                'schedule' => 'required|in:yearly,monthly,weekly',
                'is_paid' => 'boolean',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the fixed transaction to update
            $fixed_transaction = FixedTransaction::find($request->input('id'));
            if (!$fixed_transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fixed transaction not found',
                ], 404);
            }

            // Update the fixed transaction
            $fixed_transaction->title = $request->input('title');
            $fixed_transaction->description = $request->input('description');
            $fixed_transaction->amount = $request->input('amount');
            $fixed_transaction->date_time = $request->input('date_time');
            $fixed_transaction->type = $request->input('type');
            $fixed_transaction->schedule = $request->input('schedule');
            $fixed_transaction->is_paid = $request->input('is_paid');
            $fixed_transaction->save();

            return response()->json([
                'success' => true,
                'message' => 'Fixed transaction updated successfully',
                'fixed_transaction' => $fixed_transaction,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating fixed transaction in database'
            ]);
        }
    }


    public function deleteBy(Request $request, $type, $category, $schedule, $admin, $fixed_keys, $is_paid)
    {
        try {
            $fixed = FixedTransaction::query();

            // Filter by type
            if ($type != 'all') {
                $fixed->where('type', $type);
            }

            // Filter by category
            if ($category != 'all') {
                $fixed->whereHas('categories', function ($query) use ($category) {
                    $query->where('id', $category);
                });
            }

            // Filter by schedule
            if ($schedule != 'all') {
                $fixed->where('schedule', $schedule);
            }

            // Filter by admins
            if ($admin != 'all') {
                $fixed->whereHas('admins', function ($query) use ($admin) {
                    $query->where('id', $admin);
                });
            }

            // Filter by fixed keys
            if ($fixed_keys != 'all') {
                $fixed->whereHas('fixed_keys', function ($query) use ($fixed_keys) {
                    $query->where('id', $fixed_keys);
                });
            }

            // Filter by paid
            if ($is_paid != 'all') {
                $fixed->where('is_paid', false);
            }

            // Delete the filtered fixed transactions
            $fixed->delete();

            return response()->json([
                'status' => 200,
                'message' => 'The fixed transactions have been deleted successfully.'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting fixed transactions from database'
            ]);
        }
    }

    public function deleteById(Request $request, $id)
    {
        try {
            $fixed = FixedTransaction::find($id);
            if (!$fixed) {
                return response()->json([
                    'success' => false,
                    'message' => 'fixed transaction not found'
                ], 404);
            }
            $fixed->delete();
            return response()->json([
                'success' => true,
                'message' => 'fixed transaction deleted successfully',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting fixed transaction from database'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting fixed transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
