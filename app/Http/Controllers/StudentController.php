<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\Groupchat;
use Illuminate\Support\Facades\Log;
use App\Models\Task;

class StudentController extends Controller
{
    public function index()
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            // Handle the case where the user is not authenticated
            return redirect()->route('login'); // Redirect to login or handle as needed
        }

        // Get the group chat(s) the current user belongs to
        $userGroupChats = Auth::user()->groupChats;

        // Check if the user has any group chats
        if ($userGroupChats->isEmpty()) {
            // Handle the case where the user has no group chats
            return view('student.home', [
                'groupChat' => null,
                'messages' => collect(),
                'members' => collect(),
                'tasks' => collect(), // Return an empty collection for tasks
            ]);
        }

        // Get the first group chat
        $groupChat = $userGroupChats->first();

        // Fetch messages for the group chat
        $messages = $groupChat->messages ?? collect(); // Use null coalescing operator

        // Fetch users who are part of the group chat
        $groupChatUsers = $groupChat->users ?? collect(); // Use null coalescing operator

        // Fetch the tasks for the current group chat
        $tasks = Task::where('group_id', $groupChat->id)->get();

        return view('student.home', [
            'groupChat' => $groupChat,
            'messages' => $messages,
            'members' => $groupChatUsers,
            'tasks' => $tasks, // Include tasks in the view data
        ]);

        // For debugging use
        // $data = [
        //     // 'members' => $groupChatUsers,
        //     // 'userGroupChats' => $userGroupChats,
        //     // 'groupChat' => $groupChat,
        //     'messages' => $messages,
        //     'tasks' => $tasks,
        // ];
        // return response()->json($data);
        // dd($data);
    }

    // Send message to group chat
    public function sendMessage(Request $request, $groupId)
    {

        // // check if one of the input input is empty
        // if (empty($request->input('message')) || empty($request->input('user_id')) || empty($request)) {
        //     return response()->json(['error' => 'Message or User ID is empty'], 400);
        // }

        // Validate the incoming request
        $validated = $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx',
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
                'message' => $validated['message'] ?? null, // Set to null if not provided
                'file_path' => $filePath, // Store the file path in the database
            ]);

            return redirect()->back()->with('success', 'Message sent successfully!');

        } catch (\Exception $e) {
            // Log the error
            Log::error('Message sending failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to send message. Please try again.');
        }

        // for debugging use
        // $data = [
        // 'message' => $message,
        // 'request' => $request->all(),
        //     'validated' => $validated,
        // ];
        
        // return response()->json($data);

    }
}
