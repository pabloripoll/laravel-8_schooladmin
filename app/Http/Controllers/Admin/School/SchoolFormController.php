<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\RegionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\Admin\FilesController;
use App\Http\Controllers\Admin\School\SchoolController;
use App\Http\Controllers\Admin\School\SchoolFilesController;
use App\Http\Controllers\Admin\Student\StudentFilesController;

use App\Models\School\SchoolModel;

class SchoolFormController extends Controller
{

    static public function getList($request) {
        $data = new \stdClass;
        $rows_per_page = 15;
        $pagination_limit = 4; // avoid less than 2

        // Query start
        $query = new SchoolModel;
        isset($request['limit']) ? $rows_limit = $request['limit'] : $rows_limit = $rows_per_page;
        isset($request['page']) ? $page = $request['page'] : $page = 1;
        $page != 0 ? : $page = 1;
        $page == 1 ? $skip = 0 : $skip = ($page -1) * $rows_limit;

        // Clauses
        //$query = $query->where('name', 'like', 'T%');

        // Stats
        $total = $query->count();
        $pages = intdiv($total, $rows_limit);
        $pages > 0 ? : $pages = 1;
        ($total / $rows_limit) <= $pages ? : $pages = $pages + 1;        
        //$page <= $pages ? : $page = $pages;

        // Order - simple param
        $order = 'reg-90'; $order_key = 'id'; $order_value = 'desc';
        if ( isset($request['order']) ) {
            $order_request = $request['order'];
            // options
            $order_request != 'reg-09' ? : $order_value = 'asc';
            $order_request == 'latest' || $order_request == 'oldest' ? $order_key = 'updated_at' : null;
            $order_request == 'oldest' ? $order_value = 'asc' : null;
            $order_request == 'a-z' || $order_request == 'z-a' ? $order_key = 'name' : null;
            $order_request == 'a-z' ? $order_value = 'asc' : null;

            $order = $order_request;
        }
        $query = $query->orderBy($order_key, $order_value);

        // Get
        $query = $query->take($rows_limit);
        $query = $query->skip($skip);
        $results = $query->get();
        
        // Return
        $data->query['page'] = $page;
        $data->query['order'] = $order;
        $data->query['rows'] = $rows_limit;
        $data->query['results'] = $results;
        $data->query['pages'] = $pages;
        $data->query['total'] = $total;

        // Pagination
        $paginate = [];
        if ($page > $pagination_limit) {
            $backward = [];
            for ($i = $page; $i > ($page - $pagination_limit); $i--) {
                $backward['page-'.($i)] = ['page' => ($i)];            
            }
            $paginate = array_reverse($backward);
        }
        $page <= $pagination_limit ? $init = 1 : $init = $page;
        $page <= $pagination_limit ? $limit = $pages + 1 : $limit = $page + $pagination_limit;
        $limit > $pages ? $limit = $pages + 1 : $limit = $limit;
        for ($i = $init; $i < $limit; $i++) {
            $paginate['page-'.($i)] = ['page' => ($i)];
        }
        $data->query['paginate'] = $paginate;

        return $data;
    }


    static public function createRegister($request) {
        $data = json_decode($request['json'], true); // json to array
        $data = array_map('trim', $data);

        $validate = \Validator::make($data, [
            'name' => 'required|min:6|max:64',
            'licence' => 'required|unique:schools|min:6|max:64',
            'phone' => 'min:6',
            'email' => 'email',
            'country_id' => 'integer',
            'region_id' => 'integer',
            'province_id' => 'integer',
            'city_id' => 'integer',
            'address' => 'required',
        ]);
        if($validate->fails()){
            $data = [
                'status' => 'field',
                'code' => 400,
                'message' => $validate->errors()
            ];
        } else {
            $data['idcode'] = rand(100000000,1000000000); // 9 digit lenght
            
            // files attached to request
            if ( $_FILES ) {
                $reference = $data['idcode'];                
                $files = FilesController::getFilesData($request, $reference);
                $data['files'] = $files;
            }
            
            $school = new SchoolModel;
            $school->idcode = $data['idcode'];
            $school->country_id = $data['country_id'];
            $school->province_id = $data['province_id'];
            $school->region_id = $data['region_id'];            
            $school->city_id = $data['city_id'];
            $school->name = $data['name'];
            $school->licence = $data['licence'];
            $school->phone = $data['phone'];
            $school->email = $data['email'];
            $school->website = $data['website'];
            $school->address = $data['address'];
            
            $school->save();

            $school_id = $school->id;

            // store images
            if ( isset($data['files']['image']) ) {
                
                $newFiles = $data['files']['image'];
                $images = SchoolFilesController::checkSchoolImage($newFiles);

                if ( isset($images['errors']) ) {
                    $school->delete(); // rollback school created
                    $data = [
                        'status' => 'field',
                        'code' => 400,
                        'message' => ['image' => $images['errors']]
                    ];
                } else {
                    // if everything is correct move new files to:
                    $location = 'public';
                    $path = '/schools/images/';

                    // move uploaded files
                    $newFiles = SchoolFilesController::saveSchoolImage($newFiles, $school_id);
                    $images = FilesController::storeFiles($request, $location, $path, $newFiles);
                    
                    $data = [
                        'status'    => 'success',
                        'code'      => 200,
                        'message'   => 'register has been created',
                        'images'    => $data['files']['image']
                    ];
                }

            } else {
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'register has been created'
                ];
            }            
        }

