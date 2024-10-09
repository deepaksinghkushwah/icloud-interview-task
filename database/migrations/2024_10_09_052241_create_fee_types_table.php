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
        Schema::create('fee_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_category_id')->constrained('fee_categories')->cascadeOnDelete();
            $table->string('f_name');
            $table->foreignId('collection_id')->constrained('fee_collection_types')->cascadeOnDelete();
            $table->foreignId('br_id')->constrained('branches')->cascadeOnDelete();
            $table->bigInteger('seq_id');
            $table->string('fee_type_ledger')->nullable(true);
            $table->bigInteger('fee_headtype')->nullable(true);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_types');
    }
};
