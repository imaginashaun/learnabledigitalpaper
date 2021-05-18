<?php

namespace App\Http\Controllers;

use App\StudentAnswers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssessorsController extends Controller
{


    public function index(){
        $assessors = User::where(['level'=>3])->get();
        return response( $assessors->jsonSerialize(), Response::HTTP_OK);
    }


    public function store(Request $request){


        /*
         *
         *
                    data.append('rubric', JSON.stringify({
                        'answers_are': this.multipleChoiceQuestions
                    }))

         */

        $id = json_decode($request->post("rubric"))->answers_are[0]->question_id;

        $assessors = StudentAnswers::find($id);

        $assessors->student_answers_teacher_object = json_encode(json_decode($request->post("rubric"))->answers_are);

        $assessors->save();

        return response( $assessors->jsonSerialize(), Response::HTTP_OK);
    }
    //
}
