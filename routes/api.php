<?php

use App\Http\Controllers\FilesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('greeting', function (Request $request) {
    return 'Hello World';
});

Route::get('post/{id}', 'FilesController@show');

Route::get('post', 'FilesController@index');

Route::get('wallpapers', 'FilesController@getWallpapers');
Route::get('featureWallpapers/{count}', 'FilesController@featureWallpapers');

Route::get('ringtones', 'FilesController@getRingtones');
Route::get('featureRingtones/{count}', 'FilesController@featureRingtones');

Route::post('updateDownload/{id}', 'FilesController@updateDownloads');

Route::post('uploadFiles', 'FilesController@uploadFiles');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
