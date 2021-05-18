<?php

namespace App\Http\Controllers;

use App\LearningPathItem;
use App\StudentAnswers;
use App\TimeSpent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LearningPathItemController extends Controller
{
    //
    public function index(){


        $learningpathitems = LearningPathItem::select(['learning_path_items.*', 'lesson_types.type_icon'])-> join('lesson_types', function ($join) {
            $join->on('learning_path_items.lesson_type_id', '=', 'lesson_types.id');
        })->get();

        return response( $learningpathitems->jsonSerialize(), Response::HTTP_OK);

    }

    public function get_index($learning_path_id){



        $learningpathitems = LearningPathItem::select(['learning_path_items.*', 'lesson_types.type_icon'])->where(['learning_path_id'=>$learning_path_id])-> join('lesson_types', function ($join) {
            $join->on('learning_path_items.lesson_type_id', '=', 'lesson_types.id');
        })  ->orderBy('id', 'desc')->get();

        return response( $learningpathitems->jsonSerialize(), Response::HTTP_OK);

    }

    public function show($learning_path_id){


        $learningpathitems = LearningPathItem::select(['learning_path_items.*', 'lesson_types.type_icon'])->where(['learning_path_items.id'=>$learning_path_id])-> join('lesson_types', function ($join) {
            $join->on('learning_path_items.lesson_type_id', '=', 'lesson_types.id');
        })->first();

        return response( $learningpathitems->jsonSerialize(), Response::HTTP_OK);

    }


    public function updateTime($learning_path_id, $old_time){

        $time = TimeSpent::where(['learningpath_item_time_id'=>$learning_path_id, 'student_time_id'=>Auth::id()])->first();


        $newtime = $old_time+$time->timespent;

        $timespent = TimeSpent::where('learningpath_item_time_id', $learning_path_id)
            ->where('student_time_id', Auth::id())
            ->update(['timespent' => $newtime]);


        return response( $timespent, Response::HTTP_OK);
    }

    public function getAndUpdateIndex($learning_path_id, $user_id){


        $time = TimeSpent::where(['learningpath_item_time_id'=>$learning_path_id, 'student_time_id'=>$user_id])->count();

        if($time > 0){



        }else{
            $timespent = new TimeSpent;
            $timespent->learningpath_item_time_id =$learning_path_id;
            $timespent->student_time_id = $user_id;
            $timespent->save();

        }

        $learningpathitems = LearningPathItem::select(['learning_path_items.*', 'lesson_types.type_icon'])->where(['learning_path_items.id'=>$learning_path_id])-> join('lesson_types', function ($join) {
            $join->on('learning_path_items.lesson_type_id', '=', 'lesson_types.id');
        })->first();

        return response( $learningpathitems->jsonSerialize(), Response::HTTP_OK);

    }
}
