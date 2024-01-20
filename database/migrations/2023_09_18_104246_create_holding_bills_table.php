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
        Schema::create('holding_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('tax_payer_id');
            $table->string('bill_session')->comment('বিলের অর্থ বৎসর');
            $table->string('due_session')->comment('বকেয়া শুরুর অর্থ বৎসর');
            $table->float('due_amount')->comment('পূর্বের বকেয়া');
            $table->float('due_paid')->default(0);
            $table->float('surcharge')->default(0)->comment('5% of due_amount ');
            $table->float('rebate_amount')->default(0)->comment('discount ');
            $table->float('first_installment')->default(0)->comment('1 ম কিস্তি ');
            $table->float('first_installment_paid')->default(0);
            $table->float('second_installment')->default(0)->comment('২ য় কিস্তি ');
            $table->float('second_installment_paid')->default(0);
            $table->float('third_installment')->default(0)->comment('৩ য় কিস্তি ');
            $table->float('third_installment_paid')->default(0);
            $table->float('fourth_installment')->default(0)->comment('৪ র্থ কিস্তি');
            $table->float('fourth_installment_paid')->default(0);
            $table->float('yearly_rent')->default(0)->comment('১০ মাসের ভাড়া');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holding_bills');
    }
};
