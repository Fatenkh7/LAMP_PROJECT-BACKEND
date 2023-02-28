<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recurring_transactions', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('description');
            $table->enum('type', ['income', 'expense']);
            $table->enum('schedule', ['yearly', 'monthly', 'weekly']);
            $table->integer('amount');
            $table->date('startDate');
            $table->date('endDate');
            $table->unsignedBigInteger('currencies_id');
            $table->foreign('currencies_id')->references('id')->on('currencies');
            $table->unsignedBigInteger('admins_id');
            $table->foreign('admins_id')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
