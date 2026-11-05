<?php

namespace Database\Seeders;

use App\Models\Story;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Seed 10 realistic, diverse success stories into the database.
     */
    public function run(): void
    {
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
                'images' => json_encode(['img/indexbanner.jpg', 'img/section-couple.png']),
                'descriptions' => "Rani Matrimonial's matchmaking filters helped us discover each other despite living in different cities. The transparency, detailed candidate bios, and family backgrounds made our decision effortless.\n\nFrom our first conversation to our wedding mandap, every step was pure harmony. If you're looking for genuine, family-oriented life partners, this is the right place!",
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Sourav & Debolina: A Serendipitous Kolkata Romance',
                'couple_names' => 'Sourav Mukherjee & Debolina Banerjee',
                'wedding_date' => '2026-01-22',
                'images' => json_encode(['img/section-couple.png', 'img/hero.png']),
                'descriptions' => "Both of our families were looking for someone who respected Bengali cultural heritage, literature, and close family bonds. When Sourav's request appeared on my Rani Matrimonial feed, our biodatas matched 98%!\n\nWe had our first meet over phuchka and filter coffee at Victoria Memorial. Six months later, with traditional 'Shubho Drishti' and ululation, we tied the knot. Rani Matrimonial made the arranged marriage journey so warm and personal!",
                'is_active' => true,
                'order' => 4,
            ],
            [
                'title' => 'Kabir & Farzana: Bound by Faith, Respect & Love',
                'couple_names' => 'Kabir Ahmed & Farzana Siddiqui',
                'wedding_date' => '2026-03-08',
                'images' => json_encode(['img/card_couple_bg.jpg', 'img/section-couple.png']),
                'descriptions' => "Finding someone pious, well-educated, and grounded in family values was our priority. Rani Matrimonial's Islamic matchmaking filters and privacy-focused photo settings gave our families total confidence.\n\nOur parents connected through the platform first, followed by our Nikah ceremony in Hyderabad. Alhumdulillah for this blessed union through Rani Matrimonial!",
                'is_active' => true,
                'order' => 5,
            ],
            [
                'title' => 'Karthik & Meenakshi: Tradition Meets Compatibility',
                'couple_names' => 'Karthik Sundaram & Meenakshi Iyer',
                'wedding_date' => '2026-05-15',
                'images' => json_encode(['img/indexbanner.jpg', 'img/card_couple_bg.jpg']),
                'descriptions' => "As working professionals living in Bengaluru, finding a partner with matching horoscopes, shared South Indian traditions, and global aspirations was tough. Rani Matrimonial's detailed lifestyle and community preferences made our discovery seamless.\n\nToday, we celebrate our traditional Iyer wedding with sheer joy and gratitude to Rani Matrimonial for bringing our worlds together.",
                'is_active' => true,
                'order' => 6,
            ],
            [
                'title' => 'Siddharth & Tanvi: Two Souls, One Beautiful Beginning',
                'couple_names' => 'Siddharth Joshi & Tanvi Kulkarni',
                'wedding_date' => '2025-11-28',
                'images' => json_encode(['img/hero.png', 'img/indexbanner.jpg']),
                'descriptions' => "From exchanging respectful chats on the Rani Matrimonial portal to our first family meeting in Pune, everything unfolded smoothly. The verified badge and authentic profiles eliminated all the uncertainties of modern matchmaking.\n\nWe completed our Maharashtrian wedding rituals surrounded by our beloved families. Thank you, Rani Matrimonial, for giving us our happily ever after!",
                'is_active' => true,
                'order' => 7,
            ],
            [
                'title' => 'Arjun & Simran: When Stars Aligned in Chandigarh',
                'couple_names' => 'Arjun Singh Gill & Simran Kaur',
                'wedding_date' => '2025-12-18',
                'images' => json_encode(['img/card_couple_bg.jpg', 'img/hero.png']),
                'descriptions' => "Our Anand Karaj ceremony in Amritsar was a dream come true, and the first spark began right here on Rani Matrimonial. Simran's laughter and family-first nature stood out immediately.\n\nThe platform's intuitive filters and prompt customer support made the matchmaking experience transparent and stress-free. We recommend Rani Matrimonial to every hopeful heart looking for a genuine life partner.",
                'is_active' => true,
                'order' => 8,
            ],
            [
                'title' => 'Rajesh & Sunita: Finding Love and Second Chances',
                'couple_names' => 'Rajesh Agarwal & Sunita Bansal',
                'wedding_date' => '2026-02-28',
                'images' => json_encode(['img/section-couple.png', 'img/indexbanner.jpg']),
                'descriptions' => "Entering the matrimonial search for a second chance in life can be daunting, but Rani Matrimonial treated our journey with utmost dignity, warmth, and discretion.\n\nWe found true understanding, companionship, and emotional safety in each other. Our children and families are overjoyed. Love truly has no deadline when destiny is on your side.",
                'is_active' => true,
                'order' => 9,
            ],
            [
                'title' => 'Aman & Ritika: Across Continents to Forever',
                'couple_names' => 'Aman Choudhury & Ritika Sen',
                'wedding_date' => '2026-07-04',
                'images' => json_encode(['img/hero.png', 'img/card_couple_bg.jpg']),
                'descriptions' => "Living in London while searching for someone rooted in Indian traditions seemed difficult until I registered on Rani Matrimonial. The time zone and international contact features helped us stay connected effortlessly through chats and video calls.\n\nWhen I flew back to Kolkata, meeting Ritika felt like coming home. We are ecstatic to start our international adventure together!",
                'is_active' => true,
                'order' => 10,
            ],
        ];

        foreach ($sampleStories as $item) {
            Story::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
