<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'api'
], function () use ($router) {
    $router->post('/login', 'AuthController@login');
    $router->get('/course', 'CourseController@index');
    $router->get('/posts', 'StudentController@getPost');
    $router->get('/posts/{postId}', 'StudentController@getDetailPost');
    $router->post('/course', 'CourseController@create');
    $router->post('/add-student-course', 'StudentController@studentSignCourse');
    $router->post('comments', 'StudentController@createComment');
    $router->delete('comments/{id}', 'StudentController@deleteComment');
    $router->delete('course/{id}', 'CourseController@delete');
});
