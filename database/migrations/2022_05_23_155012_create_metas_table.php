<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->unsigned();
            $table->string('parent_type', 255);
            $table->string('name', 255)->index();
            $table->mediumText('value')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['parent_id', 'parent_type'], 'parent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metas');
    }
}
