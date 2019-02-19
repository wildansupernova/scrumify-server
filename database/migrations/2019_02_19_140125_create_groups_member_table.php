<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_member', function (Blueprint $table) {
            $table->integer('group_id')->foreign('group_id')->references('id')->on('groups');
            $table->integer('user_id')->foreign('user_id')->references('id')->on('users');
            $table->primary(['group_id', 'user_id']);
            $table->string('role');
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
        Schema::dropIfExists('groups_member');
    }
}
