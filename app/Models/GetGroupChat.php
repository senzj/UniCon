<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetGroupChat extends Model
{
    protected $table = 'groupchat';

    // Relationship method to define the connection
    public function members()
    {
        return $this->hasMany(GroupMember::class, 'groupchat_id', 'id');
    }

    // Static method to get group chats for current user
    public static function forCurrentUser()
    {
        $userId = Auth::id(); // Get current user's ID

        return self::whereHas('members', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }
}

// Optional: Create a GroupMember model if not exists
class GroupMember extends Model
{
    protected $table = 'groupmembers';

    public function groupChat()
    {
        return $this->belongsTo(GetGroupChat::class, 'groupchat_id', 'id');
    }
}