<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('password');
            $table->string('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('postal_code')->nullable()->after('city');
            $table->enum('role', ['admin', 'vendor', 'customer'])->default('customer')->after('postal_code');
            $table->enum('vendor_status', ['pending', 'approved', 'rejected'])->nullable()->after('role');
            $table->string('store_name')->nullable()->after('vendor_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'phone',
                'address',
                'city',
                'postal_code',
                'role',
                'vendor_status',
                'store_name',
            ]);
        });
    }
};
