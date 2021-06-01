<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\ProvinceModel;

class ProvincesSpainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = ProvinceModel::table();
        $datetime = Carbon::now();
        $datetime_now = $datetime->toDateTimeString();

        $array = [
            [
                'country_id' => 6,
                'region_id' => 1,
                'name' => 'Badajoz',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 1,
                'name' => 'Cáceres',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 2,
                'name' => 'Ciudad Real',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 3,
                'name' => 'Zaragoza',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 2,
                'name' => 'Cuenca',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 3,
                'name' => 'Huesca',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 4,
                'name' => 'León',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 2,
                'name' => 'Toledo',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 2,
                'name' => 'Albacete',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 3,
                'name' => 'Teruel',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 4,
                'name' => 'Burgos',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 5,
                'name' => 'Sevilla',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 5,
                'name' => 'Córdoba',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 5,
                'name' => 'Jaén',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 5,
                'name' => 'Granada',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 4,
                'name' => 'Salamanca',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 1,
                'name' => 'Guadalajara',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 6,
                'name' => 'Lérida',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 7,
                'name' => 'Murcia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 8,
                'name' => 'Valencia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 9,
                'name' => 'Asturias',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 4,
                'name' => 'Zamora',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 10,
                'name' => 'Navarra',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 4,
                'name' => 'Soria',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 5,
                'name' => 'Huelva',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 11,
                'name' => 'Lugo',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 5,
                'name' => 'Almería',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 4,
                'name' => 'Valladolid',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 4,
                'name' => 'Palencia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 4,
                'name' => 'Ávila',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 12,
                'name' => 'Madrid',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 11,
                'name' => 'La Coruña',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 6,
                'name' => 'Barcelona',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 5,
                'name' => 'Cádiz',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 5,
                'name' => 'Málaga',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 11,
                'name' => 'Ourense',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 4,
                'name' => 'Segovia',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 8,
                'name' => 'Castellón',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 6,
                'name' => 'Tarragona',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 6,
                'name' => 'Gerona',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 8,
                'name' => 'Alicante',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 13,
                'name' => 'Cantabria',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 14,
                'name' => 'La Rioja',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 15,
                'name' => 'Islas Baleáres',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 11,
                'name' => 'Pontevedra',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 16,
                'name' => 'Las Palmas',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 16,
                'name' => 'Santa Cruz de Tenerife',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 17,
                'name' => 'Álava',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 17,
                'name' => 'Vizcaya',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 17,
                'name' => 'Guipúzcoa',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 18,
                'name' => 'Melilla',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ],
            [
                'country_id' => 6,
                'region_id' => 19,
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
