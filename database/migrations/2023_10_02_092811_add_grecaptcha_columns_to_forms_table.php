<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('grecaptcha_enabled')->default(false)->after('redirect_to');
            $table->string('grecaptcha_site_key')->nullable()->after('grecaptcha_enabled');
            $table->string('grecaptcha_secret_key')->nullable()->after('grecaptcha_site_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('grecaptcha_enabled');
            $table->dropColumn('grecaptcha_site_key');
            $table->dropColumn('grecaptcha_secret_key');
        });
    }
};
