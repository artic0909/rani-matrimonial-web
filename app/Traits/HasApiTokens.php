<?php

namespace App\Traits;

use App\Models\PersonalAccessToken;
use Illuminate\Support\Str;

trait HasApiTokens
{
    /**
     * Access token relationship or mock for personal access tokens.
     */
    public function tokens()
    {
        if (class_exists(\Laravel\Sanctum\PersonalAccessToken::class)) {
            return $this->morphMany(\Laravel\Sanctum\PersonalAccessToken::class, 'tokenable');
        }

        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }

    /**
     * Create a new personal access token for the candidate.
     */
    public function createToken(string $name, array $abilities = ['*'], ?\DateTimeInterface $expiresAt = null)
    {
        $plainTextToken = Str::random(40);

        $tokenClass = class_exists(\Laravel\Sanctum\PersonalAccessToken::class)
            ? \Laravel\Sanctum\PersonalAccessToken::class
            : PersonalAccessToken::class;

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken),
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
        ]);

        return new class($token, $token->getKey() . '|' . $plainTextToken) {
            public $accessToken;
            public $plainTextToken;

            public function __construct($accessToken, $plainTextToken)
            {
                $this->accessToken = $accessToken;
                $this->plainTextToken = $plainTextToken;
            }
        };
    }

    /**
     * Get the access token currently associated with the candidate.
     */
    public function currentAccessToken()
    {
        return $this->accessToken ?? $this->tokens()->latest()->first();
    }

    /**
     * Set the current access token for the candidate.
     */
    public function withAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }
}
