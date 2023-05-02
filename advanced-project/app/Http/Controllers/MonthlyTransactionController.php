<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FixedTransactionController;

class MonthlyTransactionController extends Controller
{
    public function generate()
    {
        // Generate new monthly transactions using the FixedTransactionController
        $fixedController = new FixedTransactionController();
        $transactions = $fixedController->generateMonthlyTransactions();

        // Return the transactions to the user interface
        return response()->json(['transactions' => $transactions]);
    }
}
