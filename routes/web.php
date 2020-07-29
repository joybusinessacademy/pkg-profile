<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

\Illuminate\Support\Facades\Route::group([

], function($router){
    $router->get('/resumes', 'ResumeController@index')
            ->name(dotUrl(config('jba-profile.route.prefix')) . '.resumes');

    $router->get('/resumes/{resume}/download', 'ResumeController@download')
        ->name(dotUrl(config('jba-profile.route.prefix')) . '.resumes.download');

    $router->put('/resumes/{resume}/default', 'ResumeController@setDefault')
        ->name(dotUrl(config('jba-profile.route.prefix')) . '.resumes.default');

    $router->post('/resumes', 'ResumeController@upload')
            ->name(dotUrl(config('jba-profile.route.prefix')) . '.resumes.upload');

    $router->delete('/resumes/{resume}', 'ResumeController@remove')
        ->name(dotUrl(config('jba-profile.route.prefix')) . '.resumes.remove')
        ->where('resume', '\d+');

    $router->put('/cover_letter', 'ProfileController@updateCoverLetter')
        ->name(dotUrl(config('jba-profile.route.prefix')) . '.cover_letter.update');
});