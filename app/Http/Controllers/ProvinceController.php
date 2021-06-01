<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\ProvinceModel;

class ProvinceController extends Controller
{

    static function getRegionProvinces($country_id, $region_id) {

        !empty($country_id) ? : $country_id = 0;
        !empty($region_id) ? : $region_id = 0;

        $table = ProvinceModel::table(); $query = DB::table($table);
        $query = $query->where('country_id', '=', $country_id);
        $query = $query->where('region_id', '=', $region_id);
        $query = $query->orderBy('name');
        $result = $query->get();

        return $result;
    }
}
