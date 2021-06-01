<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Log;

use App\Http\Controllers\RegionController;
use App\Http\Controllers\Admin\User\UserFormController;
use App\Http\Controllers\Admin\School\SchoolFormController;
use App\Http\Controllers\Admin\Student\StudentFormController;

class FormController extends Controller
{
    // Json Post Requests
    public function jsonData (Request $request)
    {
        $request = $request->json()->all();
        $method = $request['function'];
        $data = self::$method($request);
        return response()->json($data);
    }

    // Form Data Post Requests
    public function formData (Request $request)
    {
        $method = $request['function'];
        $data = self::$method($request);
        return response()->json($data);
    }

    // common object initialization
    private function data() {
        return new \stdClass;
    }

    /*
    ---> Dashboard
    */
    private function dashboard_index_index($request)
    {
        $data = $this->data();
        
        return $data;
    }

    /*
    ---> Schools
    */
    private function schools_index_index($request)
    {
        $action = $request['action'];
        $data = StudentFormController::$action($request);
        return $data;
    }

    private function school_create_index($request)
    {
        $action = $request['action'];
        $data = SchoolFormController::$action($request);
        return $data;
    }

    private function school_update_index($request)
    {        
        $action = $request['action'];
        $data = SchoolFormController::$action($request);
        return $data;
    }

    private function school_delete_index($request)
    {
        $action = $request['action'];
        $data = StudentFormController::$action($request);
        return $data;
    }
    
    /*
    ---> Students
    */
    private function student_create_index($request)
    {
        $action = $request['action'];
        $data = StudentFormController::$action($request);
        return $data;
    }

    private function student_update_index($request)
    {
        $action = $request['action'];
        $data = StudentFormController::$action($request);
        return $data;
    }

    /*
    ---> My Account
    */
    private function users_index_index($request)
    {
        $action = $request['action'];
        $data = UserFormController::$action($request);
        return $data;
    }

    private function user_update_index($request)
    {
        $action = $request['action'];
        $data = UserFormController::$action($request);
        return $data;
    }

}