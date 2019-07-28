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
            $table->text('message_text')->comment('Текст сообщения');
            $table->dateTime('created_at')->comment('Дата создания сообщения');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_message');
    }
}
