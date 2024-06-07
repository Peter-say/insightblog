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
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('blog_posts')->onDelete('cascade');
            $table->text('body');
            $table->string('commenter_name');
            $table->string('commenter_email');
            $table->string('commenter_website')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('blog_comments')->onDelete('cascade'); // Self-referencing foreign key
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved'); // Assuming comments are auto-approved
            $table->timestamp('moderated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};
