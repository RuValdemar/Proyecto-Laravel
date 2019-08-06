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

/*use App\Video;

Route::get('/', function () {

	$videos = Video::all();
	foreach ($videos as  $video) {
		echo '<p>' . $video->title . '<br/>';
		echo $video->user->email . '<br/>';
		foreach ($video->comments as $comment) {
			echo $comment->body. '<br/></p>';
		}
		echo '<hr>';
	}
	die();
    
});*/

/*Route::get('/', function () {
    return view('welcome');
});*/


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
/*Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@index'
));*/

//Rutas del controlador videos

Route::get('/crear-video', array(
	'as' => 'createVideo',
	'middleware' => 'auth',
	'uses' => 'VideoController@create'
));

Route::post('/guardar-video', array(
	'as' => 'saveVideo',
	'middleware' => 'auth',
	'uses' => 'VideoController@store'
));

Route::post('/update-video/{video_id}', array(
	'as' => 'updateVideo',
	'middleware' => 'auth',
	'uses' => 'VideoController@update'
));

Route::get('/buscar-video/{search?}/{filter?}', array(
	'as' => 'searchVideo',
	'uses' => 'VideoController@search'
));

Route::get('/thumbnail/{filename}', array(
	'as' => 'imageVideo',
	'uses' => 'VideoController@getImage'
));

Route::get('/video/{video_id}', array(
	'as' => 'detailVideo',
	'uses' => 'VideoController@show'
));

Route::get('/video-file/{filename}', array(
	'as' => 'fileVideo',
	'uses' => 'VideoController@getVideo'
));

Route::get('/editar-video/{video_id}', array(
	'as' => 'videoEdit',
	'middleware' => 'auth',
	'uses' => 'VideoController@edit'
));

Route::get('/delete-video/{video_id}', array(
	'as' => 'videoDelete',
	'middleware' => 'auth',
	'uses' => 'VideoController@destroy'
));



//Ruta para comentarios
Route::post('/comment', array(
	'as' => 'comment',
	'middleware' => 'auth',
	'uses' => 'CommentController@store'
));

//Ruta para eliminar comentario
Route::get('/delete-comment/{comment_id}', array(
	'as' => 'commentDelete',
	'middleware' => 'auth',
	'uses' => 'CommentController@delete'
));

//Usuarios
Route::get('/canal/{user_id}', array(
	'as' => 'channel',
	'uses' => 'UserController@index'
));


//Borrar Cache
Route::get('/clear-cache', function(){
	$code = Artisan::call('cache:clear');
});