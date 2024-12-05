<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// user model
class User extends Authenticatable
{
    use Notifiable;

    // if sometimes table doesn't exist in the database, we can define the table name here, to avoid any error
    protected $table = 'users'; // user table

    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'password', 
        'role',
    ];

    public $timestamps = false; // Disable timestamps

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // /**
    //  * Get the attributes that should be cast.
    //  *
    //  * @return array<string, string>
    //  */
    // protected function casts(): array
    // {
    //     return [
    //         // 'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    // get the group members
    public function groupChats()
    {
        return $this->belongsToMany(GroupChat::class);
    }
    
}
