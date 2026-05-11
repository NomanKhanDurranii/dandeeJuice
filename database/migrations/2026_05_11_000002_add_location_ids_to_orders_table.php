<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('delivery_zone_id')->nullable()->after('delivery_address')->constrained('delivery_zones')->nullOnDelete();
            $table->foreignId('pickup_branch_id')->nullable()->after('delivery_zone_id')->constrained('branches')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\DeliveryZone::class, 'delivery_zone_id');
            $table->dropForeignIdFor(\App\Models\Branch::class, 'pickup_branch_id');
            $table->dropColumn(['delivery_zone_id', 'pickup_branch_id']);
        });
    }
};
