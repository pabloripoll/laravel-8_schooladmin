<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\CountryModel;

class CountriesEuropeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = CountryModel::table();
        $datetime = Carbon::now();
        $datetime_now = $datetime->toDateTimeString();

        $array = [
            [
                'name' => 'United Kingdom',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Ireland',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Germany',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'France',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Italy',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Spain',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Russia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Ukraine',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Poland',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Romania',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Netherlands',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Belgium',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Czech Republic',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Greece',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Portugal',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Sweden',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Hungary',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Belarus',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Austria',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Serbia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Switzerland',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Bulgaria',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Denmark',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Finland',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Slovakia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Norway',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],            
            [
                'name' => 'Croatia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Moldova',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Bosnia and Herzegovina',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Albania',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Lithuania',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'North Macedonia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Slovenia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Latvia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Estonia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Montenegro',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Luxembourg',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Malta',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Iceland',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Andorra',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Monaco',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Liechtenstein',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'San Marino',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'name' => 'Vatican',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ]
        ];

        foreach($array as $item) {
            DB::table($table)->insert($item);
        }
        
    }
}
