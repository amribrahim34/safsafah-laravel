<?php

use App\Models\SkinType;
use App\Models\SkinConcern;
use App\Models\ActiveIngredient;
use App\Models\User;
use function Pest\Laravel\postJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can store beauty profile', function () {
    $user = User::factory()->create();
    $skinType = SkinType::factory()->create();
    $skinConcern = SkinConcern::factory()->create();
    $ingredient = ActiveIngredient::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/beauty-profile', [
        'skinTypeId' => $skinType->id,
        'skinConcernIds' => [$skinConcern->id],
        'preferredIngredientIds' => [$ingredient->id],
        'avoidedIngredientIds' => [$ingredient->id],
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'userId',
                'skinType',
                'skinConcerns',
                'allergies',
            ]
        ]);
});
