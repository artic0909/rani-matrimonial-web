<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
    ];

    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function tokenable()
    {
        return $this->morphTo();
    }

    /**
     * Find the token instance for the given token string.
     */
    public static function findToken(?string $token)
    {
        if (empty($token)) {
            return null;
        }

        if (str_contains($token, '|')) {
            [$id, $plainToken] = explode('|', $token, 2);
            $instance = static::find($id);
            if ($instance && hash_equals($instance->token, hash('sha256', $plainToken))) {
                return $instance;
            }
            return null;
        }

        return static::where('token', hash('sha256', $token))->first();
    }
}
