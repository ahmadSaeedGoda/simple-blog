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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::put('article/{id}/publish', 'ArticleController@publish')->name('article.publish');

    Route::resources([
        'category' => 'CategoryController',
        'article' => 'ArticleController'
    ]);
    
    Route::resource('comment', 'CommentController')->only([
        'index', 'show'
    ]);
});

Route::group(['as' => 'visitor.', 'prefix' => 'visitor', 'namespace' => 'Visitor', 'middleware' => ['auth', 'visitor']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::resource('article', 'ArticleController')->only([
        'index', 'show'
    ]);

    Route::resource('comment', 'CommentController')->only([
        'store'
    ]);

    Route::post('article', 'ArticleController@getArticlesByCategory')->name('articles.category');
});
