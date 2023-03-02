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
        Schema::create('fixed_transactions', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->string('description');
            $table->integer('amount');
            $table->dateTime('date_time');
            $table->enum('type', ['income', 'expense']);
            $table->enum('schedule', ['yearly', 'monthly','weekly']);
            $table->boolean('is_paid')->default(false);;
            $table->unsignedBigInteger('fixed_keys_id');
            $table->foreign('fixed_keys_id')->references('id')->on('fixed_keys');
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
