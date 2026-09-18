<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $table = 'stories';

    protected $fillable = [
        'title',
        'couple_names',
        'wedding_date',
        'images',
        'descriptions',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'wedding_date' => 'date',
    ];

    /**
     * Scope for active/published stories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Get primary image URL
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->images)) {
            return asset('img/hero.png');
        }

        $val = $this->images;
        // Check if JSON array
        if (str_starts_with($val, '[') || str_starts_with($val, '{')) {
            $decoded = json_decode($val, true);
            if (is_array($decoded) && !empty($decoded)) {
                $val = $decoded[0];
            }
        } elseif (str_contains($val, ',')) {
            $parts = explode(',', $val);
            $val = trim($parts[0]);
        }

        if (str_starts_with($val, 'http')) {
            return $val;
        }

        if (str_starts_with($val, 'img/')) {
            return asset($val);
        }

        return asset('storage/' . ltrim($val, '/'));
    }

    /**
     * Get all image URLs as an array
     */
    public function getGalleryImagesAttribute(): array
    {
        if (empty($this->images)) {
            return [asset('img/hero.png')];
        }

        $list = [];
        $raw = $this->images;

        if (str_starts_with($raw, '[') || str_starts_with($raw, '{')) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $list = $decoded;
            }
        } elseif (str_contains($raw, ',')) {
            $list = array_filter(array_map('trim', explode(',', $raw)));
        } else {
            $list = [$raw];
        }

        return array_map(function ($item) {
            if (str_starts_with($item, 'http')) {
                return $item;
            }
            if (str_starts_with($item, 'img/')) {
                return asset($item);
            }
            return asset('storage/' . ltrim($item, '/'));
        }, $list);
    }

    /**
     * Formatted wedding date
     */
    public function getFormattedWeddingDateAttribute(): ?string
    {
        if (!$this->wedding_date) {
            return null;
        }

        try {
            return Carbon::parse($this->wedding_date)->format('F d, Y');
        } catch (\Exception $e) {
            return (string) $this->wedding_date;
        }
    }
}
