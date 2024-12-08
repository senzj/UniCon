<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'reporting_date' => 'required|date',
            'reporting_week' => 'required|integer|min:1|max:8',
            'project_title' => 'required|string|max:255',
            'chapter_1_date' => 'nullable|date',
            'chapter_1_activities' => 'nullable|string',
            'chapter_2_date' => 'nullable|date',
            'chapter_2_activities' => 'nullable|string',
            'chapter_3_date' => 'nullable|date',
            'chapter_3_activities' => 'nullable|string',
            'chapter_4_date' => 'nullable|date',
            'chapter_4_activities' => 'nullable|string',
            'chapter_5_date' => 'nullable|date',
            'chapter_5_activities' => 'nullable|string',
            'chapter_6_date' => 'nullable|date',
            'chapter_6_activities' => 'nullable|string',
        ]);

        // Save to database
        Task::create([
            'group_name' => $validatedData['group_name'],
            'reporting_date' => $validatedData['reporting_date'],
            'reporting_week' => $validatedData['reporting_week'],
            'project_title' => $validatedData['project_title'],
            'day1_date' => $validatedData['chapter_1_date'] ?? null,
            'day1_activities' => $validatedData['chapter_1_activities'] ?? null,
            'day2_date' => $validatedData['chapter_2_date'] ?? null,
            'day2_activities' => $validatedData['chapter_2_activities'] ?? null,
            'day3_date' => $validatedData['chapter_3_date'] ?? null,
            'day3_activities' => $validatedData['chapter_3_activities'] ?? null,
            'day4_date' => $validatedData['chapter_4_date'] ?? null,
            'day4_activities' => $validatedData['chapter_4_activities'] ?? null,
            'day5_date' => $validatedData['chapter_5_date'] ?? null,
            'day5_activities' => $validatedData['chapter_5_activities'] ?? null,
            'day6_date' => $validatedData['chapter_6_date'] ?? null,
            'day6_activities' => $validatedData['chapter_6_activities'] ?? null,
        ]);

        return back()->with('success', 'Progress report submitted successfully.');
    }
}
