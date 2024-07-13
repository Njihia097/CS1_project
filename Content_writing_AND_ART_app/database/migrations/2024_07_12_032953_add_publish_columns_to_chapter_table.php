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
        Schema::table('chapter', function (Blueprint $table) {
            $table->boolean('IsPublished')->default(false)->after('ChapterNumber');
            $table->timestamp('publication_date')->nullable()->after('IsPublished');
            $table->enum('Status', ['draft', 'pending', 'approved', 'flagged', 'suspended'])->after('publication_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chapter', function (Blueprint $table) {
            $table->dropColumn('IsPublished');
            $table->dropColumn('publication_date');
            $table->dropColumn('Status', ['draft', 'pending', 'approved', 'flagged', 'suspended']);
        });
    }
};
