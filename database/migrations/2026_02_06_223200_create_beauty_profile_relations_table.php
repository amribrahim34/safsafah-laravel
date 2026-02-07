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
        Schema::create('beauty_profile_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('related_id')->comment('ID of the related entity (SkinConcern or ActiveIngredient)');
            $table->string('relation_type', 50)->comment('Type of relation (skin_concern, preferred_ingredient, avoided_ingredient)');
            $table->timestamps();

            $table->index(['user_id', 'relation_type']);
            $table->index('related_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beauty_profile_relations');
    }
};
