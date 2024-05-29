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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('dispatcher_id')->default(1);
            $table->integer('client_id');
            $table->integer('executor_id')->nullable();
            $table->boolean('is_paid');
            $table->text('description')->nullable();
            $table->string('ticket_number');
            $table->dateTime('start_work');
            $table->dateTime('end_work');
            $table->string('address');
            $table->string('title');
            $table->string('phone_client');
            $table->integer('status');
            $table->dateTime('created_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
