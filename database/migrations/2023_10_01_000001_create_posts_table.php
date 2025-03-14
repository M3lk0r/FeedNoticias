<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function(Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            // Data/Hora programada para publicação (pode ser nula se publicação imediata)
            $table->dateTime('scheduled_at')->nullable();
            // Data/Hora da publicação real
            $table->dateTime('published_at')->nullable();
            // Status: 'published', 'scheduled' ou 'draft'
            $table->enum('status', ['published', 'scheduled', 'draft'])->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}