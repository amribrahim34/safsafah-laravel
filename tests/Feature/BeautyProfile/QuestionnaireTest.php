<?php

use App\Models\SkinType;
use App\Models\SkinConcern;
use App\Models\ActiveIngredient;
use App\Models\User;
use function Pest\Laravel\getJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can fetch beauty questionnaire options', function () {
    SkinType::factory()->create();
    SkinConcern::factory()->create();
    ActiveIngredient::factory()->create();

    $user = User::factory()->create();
    $response = $this->actingAs($user)->getJson('/api/beauty-questionnaire');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'skinTypes',
                'skinConcerns',
                'activeIngredients',
            ]
        ]);
});
