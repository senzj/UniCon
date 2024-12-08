<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name', 
        'reporting_date', 
        'reporting_week', 
        'project_title',
        'day1_date', 'day1_activities',
        'day2_date', 'day2_activities',
        'day3_date', 'day3_activities',
        'day4_date', 'day4_activities',
        'day5_date', 'day5_activities',
        'day6_date', 'day6_activities',
    ];
}
