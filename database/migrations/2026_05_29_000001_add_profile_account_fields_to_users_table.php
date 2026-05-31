<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('username')->nullable()->unique()->after('last_name');
            $table->string('gender')->nullable()->after('email');
            $table->string('phone')->nullable()->after('gender');
            $table->date('birthdate')->nullable()->after('phone');
            $table->string('country')->nullable()->after('birthdate');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'username',
                'gender',
                'phone',
                'birthdate',
                'country',
            ]);
        });
    }
};
