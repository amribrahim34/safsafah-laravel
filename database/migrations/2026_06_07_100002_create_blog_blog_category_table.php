<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_blog_category', function (Blueprint $table) {
            $table->foreignId('blog_id')->constrained('blogs')->cascadeOnDelete();
            $table->foreignId('blog_category_id')->constrained('blog_categories')->cascadeOnDelete();
            $table->primary(['blog_id', 'blog_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_blog_category');
    }
};
