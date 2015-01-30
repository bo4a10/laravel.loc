@extends('layouts.scaffold')

@section('main')

<h1>Создать новый тэг</h1>

{{ Form::open(array('route' => 'tags.store')) }}
	<ul>
        <li>
            {{ Form::label('title', 'Название:') }}
            {{ Form::text('title') }}
        </li>

		<li>
			{{ Form::submit('Добавить', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


