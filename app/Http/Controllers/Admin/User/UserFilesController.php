<?php

namespace App\Http\Controllers\Admin\User;

use Validator;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Log;

use App\Models\Admin\User;
use App\Models\Admin\UserImageModel;

class UserFilesController extends Controller
{

    public static function checkUserImage($files) {
        $images = [];

        foreach ($files as $file) {

            $validate = Validator::make($file, [                
                'size' => 'required|integer|min:2048|max:5242880',
                'width' => 'required|integer|max:9216',
                'heigh' => 'required|integer|min:200|max:9216',
            ]);

            if ($validate->fails()) {
                $images['errors'] = $validate->errors();
            }           
        }
        
        return $images;
    }

    public static function saveUserImage($files, $foreignId) {

        foreach ($files as $file) {
            $target = new UserImageModel;
            $target->user_id = $foreignId;
            $target->role = 0;
            $target->file = $file['file'];
            $target->ext = $file['ext'];
            $target->size = $file['size'];
            $target->width = $file['width'];
            $target->heigh = $file['heigh'];
            $target->url = $file['url'];
            $target->name = $file['name'];
            $target->save();
        }
        
        return $files;
    }

    public static function deleteUserImage($foreignId) {        
        $files = [];
        $image = User::find($foreignId)->image;
        if ($image) {

            // An array must be returned to use removeFiles()
            $files = [
                [
                    'file' => $image->file
                ],
            ];
                        
            $image->delete();
        }

        return $files;
    }

}
