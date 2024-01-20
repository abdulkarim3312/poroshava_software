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
        Schema::create('holding_assessment_settings', function (Blueprint $table) {
            $table->id();
            $table->double('holding_tax_rate',8,2);
            $table->double('light_rate',8,2);
            $table->double('consevancy_rate',8,2);
            $table->double('water_rate',8,2);
            $table->double('other_rate',8,2);
            $table->string('financial_years');
            $table->tinyInteger('active_flag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holding_assessment_settings');
    }
};
