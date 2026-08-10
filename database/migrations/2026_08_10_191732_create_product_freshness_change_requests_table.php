<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_freshness_change_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('vendor_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('current_arrival_date')->nullable();
            $table->date('requested_arrival_date')->nullable();

            $table->unsignedInteger('current_shelf_life_days')->nullable();
            $table->unsignedInteger('requested_shelf_life_days')->nullable();

            $table->text('reason');

            $table->enum('status', ['pending', 'approved', 'denied'])
                ->default('pending');

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();

            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_freshness_change_requests');
    }
};