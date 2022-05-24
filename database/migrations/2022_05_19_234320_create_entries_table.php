<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id')->unsigned()->index();
            $table->string('name', 255)->nullable()->index();
            $table->integer('locale_id')->unsigned()->index();
            $table->string('title', 255)->nullable();
            $table->mediumText('content')->nullable();
            $table->text('summary')->nullable();
            $table->integer('author_id')->unsigned()->index();
            $table->integer('cover_id')->unsigned()->nullable();
            $table->timestamp('published_at')->nullable()->index();
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
        Schema::dropIfExists('entries');
    }
}
