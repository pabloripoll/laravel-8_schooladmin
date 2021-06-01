<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\School\SchoolModel;
use App\Models\School\SchoolImageModel;
use App\Models\Student\StudentModel;
use App\Models\Student\StudentImageModel;

use App\Http\Controllers\RegionController;
use App\Http\Controllers\ProvinceController;

class StudentLayoutController extends Controller
{
    //
    public static function layout_create($request) {
        $data = new \stdClass;
        
        $country_id = 6; // Default for Spain
        $regions = RegionController::getCountryRegions($country_id);        
        $data->regions = $regions;

        $school = SchoolModel::find($request->school);
        
        if ( empty($school) ) {
            $data->error = [
                'code'      => 400,
                'message'   => 'School`s id record "'.$request->id.'" not found'
            ];
        } else {
            $data->school = $school;
            
        }
        
        return $data;
    }

    public static function layout_update($request) {
        $data = new \stdClass;

        $student = StudentModel::find($request->id);
        
        if ( empty($student) ) {
            $data->error = [
                'code'      => 400,
                'message'   => 'record id: '.$request->id.' not found'
            ];
        } else {
            $data->row = $student;
            $data->image = $student->image;
            $data->school = $student->school;

            $regions = RegionController::getCountryRegions($student->country_id);
            $data->regions = $regions;            
            $provinces = ProvinceController::getRegionProvinces($student->country_id, $student->region_id);        
            $data->provinces = $provinces;
            
        }
        return $data;
    }
}
