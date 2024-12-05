<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = ['group_chat_id', 'student_name', 'content', 'grade', 'comment'];

    // Relationship with GroupChat
    public function groupChat()
    {
        return $this->belongsTo(GroupChat::class);
    }
}
