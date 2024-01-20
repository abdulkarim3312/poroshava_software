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
        Schema::create('structure_holding_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('holding_tax_payer_id');
            $table->integer('holding_info_id');
            $table->integer('structure_type_id');
            $table->integer('use_type_id');
            $table->string('total_floor');
            $table->string('owner_use_floor_no');
            $table->string('tenant_use_floor_no');
            $table->string('unuse_floor_no');
            $table->string('structure_length');
            $table->string('structure_width');
            $table->string('structure_volume');
            $table->string('construction_rate');
            $table->string('construction_amount');
            $table->string('aprox_monthly_rent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structure_holding_infos');
    }
};
