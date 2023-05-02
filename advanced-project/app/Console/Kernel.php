<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\FixedTransaction;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            // Generate new monthly transactions
            $transactions = self::generateMonthlyTransactions();
            // Save transactions to the database
            FixedTransaction::insert($transactions);
        })->monthly();
    }
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Generate monthly transactions.
     */
    public static function generateMonthlyTransactions()
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
