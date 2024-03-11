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
        Schema::create('card_details', function (Blueprint $table) {
            $table->id();
            $table->text('type');
            $table->text('name');
            $table->string('email');
            $table->integer('client_id');
            $table->integer('user_id');
            $table->bigInteger('card_number');
            $table->string('exp_date');
            $table->integer('cvc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_details');
    }
};
