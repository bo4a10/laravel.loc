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

Route::get('logout', array('as' => 'login.logout', 'uses' => 'LoginController@logout'));

Route::group(array('before' => 'un_auth'), function()
{
	Route::get('login', array('as' => 'login.index', 'uses' => 'LoginController@index'));
	Route::get('register', array('as' => 'login.register', 'uses' => 'LoginController@register'));
	Route::post('login', array('uses' => 'LoginController@login'));
	Route::post('register', array('uses' => 'LoginController@store'));

	Route::get('password/remind', array('as' => 'password.remind', 'uses' => 'LoginController@showReminderForm'));
	Route::post('password/remind', array('uses' => 'LoginController@sendReminder'));
	Route::get('password/reset/{token}', array('as' => 'password.reset', 'uses' => 'LoginController@showResetForm'));
	Route::post('password/reset/{token}', array('uses' => 'LoginController@resetPassword'));
});

Route::get('offer_{id}', array('as' => 'home.offer', 'uses' => 'HomeController@showOffer'))->where('id', '[0-9]+');
Route::post('offer_{id}', array('before' => 'not_guest|regular_user', 'uses' => 'HomeController@commentOnOffer'))->where('id', '[0-9]+');
//Route::get('offer_{id}', array('as'=>'offer.more', 'uses' => 'HomeController@commentOnOffer'))->where('id', '[0-9]+');

//-------------------------------------------//

Route::group(array('before' => 'admin.auth'), function()
{
	Route::get('dashboard', function()
	{
		return View::make('dasboard');
	});

	Route::group(array('before' => 'manager_role_only'), function()
	{
		Route::resource('cities', 'CitiesController');

		Route::resource('companies', 'CompaniesController');

		Route::resource('tags', 'TagsController');

		Route::resource('offers', 'OffersController');

		Route::post('upload', array('uses' => 'HomeController@uploadOfferImage'));
	});

	Route::resource('comments', 'CommentsController');

	Route::group(array('before' => 'manager_role_only'), function()
	{
		Route::resource('roles', 'RolesController');

		Route::resource('users', 'UsersController');
	});
});

Route::when('comments*', 'moderator_role_only');

Route::filter('admin_role_only', function()
{
	if (Auth::user()->isAdmin()) {
		return Redirect::intended('/')->withMessage('Недостаточно прав!');
	}
});

Route::filter('manager_role_only', function()
{
	if (!Auth::user()->isManager()) {
		return Redirect::intended('/')->withMessage('Недостаточно прав!');
	}
});

Route::filter('moderator_role_only', function()
{
	if (!Auth::user()->isModerator()) {
		return Redirect::intended('/')->withMessage('Недостаточно прав!');
	}
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

Route::filter('not_guest', function(){
	if (Auth::guest()) {
		return Redirect::intended('/')->withInput()->with('message', 'Вы должны зарегестрироваться ли войти под своим аккаунтом для того чтобы оставить комментарний!');
	}
});

Route::filter('regular_user', function(){
	if (!Auth::guest()) {
		if (!Auth::user()->isRegular()) {
			return Redirect::back()->with('message', 'Вы не можете выполнить данное действие исходя из Вашей роли');
		}
	}
});
