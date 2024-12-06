<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\Groupchat;

class StudentController extends Controller
{
    public function index()
    {
        // Get the group chat(s) the current user belongs to
        $userGroupChats = Auth::user()->groupChats;

        // Or if you prefer to get the first group chat
        $groupChat = Auth::user()->groupChats->first();

        // Fetch messages for the group chat
        $messages = $groupChat ? $groupChat->messages : collect();

        return view('student.home', [
            // 'userGroupChats' => $userGroupChats,
            'groupChat' => $groupChat,
            'messages' => $messages
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $groupId = Auth::user()->group_id;

        if (!$groupId) {
            return redirect()->back()->with('error', 'You are not part of a group chat.');
        }

        $groupChat = \App\Models\Groupchat::find($groupId);

        if (!$groupChat) {
            return redirect()->back()->with('error', 'Group chat does not exist.');
        }

        // Save the message
        Message::create([
            'group_id' => $groupId,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
