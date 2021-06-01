<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Type;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\RegionController;

use App\Http\Controllers\Admin\User\UserLayoutController;
use App\Http\Controllers\Admin\School\SchoolLayoutController;
use App\Http\Controllers\Admin\Student\StudentLayoutController;

class PageController extends Controller
{
    private $panel      = 'dashboard';
    private $section    = 'index';
    private $page       = 'index';    

    /* MAIN CONTROLLERS */
    
    public function controller (
            Request $request,
            $panel = '',
            $section = '',
            $page = ''
        )
    {
        !empty($panel) ? : $panel = $this->panel;
        !empty($section) ? : $section = $this->section;
        !empty($page) ? : $page = $this->page;
        $method = $panel.'_'.$section.'_'.$page; // auto composing method

        // $data object comes from method
        method_exists(new Pagecontroller, $method) ?
        $data = self::$method($request) :
        $data = self::error_index_index($request);
        
        $layout = $method;
        $data->layout = $layout; // include current method to data object

        if ( isset($data->error) ) {
            $layout = 'error_index_index'; $data->layout = $layout;            
        } 
        
        return view('admin.layouts.'.$layout, ['data' => $data]);
    }

    /* PAGES */
    private function error_index_index($request)
    {
        $data = new \stdClass;
        $data->error = [
            'code'      => 404,
            'message'   => 'page not found'
        ];
        return $data;
    }

    /*
    ---> Dashboard
    */
    private function dashboard_index_index($request)
    {
        $data = new \stdClass;
        $data->example = 'example';
        return $data;
    }

    /*
    ---> Schools
    */
    private function schools_index_index($request)
    {
        return SchoolLayoutController::layout_list($request);
    }

    private function school_create_index($request)
    {
        return SchoolLayoutController::layout_create($request);
    }

    private function school_update_index($request)
    {        
        return SchoolLayoutController::layout_update($request);
    }

    private function school_students_index($request)
    {
        return SchoolLayoutController::layout_students($request);
    }

    /*
    ---> Students
    */
    private function student_create_index($request)
    {
        return StudentLayoutController::layout_create($request);
    }

    private function student_update_index($request)
    {
        return StudentLayoutController::layout_update($request);
    }

    /*
    ---> My Account
    */
    private function users_index_index($request)
    {

        return UserLayoutController::layout_list($request);
    }
    
    private function user_update_index($request)
    {
        return UserLayoutController::layout_update($request);
    }

}