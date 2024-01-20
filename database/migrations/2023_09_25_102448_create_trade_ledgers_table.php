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
        Schema::create('trade_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('licence_no')->nullable();
            $table->double('arrears',20,2)->nullable();
            $table->double('surcharge',20,2)->nullable();
            $table->double('licence_fee',20,2)->nullable();
            $table->double('signboard_fee',20,2)->nullable();
            $table->double('extra_fee',20,2)->nullable();
            $table->date('renewal_date')->nullable();
            $table->string('financial_year')->nullable();
            $table->tinyInteger('paid_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_ledgers');
    }
};
