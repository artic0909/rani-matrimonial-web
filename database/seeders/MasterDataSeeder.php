<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Community;
use App\Models\Country;
use App\Models\Diet;
use App\Models\Height;
use App\Models\Hobby;
use App\Models\Income;
use App\Models\MaritalStatus;
use App\Models\Religion;
use App\Models\State;
use App\Models\WorkingWith;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        City::truncate();
        State::truncate();
        Country::truncate();
        Community::truncate();
        Religion::truncate();
        MaritalStatus::truncate();
        Height::truncate();
        Diet::truncate();
        Income::truncate();
        Hobby::truncate();
        WorkingWith::truncate();
        Schema::enableForeignKeyConstraints();

        $now = now();

        // 1. Marital Statuses
        $maritalStatuses = [
            ['name' => 'Never Married', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Divorced', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Widowed', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Awaiting Divorce', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Annulled', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('marital_statuses')->insert($maritalStatuses);

        // 2. Heights
        $heightsList = [
            "4' 0\" (121 cm)", "4' 1\" (124 cm)", "4' 2\" (127 cm)", "4' 3\" (129 cm)", "4' 4\" (132 cm)",
            "4' 5\" (134 cm)", "4' 6\" (137 cm)", "4' 7\" (139 cm)", "4' 8\" (142 cm)", "4' 9\" (144 cm)",
            "4' 10\" (147 cm)", "4' 11\" (149 cm)", "5' 0\" (152 cm)", "5' 1\" (154 cm)", "5' 2\" (157 cm)",
            "5' 3\" (160 cm)", "5' 4\" (162 cm)", "5' 5\" (165 cm)", "5' 6\" (167 cm)", "5' 7\" (170 cm)",
            "5' 8\" (172 cm)", "5' 9\" (175 cm)", "5' 10\" (177 cm)", "5' 11\" (180 cm)", "6' 0\" (182 cm)",
            "6' 1\" (185 cm)", "6' 2\" (187 cm)", "6' 3\" (190 cm)", "6' 4\" (193 cm)", "6' 5\" (195 cm)",
            "6' 6\" (198 cm)", "6' 7\" (200 cm)", "6' 8\" (203 cm)", "6' 9\" (205 cm)", "6' 10\" (208 cm)",
            "6' 11\" (210 cm)", "7' 0\" (213 cm)",
        ];
        $heightsData = array_map(fn ($height) => [
            'name' => $height,
            'created_at' => $now,
            'updated_at' => $now,
        ], $heightsList);
        DB::table('heights')->insert($heightsData);

        // 3. Diets
        $diets = [
            ['name' => 'Vegetarian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Non-Vegetarian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Eggetarian', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Vegan', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Jain', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('diets')->insert($diets);

        // 4. Incomes
        $incomesList = [
            'No Income',
            'Under 1 Lakh',
            '1 - 2 Lakhs',
            '2 - 3 Lakhs',
            '3 - 4 Lakhs',
            '4 - 5 Lakhs',
            '5 - 7.5 Lakhs',
            '7.5 - 10 Lakhs',
            '10 - 15 Lakhs',
            '15 - 20 Lakhs',
            '20 - 30 Lakhs',
            '30 - 50 Lakhs',
            '50 - 75 Lakhs',
            '75 Lakhs - 1 Crore',
            '1 Crore & Above',
        ];
        $incomesData = array_map(fn ($inc) => [
            'name' => $inc,
            'created_at' => $now,
            'updated_at' => $now,
        ], $incomesList);
        DB::table('incomes')->insert($incomesData);

        // 5. Hobbies
        $hobbiesList = [
            'Reading Books',
            'Traveling & Exploring',
            'Cooking & Culinary Arts',
            'Music & Playing Instruments',
            'Singing',
            'Photography',
            'Dancing',
            'Painting & Sketching',
            'Gardening & Plants',
            'Fitness, Gym & Workouts',
            'Yoga & Meditation',
            'Movies & OTT Series',
            'Writing & Blogging',
            'Playing Sports (Cricket, Football, Badminton)',
            'Trekking & Outdoor Adventures',
            'Video Gaming & Esports',
            'Volunteering & Social Service',
            'Pet Care & Animals',
            'Theater & Performing Arts',
            'Cycling & Running',
            'Board Games & Puzzles',
            'DIY & Crafting',
        ];
        $hobbiesData = array_map(fn ($hobby) => [
            'name' => $hobby,
            'created_at' => $now,
            'updated_at' => $now,
        ], $hobbiesList);
        DB::table('hobbies')->insert($hobbiesData);

        // 6. Religions & Communities
        $religionsWithCommunities = [
            'Hindu' => [
                'Brahmin', 'Brahmin - Gaur', 'Brahmin - Saraswat', 'Brahmin - Kanyakubj', 'Brahmin - Iyer', 'Brahmin - Iyengar',
                'Kshatriya', 'Rajput', 'Maratha', 'Agarwal', 'Kayastha', 'Khatri', 'Arora', 'Yadav', 'Gujjar', 'Lingayat',
                'Reddy', 'Nair', 'Ezhava', 'Bania', 'Jat', 'Patel', 'Patel - Leva', 'Patel - Kadva', 'Thevar', 'Mudaliar',
                'Sindhi', 'Maheshwari', 'Kamma', 'Kapu', 'Vokkaliga', 'Nadar', 'SC', 'ST', 'Other',
            ],
            'Muslim' => [
                'Sunni', 'Shia', 'Hanafi', 'Shafi', 'Maliki', 'Hanbali', 'Dawoodi Bohra', 'Ismaili', 'Sufi',
                'Ansari', 'Qureshi', 'Sheikh', 'Syed', 'Pathan', 'Mughal', 'Other',
            ],
            'Christian' => [
                'Roman Catholic', 'Protestant', 'Latin Catholic', 'Syrian Catholic', 'Pentecostal', 'Baptist',
                'Mar Thoma', 'Orthodox', 'Anglican', 'Methodist', 'Other',
            ],
            'Sikh' => [
                'Jat', 'Khatri', 'Arora', 'Ramgarhia', 'Ahluwalia', 'Saini', 'Kamboj', 'Mazhabi', 'Bhatia', 'Other',
            ],
            'Jain' => [
                'Digambar', 'Shwetambar', 'Agarwal', 'Oswal', 'Khandelwal', 'Porwal', 'Other',
            ],
            'Buddhist' => [
                'Theravada', 'Mahayana', 'Navayana / Neo-Buddhist', 'Tibetan', 'Other',
            ],
            'Parsi' => [
                'Irani', 'Parsi', 'Other',
            ],
            'Jewish' => [
                'Bene Israel', 'Baghdadi', 'Cochin', 'Other',
            ],
            'Other' => [
                'Other',
            ],
        ];

        foreach ($religionsWithCommunities as $religionName => $communities) {
            $religionId = DB::table('religions')->insertGetId([
                'name' => $religionName,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $commData = array_map(fn ($comm) => [
                'religion_id' => $religionId,
                'name' => $comm,
                'created_at' => $now,
                'updated_at' => $now,
            ], $communities);

            DB::table('communities')->insert($commData);
        }

        // 7. Countries, States & Cities
        $geographicData = [
            'India' => [
                'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur', 'Thane', 'Nashik', 'Aurangabad', 'Solapur', 'Navi Mumbai', 'Kolhapur', 'Amravati'],
                'Delhi' => ['New Delhi', 'Central Delhi', 'South Delhi', 'North Delhi', 'East Delhi', 'West Delhi', 'Dwarka', 'Rohini'],
                'Karnataka' => ['Bangalore', 'Mysore', 'Hubli', 'Mangalore', 'Belgaum', 'Davanagere', 'Bellary', 'Gulbarga'],
                'Tamil Nadu' => ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli', 'Vellore', 'Erode'],
                'Gujarat' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar', 'Gandhinagar', 'Anand'],
                'Uttar Pradesh' => ['Lucknow', 'Kanpur', 'Varanasi', 'Agra', 'Prayagraj (Allahabad)', 'Noida', 'Ghaziabad', 'Meerut', 'Bareilly', 'Aligarh'],
                'West Bengal' => ['Kolkata', 'Howrah', 'Siliguri', 'Durgapur', 'Asansol', 'Bardhaman', 'Kharagpur'],
                'Telangana' => ['Hyderabad', 'Warangal', 'Nizamabad', 'Karimnagar', 'Khammam'],
                'Andhra Pradesh' => ['Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore', 'Kurnool', 'Tirupati', 'Rajahmundry'],
                'Rajasthan' => ['Jaipur', 'Jodhpur', 'Udaipur', 'Kota', 'Bikaner', 'Ajmer', 'Bhilwara', 'Alwar'],
                'Kerala' => ['Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Kollam', 'Palakkad', 'Kannur', 'Alappuzha'],
                'Punjab' => ['Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala', 'Bathinda', 'Mohali', 'Pathankot'],
                'Haryana' => ['Gurgaon (Gurugram)', 'Faridabad', 'Panipat', 'Ambala', 'Yamunanagar', 'Rohtak', 'Hisar', 'Karnal'],
                'Madhya Pradesh' => ['Indore', 'Bhopal', 'Jabalpur', 'Gwalior', 'Ujjain', 'Sagar', 'Dewas'],
                'Bihar' => ['Patna', 'Gaya', 'Bhagalpur', 'Muzaffarpur', 'Purnia', 'Darbhanga'],
                'Odisha' => ['Bhubaneswar', 'Cuttack', 'Rourkela', 'Berhampur', 'Sambalpur', 'Puri'],
                'Assam' => ['Guwahati', 'Silchar', 'Dibrugarh', 'Jorhat', 'Nagaon'],
                'Jharkhand' => ['Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro Steel City', 'Deoghar'],
                'Uttarakhand' => ['Dehradun', 'Haridwar', 'Roorkee', 'Haldwani', 'Rishikesh'],
                'Goa' => ['Panaji', 'Margao', 'Vasco da Gama', 'Mapusa'],
                'Himachal Pradesh' => ['Shimla', 'Dharamshala', 'Solan', 'Mandi', 'Kullu'],
                'Jammu and Kashmir' => ['Srinagar', 'Jammu', 'Anantnag', 'Baramulla'],
                'Chandigarh' => ['Chandigarh'],
            ],
            'United States' => [
                'California' => ['Los Angeles', 'San Francisco', 'San Jose', 'San Diego', 'Sacramento', 'Fremont', 'Sunnyvale'],
                'Texas' => ['Houston', 'Dallas', 'Austin', 'San Antonio', 'Fort Worth', 'Plano', 'Irving'],
                'New York' => ['New York City', 'Buffalo', 'Rochester', 'Albany', 'Syracuse'],
                'New Jersey' => ['Jersey City', 'Newark', 'Edison', 'Princeton', 'Paterson', 'Iselin'],
                'Illinois' => ['Chicago', 'Naperville', 'Aurora', 'Rockford', 'Schaumburg'],
                'Washington' => ['Seattle', 'Bellevue', 'Redmond', 'Tacoma', 'Spokane'],
            ],
            'United Kingdom' => [
                'England' => ['London', 'Birmingham', 'Manchester', 'Leeds', 'Leicester', 'Slough', 'Coventry', 'Hounslow'],
                'Scotland' => ['Edinburgh', 'Glasgow', 'Aberdeen', 'Dundee'],
                'Wales' => ['Cardiff', 'Swansea', 'Newport'],
            ],
            'Canada' => [
                'Ontario' => ['Toronto', 'Mississauga', 'Brampton', 'Ottawa', 'Hamilton', 'Markham'],
                'British Columbia' => ['Vancouver', 'Surrey', 'Burnaby', 'Richmond', 'Victoria'],
                'Alberta' => ['Calgary', 'Edmonton', 'Red Deer'],
            ],
            'United Arab Emirates' => [
                'Dubai' => ['Dubai'],
                'Abu Dhabi' => ['Abu Dhabi', 'Al Ain'],
                'Sharjah' => ['Sharjah', 'Ajman'],
            ],
            'Australia' => [
                'New South Wales' => ['Sydney', 'Newcastle', 'Wollongong', 'Parramatta'],
                'Victoria' => ['Melbourne', 'Geelong', 'Ballarat'],
                'Queensland' => ['Brisbane', 'Gold Coast', 'Sunshine Coast'],
            ],
        ];

        foreach ($geographicData as $countryName => $states) {
            $countryId = DB::table('countries')->insertGetId([
                'name' => $countryName,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            foreach ($states as $stateName => $cities) {
                $stateId = DB::table('states')->insertGetId([
                    'country_id' => $countryId,
                    'name' => $stateName,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $citiesData = array_map(fn ($city) => [
                    'state_id' => $stateId,
                    'name' => $city,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], $cities);

                DB::table('cities')->insert($citiesData);
            }
        }

        // 8. Working With Sectors
        $workingWithList = [
            'Private Company',
            'Government / Public Sector',
            'Defense / Civil Services',
            'Business / Self Employed',
            'Non Working',
        ];
        $workingWithData = array_map(fn ($item) => [
            'name' => $item,
            'created_at' => $now,
            'updated_at' => $now,
        ], $workingWithList);
        DB::table('working_withs')->insert($workingWithData);
    }
}
