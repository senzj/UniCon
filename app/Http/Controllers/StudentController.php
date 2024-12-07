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

        // fetch user who are part of the group chat
        $groupChatUsers = $groupChat ? $groupChat->users : collect();

        // Fetch the task progress for the group chat
        $task = $groupChat->task; // Use the relationship instead of querying directly

        // Prepare progress data
        $progresses = [
            'chapter1' => $task ? ($task->chapter1['overall_score'] ?? 0) : 0,
            'chapter2' => $task ? ($task->chapter2['overall_score'] ?? 0) : 0,
            'chapter3' => $task ? ($task->chapter3['overall_score'] ?? 0) : 0,
            'chapter4' => $task ? ($task->chapter4['overall_score'] ?? 0) : 0,
            'chapter5' => $task ? ($task->chapter5['overall_score'] ?? 0) : 0,
            'chapter6' => $task ? ($task->chapter6['overall_score'] ?? 0) : 0,
        ];

        return view('student.home', [
            // 'userGroupChats' => $userGroupChats,
            'groupChat' => $groupChat,
            'messages' => $messages,
            'members' => $groupChatUsers,
            'progress' => $progresses,
        ]);

        // // for debugging use
        // $data = [
        //     'members' => $groupChatUsers,
        //     'userGroupChats' => $userGroupChats,
        //     'groupChat' => $groupChat,
        //     'messages' => $messages,
        //     'progress' => $progresses,
        // ];
        // return response()->json($data);
        // dd($data);
    }

    // Send message to group chat
    public function sendMessage(Request $request, $groupId)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'message' => 'required|string|max:500',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240'
        ]);

        try {
            // Find the group chat
            $groupChat = GroupChat::findOrFail($groupId);

            // Initialize file path variable
            $filePath = null;

            // Handle file upload if a file is present
            if ($request->hasFile('file')) {
                // Get the original file name
                $originalFileName = $request->file('file')->getClientOriginalName();

                // Get the group name (you may need to fetch this from your database)
                $group = GroupChat::find($groupId); // Assuming you have a Group model
                $groupName = $group ? $group->name : 'Undefined_group'; // Replace with actual group name retrieval logic

                // Create a new file name
                $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '.' . $request->file('file')->getClientOriginalExtension();

                // Store the file in a folder named after the group
                $filePath = $request->file('file')->storeAs("uploads/{$groupName}", $newFileName, 'public'); // Store in 'public/uploads/groupname'
            }

            // Create the message
            $message = Message::create([
                'group_id' => $groupChat->id,
                'user_id' => Auth::id(),
                'message' => $validated['message'],
                'file_path' => $filePath, // Store the file path in the database
            ]);

            return redirect()->back()->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Message sending failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to send message. Please try again.');
        }

        // for debugging use
        $data = [
            'message' => $message,
            // 'request' => $request,
            // 'validated' => $validated,
        ];
        return response()->json($data);
    }
}
