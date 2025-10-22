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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Donor (can be guest)
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade'); // Campaign receiving donation
            $table->decimal('amount', 10, 2); // Donation amount
            $table->string('donor_name')->nullable(); // For anonymous or guest donations
            $table->string('donor_email')->nullable(); // For guest donations
            $table->text('message')->nullable(); // Optional message from donor
            $table->boolean('anonymous')->default(false); // Hide donor name publicly
            $table->string('status')->default('completed'); // For future: pending, completed, failed
            $table->string('payment_method')->default('prototype'); // For prototype: 'prototype'
            $table->string('transaction_id')->nullable(); // For future real payments
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['campaign_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
