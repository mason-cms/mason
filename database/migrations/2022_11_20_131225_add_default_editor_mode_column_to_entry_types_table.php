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
            $table->string('default_editor_mode', 50)->nullable()->after('icon_class');
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
            $table->dropColumn('default_editor_mode');
        });
    }
};
