<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\RegionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\Admin\FilesController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\User\UserFilesController;

use App\Models\Admin\User;

class UserFormController extends Controller
{

    static public function updateRegister($request) {
        $data = json_decode($request['json'], true); // json to array
        $data = array_map('trim', $data);
        
        $user = User::find($data['id']);
        if ( empty($user) ) {
            $data = [
                'status' => 'error',
                'code'      => 400,
                'message'   => 'record id: '.$data['id'].' not found' 
            ];
        } else {
            
            empty($data['password']) ?
            $validation = self::validationWithoutPassword($user, $data) :
            $validation = self::validationWithPassword($user, $data);

            if ( !empty($validation) ) {
                $data = $validation;
            } else {
                $data['idcode'] = $user->idcode;

                // files attached to request
                if ( $_FILES ) {
                    $reference = $data['idcode'];                
                    $files = FilesController::getFilesData($request, $reference);
                    $data['files'] = $files;
                }
                
                $user->email = $data['email'];
                $user->name = $data['name'];
                if ( !empty($data['new_password']) ) {
                    $user->password = Hash::make($data['new_password']);
                }
                $user->update();

                // images
                $user_id = $user->id;
                !isset($user->image->file) ? : $user_image_file = $user->image->file;

                // store images
                if ( isset($data['files']['image']) ) {       
                    $newFiles = $data['files']['image'];
                    $images = UserFilesController::checkUserImage($newFiles);
                    if ( isset($images['errors']) ) {
                        
                        $data = [
                            'status' => 'field',
                            'code' => 400,
                            'message' => ['image' => $images['errors']]
                        ];
                    } else {
                        // if everything is correct move new files to:
                        $location = 'private';
                        $path = '/users/images/';

                        // delete files from DB & remove them from disk
                        $filesOld = UserFilesController::deleteUserImage($user_id);
                        $images = FilesController::removeFiles($location, $path, $filesOld);

                        // move uploaded files
                        $newFiles = UserFilesController::saveUserImage($newFiles, $user_id);
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
                        $location = 'private';
                        $path = '/users/images/';

                        $filesOld = UserFilesController::deleteUserImage($user_id);
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

    private static function validationWithoutPassword ($user, $data) {       
        $validation = [];
        $validate_params = [];

        $user->email == $data['email'] ? : $validate_params['email'] = 'required|email|unique:users|min:6|max:32';
        $validate_params['name'] = 'required|min:6|max:32';

        $validate = \Validator::make($data, $validate_params);

        if( $validate->fails() ){
            $validation = [
                'status' => 'field',
                'code' => 400,
                'message' => $validate->errors()
            ];
        }

        return $validation;
    }

    private static function validationWithPassword ($user, $data) {
        $current_password_hashed = $user->password;
        $validation = [];
        $validate_params = [];

        if ( !Hash::check($data['password'], $current_password_hashed) ) {
            $validation = [
                'status' => 'field',
                'code' => 400,
                'message' => ["password" => ["password does not match with actual one"]]
            ];
        } else if ( $data['new_password'] != $data['new_password_repeated'] ) {
            $validation = [
                'status' => 'field',
                'code' => 400,
                'message' => ["new_password_repeated" => ["new password not match"]]
            ];
        } else {
            $user->email == $data['email'] ? : $validate_params['email'] = 'required|email|unique:users|min:6|max:32';
            $validate_params['name'] = 'required|min:6|max:32';
            $validate_params['new_password'] = 'required|min:8|max:16';

            $validate = \Validator::make($data, $validate_params);

            if( $validate->fails() ){
                $validation = [
                    'status' => 'field',
                    'code' => 400,
                    'message' => $validate->errors()
                ];
            }
        }
        
        return $validation;
    }

    static public function deleteRegister($request) {
        $data = $request['json']; // json to array json_decode(, true) - NOT !!!
        $user_id = $data['id'];

        $user = User::find($data['id']);
        if (!$user) {

            $data = [
                'status' => 'field',
                'code' => 400,
                'message' => 'register cannot be found'
            ];
        } else {

            // images
            if ($user->image) {
                // delete files from DB & remove them from disk
                $location = 'private';
                $path = '/users/images/';

                $filesOld = UserFilesController::deleteUserImage($user_id);
                $images = FilesController::removeFiles($location, $path, $filesOld);
            }
            $user->delete();

            $data = [
                'status' => 'success',
                'code' => 200,
                'message' => 'register and its dependencies have been deleted'
            ];
        }
        return $data;
    }

}
