<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\RegionModel;

class RegionsSpainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = RegionModel::table();
        $datetime = Carbon::now();
        $datetime_now = $datetime->toDateTimeString();

        $array = [            
            [
                'country_id' => 6,
                'name' => 'Extremadura',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Castilla La Mancha',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Aragón',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Castilla y León',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Andalucía',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Cataluña',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Murcia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Comunidad Valenciana',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Asturias',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Navarra',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Galicia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Madrid',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Cantabria',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'La Rioja',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Islas Baleares',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Islas Canarias',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Comunidad Bazca',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Melilla',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'name' => 'Ceuta',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
        ];

        foreach($array as $item) {
            DB::table($table)->insert($item);
        }

    }
}
