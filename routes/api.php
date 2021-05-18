<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('/ar_objects', 'ARStudioController');
Route::resource('/assessment_object', 'AssessmentController');
Route::resource('/literature_object', 'LiteratureController');
Route::resource('/video_object', 'VideoController');

Route::resource('/learningpathitems', 'LearningPathItemController');

Route::get('/learningpathitems_get/{learning_path_id}/{user_id}', 'LearningPathItemController@getAndUpdateIndex');

Route::get('/learningpathitems/fetchall/{learning_path_id}', 'LearningPathItemController@get_index');

Route::resource('/knowledgebase', 'KnowledgeBaseCategoryController');

Route::get('/subjects/themes', 'SubjectsController@themes');
Route::get('/lessons/types', 'SubjectsController@lessontypes');
Route::get('/lessons/create', 'SubjectsController@createnew');
Route::get('/lessons/create/{class_id}/{subject_id}', 'SubjectsController@createForClass');
Route::get('/lessons/get/{learning_path_id}', 'SubjectsController@getLesson');


Route::get('/lessons/getall/{class_id}', 'SubjectsController@getAllLessons');



Route::post('/lessons/update', 'SubjectsController@updatelesson');
Route::get('/knowledgebaseitems/{id}', 'KnowledgeBaseCategoryController@getItems');
//Route::get('/arstudio/objects', 'ARStudioController@index');

Route::post('/learningpathitems/submit', 'StudentLearningPathController@submit');
Route::get('/results/lesson', 'StudentLearningPathController@results');

Route::get('/results/{learning_path_id}', 'SubjectsController@getDetails');

Route::resource('/class', 'ClassesController');
Route::resource('/lesson_results', 'ResultsController');



//toremove
Route::get('lessons/getdetails/{learning_path_id}', 'SubjectsController@getDetails');

//data
Route::get('detailed_results/{learning_path_id}/{user_id}', 'ResultsController@detailed');

Route::post('createbotclass', 'SubjectsController@createbotclass');

//Route::middleware('auth:api')->resource('/class', 'ClassesController');
Route::post('whatsapp', 'WhatsAppController@receive');
Route::get('whatsapp', 'WhatsAppController@testmultiple');


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('api_signup', 'AuthController@signup');

    Route::post('api_checkuser', 'AuthController@checkUser');



    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::get('join_lesson/{learningpathcode}', 'StudentLearningPathController@joinLesson');
        Route::get('mylessons/getall', 'SubjectsController@getMyLessons');
        Route::get('learningpath/show', 'SubjectsController@getMyLessons');
        Route::get('lessons/get/{learning_path_id}', 'SubjectsController@getLesson');
        Route::get('lessons/get/{learning_path_id}', 'SubjectsController@getLesson');
        Route::get('updatetime/{learning_path_id}/{old_time}', 'LearningPathItemController@updateTime');
        Route::resource('/class', 'ClassesController');
        Route::resource('/assessors', 'AssessorsController');

        Route::resource('/subjects', 'SubjectsController', [
            'except' => ['edit', 'show', 'store']
        ]);


//        Route::get('join_lesson/{lessoncode}', 'EducatorClassController@getJoin');

//       Route::post('class/create', 'ClassesController@create');

    });

});
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
