<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
