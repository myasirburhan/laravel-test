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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string(column: 'title', length: 255)
                ->comment(comment: 'title of post');
            $table->text(column: 'content')
                ->comment(comment: 'content of post');
            $table->string(column: 'image', length: 255)
                ->comment(comment: 'image url')
                ->nullable(value: true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
