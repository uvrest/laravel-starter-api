<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('email_verified_at', function ($table) {
                $table->string('account_type')->after('email_verified_at')->nullable(false);
                $table->string('avatar_thumbnail')->nullable();
                $table->string('phone')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('account_type');
            $table->dropColumn('avatar_thumbnail');
            $table->dropColumn('phone');
        });
    }
};
