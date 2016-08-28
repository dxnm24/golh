<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGametyperelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_type_relations', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('type_id');
            $table->index('game_id', 'game_type_relations_game_id_index');
            $table->index('type_id', 'game_type_relations_type_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_type_relations');
    }
}
