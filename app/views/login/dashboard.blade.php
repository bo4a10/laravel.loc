@extends('layouts.scaffold')

@section('main')

    <h1>Панель управления сайтом</h1>

    <p>Здравствуйте, <b>{{{ Auth::user()->username }}}</b></p>

@stop
