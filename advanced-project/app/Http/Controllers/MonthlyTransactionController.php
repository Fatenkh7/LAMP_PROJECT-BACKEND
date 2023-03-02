<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FixedTransaction;

class MonthlyTransactionController extends Controller
{
    public function generate()
    {
        // Generate new monthly transactions
        $transactions = $this->generateMonthlyTransactions();

        // Return the transactions to the user interface
        return response()->json(['transactions' => $transactions]);
    }

    protected function generateMonthlyTransactions()
    {
        $transactions = [];

        // Get all fixed transactions that are scheduled monthly
        $fixedTransactions = FixedTransaction::where('schedule', 'monthly')->get();

        // For each fixed transaction, generate a transaction with the fixed amount
        foreach ($fixedTransactions as $fixedTransaction) {
            $transaction = [
                'title' => $fixedTransaction->title,
                'description' => $fixedTransaction->description,
                'amount' => $fixedTransaction->amount,
                'date_time' => now(),
                'type' => $fixedTransaction->type,
                'schedule' => 'monthly',
                'is_paid' => false,
                'fixed_keys_id' => $fixedTransaction->fixed_keys_id,
                'currencies_id' => $fixedTransaction->currencies_id,
                'admins_id' => $fixedTransaction->admins_id,
                'categories_id' => $fixedTransaction->categories_id,
            ];
            array_push($transactions, $transaction);
        }

        return $transactions;
    }
}
