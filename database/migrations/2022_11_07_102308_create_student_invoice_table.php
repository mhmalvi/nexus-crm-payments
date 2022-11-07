<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->bigInteger('lead_id')->nullable()->default(0);
            $table->integer('Company_id')->nullable()->default(0);
            $table->integer('user_id')->nullable()->default(0);
            $table->string('Company_name')->nullable();
            $table->string('Company_logo')->nullable();
            $table->string('Course_code')->nullable();
            $table->string('Course_title')->nullable();
            $table->float('payment_amount')->nullable()->default(0);
            $table->string('payment_method')->nullable();
            $table->string('student_name')->nullable();
            $table->string('student_email')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_contact')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_invoice');
    }
}
