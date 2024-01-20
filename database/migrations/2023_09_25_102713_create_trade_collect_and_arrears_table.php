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
        Schema::create('trade_collect_and_arrears', function (Blueprint $table) {
            $table->id();
            $table->string('financial_year')->nullable();
            $table->string('total_holding')->nullable();
            $table->string('total_collect_holding')->nullable();
            $table->double('demand_arrears',20,2)->nullable();
            $table->double('demand_present_tax',20,2)->nullable();
            $table->double('collect_arrears',20,2)->nullable();
            $table->double('collect_present_tax',20,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_collect_and_arrears');
    }
};
