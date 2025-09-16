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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->decimal('goal_amount', 12, 2);
            $table->decimal('current_amount', 12, 2)->default(0);
            $table->date('deadline');
            $table->enum('status', ['active', 'paused', 'completed', 'cancelled'])->default('active');
            $table->string('image_path')->nullable();
            $table->string('category')->nullable();
            $table->integer('backers_count')->default(0);
            $table->boolean('featured')->default(false);
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['status', 'featured']);
            $table->index(['deadline', 'status']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
