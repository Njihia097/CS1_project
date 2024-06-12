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
        Schema::create('content', function (Blueprint $table) {
            $table->id('ContentID');
            $table->string('Title', 255);
            $table->unsignedBigInteger('AuthorID');
            $table->unsignedBigInteger('CategoryID');
            $table->string('thumbnail', 255)->nullable();
            $table->text('ContentBody')->nullable();
            $table->boolean('IsChapter');
            $table->boolean('IsPublished');
            $table->date('PublicationDate')->nullable();
            $table->enum('Status', ['pending', 'approved', 'flagged', 'suspended']);
            $table->date('SuspendedUntil')->nullable();
            $table->timestamps(); 
            $table->json('content_delta')->nullable(); // JSON column for Quilljs content delta
            $table->json('keywords')->nullable(); // JSON column for keywords

            $table->foreign('AuthorID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('CategoryID')->references('CategoryID')->on('category_content')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content');
    }
};
