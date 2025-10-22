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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('minimum_amount', 10, 2);
            $table->integer('maximum_backers')->nullable(); // null = unlimited
            $table->integer('current_backers')->default(0);
            $table->date('estimated_delivery')->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0); // for display ordering
            $table->text('included_items')->nullable(); // JSON or text list of what's included
            $table->string('shipping_info')->nullable(); // "Digital", "Worldwide", "US Only", etc.
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['campaign_id', 'minimum_amount']);
            $table->index(['campaign_id', 'is_available']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
