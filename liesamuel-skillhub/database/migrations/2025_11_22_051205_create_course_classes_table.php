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
        Schema::create('courseclasses', function (Blueprint $table) {
            $table->id('courseclass_id');
            $table->string('title', 150);
            $table->string('description', 255);
            $table->string('instructor_name', 100);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration');    // hours
            $table->string('level', 50);    // basic / intermediate / advanced
            $table->string('category', 50); // design / programming / etc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_classes');
    }
};
