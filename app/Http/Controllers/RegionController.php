<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\RegionModel;

class RegionController extends Controller
{

    static function getCountryRegions($country_id) {

        !empty($country_id) ? : $country_id = 0;

        $table = RegionModel::table(); $query = DB::table($table);
        $query = $query->where('country_id', '=', $country_id);
        $query = $query->orderBy('name');
        $result = $query->get();

        return $result;
    }

}
