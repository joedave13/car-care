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
        Schema::disableForeignKeyConstraints();

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('phone');
            $table->foreignId('store_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->date('booking_date');
            $table->time('booking_time');
            $table->bigInteger('service_price');
            $table->bigInteger('booking_fee');
            $table->bigInteger('tax');
            $table->bigInteger('total');
            $table->string('status')->default('pending');
            $table->string('payment_proof')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
