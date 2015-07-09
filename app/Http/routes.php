<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('foo/{user}/{name}/{age}', function($user, $name, $age) {
	return "Hello, ".$user." ".$name.". You age is ".$age; 
})->where(['user'=>'[a-z]+',
			'name'=>'[a-z]+',
			'age'=>'[0-9]+']);*/

Route::get('/', 'FrontController@index');
Route::get('dbase', ['as'=>'database', 'uses'=>'FrontController@database']);
Route::get('home', 'HomeController@index');
Route::get('adding', ['as'=>'add', 'middleware'=>'cabinet', 'uses'=>'FrontController@adding']);

Route::get('cabinet', ['as'=>'cabinet', 'uses'=>'CabinetController@index']);
Route::get('cabinet/discoveries', ['as'=>'discovery', 'uses'=>'CabinetController@discovery']);
Route::get('cabinet/mail', ['as'=>'usermail', 'uses'=>'CabinetController@mail']);
Route::get('cabinet/deletemail', ['as'=>'cabMailDel', 'uses'=>'CabinetController@mailDelete']);

Route::get('administration', ['as'=>'administration', 'uses'=>'AdministrationController@index']);
Route::get('administration/mail', ['as'=>'adminmail', 'uses'=>'AdministrationController@mail']);
Route::get('administration/change', ['as'=>'del-o-prove', 'uses'=>'AdministrationController@delprove']);
Route::get('administration/request', ['as'=>'screenRequest', 'uses'=>'AdministrationController@request']);
Route::get('administration/deletemail', ['as'=>'admMailDel', 'uses'=>'AdministrationController@mailDelete']);
Route::get('administration/search', ['as'=>'search', 'uses'=>'AdministrationController@search']);
Route::get('administration/delete', ['as'=>'delete', 'uses'=>'AdministrationController@delete']);

Route::get('moderation', ['as'=>'moderation', 'uses'=>'ModerationController@index']);
Route::get('moderation/reader', ['as'=>'reader', 'uses'=>'ModerationController@reader']);
Route::get('moderation/results', ['as'=>'reportResult', 'uses'=>'ModerationController@result']);
Route::get('moderation/roles', ['as'=>'roles', 'uses'=>'ModerationController@roles']);
Route::get('moderation/setrole', ['as'=>'setrole', 'uses'=>'ModerationController@setRoles']);
Route::get('moderation/texts', ['as'=>'texts', 'uses'=>'ModerationController@texts']);
Route::get('moderation/multistars', ['as'=>'multi', 'uses'=>'ModerationController@multistars']);


Route::post('ajaform', ['as'=>'AjaxFormer', 'uses'=>'AjaxController@chartForms']);
Route::post('ajachart', ['as'=>'AjaxCharter', 'uses'=>'AjaxController@chartBuilder']);
Route::post('ajaxadd', ['as'=>'AjaxAdder', 'uses'=>'AjaxController@baseAdder']);
Route::post('ajamoder', ['as'=>'AjaxModeration', 'uses'=>'AjaxController@moderation']);
Route::post('ajamoder/charts', ['as'=>'AjaxModerationCharts', 'uses'=>'AjaxController@moderationCharts']);
Route::post('ajacabin', 'AjaxController@cabinetInfo');

Route::post('senmail', ['as'=>'sender', 'uses'=>'CabinetController@sender']);
Route::post('sendmail', ['as'=>'senderAdmin', 'uses'=>'AdministrationController@sender']);
Route::post('sendrep', ['as'=>'reportAccepter', 'uses'=>'ModerationController@reporter']);
Route::post('changetext', ['as'=>'changeText', 'uses'=>'ModerationController@changer']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/{url}', ['as'=>'staticPages', 'uses'=>'FrontController@staticPage'])->where('url', '[a-z_]+');
