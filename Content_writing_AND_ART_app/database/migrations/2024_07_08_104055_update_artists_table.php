<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->string('title');
            $table->text('description');
            $table->integer('width');
            $table->integer('height');
            $table->string('image_path');
            $table->text('keywords');
            $table->string('medium');
            $table->decimal('price', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'description',
                'width',
                'height',
                'image_path',
                'keywords',
                'medium',
                'price',
            ]);
        });
    }
};
