@extends('layouts.scaffold')

@section('main')

<h1>Создать предложение</h1>

{{ Form::open(array('route' => 'offers.store')) }}
	<ul>
        <li>
            {{ Form::label('title', 'Название:') }}
            {{ Form::text('title') }}
        </li>

        <li>
            {{ Form::label('description', 'Описание:') }}
            {{ Form::textarea('description') }}
        </li>

        {{--Получить все города для выпадающего списка--}}
        <?php $cities = array(0 => 'Выберите город');
        foreach (City::get(array('id', 'name')) as $city) {
            $cities[$city->id] = $city->name;
        } ?>

        <li>
            {{ Form::label('city_id', 'Город:') }}
            {{ Form::select('city_id', $cities) }}
        </li>

        {{--Получить все компании для выпадающего списка--}}
        <?php
            $companies = [0 => 'Выберите компанию'];
            foreach(Company::get(['id', 'title']) as $company) {
                $companies[$company->id] = $company->title;
            }
        ?>

        <li>
            {{ Form::label('company_id', 'Компания:') }}
            {{ Form::select('company_id', $companies) }}
        </li>

        <li>
            {{ Form::label('off', 'Off:') }}
            {{ Form::input('number', 'off') }}
        </li>

        <li>
            {{ Form::label('file', 'Image:') }}
            {{ Form::file('file')}}
            <img src="" id="thumb" style="max-width:300px; max-height: 200px; display: block;">
            {{ Form::hidden('image') }}
            <div class="error"></div>
        </li>

        <li>
            {{ Form::label('expires', 'Expires:') }}
            {{ Form::text('expires') }}
        </li>

        <li>
            {{ Form::label('tags', 'Тэги:') }}
            {{ Form::input('text', 'tags') }}
        </li>

		<li>
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@section('scripts')
    @include('offers.scripts')
@stop

@stop


