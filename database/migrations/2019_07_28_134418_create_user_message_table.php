<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMessageTable extends Migration
{
    public function up()
    {
        Schema::create('user_message', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('id пользователя');
            $table->text('text')->comment('Текст сообщения');
            $table->integer('private')->unsigned()->comment('Закодированно ли сообщение');
            $table->integer('deleted')->unsigned()->comment('Удалено ли сообщение');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_message');
    }
}
