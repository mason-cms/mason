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
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->text('grecaptcha_token')->nullable()->after('referrer_url');
            $table->boolean('grecaptcha_success')->nullable()->after('grecaptcha_token');
            $table->float('grecaptcha_score')->nullable()->after('grecaptcha_success');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropColumn('grecaptcha_token');
            $table->dropColumn('grecaptcha_success');
            $table->dropColumn('grecaptcha_score');
        });
    }
};
