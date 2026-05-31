<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('city')->nullable()->after('address');
            $table->string('zip_code', 20)->nullable()->after('city');
            $table->string('contract')->nullable()->after('zip_code');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['city', 'zip_code', 'contract']);
        });
    }
};
