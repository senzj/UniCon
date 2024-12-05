<?php

namespace App\Http\Controllers;

use App\Models\GroupChat; // Ensure this class exists
use App\Models\Submission; // Ensure this class exists
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{

    // teacher dashboard view
    public function index()
    {
        // Fetch all group chats for the home view
        $groupChats = GroupChat::all(); // Fetch all group chats
        return view('teacher.home', compact('groupChats')); // Return the home view with group chats
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
            'group_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // File validation
        ]);

        // Get the validated data excluding the file
        $groupChatDetails = $request->only(['group_name', 'group_section', 'group_specialization', 'group_adviser']);

        // Handle the file upload
        if ($request->hasFile('group_logo')) {
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
            'logo' => $groupChatDetails['group_logo_path'], // Ensure this matches your database column
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
        // return response()->json($data);
    }

    public function getGroupchats()
    {
        try {
            // Fetch group chats where the current user is a member
            $groupChats = Auth::user()->groupChats()->with([
                'members', 
                'creator'
            ])
            ->latest()
            ->paginate(10);

            return view('your-view-path', [
                'groupChats' => $groupChats
            ]);
        } catch (\Exception $e) {
            Log::error('Group Chats Fetch Error', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Unable to retrieve group chats');
        }
    }


    // add member to group chat
    public function addMember(Request $request, $groupChatId)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $groupChat = GroupChat::findOrFail($groupChatId);
        $user = User::where('email', $request->input('email'))->firstOrFail();

        $groupChat->members()->attach($user);

        return back()->with('success', 'Member added successfully!');
    }

    // group chat view
    public function groupChat($id)
    {
        $groupChat = GroupChat::with(['members', 'submissions'])->findOrFail($id);
        $groupChats = GroupChat::all();
        $submissions = $groupChat->submissions;

        return view('teachers.home', compact('groupChats', 'groupChat', 'submissions'));
    }

    public function gradeSubmission(Request $request, $submissionId)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'comment' => 'nullable|string|max:255',
        ]);

        $submission = Submission::findOrFail($submissionId);

        $submission->update([
            'grade' => $request->input('grade'),
            'comment' => $request->input('comment'),
        ]);

        return back()->with('success', 'Grade and comment added successfully!');
    }

    public function showHome($groupChatId)
    {
        // Fetch the specific group chat
        $groupChat = GroupChat::with(['members', 'submissions'])->find($groupChatId);

        // Fetch all group chats for the left section
        $groupChats = GroupChat::all();

        // Fetch submissions for the specific group chat
        $submissions = $groupChat ? $groupChat->submissions : collect(); // Use an empty collection if $groupChat is null

        return view('home', compact('groupChats', 'groupChat', 'submissions'));
    }
}
