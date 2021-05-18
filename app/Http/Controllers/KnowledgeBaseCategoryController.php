<?php

namespace App\Http\Controllers;

use App\KnowledgeBaseCategory;
use App\KnowledgeBaseItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KnowledgeBaseCategoryController extends Controller
{
    //
    public function index(){

        $categories = KnowledgeBaseCategory::all();
        return response( $categories->jsonSerialize(), Response::HTTP_OK);

    }

    public function getItems($id){

        $items = KnowledgeBaseItem::where(['knowledge_base_item_type'=>$id])->get();

        return response( $items->jsonSerialize(), Response::HTTP_OK);

    }
}
