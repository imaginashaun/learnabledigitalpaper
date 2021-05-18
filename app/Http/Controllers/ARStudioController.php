<?php

namespace App\Http\Controllers;

use App\LearningPathItem;
use App\MaterialItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ARStudioController extends Controller
{
    //

    public function index(){

        $m_objects = MaterialItem::where('lesson_type_id', '6')->get();

        return response( $m_objects->jsonSerialize(), Response::HTTP_OK);
    }


    public function store(Request $request){


        $object_to_save = (object) [];

   //     Storage::put('public/1', $request->post('audio_file'));

    //    print_r($object_to_save);

      //  echo "ENDLOC";

        $learning_path_item = new LearningPathItem();
        $learning_path_item->lesson_type_id = 6;

        if($request->has('audio_file')) {
            $object_to_save->audio_file = $request->file('audio_file')->store('/recordings/', 'public');
        }
        if($request->has('object_file')) {
            $object_to_save->object_file = $request->post('object_file');
        }

        if($request->has('object_hotspots')) {
            $object_to_save->object_hotspots = $request->post('object_hotspots');
        }

        if($request->has('object_id')) {
            $object_to_save->object_id = $request->post('object_id');
        }
        //$class->educator = Auth::id();
        $learning_path_item->learning_path_item_object =  json_encode($object_to_save);
        $learning_path_item->learning_path_id = $request->post('learning_path_id');
        $learning_path_item->save();

        return response( $learning_path_item->jsonSerialize(), Response::HTTP_OK);
    }
}
