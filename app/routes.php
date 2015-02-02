<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);


Route::get('by_tag/{title}', array('as' => 'home.by_tag', 'uses' => 'HomeController@byTag'))->where('title', '[A-Za-z0-9 -_]+');
Route::get('by_city/{name}', array('as' => 'home.by_city', 'uses' => 'HomeController@byCity'));
Route::get('by_company/{name}', array('as' => 'home.by_company', 'uses' => 'HomeController@byCompany'))->where('title', '[A-Za-z0-9 -_]+');


Route::resource('roles', 'RolesController');

Route::resource('cities', 'CitiesController');

Route::resource('companies', 'CompaniesController');

Route::resource('tags', 'TagsController');

Route::resource('offers', 'OffersController');

Route::resource('comments', 'CommentsController');
Route::resource('users', 'UsersController');

/**
 *	Новые роуты для регистрации/авторизации
 */

//Route::get('/', array('as' => 'home', function()
//{
//	return View::make('hello');
//}));

Route::get('logout', array('as' => 'login.logout', 'uses' => 'LoginController@logout'));

Route::group(array('before' => 'un_auth'), function()
{
	Route::get('login', array('as' => 'login.index', 'uses' => 'LoginController@index'));
	Route::get('register', array('as' => 'login.register', 'uses' => 'LoginController@register'));
	Route::post('login', array('uses' => 'LoginController@login'));
	Route::post('register', array('uses' => 'LoginController@store'));
});

Route::group(array('before' => 'admin.auth'), function()
{
	Route::get('dashboard', function()
	{
		return View::make('login.dashboard');
	});

	Route::resource('roles', 'RolesController');

	Route::resource('cities', 'CitiesController');

	Route::resource('companies', 'CompaniesController');

	Route::resource('tags', 'TagsController');

	Route::resource('offers', 'OffersController');

	Route::resource('comments', 'CommentsController');

	Route::post('upload', array('uses' => 'HomeController@uploadOfferImage'));

});

Route::filter('admin.auth', function()
{
	if (Auth::guest()) {
		return Redirect::to('login');
	}
});

Route::filter('un_auth', function()
{
	if (!Auth::guest()) {
		Auth::logout();
	}
});

Route::get('offer_{id}', array('as' => 'home.offer', 'uses' => 'HomeController@showOffer'))->where('id', '[0-9]+');
Route::post('offer_{id}', array('before' => 'not_guest', 'uses' => 'HomeController@commentOnOffer'))->where('id', '[0-9]+');
//Route::get('offer_{id}', array('as'=>'offer.more', 'uses' => 'HomeController@commentOnOffer'))->where('id', '[0-9]+');

Route::filter('not_guest', function(){
	if (Auth::guest()) {
		return Redirect::back()->withInput()->with('message', 'Вы должны зарегестрироваться ли войти под своим аккаунтом для того чтобы оставить комментарний!');
	}
});
