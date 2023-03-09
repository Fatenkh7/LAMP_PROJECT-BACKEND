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
        Schema::create('profit_goals', function (Blueprint $table) {
            $table->id();
            $table->string('goal_title')->unique();
            $table->integer('goal_amount');
            $table->string('goal_description');
            $table->unsignedBigInteger('currencies_id');
            $table->foreign('currencies_id')->references('id')->on('currencies');
            $table->unsignedBigInteger('admins_id');
            $table->foreign('admins_id')->references('id')->on('admins')->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_goals');
    }
};
