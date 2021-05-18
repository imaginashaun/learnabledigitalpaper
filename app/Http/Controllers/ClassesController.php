<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\LearningPath;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class ClassesController extends Controller
{

    //
    public function index(){



//        $user = 4;
        $user =  Auth::id();

        if(Auth::user()->level == 2){

            $class =  ClassRoom::leftJoin('learning_paths', function ($join) {
                $join->on('classes.id', '=', 'learning_paths.class');
            })->groupBy('classes.id')->selectRaw('classes.*, GROUP_CONCAT(learning_paths.learning_path_title) as learning_path_titles')->get();

        }else if(Auth::user()->level == 3) {

            $class =  ClassRoom::where(['classes.assessor'=>$user])->leftJoin('learning_paths', function ($join) {
                $join->on('classes.id', '=', 'learning_paths.class');
            })->groupBy('classes.id')->selectRaw('classes.*, GROUP_CONCAT(learning_paths.learning_path_title) as learning_path_titles')->get();

        }else{


            $class =  ClassRoom::where(['educator'=>$user])->leftJoin('learning_paths', function ($join) {
                $join->on('classes.id', '=', 'learning_paths.class');
            })->groupBy('classes.id')->selectRaw('classes.*, GROUP_CONCAT(learning_paths.learning_path_title) as learning_path_titles')->get();
        }



/*
        $class =  ClassRoom::where(['educator'=>$user])->get();
*/

     //   $paths =  LearningPath::where(['class'=>$class->id])->get();

       // $class->paths = $paths;

        return response( $class->jsonSerialize(), Response::HTTP_OK);
    }




    //
    public function store(Request $request){

        $class = new ClassRoom();
        $class->title = $request->post("classname");
        $class->educator = Auth::id();
      //  $class->educator = 4;
        $class->save();

        return response( $class->jsonSerialize(), Response::HTTP_OK);
    }
}
