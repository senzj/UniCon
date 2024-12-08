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
        Schema::create('groupchat', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('section');
            $table->string('title');
            $table->string('specialization');
            $table->string('adviser');
            $table->string('logo')->default(asset('assets/images/default_logo.png'));
            $table->timestamps(); // adds a date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop table if exist
        Schema::dropIfExists('groupchat');
    }
};