        return $data;
    }

    static public function updateRegister($request) {
        $data = json_decode($request['json'], true); // json to array
        $data = array_map('trim', $data);
        
        $school = SchoolModel::find($data['id']);
        if ( empty($school) ) {
            $data = [
                'status' => 'error',
                'code'      => 400,
                'message'   => 'record id: '.$data['id'].' not found' 
            ];
        } else {
            $validate_params = [
                'name' => 'required|min:6|max:64',
                'licence' => 'required|min:6|max:64',
                'phone' => 'min:6',
                'email' => 'email',
                'country_id' => 'integer',
                'region_id' => 'integer',
                'province_id' => 'integer',
                'city_id' => 'integer',
                'address' => 'required',
            ];
            $school->licence == $data['licence'] ? : $validate_params['licence'] = 'required|unique:schools|min:6|max:64';

            $validate = \Validator::make($data, $validate_params);
            if( $validate->fails() ){
                $data = [
                    'status' => 'field',
                    'code' => 400,
                    'message' => $validate->errors()
                ];
            } else {                
                $data['idcode'] = $school->idcode;

                // files attached to request
                if ( $_FILES ) {
                    $reference = $data['idcode'];                
                    $files = FilesController::getFilesData($request, $reference);
                    $data['files'] = $files;
                }
                
                $school->province_id = $data['province_id'];
                $school->region_id = $data['region_id'];            
                $school->city_id = $data['city_id'];
                $school->name = $data['name'];
                $school->licence = $data['licence'];
                $school->phone = $data['phone'];
                $school->email = $data['email'];
                $school->website = $data['website'];
                $school->address = $data['address'];                
                $school->update();                

                // images
                $school_id = $school->id;
                !isset($school->image->file) ? : $school_image_file = $school->image->file;

                // store images
                if ( isset($data['files']['image']) ) {       
                    $newFiles = $data['files']['image'];
                    $images = SchoolFilesController::checkSchoolImage($newFiles);
                    if ( isset($images['errors']) ) {
                        
                        $data = [
                            'status' => 'field',
                            'code' => 400,
                            'message' => ['image' => $images['errors']]
                        ];
                    } else {
                        // if everything is correct move new files to:
                        $location = 'public';
                        $path = '/schools/images/';

                        // delete files from DB & remove them from disk
                        $filesOld = SchoolFilesController::deleteSchoolImage($school_id);
                        $images = FilesController::removeFiles($location, $path, $filesOld);

                        // move uploaded files
                        $newFiles = SchoolFilesController::saveSchoolImage($newFiles, $school_id);
                        $images = FilesController::storeFiles($request, $location, $path, $newFiles);
                        
                        $data = [
                            'status'    => 'success',
                            'code'      => 200,
                            'message'   => 'register has been updated',
                            'images'    => $newFiles
                        ];
                    }
                } else {
                    if ( isset($data['imageDelete']) && $data['imageDelete'] == 1) {
                        // delete files from DB & remove them from disk
                        $location = 'public';
                        $path = '/schools/images/';

                        $filesOld = SchoolFilesController::deleteSchoolImage($school_id);
                        $images = FilesController::removeFiles($location, $path, $filesOld);
                    }

                    $data = [
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'register has been updated'
                    ];
                }
            }
        }
        return $data;
    }

    static public function deleteRegister($request) {
        $data = $request['json']; // json to array json_decode(, true) - NOT !!!
        $school_id = $data['id'];

        $school = SchoolModel::find($data['id']);
        if (!$school) {

            $data = [
                'status' => 'field',
                'code' => 400,
                'message' => 'register cannot be found'
            ];
        } else {
            // remove dependant images
            if ($school->image) {
                // delete files from DB & remove them from disk
                $location = 'public';
                $path = '/schools/images/';

                $filesOld = SchoolFilesController::deleteSchoolImage($school_id);
                $images = FilesController::removeFiles($location, $path, $filesOld);
            }

            if ($school->students) {
                $students = count($school->students);
                foreach ($school->students as $student) {
                    $location = 'private';
                    $path = '/students/images/';
                    $filesOld = StudentFilesController::deleteStudentImage($student->id);                    
                    $images = FilesController::removeFiles($location, $path, $filesOld);            
                    $student->delete();
                }
            }

            $school->delete();

            $students == 1 ? $text = $students.' student' : $students.' students'; 
            $data = [
                'status' => 'success',
                'code' => 200,
                'message' => 'register and '.$text.' have been deleted'
            ];
        }
        return $data;
    }

    //
    static public function getRegionProvinces($request) {
        $data = $request['json']; // json to array json_decode(, true) - NOT !!!
        $country_id = $data['country_id'];
        $region_id = $data['region_id'];
        $data = ProvinceController::getRegionProvinces($country_id, $region_id);

        return $data;
    }

}
