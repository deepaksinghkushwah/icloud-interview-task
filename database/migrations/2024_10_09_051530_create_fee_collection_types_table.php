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
        Schema::create('fee_collection_types', function (Blueprint $table) {
            $table->id();
            $table->string('collection_head');
            $table->string('collection_desc')->nullable(true);
            $table->foreignId('br_id')->constrained('branches')->cascadeOnDelete();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_collection_types');
    }
};
