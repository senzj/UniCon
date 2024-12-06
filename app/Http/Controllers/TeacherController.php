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

    // teacher dashboard view
    // public function index()
    // {
    //     // Fetch all group chats for the current user
    //     $groupChats = GetGroupChat::forCurrentUser();

    //     // Check if there are any group chats
    //     if ($groupChats->isNotEmpty()) {
    //         // Get the first group chat by default
    //         $firstGroupChat = $groupChats->first();

    //         // Fetch messages for the first group chat
    //         $messages = Message::where('group_id', $firstGroupChat->id)
    //             ->with('user')
    //             ->orderBy('created_at', 'asc')
    //             ->get();

    //         // Fetch members of the first group chat
    //         $members = $firstGroupChat->members()->select(
    //             'users.id', 
    //             'users.picture', 
    //             'users.first_name', 
    //             'users.last_name', 
    //             'users.email'
    //         )->get();

    //         return view('teacher.home', [
    //             'groupChats' => $groupChats,
    //             'groupChat' => $firstGroupChat,
    //             'messages' => $messages,
    //             'members' => $members
    //         ]);
    //     }

    //     // If no group chats exist
    //     return view('teacher.home', [
    //         'groupChats' => $groupChats,
    //         'groupChat' => null,
    //         'messages' => collect(),
    //         'members' => collect()
    //     ]);
    // }
    

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
        $groupChatModel = Groupchat::create($data);

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
        Log::info('Group Chat ID: ' . $groupChatId);

        // Fetch the specific group chat to ensure it exists
        $groupChat = Groupchat::findOrFail($groupChatId);
        Log::info('Group Chat: ' . $groupChat);

        // Fetch messages for the specific group chat
        $messages = Message::where('group_id', $groupChatId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();
        Log::info('Messages: ' . $messages);

        // Fetch ALL group chats for the current user
        $user = Auth::user();
        $groupChats = $user->groupChats; // This should now return the user's group chats

        // Fetch all members of the selected group chat
        // Access members directly
        // $members = $groupChat->members;

        // If you want specific fields
        $members = $groupChat->members()->select('users.id', 'users.picture', 'users.first_name', 'users.last_name', 'users.email')->get();

        // Logging for debugging
        Log::info('Group Chat ID: ' . $groupChatId);
        Log::info('Messages count: ' . $messages->count());
        Log::info('Group Chats count: ' . $groupChats->count());
        

        // Render the view with all necessary data
        return view('teacher.home', [
            'groupChat' => $groupChat, // Pass the specific group chat
            'messages' => $messages,
            'groupChats' => $groupChats, // Pass all group chats
            'members' => $members
        ]);

        // for debugging use
        // $data = [
        //     'groupChatId' => $groupChatId,
        //     'groupChat' => $groupChat,
        //     'messages' => $messages,
        //     'groupChats' => $groupChats,
        //     'members' => $members
        // ];

        // return response()->json($data);
    }


    // send message to group chat
    public function sendMessage(Request $request, $groupId)
    {
        // Debugging: Log the request data
        // Log::info('Request Data: ', $request->all());

        // Validate the request
        $validatedData = $request->validate([
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx'
        ]);

        // Initialize file path variable
        $filePath = null;

        // Handle the file upload
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

        // Data for the model
        $data = [
            'group_id' => $groupId,
            'user_id' => Auth::id(),
            'message' => $validatedData['content'],
            'file_path' => $filePath // Save the file path if it exists
        ];

        // Pass the data to the model
        $messages = Message::create($data);

        // get user id

        // Return to the group chat with chat messages
        return redirect()->back()->with('success', 'Message sent successfully!');

        // For debugging use
        // return response()->json($message);
    }

    public function addMember(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'email' => 'required|email|exists:users,email',
                'group_id' => 'required|exists:groupchat,id'
            ]);

            // Retrieve the user by their email
            $user = User::where('email', $request->input('email'))->first();

            // Retrieve the group chat
            $group = Groupchat::findOrFail($request->input('group_id'));

            // Check if the user is already a member of the group
            if ($group->members()->where('user_id', $user->id)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User is already a member of this group!'
                ], 409);
            }

            // Save to groupmembers table
            $group->members()->attach($user->id);

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'User added successfully!',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
// For debugging use
        // $data = [
        //     'user' => $user,
        //     'groupId' => $groupId,
        //     'email' => $request->input('email'),
        //     'group' => $group
        // ];

        // return response()->json($data);
}
