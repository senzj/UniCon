<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the group_members pivot table
        Schema::create('groupmembers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('groupchat_id');  // Foreign key to the groupchat table
            $table->unsignedBigInteger('user_id');  // Foreign key to the users table
            $table->timestamps();

            // Define foreign keys
            $table->foreign('groupchat_id')->references('id')->on('groupchat')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupmembers');
    }
};
