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
        Schema::create('holding_assessments', function (Blueprint $table) {
            $table->id();
            $table->integer('holding_tax_payer_id')->nullable();
            $table->integer('holding_info_id')->nullable();
            $table->integer('holding_assessment_setting_id')->nullable();
            $table->double('consider_holding_tax',14,2)->nullable();
            $table->double('actual_assesment',14,2)->nullable();
            $table->double('Yearly_construct_assesment',14,2)->nullable();
            $table->double('Maintenance_deduct',14,2)->nullable();
            $table->double('owner_deduct',14,2)->nullable();
            $table->tinyInteger('re_interim_assessment')->nullable();
            $table->double('total_approximate_rent',14,2)->nullable();
            $table->double('total_monthly_rent',14,2)->nullable();
            $table->double('Yearly_assesment',14,2)->nullable();
            $table->double('holding_tax',14,2)->nullable();
            $table->double('light_tax',14,2)->nullable();
            $table->double('water_supply_tax',14,2)->nullable();
            $table->double('consrvancy_tax',14,2)->nullable();
            $table->double('other_tax',14,2)->nullable();
            $table->double('total_tax',14,2)->nullable();
            $table->tinyInteger('paid_status')->nullable();
            $table->tinyInteger('secretary')->nullable();
            $table->tinyInteger('mayor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holding_assessments');
    }
};
