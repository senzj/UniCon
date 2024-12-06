<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
{
    $groupId = Auth::user()->group_id;

    // Fetch group messages if the user is part of a group
    $messages = [];
    $groupChat = null;

    if ($groupId) {
        $groupChat = \App\Models\Groupchat::find($groupId);
        if ($groupChat) {
            $messages = $groupChat->messages; // Fetch messages related to this group chat
        }
    }

    return view('student.home', [
        'messages' => $messages,
        'groupChat' => $groupChat
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
