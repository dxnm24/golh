<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('type_main_id');
            $table->integer('seri');
            $table->integer('related');
            $table->integer('type');
            $table->string('url');
            $table->string('summary', 1000);
            $table->text('description');
            $table->string('image');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->string('meta_description');
            $table->string('meta_image');
            $table->text('download');
            $table->string('width')->default(FRAME_WIDTH);
            $table->string('height')->default(FRAME_HEIGHT);
            $table->integer('screen')->default(HORIZONTAL);
            $table->integer('play')->default(ACTIVE);
            $table->integer('position');
            $table->string('start_date');
            $table->integer('view');
            $table->integer('status')->default(ACTIVE);
            $table->string('lang')->default(VI);
            $table->timestamps();
            $table->index('slug', 'games_slug_index');
            $table->index('type_main_id', 'games_type_main_id_index');
            $table->index('seri', 'games_seri_index');
            $table->index('related', 'games_related_index');
            $table->index('type', 'games_type_index');
            $table->index('start_date', 'games_start_date_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
    }
}
