<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMessageRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::check();
    }

    public function rules()
    {
        return [
            'message_id' => 'required',
            '_token' => 'required'
        ];
    }
}
