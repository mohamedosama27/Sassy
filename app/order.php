<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    public function items()
    {
        return $this->belongsToMany(item::class)->withPivot('quantity');;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
