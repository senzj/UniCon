<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'groupmessage';
    
    protected $fillable = [
        'group_id', 
        'user_id', 
        'message',
        'file_path'
    ];

    protected $with = ['user'];

    // Customize JSON serialization
    protected $appends = ['formatted_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Groupchat::class, 'group_id');
    }

    // Accessor for formatted time
    public function getFormattedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
