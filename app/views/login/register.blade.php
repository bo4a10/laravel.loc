@extends('layouts.scaffold')

@section('main')

    <h1>Register</h1>

    <p>{{ link_to_route('login.index', 'Авторизация') }}</p>

    {{ Form::open(array('route' => 'login.register')) }}
    <ul>
        <li>
            {{ Form::label('email', 'Email:') }}
            {{ Form::text('email') }}
        </li>

        <li>
            {{ Form::label('username', 'Логин:') }}
            {{ Form::text('username') }}
        </li>

        <li>
            {{ Form::label('password', 'Пароль:') }}
            {{ Form::password('password') }}
        </li>

        <li>
            {{ Form::submit('Зарегестрироваться', array('class' => 'btn btn-info')) }}
        </li>
    </ul>
    {{ Form::close() }}

    @include('partials.errors', ['errors' => $errors])

@stop