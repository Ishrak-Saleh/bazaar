<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_freshness_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('old_arrival_date')->nullable();
            $table->date('new_arrival_date')->nullable();

            $table->unsignedInteger('old_shelf_life_days')->nullable();
            $table->unsignedInteger('new_shelf_life_days')->nullable();

            $table->timestamp('changed_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_freshness_logs');
    }
};