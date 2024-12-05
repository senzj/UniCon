<?php

namespace App\Http\Controllers;

use App\Models\GroupChat; // Ensure this class exists
use App\Models\Submission; // Ensure this class exists
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
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

    public function createGroupChat(Request $request)
    {
        // Validate the request
        $request->validate([
            'group_name' => 'required|string|max:255',
        ]);

        // Create a new group chat
        $groupChat = new GroupChat();
        $groupChat->name = $request->group_name;
        $groupChat->save();

        // Redirect back to the home page with a success message
        return redirect()->route('teacher.home')->with('success', 'Group chat created successfully!');
    }

    public function index()
    {
        // Fetch all group chats for the home view
        $groupChats = GroupChat::all(); // Fetch all group chats
        return view('teacher.home', compact('groupChats')); // Return the home view with group chats
    }
}