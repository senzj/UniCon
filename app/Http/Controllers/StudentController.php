<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\Groupchat;
use Illuminate\Support\Facades\Log;

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

        // for debugging use
        // $data = [
        //     'userGroupChats' => $userGroupChats,
        //     'groupChat' => $groupChat,
        //     'messages' => $messages
        // ];
        // return response()->json($data);
        // dd($data);
    }

    public function sendMessage(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'message' => 'required|string|max:500',
        ]);

        try {
            // Get the user's first group chat
            $groupChat = Auth::user()->groupChats->first();

            // Check if user belongs to a group chat
            if (!$groupChat) {
                return redirect()->back()->with('error', 'You are not part of any group chat.');
            }

            // Create the message
            $message = Message::create([
                'group_id' => $groupChat->id,
                'user_id' => Auth::id(),
                'message' => $validated['message'],
            ]);

            // Optional: Add additional logic like broadcasting or notifications
            // event(new MessageSent($message));

            return redirect()->back()->with('success', 'Message sent successfully!');

        } catch (\Exception $e) {
            // Log the error
            Log::error('Message sending failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to send message. Please try again.');
        }
    }
}
