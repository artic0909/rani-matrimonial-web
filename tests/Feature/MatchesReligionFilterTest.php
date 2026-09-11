<?php

use App\Models\Candidate;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('muslim male candidate only sees muslim female candidates in matches', function () {
    // Create Muslim Male candidate
    $muslimMale = Candidate::create([
        'mobile' => '9900000001',
        'first_name' => 'Imran',
        'last_name' => 'Khan',
        'gender' => 'Male',
        'religion' => 'Muslim',
    ]);

    // Create Muslim Female candidate
    $muslimFemale = Candidate::create([
        'mobile' => '9900000002',
        'first_name' => 'Fatima',
        'last_name' => 'Sheikh',
        'gender' => 'Female',
        'religion' => 'Muslim',
    ]);

    // Create Hindu Female candidate
    $hinduFemale = Candidate::create([
        'mobile' => '9900000003',
        'first_name' => 'Pooja',
        'last_name' => 'Sharma',
        'gender' => 'Female',
        'religion' => 'Hindu',
    ]);

    // Create Christian Female candidate
    $christianFemale = Candidate::create([
        'mobile' => '9900000004',
        'first_name' => 'Maria',
        'last_name' => 'D\'Souza',
        'gender' => 'Female',
        'religion' => 'Christian',
    ]);

    $response = $this->actingAs($muslimMale)->get('/matches');
    $response->assertStatus(200);

    $matches = $response->viewData('matches');
    $matchIds = array_column($matches, 'db_id');

    expect($matchIds)->toContain($muslimFemale->id)
        ->and($matchIds)->not->toContain($hinduFemale->id)
        ->and($matchIds)->not->toContain($christianFemale->id);
});

test('hindu male candidate only sees hindu female candidates in matches', function () {
    // Create Hindu Male candidate
    $hinduMale = Candidate::create([
        'mobile' => '9900000005',
        'first_name' => 'Rajesh',
        'last_name' => 'Verma',
        'gender' => 'Male',
        'religion' => 'Hindu',
    ]);

    // Create Muslim Female candidate
    $muslimFemale = Candidate::create([
        'mobile' => '9900000006',
        'first_name' => 'Ayesha',
        'last_name' => 'Khan',
        'gender' => 'Female',
        'religion' => 'Muslim',
    ]);

    // Create Hindu Female candidate
    $hinduFemale = Candidate::create([
        'mobile' => '9900000007',
        'first_name' => 'Neha',
        'last_name' => 'Gupta',
        'gender' => 'Female',
        'religion' => 'Hindu',
    ]);

    $response = $this->actingAs($hinduMale)->get('/matches');
    $response->assertStatus(200);

    $matches = $response->viewData('matches');
    $matchIds = array_column($matches, 'db_id');

    expect($matchIds)->toContain($hinduFemale->id)
        ->and($matchIds)->not->toContain($muslimFemale->id);
});

test('muslim female candidate only sees muslim male candidates in matches', function () {
    // Create Muslim Female candidate
    $muslimFemale = Candidate::create([
        'mobile' => '9900000008',
        'first_name' => 'Zara',
        'last_name' => 'Siddiqui',
        'gender' => 'Female',
        'religion' => 'Muslim',
    ]);

    // Create Muslim Male candidate
    $muslimMale = Candidate::create([
        'mobile' => '9900000009',
        'first_name' => 'Sameer',
        'last_name' => 'Khan',
        'gender' => 'Male',
        'religion' => 'Muslim',
    ]);

    // Create Hindu Male candidate
    $hinduMale = Candidate::create([
        'mobile' => '9900000010',
        'first_name' => 'Aarav',
        'last_name' => 'Kapoor',
        'gender' => 'Male',
        'religion' => 'Hindu',
    ]);

    $response = $this->actingAs($muslimFemale)->get('/matches');
    $response->assertStatus(200);

    $matches = $response->viewData('matches');
    $matchIds = array_column($matches, 'db_id');

    expect($matchIds)->toContain($muslimMale->id)
        ->and($matchIds)->not->toContain($hinduMale->id);
});
