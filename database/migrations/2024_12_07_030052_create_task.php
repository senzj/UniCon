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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->string('chapter1')->nullable();
            $table->string('chapter2')->nullable();
            $table->string('chapter3')->nullable();
            $table->string('chapter4')->nullable();
            $table->string('chapter5')->nullable();
            $table->string('chapter6')->nullable();
            $table->string('total_score')->nullable();
            $table->timestamps();
        });

        // for array
        // Schema::create('task', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('group_id');
        //     $table->json('chapter1')->nullable();
        //     $table->json('chapter2')->nullable();
        //     $table->json('chapter3')->nullable();
        //     $table->json('chapter4')->nullable();
        //     $table->json('chapter5')->nullable();
        //     $table->json('chapter6')->nullable();
        //     $table->string('total_score')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task', function (Blueprint $table) {
            // Drop foreign key constraint before dropping the table
            $table->dropForeign(['group_id']);
        });

        Schema::dropIfExists('task');
    }
};