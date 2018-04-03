<?php
//error_reporting(E_ALL);
Route::auth();

Route::get('/', 'HomeController@index');

/*     HomeController  */

Route::get('/home', 'HomeController@index');

Route::post('asked', 'HomeController@askedQuestion');

Route::get('ask', 'HomeController@askQuestion');


/*     AdminController  */

Route::get('/adminMgt', 'AdminController@adminMgt');

Route::get('/deleteAdmin/{id}/{name}', 'AdminController@deleteAdmin');

Route::get('/adminMonitor', 'AdminController@adminMonitor');

Route::get('/addAdmin', function () {
    return view('addAdmin');
});

Route::post('/adminAdded', 'AdminController@createAdmin');

Route::post('/resetpass/{id}/{name}', 'AdminController@resetpass');


/*     TagController  */

Route::get('/tagMgt', 'TagController@index');

Route::post('/changeTagName/{id} / {name}', 'TagController@changeTagName');

Route::post('/addTagname', 'TagController@addTagName');

Route::get('/deleteTag/{id} /{name}', 'TagController@deleteTag');


/*     QuestionController  */

Route::get('/questionAll', 'QuestionController@questionsAll');

Route::get('/questionUnaMgt', 'QuestionController@questionsUnsMgt');

Route::post('answer/{id}/{tag}', 'QuestionController@answer');

Route::get('deleteQuestion/{id}/{tag}', 'QuestionController@deleteQuestion');

Route::get('makeNonVisible/{id}', 'QuestionController@makeNonVisible');

Route::get('makeVisible/{id}', 'QuestionController@makeVisible');

Route::get('/questionsCenosred', 'QuestionController@questionsCenosred');

Route::get('/questionAnsMgt', 'QuestionController@questionAnsMgt');

Route::post('/changeUnaQuestionTag/{id}/{tag}', 'QuestionController@changeUnaQuestionTag');

Route::post('/changeAnsQuestionTag/{id}/{tag}', 'QuestionController@changeAnsQuestionTag');

Route::post('/authorChange/{id}/{author}', 'QuestionController@authorChange');

Route::post('/questionChange/{id}/{question}', 'QuestionController@questionChange');

Route::post('/answerChange/{id}/{answer}', 'QuestionController@answerChange');

Route::get('/allowQuestion/{id}/{tag}', 'QuestionController@allowQuestion');


/*     CensorController  */

Route::get('/censor/', 'CensorController@index');

Route::post('/addWord/', 'CensorController@addWord');

Route::get('/deleteWord/{id}/{word}', 'CensorController@deleteWord');



