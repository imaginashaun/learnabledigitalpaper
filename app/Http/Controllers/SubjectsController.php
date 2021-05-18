<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\LearningPath;
use App\LearningPathItem;
use App\LessonType;
use App\StudentLearningPath;
use App\Subject;
use App\Subjects;
use App\Theme;
use App\TimeSpent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SubjectsController extends Controller
{
    //

    public function index(){

        $subjects = Subject::join('themes', function ($join) {
            $join->on('subjects.subject_theme_id', '=', 'themes.id');
        })->get();

        return response( $subjects->jsonSerialize(), Response::HTTP_OK);
    }

    protected function generateLessonCode($id){


        return 'l'.chr(rand(97,122)).$id;
        //  return strtoupper( uniqid('L'));
    }

    public function updatelesson(Request $request){


        $user = 1;
        $learningpath = LearningPath::find($request->post('id'));
        $learningpath->learning_path_title = $request->post('learning_path_title')??null;
        $learningpath->learning_path_desc = $request->post('learning_path_desc')??null;
        $learningpath->learning_path_theme = $request->post('learning_path_theme')??null;
        $learningpath->learning_path_subject = $request->post('learning_path_subject')??null;
        $learningpath->assessor = $request->post('assessor')??null;

        $learningpath->save();

        $class = ClassRoom::find($request->post('class'));
        $class->assessor = $request->post('assessor')??null;

        $learningpath->save();


        return response( $learningpath->jsonSerialize(), Response::HTTP_OK);
    }

    public function createForClass($class_id, $subject_id){

        $user = 1;
        $learningpath = new LearningPath;

        $learningpath->learning_path_educator = $user;
        $learningpath->class = $class_id;
        $learningpath->learning_path_subject = $subject_id;



        $learningpath->save();



        $learningpath->learning_path_code = $this->generateLessonCode($learningpath->id);

        $learningpath->save();

        $learningpath = LearningPath::find($learningpath->id);

        $learningpath->select(['learning_paths.*', 'themes.id as learning_path_theme'])-> join('themes', function ($join) {
            $join->on('learning_paths.learning_path_subject', '=', 'themes.id');
        })->get();


        return response( $learningpath->jsonSerialize(), Response::HTTP_OK);
    }



    public function createbotclass(Request $request){



        $class = new ClassRoom();
        $class->title = $request->post("class_name");
        $class->educator = 1;
        //  $class->educator = 4;
        $class->save();



        $user = 1;
        $learningpath = new LearningPath;

        $learningpath->learning_path_educator = $user;
        $learningpath->class = $class->id;
        $learningpath->learning_path_subject = $request->post("subject_id");



        $learningpath->save();



        $learningpath->learning_path_code = $this->generateLessonCode($learningpath->id);

        $learningpath->save();

        $learningpath = LearningPath::find($learningpath->id);

        $learningpath->select(['learning_paths.*', 'themes.id as learning_path_theme'])-> join('themes', function ($join) {
            $join->on('learning_paths.learning_path_subject', '=', 'themes.id');
        })->get();


        return response( $learningpath->id, Response::HTTP_OK);
    }

    public function getMyLessons(){


        $learningpath = StudentLearningPath::where(['student_learning_path_student_id'=>Auth::id()])->select(['learning_paths.*', 'themes.id as learning_path_theme', 'themes.theme_color', 'themes.theme_illustration'])-> join('learning_paths', function ($join) {
            $join->on('learning_paths.id', '=', 'student_learning_paths.student_learning_path_lesson_id');
        })-> join('themes', function ($join) {
            $join->on('learning_paths.learning_path_theme', '=', 'themes.id');
        })->get();


        /*
        $learningpath = LearningPath::where(['class'=>'1'])->select(['learning_paths.*', 'themes.id as learning_path_theme', 'themes.theme_color', 'themes.theme_illustration'])-> join('themes', function ($join) {
            $join->on('learning_paths.learning_path_theme', '=', 'themes.id');
        })->get();
        */

        return response( $learningpath->jsonSerialize(), Response::HTTP_OK);
    }


    public function getDetails($learning_path_id){


        $learningpath = LearningPath::where(['learning_paths.id'=>$learning_path_id])->select(['learning_paths.*', 'themes.id as learning_path_theme', 'themes.theme_color', 'themes.theme_illustration'])-> join('themes', function ($join) {
            $join->on('learning_paths.learning_path_theme', '=', 'themes.id');
        })->first();

        return response( $learningpath->jsonSerialize(), Response::HTTP_OK);
    }


    public function get_percentage($total, $number)
    {
        if ( $total > 0 ) {
            return round($number / ($total / 100),2);
        } else {
            return 0;
        }
    }
    public function getAllLessons($class_id){


        $learningpath = LearningPath::where(['class'=>$class_id])->select(['learning_paths.*', 'themes.id as learning_path_theme', 'themes.theme_color', 'themes.theme_illustration'])-> join('themes', function ($join) {
            $join->on('learning_paths.learning_path_theme', '=', 'themes.id');
        })->get();



        for($i =0; $i < count($learningpath); $i++){
            $count_howmany_were_taken_count = 0;

            $learning_path_items_count = 0;

            $slp_id = StudentLearningPath::where(['student_learning_path_lesson_id'=>$learningpath[$i]->id])->count();
           // $slp_id = 1;


            $slp__each_attempt = LearningPathItem::where(['learning_path_id'=>$learningpath[$i]->id])->get();


            $learning_path_items_count = LearningPathItem::where(['learning_path_id'=>$learningpath[$i]->id])->count();


            foreach($slp__each_attempt as $slpnin){
                $count_howmany_were_taken_count += TimeSpent::where(['learningpath_item_time_id'=>$slpnin->id])->count();
            }


            $total_id = (count($slp__each_attempt)*$slp_id);

            $learningpath[$i]->progress = $this->get_percentage($total_id,$count_howmany_were_taken_count);
            $learningpath[$i]->students = $slp_id;
            //$this->get_percentage($total_id,$count_howmany_were_taken_count)
        }




//        $lessons_results = ['learning_paths'=>$learningpath];

        return response( $learningpath->jsonSerialize(), Response::HTTP_OK);
//        return response( $lessons_results, Response::HTTP_OK);
    }




    public function getLesson($learning_path_id){


        $learningpathitems = LearningPathItem::select(['lesson_types.type_title as lesson_type_title', 'learning_path_items.*'])->where(['learning_path_id'=>$learning_path_id])->join('lesson_types', function ($join){

            $join->on('lesson_types.id', '=', 'learning_path_items.lesson_type_id');

        })->get();


        return response( $learningpathitems->jsonSerialize(), Response::HTTP_OK);
    }

    public function createnew(){

        $user = 1;
        $learningpath = new LearningPath;

        $learningpath->learning_path_educator = $user;



        $learningpath->save();



        $learningpath->learning_path_code = $this->generateLessonCode($learningpath->id);

        $learningpath->save();

        $learningpath = LearningPath::find($learningpath->id);

        $learningpath->select(['learning_paths.*', 'themes.id as learning_path_theme'])-> join('themes', function ($join) {
            $join->on('learning_paths.learning_path_subject', '=', 'themes.id');
        })->get();


        return response( $learningpath->jsonSerialize(), Response::HTTP_OK);
    }

    public function themes(){

        $themes = Theme::all();

        return response( $themes->jsonSerialize(), Response::HTTP_OK);
    }

    public function lessontypes(){

        $lesson_types = LessonType::where('state', '1')->orderBy('lesson_type_weight','DESC')->get();

        return response( $lesson_types->jsonSerialize(), Response::HTTP_OK);
    }
}
