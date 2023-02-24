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


        Schema::create('fixed_expenses', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->string('description');
            $table->integer('amount');
            $table->integer('currency');
            $table->date('date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('fixed_expenses');

    }
};
