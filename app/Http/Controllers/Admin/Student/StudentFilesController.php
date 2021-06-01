<?php

namespace App\Http\Controllers\Admin\Student;

use Validator;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Log;

use App\Models\Student\StudentModel;
use App\Models\Student\StudentImageModel;

class StudentFilesController extends Controller
{
    public static function checkStudentImage($files) {
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

    public static function saveStudentImage($files, $foreignId) {

        foreach ($files as $file) {
            $target = new StudentImageModel;
            $target->student_id = $foreignId;
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

    public static function deleteStudentImage($foreignId) {        
        $files = [];
        $image = StudentModel::find($foreignId)->image;
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
