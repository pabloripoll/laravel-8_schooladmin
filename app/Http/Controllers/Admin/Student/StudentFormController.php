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
    static public function getRegionProvinces($request) {
        $data = $request['json']; // json to array json_decode(, true) - NOT !!!
        $country_id = $data['country_id'];
        $region_id = $data['region_id'];
        $data = ProvinceController::getRegionProvinces($country_id, $region_id);
        
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
}
