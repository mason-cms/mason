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
        Schema::table('entry_types', function (Blueprint $table) {
            $table->string('default_order_column')->nullable()->after('default_editor_mode');
            $table->string('default_order_direction')->nullable()->after('default_order_column');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entry_types', function (Blueprint $table) {
            $table->dropColumn('default_order_column');
            $table->dropColumn('default_order_direction');
        });
    }
};
