@extends('layouts.scaffold')

@section('main')

    <h1>Редактировать скидку</h1>
    {{ Form::model($offer, array('method' => 'PATCH', 'route' => array('offers.update', $offer->id))) }}
    <ul>
        <li>
            {{ Form::label('title', 'Название:') }}
            {{ Form::text('title') }}
        </li>

        <li>
            {{ Form::label('description', 'Описание:') }}
            {{ Form::textarea('description') }}
        </li>

        <?php $cities = array(0 => 'Choose city');
        foreach (City::get(array('id', 'name')) as $city) {
            $cities[$city->id] = $city->name;
        } ?>

        <li>
            {{ Form::label('city_id', 'Город:') }}
            {{ Form::select('city_id', $cities) }}
        </li>

        <?php $companies = array(0 => 'Выберите компанию');
        foreach (Company::get(array('id', 'title')) as $company) {
            $companies[$company->id] = $company->title;
        } ?>

        <li>
            {{ Form::label('company_id', 'Компания:') }}
            {{ Form::select('company_id', $companies) }}
        </li>

        <li>
            {{ Form::label('off', 'Off:') }}
            {{ Form::input('number', 'off') }}
        </li>

        <li>
            {{ Form::label('file', 'Изображение:') }}
            {{ Form::file('file')}}
            <img src="" id="thumb" style="max-width:300px; max-height: 200px; display:block; ">
            {{ Form::hidden('image') }}
            <div class="error"></div>
        </li>

        <li>
            {{ Form::label('expires', 'Действует до:') }}
            {{ Form::text('expires') }}
        </li>

        <li>
            {{ Form::label('tags', 'Тэги:') }}
            {{ Form::text('tags', Input::old('tags', implode(', ', array_fetch($offer->tags()->get(array('title'))->toArray(), 'title')))) }}
        </li>

        <li>
            {{ Form::submit('Обновить', array('class' => 'btn btn-info')) }}
            {{ link_to_route('offers.show', 'Отмена', $offer->id, array('class' => 'btn')) }}
        </li>
    </ul>
    {{ Form::close() }}

    @if ($errors->any())
        <ul>
            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
        </ul>
    @endif

@stop

@section('scripts')
    @include('offers.scripts')
@stop