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
        Schema::create('trade_inspactor_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('trade_user_id')->nullable();
            $table->tinyInteger('org_name')->nullable();
            $table->string('correct_org_name')->nullable();
            $table->tinyInteger('owner_name')->nullable();
            $table->string('correct_owner_name')->nullable();
            $table->tinyInteger('business_type')->nullable();
            $table->string('correct_business_type')->nullable();
            $table->tinyInteger('business_start_date')->nullable();
            $table->date('correct_business_start_date')->nullable();
            $table->tinyInteger('business_capital')->nullable();
            $table->string('correct_business_capital')->nullable();
            $table->tinyInteger('org_address')->nullable();
            $table->string('correct_org_address')->nullable();
            $table->string('correct_holding_no')->nullable();
            $table->string('correct_shop_no')->nullable();
            $table->integer('correct_ward_id')->nullable();
            $table->integer('correct_road_id')->nullable();
            $table->integer('correct_district_id')->nullable();
            $table->integer('correct_upazila_id')->nullable();
            $table->tinyInteger('sign_board_type')->nullable();
            $table->integer('correct_sign_board_type')->nullable();
            $table->tinyInteger('sign_board_size')->nullable();
            $table->string('correct_sign_board_size')->nullable();
            $table->tinyInteger('approved_application')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_inspactor_reports');
    }
};
