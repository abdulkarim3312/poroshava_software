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
        Schema::create('holding_tax_payers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('father_husband_name');
            $table->string('mother_name');
            $table->string('contact_no');
            $table->string('national_id');
            $table->string('address');
            $table->string('email');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holding_tax_payers');
    }
};





