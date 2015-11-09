@extends('layouts.scaffold')

@section('main')

    <h1>Авторизация</h1>

    <p>{{ link_to_route('login.register', 'Регистрация на сайте') }}</p>

    {{ Form::open(array('route' => 'login.index')) }}
    <ul>
        <li>
            {{ Form::label('email', 'Email или Логин:') }}
            {{ Form::text('email') }}
        </li>

        <li>
            {{ Form::label('password', 'Пароль:') }}
            {{ Form::password('password') }}
        </li>

        <li>
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        </li>
    </ul>
    {{ Form::close() }}

    <p>{{ link_to_route('password.remind', 'Забыли пароль?!') }}</p>

    @include('partials.errors', ['errors' => $errors])

@stop