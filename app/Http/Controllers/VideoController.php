<?php

namespace App\Http\Controllers;

use App\LearningPathItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    //
    public function store(Request $request){



        $learning_path_item = new LearningPathItem();
        $learning_path_item->lesson_type_id = 4;

        $learning_path_item->learning_path_item_title = $request->post('title');
        $learning_path_item->learning_path_item_object = $request->post('url');
        $learning_path_item->learning_path_id = $request->post('learning_path_id');
        $learning_path_item->save();

        return response( $learning_path_item->jsonSerialize(), Response::HTTP_OK);
    }
}
