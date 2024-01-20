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
            $table->string('total_licence')->nullable();
            $table->string('renewal_licence')->nullable();
            $table->double('total_arrears_dimand',20,2)->nullable();
            $table->double('total_hal_dimand',20,2)->nullable();
            $table->double('total_arrears_collect',20,2)->nullable();
            $table->double('total_hal_collect',20,2)->nullable();
            $table->tinyInteger('status')->default(0);
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
