<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\UserMessage;
use App\Http\Requests\SaveMessageRequest;
use App\Http\Requests\DeleteMessageRequest;

class MessageController extends Controller
{
    public function getData() // Получить список сообщений
    {
        $data = UserMessage::with('user')
            ->where('deleted', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json(['content' => $data]);
    }

    public function saveMessage(SaveMessageRequest $Request) // Сохранить новое/отредактированное сообщение
    {
        if($Request->filled('message_id')){

            $UserMessage = UserMessage::find($Request->input('message_id'));

            if($UserMessage->user_id != \Auth::id()){
                abort(403);
            }

            $UserMessage->private = $Request->input('is_message_private');
            $UserMessage->text = $Request->input('message_text');
            $UserMessage->save();
        }
        else{
            UserMessage::insert([
                'user_id' => \Auth::id(),
                'private' => $Request->input('is_message_private'),
                'text' => $Request->input('message_text'),
                'created_at' => Carbon::now()
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function deleteMessage(DeleteMessageRequest $Request) // Удалить сообщение
    {
        $UserMessage = UserMessage::find($Request->input('message_id'));

        if($UserMessage->user_id != \Auth::id()){
            abort(403);
        }

        $UserMessage->deleted = 1;
        $UserMessage->save();

        return response()->json(['status' => 'ok']);
    }
}
