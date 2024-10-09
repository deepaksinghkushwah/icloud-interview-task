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
        Schema::create('financlatrandetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_trans_id')->constrained('financlatrans')->cascadeOnDelete();
            $table->bigInteger('module_id');
            $table->double('amount');
            $table->bigInteger('head_id');
            $table->string('crdr');
            $table->foreignId('br_id')->constrained('branches','id')->cascadeOnDelete();
            $table->string('head_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financlatrandetails');
    }
};
