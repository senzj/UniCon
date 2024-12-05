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
        // creates chatmessage table
        Schema::create('chatmessage', function (Blueprint $table) {
            $table->id();
            $table->string('chatroom_id');
            $table->string('message');
            $table->string('sender');
            $table->timestamps();
            // $table->rememberToken();
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
