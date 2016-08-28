<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGametagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_tags', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('summary', 1000);
            $table->text('description');
            $table->string('image');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->string('meta_description');
            $table->string('meta_image');
            $table->integer('status')->default(ACTIVE);
            $table->string('lang')->default(VI);
            $table->timestamps();
            $table->index('slug', 'game_tags_slug_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_tags');
    }
}
