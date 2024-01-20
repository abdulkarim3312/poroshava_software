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
        Schema::create('trade_collects', function (Blueprint $table) {
            $table->id();
            $table->string('trade_user')->nullable();
            $table->tinyInteger('collect_details')->nullable();
            $table->double('trade_arrears',20,2)->nullable();
            $table->double('trade_surcharge',20,2)->nullable();
            $table->double('present_trade',20,2)->nullable();
            $table->double('signborad',20,2)->nullable();
            $table->double('extra',20,2)->nullable();
            $table->double('total_collect_amount',20,2)->nullable();
            $table->string('collect_date')->nullable();
            $table->string('financial_year')->nullable();
            $table->unsignedInteger('bank_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_collects');
    }
};
