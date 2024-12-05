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
        // Creates chatmessage table
        Schema::create('chatmessage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chatroom_id');
            $table->text('message')->nullable(); // Allow null for messages if only a file is sent
            $table->string('file_path')->nullable(); // To store the file path
            $table->unsignedBigInteger('sender');
            $table->timestamps();

            // Foreign key constraints (optional, based on your schema)
            $table->foreign('chatroom_id')->references('id')->on('chatroom_tbl')->onDelete('cascade');
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
