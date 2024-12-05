<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupchat extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'groupchat';

    // Define fillable fields
    protected $fillable = [
        'name',            // Updated to match your previous code
        'section',         // Added field for group section
        'specialization',  // Added field for group specialization
        'adviser',         // Added field for group adviser
        'logo',       // Added field for logo path
    ];

    // get the group members
    public function groupChats()
    {
        return $this->belongsToMany(
            Groupchat::class, 
            'group_members', 
            'user_id', 
            'groupchat_id'
        )
        ->withPivot(['role', 'joined_at'])
        ->withTimestamps();
    }

    // In Groupchat model
    public function members()
    {
        return $this->belongsToMany(
            User::class,           // Related Model
            'groupmembers',        // Pivot table name (use snake_case)
            'groupchat_id',        // Foreign key of current model
            'user_id'              // Foreign key of related model
        )
        ->withPivot(['role', 'joined_at']) // Optional: Add additional pivot table columns
        ->withTimestamps();        // Automatically manage created_at and updated_at in pivot table
    }

    // Additional helpful relationship methods
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function admin()
    {
        return $this->belongsToMany(User::class, 'group_members')
            ->wherePivot('role', 'admin');
    }

    // Relationship with submissions
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}