<?php

class LoginController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('login.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function register()
	{
        return View::make('login.register');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'email' 	=> 'required|email|unique:users,email',
			'password' 	=> 'required|alpha_num|between:4,50',
			'username'	=> 'required|alpha_num|between:2,20|unique:users,username'
		);

		$messages = [
			'required' => 'Поле :attribute должно быть заполнено',
			'email' => 'Неверный формат поля :attribute',
			'alpha_num' => 'Поле :attribute должно состоять только из цифр и букв алфавита',
			'between' => 'Значение поля :attribute должно быть от :min до :max символов',
			'unique' => 'Значение :attribute уже существует в базе данных',
		];

		// Названия для полей валидации
		$attributesName = [
			'email' => 'Электронная почта',
			'password' => 'Пароль',
			'username' => 'Логин'
		];

		$validator = Validator::make(Input::all(), $rules, $messages);
		$validator->setAttributeNames($attributesName);

		if($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$user = new User;
		$user->email = Input::get('email');
		$user->username = Input::get('username');
		$user->password = Hash::make(Input::get('password'));
		$user->save();

		Mail::send('emails.welcome', array('username' => $user->username), function($message) use ($user)
		{
			$message->to($user->email, $user->username)->subject('Welcome to Habra Offers!');
		});

		Auth::loginUsingId($user->id);

		return Redirect::home()->with('message', 'Thank you for registration, now you can comment on offers!');
	}

	/**
	 * Авторизация пользователя
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function login()
	{
		if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), true)
			|| Auth::attempt(array('username' => Input::get('email'), 'password' => Input::get('password')), true))	{

			if (!Auth::user()->isRegular()) {
				return Redirect::to('dashboard');
			}

			return Redirect::intended('/');
		}

		return Redirect::back()->withInput(Input::except('password'))->with('message', 'Wrong creadentials!');
	}

	/**
	 * Ралогиниться
	 *
	 * @return Response
	 */
	public function logout()
	{
		Auth::logout();

		return Redirect::home()->with('message', 'До скорых встреч!');
	}

	/**
	 * Show reminder form.
	 *
	 * @return Response
	 */
	public function showReminderForm()
	{
		return View::make('auth.remind');
	}


	/**
	 * Send reminder email.
	 *
	 * @return Response
	 */
	public function sendReminder()
	{
		$credentials = array('email' => Input::get('email'));

		return Password::remind($credentials, function($message, $user)
		{
			$message->subject('Password Reminder on Habra Offers');
		});
	}


	/**
	 * Show reset password form.
	 *
	 * @return Response
	 */
	public function showResetForm($token)
	{
		return View::make('auth.reset')->with('token', $token);
	}


	/**
	 * Reset password.
	 *
	 * @return Response
	 */
	public function resetPassword($token)
	{
		$credentials = array('email' => Input::get('email'));

		return Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();

			Auth::loginUsingId($user->id);

			return Redirect::home()->with('message', 'Your password has been successfully reseted.');
		});
	}

}
