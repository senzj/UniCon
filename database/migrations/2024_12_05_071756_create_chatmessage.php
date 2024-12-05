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
        // Create chatmessage table
        Schema::create('chatmessage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chatroom_id'); // Links to chatroom
            $table->text('message')->nullable(); // Allow null for messages if only a file is sent
            $table->string('file_path')->nullable(); // Nullable for cases with no file
            $table->unsignedBigInteger('sender'); // Links to user
            $table->timestamps(); // Adds created_at and updated_at columns

            // Foreign key constraints
            $table->foreign('chatroom_id')->references('id')->on('chatroom')->onDelete('cascade');
            $table->foreign('sender')->references('id')->on('users')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop table if exist
        Schema::dropIfExists('chatmesasge');
    }
};
