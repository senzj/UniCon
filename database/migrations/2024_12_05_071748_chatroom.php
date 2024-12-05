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
        // Create chatroom table
        Schema::create('chatroom', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('picture')->default(asset('assets/images/default_logo.png'));
    
            $table->string('members');
            $table->string('filename');
            $table->timestamps(); // adds a date for 
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
