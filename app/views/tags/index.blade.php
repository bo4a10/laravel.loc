@extends('layouts.scaffold')

@section('main')

<h1>Список тэгов</h1>

<p>{{ link_to_route('tags.create', 'Добавить новый тэг') }}</p>

@if ($tags->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Title</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($tags as $tag)
				<tr>
					<td>{{{ $tag->title }}}</td>
                    <td>{{ link_to_route('tags.edit', 'Редактировать', array($tag->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('tags.destroy', $tag->id))) }}
                            {{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<h3>На данный момент нет тэгов</h3>
@endif

@stop
