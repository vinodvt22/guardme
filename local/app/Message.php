<?php

namespace Responsive;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'msg',
        'status'
    ];

//    public function user()
//    {
//        return $this->belongsTo(User::class, 'sender_id', 'id');
//    }

    public function user()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
