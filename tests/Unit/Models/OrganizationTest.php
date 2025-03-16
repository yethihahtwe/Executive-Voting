<?php

test('organization has many representatives', function () {
    $organization = App\Models\Organization::factory()
        ->has(App\Models\Representative::factory()->count(3))
        ->create();
        
    expect($organization->representatives)->toHaveCount(3)
        ->and($organization->representatives->first()->organization_id)->toBe($organization->id);
});

test('organization has many voters', function () {
    $organization = App\Models\Organization::factory()
        ->has(App\Models\Voter::factory()->count(5))
        ->create();
        
    expect($organization->voters)->toHaveCount(5)
        ->and($organization->voters->first()->organization_id)->toBe($organization->id);
});
