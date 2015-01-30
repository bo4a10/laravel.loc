@extends('layouts.scaffold')

@section('main')

<h1>Редактировать тэг</h1>
{{ Form::model($tag, array('method' => 'PATCH', 'route' => array('tags.update', $tag->id))) }}
	<ul>
        <li>
            {{ Form::label('title', 'Название:') }}
            {{ Form::text('title') }}
        </li>

		<li>
			{{ Form::submit('Обновить', array('class' => 'btn btn-info')) }}
			{{ link_to_route('tags.show', 'Отмена', $tag->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
