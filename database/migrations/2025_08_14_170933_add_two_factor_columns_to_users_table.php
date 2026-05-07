<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // No-op: replaced Fortify 2FA with custom phone OTP (see users table).
    public function up(): void {}

    public function down(): void {}
};
