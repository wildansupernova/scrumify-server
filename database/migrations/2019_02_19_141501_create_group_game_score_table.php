<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupGameScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_game_score', function (Blueprint $table) {
            $table->integer('group_id')->foreign('group_id')->references('id')->on('groups');
            $table->integer('user_id')->foreign('user_id')->references('id')->on('users');
            $table->primary(['group_id', 'user_id']);
            $table->integer('score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_game_score');
    }
}
