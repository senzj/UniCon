<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GetGroupChat extends Model
{
    protected $table = 'group_chats'; // Specify the table name if it's different

    public static function forCurrentUser ()
    {
        $user = Auth::user(); // Get the currently authenticated user

        if ($user) {
            return $user->groupChats; // Return the group chats for the user
        }

        return collect(); // Return an empty collection if no user is authenticated
    }
}
