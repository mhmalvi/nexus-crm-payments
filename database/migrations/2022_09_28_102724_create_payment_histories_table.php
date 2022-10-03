<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('payment_amount')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->json('payment_log')->nullable();
            $table->bigInteger('lead_id')->nullable();
            $table->bigInteger('Authorisation_code')->nullable();
            $table->bigInteger('response_code')->nullable();
            $table->string('response_msg')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_ref')->nullable();
            $table->string('transaction_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('job_description')->nullable();
            $table->string('street1')->nullable();
            $table->string('street2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->text('comments')->nullable();
            $table->string('fax')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('payment_histories');
    }
}
