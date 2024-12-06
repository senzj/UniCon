<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupchat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        // Get the current user's group_id
        $groupId = Auth::user()->group_id;

        // Fetch messages for the group chat
        $messages = Message::where('group_id', $groupId)->get();

        // Fetch group chat details (optional)
        $groupChat = Groupchat::find($groupId);

        return view('student.home', compact('messages', 'groupChat'));
    }
}
