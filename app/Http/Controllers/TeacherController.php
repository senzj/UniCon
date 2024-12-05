<?php

namespace App\Http\Controllers;

use App\Models\GroupChat; // Ensure this class exists
use App\Models\Submission; // Ensure this class exists
use App\Models\GetGroupChat; // Ensure this class exists
use App\Models\Message; // Ensure this class exists
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// debugging options:
// return response()->json($messages);
// dd($messages);
// dd($groupChat);

class TeacherController extends Controller
{

    // teacher dashboard view
    public function index()
    {
        // Fetch all group chats for the current user
        $groupChats = GetGroupChat::forCurrentUser();

        return view('teacher.home', compact('groupChats')); // Return the home view with group chats in key value pair object

        // for debugging use
        // return response()->json($groupChats);
    }

    // creates groupchat
    public function createGroupChat(Request $request)
    {
        // Validate the request
        $request->validate([
            'group_name' => 'required|string|max:255', // Ensure the group name is unique
            'group_section' => 'required|string|max:255',
            'group_specialization' => 'required|string|max:255',
            'group_adviser' => 'required|string|max:255',
            'group_logo' => 'image|mimes:jpeg,png,jpg,gif,svg', // File validation
        ]);

        // Get the validated data excluding the file
        $groupChatDetails = $request->only(['group_name', 'group_section', 'group_specialization', 'group_adviser']);

        // Handle the file upload
        // Initialize group_logo_path to null
        $groupChatDetails['group_logo_path'] = null;

        // Handle the file upload
        if ($request->hasFile('group_logo') && $request->file('group_logo')->isValid()) {
            // Get the file extension
            $fileExtension = $request->file('group_logo')->getClientOriginalExtension();

            // Create a custom filename based on group name
            $fileName = strtolower(str_replace(' ', '_', $groupChatDetails['group_name'])) . '_logo.' . $fileExtension;

            // Store the file in the public folder (adjust path as needed)
            $filePath = $request->file('group_logo')->storeAs('group_logos', $fileName, 'public');

            // Add the file path to the group chat details
            $groupChatDetails['group_logo_path'] = $filePath; // Store the path for later use
        }

        // Prepare the data for the model
        $data = [
            'name' => $groupChatDetails['group_name'],
            'section' => $groupChatDetails['group_section'],
            'specialization' => $groupChatDetails['group_specialization'],
            'adviser' => $groupChatDetails['group_adviser'],
            'logo' => $groupChatDetails['group_logo_path'] ?? '' // Use null if not set
        ];

        // Pass the data to the model
        $groupChatModel = Groupchat::create($data); // Ensure you are using the correct model name

        // get user id
        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        // Attach the user as the first member of the group chat
        $groupChatModel->members()->attach($userId); // Use $groupChatModel instead of $groupChat

        // Return a response (you can customize this as needed)
        return back()->with('success', 'Group chat created successfully!');

        // for debugging use
        // return response()->json($request);
        // dd($data);
    }

    public function getMessage($groupChatId)
    {
        // Fetch the specific group chat to ensure it exists
        $groupChat = Groupchat::findOrFail($groupChatId);

        // Fetch messages for the specific group chat
        $messages = Message::where('group_id', $groupChatId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        // Fetch ALL group chats for the current user
        $user = Auth::user();
        $groupChats = $user->groupChats; // This should now return the user's group chats

        // Debugging
        Log::info('Group Chat ID: ' . $groupChatId);
        Log::info('Messages count: ' . $messages->count());
        Log::info('Group Chats count: ' . $groupChats->count());

        // Render the view with all necessary data
        return view('teacher.home', [
            'groupChat' => $groupChat, // Pass the specific group chat
            'messages' => $messages,
            'groupChats' => $groupChats // Pass all group chats
        ]);

        // for debugging use
        // return response()->json($groupChats);
    }


    // send message to group chat
    public function sendMessage(Request $request, $groupId)
    {
        // Debugging: Log the request data
        Log::info('Request Data: ', $request->all());


        // Validate the request
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
            // Remove group_id validation if using route parameter
        ]);

        // try {
        //     // Create the message
        //     $message = Message::create([
        //         'group_id' => $groupId, // Use route parameter
        //         'user_id' => Auth::id(),
        //         'content' => $validatedData['content']
        //     ]);

        //     // Optional: Reload the message with user relationship
        //     $message->load('user');

        //     // Return JSON response for AJAX or redirect
        //     if ($request->ajax()) {
        //         return response()->json([
        //             'status' => 'success',
        //             'message' => $message
        //         ]);
        //     }

        //     // Redirect back with success message
        //     // return back()->with('success', 'Message sent successfully!');

        //     // debugging
        //     return response()->json($message);

        // } catch (\Exception $e) {
        //     // Handle any errors
        //     if ($request->ajax()) {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Failed to send message'
        //         ], 500);
        //     }

        //     return back()->with('error', 'Failed to send message');
        // }

        // for debugging use
        return response()->json($request);
    }


    // add member to group chat
    // public function addMember(Request $request, $groupChatId)
    // {

    // }

}
