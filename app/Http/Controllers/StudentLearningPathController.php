<?php

namespace App\Http\Controllers;

use App\LearningPath;
use App\LearningPathItem;
use App\StudentAnswers;
use App\StudentLearningPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLearningPathController extends Controller
{
    //

    public function submit(Request $request)
    {

        $answer = new StudentAnswers;
        $answer->student_answers_student_id = $request->post('student_answers_student_id');
        $answer->student_answers_learning_path_id = $request->post('student_answers_learning_path_id');
        $answer->student_answers_learning_path_item_id = $request->post('student_answers_learning_path_item_id');
        $answer->student_answers_object = $request->post('student_answers_object');

        //$class->update(['qrcode'=> $this->generateClassCode($class->id)]);
        $answer->save();
        return $answer;
        //  return redirect('/lesson/view/'.$lesson->subject.'/'.$lesson->class_id.'/'.$lesson->id)->with("You have joined ".$lesson->title);
    }

    public function joinLesson(Request $request, $learningpathcode)
    {


        $user = Auth::id();
        $learningpath = LearningPath::where(['learning_path_code'=>$learningpathcode])->first();

        $joinedcount = StudentLearningPath::where(['student_learning_path_student_id'=>$user, 'student_learning_path_lesson_id'=>$learningpath->id])->count();


        if($joinedcount > 0){
            $student_enrolment = StudentLearningPath::where(['student_learning_path_student_id'=>$user, 'student_learning_path_lesson_id'=>$learningpath->id])->first();

        }else {

            $student_enrolment = new StudentLearningPath;
            $student_enrolment->student_learning_path_student_id = $user;
            $student_enrolment->student_learning_path_lesson_id = $learningpath->id;
            //$class->update(['qrcode'=> $this->generateClassCode($class->id)]);
            $student_enrolment->save();

        }

        $student_enrolment->return_message = $joinedcount>0?"You had already joined this lesson.":"Successfully joined lesson.";

        return $student_enrolment;
        //  return redirect('/lesson/view/'.$lesson->subject.'/'.$lesson->class_id.'/'.$lesson->id)->with("You have joined ".$lesson->title);
    }
}
