<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{
    protected $fillable = ['url', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function xpath()
    {
        return $this->hasOne(Xpath::class);
    }
}
