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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id'); // Assuming group_id is a foreign key
            $table->unsignedBigInteger('message_id'); // Assuming message_id is a foreign key
            $table->string('project_title');
            $table->integer('complete')->default(0); // Default to 0 (not complete)
            $table->date('reporting_date');
            $table->tinyInteger('reporting_week');

            // Fields for daily activities (Day 1 to Day 6)
            $table->date('day1_date')->nullable(); // Date for Day 1
            $table->text('day1_activities')->nullable(); // Activities for Day 1
            $table->date('day2_date')->nullable(); // Date for Day 2
            $table->text('day2_activities')->nullable(); // Activities for Day 2
            $table->date('day3_date')->nullable(); // Date for Day 3
            $table->text('day3_activities')->nullable(); // Activities for Day 3
            $table->date('day4_date')->nullable(); // Date for Day 4
            $table->text('day4_activities')->nullable(); // Activities for Day 4
            $table->date('day5_date')->nullable(); // Date for Day 5
            $table->text('day5_activities')->nullable(); // Activities for Day 5
            $table->date('day6_date')->nullable(); // Date for Day 6
            $table->text('day6_activities')->nullable(); // Activities for Day 6

            $table->timestamps(); // This creates 'created_at' and 'updated_at' columns

            // Foreign key constraints
            $table->foreign('group_id')->references('id')->on('groupchat')->onDelete('cascade');
            $table->foreign('message_id')->references('id')->on('groupmessage')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};