<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // declare the table name
    protected $table = 'task';

    protected $fillable = [
        'group_id', 
        'chapter1', 
        'chapter2', 
        'chapter3', 
        'chapter4', 
        'chapter5', 
        'chapter6'
    ];

    // Cast JSON columns
    // protected $casts = [
    //     'chapter1' => 'array',
    //     'chapter2' => 'array',
    //     'chapter3' => 'array',
    //     'chapter4' => 'array',
    //     'chapter5' => 'array',
    //     'chapter6' => 'array',
    // ];

    // Relationship with group
    public function group()
    {
        return $this->belongsTo(Groupchat::class);
    }

    // Method to update chapter grades
    public function updateChapterGrades(string $chapter, array $grades)
    {
        $this->setAttribute($chapter, $grades);
        // $this->calculateTotalScore();
        $this->save();
    }

    // // Calculate total score based on chapter grades
    // public function calculateTotalScore()
    // {
    //     $totalScore = 0;
    //     $chapterCount = 0;

    //     for ($i = 1; $i <= 6; $i++) {
    //         $chapterKey = "chapter$i";
    //         $chapterData = $this->$chapterKey;

    //         if (!empty($chapterData) && isset($chapterData['overall_score'])) {
    //             $totalScore += $chapterData['overall_score'];
    //             $chapterCount++;
    //         }
    //     }

    //     // Calculate average if chapters have been graded
    //     if ($chapterCount > 0) {
    //         $this->total_score = $totalScore / $chapterCount;
            
    //         // Update overall status
    //         $this->overall_status = $this->total_score == 100 ? 'completed' : 'in_progress';
    //     }
    // }

}