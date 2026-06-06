<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('featured_image', 500)->nullable()->after('slug');
            $table->unsignedTinyInteger('read_time')->nullable()->after('featured_image');
            $table->timestamp('published_at')->nullable()->after('read_time');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['featured_image', 'read_time', 'published_at']);
        });
    }
};
