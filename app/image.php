<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    public function item()
    {
        return $this->belongsTo(item::class);
    }
}
