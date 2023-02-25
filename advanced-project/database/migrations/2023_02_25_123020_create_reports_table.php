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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report');
            $table->enum('type_report', ['yearly', 'monthly', 'weekly']);
            $table->unsignedBigInteger('admins_id');
            $table->foreign('admins_id')->references('id')->on('admins')->onDelete('cascade');
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
