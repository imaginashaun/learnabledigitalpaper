<?php

namespace App\Http\Controllers;

use App\LearningPathItem;
use App\StudentAnswers;
use App\StudentLearningPath;
use App\TimeSpent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    //


    public function show($learning_path_id)
    {

        $students = StudentLearningPath::select(['users.*'])->where(['student_learning_path_lesson_id'=>$learning_path_id])-> join('users', function ($join) {
            $join->on('student_learning_paths.student_learning_path_student_id', '=', 'users.id');
        })->get();


        return response( $students->jsonSerialize(), Response::HTTP_OK);

    }

   public function get_percentage($total, $number)
    {
        if ( $total > 0 ) {
            return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }
    public function detailed($learning_path_id,$user_id)
    {

        $user = User::find($user_id);
        $answers = StudentAnswers::where(['student_answers_student_id'=>$user_id])->get();
//        $learning_path_items = LearningPathItem::select(['learning_path_items.*', 'time_spents.timespent', DB::Raw('IFNULL(student_answers.student_answers_object, \'\')')])->where(['learning_path_id'=>$learning_path_id, 'time_spents.student_time_id'=>$user_id, 'student_answers.student_answers_student_id'=>$user_id])
        $learning_path_items = LearningPathItem::select('learning_path_items.*', 'time_spents.timespent')->where(['learning_path_id'=>$learning_path_id, 'time_spents.student_time_id'=>$user_id])
            ->leftJoin('time_spents', function ($join) {
                $join->on('learning_path_items.id', '=', 'time_spents.learningpath_item_time_id');
            })->get();
        $total_time_spent = 0;
        $total_score = 0;
        $total_out_of = 0;



        $learning_path_items_count = LearningPathItem::where(['learning_path_id'=>$learning_path_id])->count();


        $count_howmany_were_taken_count = 0;


        for($i =0; $i < count($learning_path_items); $i++){

            $count_howmany_were_taken_count += TimeSpent::where(['learningpath_item_time_id'=>$learning_path_items[$i]->id, 'student_time_id'=>$user_id])->count();

            $learning_path_items_d = StudentAnswers::where(['student_answers_learning_path_id'=>$learning_path_items[$i]->id, 'student_answers_student_id'=>$user_id])->first();

            if($learning_path_items_d){
                $learning_path_items[$i]->student_answers_object = $learning_path_items_d->student_answers_object;


               $json_o = json_decode($learning_path_items[$i]->student_answers_object);

               foreach ($json_o->questions as $qs){



                   if(isset( $qs->answer )){


                       if(isset($qs->selected) && $qs->answer === $qs->selected && $json_o->type === 1){

                           $total_score+=1;

                       }

                       $total_out_of +=1;

                   }
               }
            }

            $total_time_spent += $learning_path_items[$i]->timespent;
        }

       // $timespent = TimeSpent::where(['learning_path_id'=>$learning_path_id])->get();



        $detailed_results = ['student'=>$user,
            'answers'=>$answers,
            'learning_path_items'=>$learning_path_items,
            'total_time_spent'=>$total_time_spent,
            'total_score'=>$total_score."/".$total_out_of,
            'total_percent'=>$this->get_percentage($total_out_of,$total_score),
            'progress'=>$this->get_percentage($learning_path_items_count,$count_howmany_were_taken_count),
            ];

        /*
        $students = StudentLearningPath::select(['users.*'])->where(['student_learning_path_lesson_id'=>$learning_path_id])-> join('users', function ($join) {
            $join->on('student_learning_paths.student_learning_path_student_id', '=', 'users.id');
        })->get();

        */

        return response( $detailed_results, Response::HTTP_OK);

    }
}
