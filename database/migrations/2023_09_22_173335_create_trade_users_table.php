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
        Schema::create('trade_users', function (Blueprint $table) {
            $table->id();
            $table->string('name_type')->nullable();
            $table->string('name')->nullable();
            $table->string('licence_no')->nullable();
            $table->string('licence_id')->nullable();
            $table->string('father_husband_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('organization_address')->nullable();
            $table->string('holding_no')->nullable();
            $table->string('shop_no')->nullable();
            $table->integer('ward_id')->nullable();
            $table->integer('road_id')->nullable();
            $table->integer('business_type_id')->nullable();
            $table->string('licence_issue_date')->nullable();
            $table->integer('signboard_id')->nullable();
            $table->string('signboard_size')->nullable();
            $table->double('signboard_fee',20,2)->nullable();
            $table->double('licence_fee',20,2)->nullable();
            $table->string('financial_year')->nullable();
            $table->double('arrears',20,2)->nullable();
            $table->string('arrears_year')->nullable();
            $table->double('extra_rate',20,2)->nullable();
            $table->string('renewal_date')->nullable();
            $table->tinyInteger('paid_status')->default(0);
            $table->string('business_type_name')->nullable();
            $table->string('approved_paid_capital')->nullable();
            $table->tinyInteger('income_tax')->nullable();
            $table->string('total_employers')->nullable();
            $table->string('machine_details')->nullable();
            $table->tinyInteger('biddut_generator')->nullable();
            $table->string('motor_details')->nullable();
            $table->string('org_start_date')->nullable();
            $table->string('product_types')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('org_contact_no')->nullable();
            $table->string('email')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('upazila_id')->nullable();
            $table->tinyInteger('bin_vat')->default(0);
            $table->string('bin_vat_no')->nullable();
            $table->string('org_telephone_no')->nullable();
            $table->string('org_email')->nullable();
            $table->string('org_web_site')->nullable();
            $table->string('husband_name')->nullable();
            $table->string('nationality')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('marital_status',['বিবাহিত','অবিবাহিত'])->nullable();
            $table->string('personal_tin_no')->nullable();
            $table->string('nid_scan_copy')->nullable();
            $table->string('personal_tin_scan_copy')->nullable();
            $table->string('org_tin_scan_copy')->nullable();
            $table->string('bin_vat_scan_copy')->nullable();
            $table->string('tax_paid_voucher_scan_copy')->nullable();
            $table->string('image')->nullable();
            $table->string('balance_sheet')->nullable();
            $table->string('tax_tenant_copy')->nullable();
            $table->string('org_drowing_paper')->nullable();
            $table->string('location_drowing_paper')->nullable();
            $table->tinyInteger('inspector')->default(0);
            $table->string('inspactor_name')->nullable();
            $table->longText('inspactor_report')->nullable();
            $table->tinyInteger('secretary')->default(0);
            $table->string('secretary_name')->nullable();
            $table->string('secretary_report')->nullable();
            $table->tinyInteger('mayor')->default(0);
            $table->string('mayor_name')->nullable();
            $table->string('mayor_report')->nullable();
            $table->tinyInteger('inactive_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_users');
    }
};
