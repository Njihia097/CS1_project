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
        Schema::create('chapter', function (Blueprint $table) {
            $table->id('ChapterID');
            $table->unsignedBigInteger('ContentID');
            $table->string('Title', 255);
            $table->text('Body')->nullable();
            $table->integer('ChapterNumber');
            $table->timestamps(); 
            $table->json('content_delta')->nullable(); // JSON column for Quilljs content delta

            $table->foreign('ContentID')->references('ContentID')->on('content')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapter');
    }
};
