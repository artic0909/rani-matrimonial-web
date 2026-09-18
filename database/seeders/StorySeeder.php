<?php

namespace Database\Seeders;

use App\Models\Story;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Seed initial success stories into database.
     */
    public function run(): void
    {
        if (Story::count() > 0) {
            return;
        }

        $sampleStories = [
            [
                'title' => 'Vikram & Ananya: Two Hearts United by Destiny',
                'couple_names' => 'Vikram Sharma & Ananya Verma',
                'wedding_date' => '2026-02-14',
                'images' => json_encode(['img/hero.png', 'img/card_couple_bg.jpg']),
                'descriptions' => "We connected on Rani Matrimonial in October. What started with a polite connection request and a conversation about shared values, family traditions, and life goals soon blossomed into something truly magical.\n\nOur families met in Delhi and instantly bonded over tea and laughter. With our parents' heartfelt blessings, we tied the knot in a grand royal ceremony. Thank you, Rani Matrimonial, for helping us discover our soulmate!",
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Rohan & Priya: A Lifetime of Love & Companionship',
                'couple_names' => 'Rohan Mehta & Priya Desai',
                'wedding_date' => '2026-04-20',
                'images' => json_encode(['img/card_couple_bg.jpg', 'img/indexbanner.jpg']),
                'descriptions' => "Finding someone who shares the same cultural outlook and career ambitions felt like a daunting task until we found Rani Matrimonial. The verified profiles gave us peace of mind and complete trust.\n\nAfter connecting and chatting on the platform, we knew we were meant for each other. Today, as we begin our new journey as husband and wife, we are eternally grateful to Rani Matrimonial.",
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Aditya & Neha: A Modern Fairytale of Shared Values',
                'couple_names' => 'Aditya Singhania & Neha Kapoor',
                'wedding_date' => '2026-06-10',
                'images' => json_encode(['img/indexbanner.jpg', 'img/hero.png']),
                'descriptions' => "Rani Matrimonial's matchmaking filters helped us discover each other despite living in different cities. The transparency, detailed candidate bios, and family backgrounds made our decision effortless.\n\nFrom our first conversation to our wedding mandap, every step was pure harmony. If you're looking for genuine, family-oriented life partners, this is the right place!",
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($sampleStories as $item) {
            Story::create($item);
        }
    }
}
