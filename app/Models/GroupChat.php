<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Groupchat model
class Groupchat extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'groupchat';

    // Define fillable fields
    protected $fillable = [
        'name',            // Updated to match your previous code
        'title',
        'section',         // Added field for group section
        'specialization',  // Added field for group specialization
        'adviser',         // Added field for group adviser
        'logo',       // Added field for logo path
        'term',
        'academic_year',
        'mentoring_day',
        'mentoring_time',
    ];

    // get the group members
    public function groupChats()
    {
        return $this->belongsToMany(
            Groupchat::class, 
            'groupmembers', 
            'user_id', 
            'groupchat_id'
        )
        // ->withPivot(['role', 'joined_at'])
        ->withTimestamps();
    }

    // add to groupmembers table
    public function members()
    {
        return $this->belongsToMany(
            User::class,           // Related Model
            'groupmembers',        // Pivot table name
            'groupchat_id',        // Foreign key of current model
            'user_id'              // Foreign key of related model
        )
        // ->withPivot(['role', 'joined_at']) // Optional: Add additional pivot table columns
        ->withTimestamps();        // Automatically manage created_at and updated_at in pivot table
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'groupmembers', 'groupchat_id', 'user_id');
        
    }

    // Relationship with submissions
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    // Add relationship with messages
    public function messages()
    {
        return $this->hasMany(Message::class, 'group_id');
    }
    
}