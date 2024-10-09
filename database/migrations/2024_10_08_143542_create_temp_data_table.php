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
        Schema::create('temp_data', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date')->nullable(true);
            $table->string('academic_year')->nullable(true);
            $table->string('session')->nullable(true);
            $table->string('alloted_category')->nullable(true);
            $table->string('voucher_type')->nullable(true);
            $table->string('voucher_no')->nullable(true);
            $table->string('roll_no')->nullable(true);
            $table->string('admno_uniqueid')->nullable(true);
            $table->string('status')->nullable(true);
            $table->string('fee_category')->nullable(true);
            $table->string('faculty')->nullable(true);
            $table->string('program')->nullable(true);
            $table->string('department')->nullable(true);
            $table->string('batch')->nullable(true);
            $table->string('receipt_no')->nullable(true);
            $table->string('fee_head')->nullable(true);
            $table->double('due_amount')->nullable(true);
            $table->double('paid_amount')->nullable(true);
            $table->double('concession_amount')->nullable(true);
            $table->double('scholarship_amount')->nullable(true);
            $table->double('reverse_concession_amount')->nullable(true);
            $table->double('write_off_amount')->nullable(true);
            $table->double('adjusted_amount')->nullable(true);
            $table->double('refund_amount')->nullable(true);
            $table->double('fund_trancfer_amount')->nullable(true);
            $table->text('remark')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_data');
    }
};
