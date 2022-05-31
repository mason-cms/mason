<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->integer('locale_id')->unsigned()->index();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('parent_type')->nullable();
            $table->string('storage_key', 255)->nullable();
            $table->string('content_type', 255)->nullable();
            $table->bigInteger('filesize')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
