<?php

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
    return "Welcome to star wars movie api. Visit https://github.com/mezlet/star-wars-API to navigate repository";
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->group(['middleware' => 'validatePaging'], function () use ($router) {
        $router->get("/movies", 'MovieController@getMovieList');
    });
    $router->group(['middleware' => ['validateParams','isMovieExist']], function () use ($router) {
        $router->get("/movies/{movie_id}/comments", 'CommentController@getComments');
        $router->group(['middleware' => 'validateSorting'], function () use ($router) {
            $router->get("/movies/{movie_id}/characters/", 'MovieController@getMovie');
        });
        $router->post('movies/{movie_id}/comments', 'CommentController@addComment');
    });

});
