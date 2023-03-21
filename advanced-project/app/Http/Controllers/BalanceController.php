<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FixedTransaction;
use App\Models\RecurringTransaction;

class BalanceController extends Controller
{
    public function calculateTheFixing()
    {
        $totalIncome = FixedTransaction::where('type', 'income')->sum('amount');

        $totalExpense = FixedTransaction::where('type', 'expense')->sum('amount');
        $fixing_balance = $totalIncome - $totalExpense;

        return response()->json(["The fixing balance" => $fixing_balance]);
    }

    public function calculateTheRecurring()
    {
        $totalIncome = RecurringTransaction::where('type', 'income')->sum('amount');

        $totalExpense = RecurringTransaction::where('type', 'expense')->sum('amount');
        $recurring_balance = $totalIncome - $totalExpense;

        return response()->json(["The recurring balance" => $recurring_balance]);
    }

    public function balance()
    {
        $fixed_response = BalanceController::calculateTheFixing();
        $fixed_data = $fixed_response->original;
        $fixed = $fixed_data["The fixing balance"];

        $recurring_response = BalanceController::calculateTheRecurring();
        $recurring_data = $recurring_response->original;
        $recurring = $recurring_data["The recurring balance"];

        $difference = $fixed + $recurring;

        return response()->json(["difference" => $difference]);
    }
}
