<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    protected $table = 'user_message';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
