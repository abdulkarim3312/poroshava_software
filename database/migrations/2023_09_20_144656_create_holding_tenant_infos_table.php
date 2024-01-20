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
        Schema::create('holding_tenant_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('holding_tax_payer_id');
            $table->integer('holding_info_id');
            $table->integer('structure_type_id');
            $table->string('tenant_floor');
            $table->string('tenant_name');
            $table->string('nid_no');
            $table->string('monthly_rent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holding_tenant_infos');
    }
};
