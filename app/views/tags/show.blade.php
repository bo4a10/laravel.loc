@extends('layouts.scaffold')

@section('main')

<h1>Просмотр тэга</h1>

<p>{{ link_to_route('tags.index', 'Вернуться к списку всех тэгов') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Title</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $tag->title }}}</td>
                    <td>{{ link_to_route('tags.edit', 'Редактировать', array($tag->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('tags.destroy', $tag->id))) }}
                            {{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
