<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Admin\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = User::table();
        $datetime = Carbon::now();
        $datetime_now = $datetime->toDateTimeString();

        DB::table($table)->insert(
            [
                'role' => 0,
                'idcode' => rand(100000000,1000000000), // 9 digit lenght
                'user' => 'admin@admin.com',
                'email' => 'admin'.'@admin.com',
                'password' => Hash::make('123456'),
                'name' => 'Adminer',
                'created_at' => $datetime_now,
                'updated_at' => $datetime_now
            ]
        );
    }
}
