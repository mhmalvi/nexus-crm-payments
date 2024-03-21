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
        Schema::create('subscriptions_prices', function (Blueprint $table) {
        $table->id();
        $table->text('package_name')->unique();
        $table->unsignedBigInteger('stripe_subscription_id');
        $table->foreign('stripe_subscription_id')->references('id')->on('stripe_subscriptions')->onDelete('cascade')->onUpdate('cascade');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
