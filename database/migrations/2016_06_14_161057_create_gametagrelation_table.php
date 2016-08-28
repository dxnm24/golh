<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGametagrelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_tag_relations', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('tag_id');
            $table->index('game_id', 'game_tag_relations_game_id_index');
            $table->index('tag_id', 'game_tag_relations_tag_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_tag_relations');
    }
}
