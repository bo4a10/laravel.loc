<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	/**
	 * Загрузка изображения
	 * @return \Illuminate\Http\JsonResponse
	 */

	public function uploadOfferImage()
	{
		$rules = array('file' => 'mimes:jpeg,png');

		$messages = [
			'mimes' => 'Файл должен быть с разрешением png, jpeg'
		];

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
			return Response::json(array('message' => $validator->messages()->first('file')));
		}

		$dir = '/images'.date('/Y/m/d/');

		do {
			$filename = str_random(30).'.jpg';
		} while (File::exists(public_path().$dir.$filename));

		Input::file('file')->move(public_path().$dir, $filename);

		return Response::json(array('filelink' => $dir.$filename));
	}

}
