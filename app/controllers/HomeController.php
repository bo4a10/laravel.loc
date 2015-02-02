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

	public function index() {
		$offers = Offer::orderBy('created_at', 'desc')->get();
		$title = 'Главная страница сайта';

		return View::make('home.index', compact('offers'))->with('title', $title);
	}

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

	/**
	 * Display a listing of offers that belongs to tag.
	 *
	 * @param  string  $name
	 * @return Response
	 */
	public function byTag($name)
	{
		$tag = Tag::whereTitle($name)->firstOrFail();

		$offers = $tag->offers;
		$title = "Скидки по тэгам: " . $tag->title;

		return View::make('home.index', compact('offers', 'title'));
	}

	/**
	 * Display a listing of offers that belongs to city.
	 *
	 * @param  string  $name
	 * @return Response
	 */
	public function byCity($name)
	{

		$city = City::whereName($name)->firstOrFail();

		$offers = $city->offers;
		$title = "Скидка в: " . $city->name;

		return View::make('home.index', compact('offers', 'title'));
	}

	/**
	 * Display a listing of offers that belongs to company.
	 *
	 * @param  string  $name
	 * @return Response
	 */
	public function byCompany($name)
	{
		$company = Company::whereTitle($name)->firstOrFail();

		$offers = $company->offers;
		$title = "Скидка от компании: " . $company->title;

		return View::make('home.index', compact('offers', 'title'));
	}

	/**
	 * Display an offer.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showOffer($id)
	{
		$offer = Offer::findOrFail($id);

		return View::make('offers._show', compact('offer'));
	}

	/**
	 * Storing comment on offer.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function commentOnOffer($id)
	{
		$offer = Offer::findOrFail($id);

		// не разрешать дважды комментировать скидку одному пользователю
//		if ($offer->usersComments->contains(Auth::user()->id)) {
//			return Redirect::back()->withInput()->with('message', 'You have already commented on this Offer');
//		}

		$rules = array('body' => 'required|min:10|max:500', 'mark' => 'required|numeric|between:1,5');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->passes()) {
			$offer->usersComments()->attach(Auth::user()->id, array('body' => Input::get('body'), 'mark' => Input::get('mark')));
			return Redirect::back();
		}

		return Redirect::back()->withInput()->withErrors($validator);
	}

}
