<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request)
{
    // Validate the input
    $validatedData = $request->validate([
        'group_name' => 'required|string|max:255',
        'reporting_date' => 'required|date',
        'reporting_week' => 'required|integer|between:1,8',
        'project_title' => 'required|string|max:255',
        // ... other validations
    ]);

    try {
        // Find the group based on the group name
        $group = DB::table('groupchat')->where('name', $request->input('group_name'))->first();
        
        if (!$group) {
            return back()->with('error', 'Group not found');
        }

        // Get the current authenticated user's ID
        $userId = Auth::id(); // Make sure to use Auth facade

        if (!$userId) {
            return back()->with('error', 'User not authenticated');
        }

        // Attempt to create or find a message
        $messageData = [
            'group_id' => $group->id,
            'user_id' => $userId, // Add user_id
            'message' => $request->input('project_title'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Try to insert the message and get its ID
        $messageId = DB::table('groupmessage')->insertGetId($messageData);

        // Prepare the task data
        $taskData = [
            'group_id' => $group->id,
            'message_id' => $messageId,
            'reporting_date' => $request->input('reporting_date'),
            'reporting_week' => $request->input('reporting_week'),
            'day1_date' => $request->input('chapter_1_date'),
            'day1_activities' => $request->input('chapter_1_activities'),
            'day2_date' => $request->input('chapter_2_date'),
            'day2_activities' => $request->input('chapter_2_activities'),
            'day3_date' => $request->input('chapter_3_date'),
            'day3_activities' => $request->input('chapter_3_activities'),
            'day4_date' => $request->input('chapter_4_date'),
            'day4_activities' => $request->input('chapter_4_activities'),
            'day5_date' => $request->input('chapter_5_date'),
            'day5_activities' => $request->input('chapter_5_activities'),
            'day6_date' => $request->input('chapter_6_date'),
            'day6_activities' => $request->input('chapter_6_activities'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert the task
        $taskId = DB::table('tasks')->insertGetId($taskData);

        return back()->with('success', 'Progress report submitted successfully');
    } catch (\Exception $e) {
        // Log the error with full details
        \Log::error('Task creation error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'input' => $request->all()
        ]);
        
        return back()->with('error', 'Failed to submit progress report: ' . $e->getMessage());
    }
}
}