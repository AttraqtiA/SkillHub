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
        Schema::create('participant_classes', function (Blueprint $table) {
            $table->id('participant_class_id');
            $table->unsignedBigInteger('participant_id');
            $table->unsignedBigInteger('courseclass_id');
            $table->dateTime('enrolled_at');
            $table->string('status', 50)->default('active'); // active / cancelled / completed
            $table->string('grade', 10)->nullable();
            $table->integer('progress')->default(0); // 0-100
            $table->timestamps();

            $table->foreign('participant_id')
                ->references('participant_id')->on('participants')
                ->onDelete('cascade');

            $table->foreign('courseclass_id')
                ->references('courseclass_id')->on('courseclasses')
                ->onDelete('cascade');

            $table->unique(['participant_id', 'courseclass_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_classes');
    }
};
