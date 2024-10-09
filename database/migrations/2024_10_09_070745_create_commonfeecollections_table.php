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
        Schema::create('commonfeecollections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('moduleid');
            $table->bigInteger('transid');
            $table->string('admno');
            $table->string('rollno');
            $table->double('amount');
            $table->foreignId('br_id')->constrained('branches','id')->cascadeOnDelete();
            $table->string('acadamic_year');
            $table->string('financial_year');
            $table->string('display_receipt_no');
            $table->string('entrymode');
            $table->date('paid_date');
            $table->string('inactive');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commonfeecollections');
    }
};
