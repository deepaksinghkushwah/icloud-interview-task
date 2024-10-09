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
        Schema::create('financlatrans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('moduleid');
            $table->bigInteger('transid');
            $table->string('admno');
            $table->double('amount');
            $table->string('crdr');
            $table->date('trandate');
            $table->string('acadyear');            
            $table->string('entrymodeno');
            $table->bigInteger('voucherno');
            $table->foreignId('br_id')->constrained('branches','id')->cascadeOnDelete();
            $table->bigInteger('type_of_concession');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financlatrans');
    }
};
