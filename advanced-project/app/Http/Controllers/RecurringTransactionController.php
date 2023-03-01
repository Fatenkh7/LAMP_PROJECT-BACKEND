<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\RecurringTransaction;
use App\Models\Admin;
use App\Models\Currency;
use App\Models\Category;


class RecurringTransactionController extends Controller
{
    public function addRecurringTransaction(Request $request) {

        try {
            $data = $request->only('name', 'description', 'amount', 'start_date', 'end_date', 'categories_id', 'admins_id', 'currencies_id', 'type', 'is_paid');
            $validator = Validator::make($data, [
                'name'=>'required|string|max:255',
                'description'=>'required|string|max:255',
                'amount'=>'required|integer',
                'start_date'=>'required|date',
                'end_date'=>'required|date|after_or_equal:start_date',
                'categories_id'=>'required|exists:categories,id',
                'admins_id'=>'required|exists:admins,id',
                'currencies_id'=>'required|exists:currencies,id',
                'type'=>'required|in:income,expense',
                'is_paid'=>'required|boolean',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->toArray();
                return $error;
            }

            $recurringTransaction = new recurringTransaction;
            $name = $request->input('name');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $type = $request->input('type');
            $is_paid = $request->input('is_paid');
            $admins_id = $request->input('admins_id');
            $categories_id = $request->input('categories_id');
            $currencies_id = $request->input('currencies_id');
            $admins = Admin::find($admins_id);
            $categories = Category::find($categories_id);
            $currencies = Currency::find($currencies_id);
            $recurringTransaction->admins()->associate($admins);
            $recurringTransaction->categories()->associate($categories);
            $recurringTransaction->currencies()->associate($currencies);

            $recurringTransaction->name = $name;
            $recurringTransaction->description = $description;
            $recurringTransaction->amount = $amount;
            $recurringTransaction->start_date = $start_date;
            $recurringTransaction->end_date = $end_date;
            $recurringTransaction->type = $type;
            $recurringTransaction->is_paid = $is_paid;

            $recurringTransaction->save();
            return response()->json([
                'message' => 'Recurring Transaction created successfully'
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function editRecurringTransaction(Request $request, $id) {
        try {
            // Check if the id is valid
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Recurring Transaction ID'
                ], 400);
            }

            // Check if the Recurring Transaction exists
            $recurringTransaction = RecurringTransaction::find($id);
            if (!$recurringTransaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recurring Transaction not found'
                ], 404);
            }

            // Validate the request inputs
            $data = $request->only('name', 'description', 'amount', 'start_date', 'end_date', 'type', 'is_paid');
            $validator = Validator::make($data, [
                'name'=>'required|string|max:255',
                'description'=>'required|string|max:255',
                'amount'=>'required|integer',
                'start_date'=>'required|date',
                'end_date'=>'required|date|after_or_equal:start_date',
                'type'=>'required|in:income,expense',
                'is_paid'=>'required|boolean',
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->toArray();
                return $error;
            }

            // Update the Recurring Transaction
            $name = $request->input('name');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $type = $request->input('type');
            $is_paid = $request->input('is_paid');
            
            $recurringTransaction->name = $name;
            $recurringTransaction->description = $description;
            $recurringTransaction->amount = $amount;
            $recurringTransaction->start_date = $start_date;
            $recurringTransaction->end_date = $end_date;
            $recurringTransaction->type = $type;
            $recurringTransaction->is_paid = $is_paid;

            $recurringTransaction->update();
            return response()->json([
                'message' => 'Recurring Transaction udpated successfully',
                'Recurring Transaction' => $recurringTransaction,
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllRecurringTransactions(Request $request) {
        try {
            $recurringTransaction = RecurringTransaction::all();
            return response()->json([
                'message' => $recurringTransaction
            ]); 
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getRecurringTransactionById(Request $request, $id) {
        try {  
            // Check if the id is valid
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Recurring Transaction ID'
                ], 400);
            }

            // Check if the Recurring Transaction exists
            $recurringTransaction = RecurringTransaction::find($id);
            if (!$recurringTransaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recurring Transaction not found'
                ], 404);
            }

            $recurringTransaction = RecurringTransaction::where('id',$id)->with(['admins', 'categories', 'currencies'])->get();
            return response()->json([
                'message' => $recurringTransaction
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
