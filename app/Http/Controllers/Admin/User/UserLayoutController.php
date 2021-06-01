<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Admin\User;
use App\Models\Admin\UserImageModel;

class UserLayoutController extends Controller
{
    
    public static function layout_list($request){
        $data = new \stdClass;

        $table = User::table();
        $query = DB::table($table);        
        //->skip(10)->take(5)->get();
        $result = $query->get();
        
        $data->list = $result;

        return $data;
    }

    public static function layout_create($request) {
        $data = new \stdClass;
        
        return $data;
    }

    public static function layout_update($request) {
        $data = new \stdClass;
        $user = User::find($request->id);
        
        if ( empty($user) ) {

            $data->error = [
                'code'      => 400,
                'message'   => 'record id: '.$request->id.' not found'
            ];
        } else {

            $data->row = $user;
            $data->image = $user->image;
        }
        return $data;
    }

}
