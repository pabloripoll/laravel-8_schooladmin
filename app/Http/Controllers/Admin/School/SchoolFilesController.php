<?php

namespace App\Http\Controllers\Admin\School;

use Validator;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Log;

use App\Models\School\SchoolModel;
use App\Models\School\SchoolImageModel;

class SchoolFilesController extends Controller
{

    public static function checkSchoolImage($files) {
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

    public static function saveSchoolImage($files, $foreignId) {

        foreach ($files as $file) {
            $target = new SchoolImageModel;
            $target->school_id = $foreignId;
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

    public static function deleteSchoolImage($foreignId) {        
        $files = [];
        $image = SchoolModel::find($foreignId)->image;
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
