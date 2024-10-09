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
        Schema::create('commonfeecollectionheadwises', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('module_id');
            $table->bigInteger("receipt_id");
            $table->bigInteger('head_id');
            $table->string('head_name');
            $table->foreignId('br_id')->constrained('branches','id')->cascadeOnDelete();
            $table->double('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commonfeecollectionheadwises');
    }
};
