<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecurringIncome;

class RecurringIncomeController extends Controller
{
    // Add a Recurring Income
    public function addRecurringIncome(Request $request) {
        $recurringIncome = new RecurringIncome;
        $title = $request->input('title');
        $description = $request->input('description');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $recurringIncome->title = $title;
        $recurringIncome->description = $description;
        $recurringIncome->amount = $amount;
        $recurringIncome->currency = $currency;
        $recurringIncome->start_date = $startDate;
        $recurringIncome->end_date = $endDate;
        $recurringIncome->save();
        return response()->json([
            'message' => 'Recurring Income added successfully'
        ]);
    }

    // Get a Recurring Income By ID
    public function getRecurringIncomeById(Request $request, $id) {
        $recurringIncome = RecurringIncome::find($id);
        return response()->json([
            'message' => $recurringIncome
        ]);
    }

    // Get all Recurring Incomes
    public function getAllRecurringIncomes(Request $request) {
        $recurringIncome = RecurringIncome::all();
        return response()->json([
            'message' => $recurringIncome
        ]);
    }

    // Update a Recurring Income By ID
    public function editRecurringIncome(Request $request, $id) {
        $recurringIncome = RecurringIncome::find($id);
        $inputs = $request->except('_method');
        $recurringIncome->update($inputs);
        
        return response()->json([
            'message' => 'Recurring Income updated successfully',
            'Recurring Income' => $recurringIncome,
        ]);
    }

    // Delete a Recurring Income By ID
    public function deleteRecurringIncome(Request $request, $id) {
        $recurringIncome = RecurringIncome::find($id);
        $recurringIncome->delete();
        return response()->json([
            'message' => 'Recurring Income deleted successfully',
        ]);
    }
}
