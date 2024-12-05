<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Groupchat extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'group_chats';

    // Define fillable fields
    protected $fillable = ['name', 'progress'];

    // Relationship with members (users)
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_chat_user', 'group_chat_id', 'user_id');
    }

    // Relationship with submissions
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}