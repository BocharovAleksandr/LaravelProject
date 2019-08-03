<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use App\Models\UserMessage;
use App\Http\Requests\SaveMessageRequest;
use App\Http\Requests\DeleteMessageRequest;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function getData()
    {
        $data = UserMessage::with('user')
            ->where('deleted', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json(['content' => $data]);
    }

    public function saveMessage(SaveMessageRequest $Request)
    {
        if($Request->filled('message_id')){

            UserMessage::where('id', $Request->input('message_id'))
            ->update([
                'private' => $Request->input('is_message_private'),
                'text' => $Request->input('message_text')
            ]);
        }
        else{
            UserMessage::insert([
                'user_id' => 1,
                'private' => $Request->input('is_message_private'),
                'text' => $Request->input('message_text'),
                'created_at' => Carbon::now()
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function deleteMessage(DeleteMessageRequest $Request)
    {
        UserMessage::where('id', $Request->input('message_id'))->update([
            'deleted' => 1
        ]);

        return response()->json(['status' => 'ok']);
    }
}
