<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveMessageRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::check();
    }

    public function rules()
    {
        return [
            'message_text' => 'required|min:1',
            'is_message_private' => 'required',
            '_token' => 'required'
        ];
    }
}
