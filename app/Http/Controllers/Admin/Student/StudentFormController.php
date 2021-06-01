<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\RegionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\Admin\FilesController;
use App\Http\Controllers\Admin\Student\StudentController;
use App\Http\Controllers\Admin\Student\StudentFilesController;

use App\Models\School\SchoolModel;
use App\Models\Student\StudentModel;

class StudentFormController extends Controller
{
    static public function getList($request) {        
        $data = new \stdClass;
        $rows_per_page = 15;
        $pagination_limit = 4; // avoid less than 2

        // Query start
        $query = new StudentModel;
        isset($request['limit']) ? $rows_limit = $request['limit'] : $rows_limit = $rows_per_page;
        isset($request['page']) ? $page = $request['page'] : $page = 1;
        $page != 0 ? : $page = 1;
        $page == 1 ? $skip = 0 : $skip = ($page -1) * $rows_limit;

        // Clauses
        $query = $query->where('school_id', '=', $request->id);

        // Stats
        $total = $query->count();
        $pages = intdiv($total, $rows_limit);
        $pages > 0 ? : $pages = 1;
        ($total / $rows_limit) <= $pages ? : $pages = $pages + 1;

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

        $school = SchoolModel::find($data['school_id']);        
        if ( empty($school) ) {
            $data->error = [
                'status' => 'error',
                'code'      => 400,
                'message'   => 'School`s id record "'.$data['school_id'].'" not found'
            ];
        } else {
            
            $validate = \Validator::make($data, [
                'name' => 'required|min:3|max:64',
                'surname' => 'required|min:3|max:64',
                'personal_id' => 'required|unique:students|min:6|max:64',
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
                
                $student = new StudentModel;                
                $student->idcode = $data['idcode'];
                $student->school_id = $school->id;
                $student->country_id = $data['country_id'];
                $student->province_id = $data['province_id'];
                $student->region_id = $data['region_id'];
                $student->city_id = $data['city_id'];
                $student->name = $data['name'];
                $student->surname = $data['surname'];
                $student->personal_id = $data['personal_id'];
                $student->phone = $data['phone'];
                $student->email = $data['email'];
                $student->address = $data['address'];
                $student->save();

                $student_id = $student->id;

                // store images
                if ( isset($data['files']['image']) ) {
                    
                    $newFiles = $data['files']['image'];
                    $images = StudentFilesController::checkStudentImage($newFiles);

                    if ( isset($images['errors']) ) {
                        $student->delete(); // rollback student created
                        $data = [
                            'status' => 'field',
                            'code' => 400,
                            'message' => ['image' => $images['errors']]
                        ];
                    } else {
                        // if everything is correct move new files to:
                        $location = 'private';
                        $path = '/students/images/';

                        // move uploaded files
                        $newFiles = StudentFilesController::saveStudentImage($newFiles, $student_id);
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
        }
        return $data;
    }

    static public function updateRegister($request) {
        $data = json_decode($request['json'], true); // json to array
        $data = array_map('trim', $data);
        
        $student = StudentModel::find($data['id']);
        if ( empty($student) ) {
            $data = [
                'status' => 'error',
                'code'      => 400,
                'message'   => 'record id: '.$data['id'].' not found' 
            ];
        } else {
            $validate_params = [
                'name' => 'required|min:3|max:64',
                'surname' => 'required|min:3|max:64',
                'personal_id' => 'required|min:6|max:64',
                'phone' => 'min:6',
                'email' => 'email',
                'country_id' => 'integer',
                'region_id' => 'integer',
                'province_id' => 'integer',
                'city_id' => 'integer',
                'address' => 'required',
            ];
            $student->personal_id == $data['personal_id'] ? : $validate_params['personal_id'] = 'required|unique:students|min:6|max:64';

            $validate = \Validator::make($data, $validate_params);
            if( $validate->fails() ){
                $data = [
                    'status' => 'field',
                    'code' => 400,
                    'message' => $validate->errors()
                ];
            } else {                
                $data['idcode'] = $student->idcode;

                // files attached to request
                if ( $_FILES ) {
                    $reference = $data['idcode'];                
                    $files = FilesController::getFilesData($request, $reference);
                    $data['files'] = $files;
                }
                
                $student->country_id = $data['country_id'];
                $student->province_id = $data['province_id'];
                $student->region_id = $data['region_id'];
                $student->city_id = $data['city_id'];
                $student->name = $data['name'];
                $student->surname = $data['surname'];
                $student->personal_id = $data['personal_id'];
                $student->phone = $data['phone'];
                $student->email = $data['email'];
                $student->address = $data['address'];               
                $student->update();                

                // images
                $student_id = $student->id;
                !isset($student->image->file) ? : $student_image_file = $student->image->file;

                // store images
                if ( isset($data['files']['image']) ) {       
                    $newFiles = $data['files']['image'];
                    $images = StudentFilesController::checkStudentImage($newFiles);
                    if ( isset($images['errors']) ) {
                        
                        $data = [
                            'status' => 'field',
                            'code' => 400,
                            'message' => ['image' => $images['errors']]
                        ];
                    } else {
                        // if everything is correct move new files to:
                        $location = 'private';
                        $path = '/students/images/';

                        // delete files from DB & remove them from disk
                        $filesOld = StudentFilesController::deleteStudentImage($student_id);
                        $images = FilesController::removeFiles($location, $path, $filesOld);

                        // move uploaded files
                        $newFiles = StudentFilesController::saveStudentImage($newFiles, $student_id);
                        $images = FilesController::storeFiles($request, $location, $path, $newFiles);
                        
                        $data = [
                            'status'    => 'success',
                            'code'      => 200,
                            'message'   => 'register has been updated',
                            'images'    => $newFiles,
                            'school'    => $student->school
                        ];
                    }
                } else {
                    if ( isset($data['imageDelete']) && $data['imageDelete'] == 1) {
                        // delete files from DB & remove them from disk
                        $location = 'private';
                        $path = '/students/images/';

                        $filesOld = StudentFilesController::deleteStudentImage($student_id);
                        $images = FilesController::removeFiles($location, $path, $filesOld);
                    }

                    $data = [
                        'status'    => 'success',
                        'code'      => 200,
                        'message'   => 'register has been updated',
                        'school'    => $student->school
                    ];
                }
            }
        }
        return $data;
    }

    static public function deleteRegister($request) {
        $data = $request['json']; // json to array json_decode(, true) - NOT !!!
        $student_id = $data['id'];

        $student = StudentModel::find($data['id']);
        $school = $student->school;
        if (!$student) {

            $data = [
                'status'    => 'field',
                'code'      => 400,
                'message'   => 'register cannot be found'
            ];
        } else {
            // remove dependant images
            if ($student->image) {
                // delete files from DB & remove them from disk
                $location = 'private';
                $path = '/students/images/';

                $filesOld = StudentFilesController::deleteStudentImage($student_id);
                $images = FilesController::removeFiles($location, $path, $filesOld);
            }
            $student->delete();
            
            $data = [
                'status'    => 'success',
                'code'      => 200,
                'message'   => 'register and its dependencies have been deleted',
                'return_id' => $school->id
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
