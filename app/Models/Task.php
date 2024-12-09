<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'user_id', // Ensure this is included if you want to associate tasks with users
        'group_id', 
        'message_id',
        'complete',
        'project_title',
        'reporting_date', 
        'reporting_week', 
        'day1_date', 'day1_activities',
        'day2_date', 'day2_activities',
        'day3_date', 'day3_activities',
        'day4_date', 'day4_activities',
        'day5_date', 'day5_activities',
        'day6_date', 'day6_activities',
    ];

    // Relationship with Groupchat
    public function group()
    {
        return $this->belongsTo(Groupchat::class, 'group_id');
    }

    // Relationship with Message
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    // Relationship with User (if applicable)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}