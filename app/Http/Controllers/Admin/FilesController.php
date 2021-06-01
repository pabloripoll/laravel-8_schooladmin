<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
//use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FilesController extends Controller
{

    // show private files only inside admin panel and when if user is logged
    static public function privateFiles (
        $target = '',
        $type = '',
        $file = ''
    ) 
    {
        if (Auth::user()) {

            if ( empty($target) || empty($type) || empty($file)) {

                return abort('404');
            } else {
                $filepath = storage_path().'/app/private/'.$target.'/'.$type.'/'.$file;

                return response()->file($filepath);
            }            
        } else {
            return abort('403');
        }

    }

    // this should be getFiles() to separate type of files and in another method moveFiles() depending on type
    static public function getFilesData($request, $reference) {
        $files = [];
        $i = 0; 
        foreach($_FILES as $file) {
            
            $file_type = substr($file['type'], 0, strrpos($file['type'], '/')); // => 'image/png',
            $file_ext = substr($file['type'], strrpos($file['type'], '/') +1);
            
            $file_error = $file['error']; // => 0,
            $file_size = $file['size']; // => 4704,

            $file_name_tmp = $file['tmp_name']; // => '/tmp/php3t7Sus',
            $file_name_org = $file['name']; // => 'Some Fancy Name.png'
            $file_name_url = Str::slug(substr($file['name'], 0, strrpos($file['name'], '.')), '-').'.'.$file_ext; // to 'some-funcy-name.png'
            $file_name_new = $reference.'_'.date('Ymd').'_'.date('His').'_'.rand(1000,10000).'.'.$file_ext; // once store in db tmp_ must be change

            if ( !isset($files[$file_type]) ) {
                $files[$file_type] = [
                    $i = [
                        'type'  => $file_type,
                        'file'  => $file_name_new,
                        'ext'   => $file_ext,
                        'size'  => $file_size,
                        'url'   => $file_name_url,
                        'name'  => $file_name_org
                    ]
                ];                
            } else {
                $files[$file_type] = array_merge($files[$file_type], [
                        $i = [
                            'type'  => $file_type,
                            'file'  => $file_name_new,
                            'ext'   => $file_ext,
                            'size'  => $file_size,
                            'url'   => $file_name_url,
                            'name'  => $file_name_org
                        ]
                    ]
                );
            }
            
            $irc = count($files[$file_type]) - 1;            

            if ($file_type == 'image') {
                $file = $request->file('file-'.$irc); // reset variable with actual file
                $size = getimagesize($file);
                $files[$file_type][$irc]['width'] = $size[0];
                $files[$file_type][$irc]['heigh'] = $size[1];
            }

            $files[$file_type][$irc]['uploadPosition'] = $irc;
            $i++;
        }
        return $files;
    }

    static public function storeFiles($request, $location, $path, $files) {                
        foreach($files as $key => $value) {
            if ( isset($_FILES['file-'.$key]) ) {
                $i = $key;
                $file = $request->file('file-'.$i);

                if ($location == 'private'):
                    $dir = '/private'.$path;
                    $image = $file->storeAs($dir, $value['file']);
                elseif ($location == 's3'):
                    $dir = $path;
                    $image = $file->storeAs($dir, $value['file'], 's3');
                else:
                    $dir = $path;
                    $image = $file->storeAs($dir, $value['file'], 'public');
                endif;
            }
        }
        return true;
    }

    static public function removeFiles($location, $path, $files) {                
        foreach($files as $file) {

            if ($location == 'private'):
                $dir = storage_path().'/app/private'.$path;
                File::delete($dir.$file['file']);                
            elseif ($location == 's3'):
                $dir = $path;
                File::delete($dir, $file['file'], 's3');
            else:
                $dir = storage_path().'/app/public'.$path;
                File::delete($dir.$file['file']);
            endif;

        }
        return true;
    }
    
}
