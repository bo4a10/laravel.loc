@extends('layouts.scaffold')

@section('main')

<h1>Просмотр скидки</h1>

<p>{{ link_to_route('offers.index', 'Вернуться к списку скидок') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Название</th>
				<th>Описание</th>
				<th>Город</th>
				<th>Компания</th>
				<th>Off</th>
				<th>Изображение</th>
				<th>Действует до</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $offer->title }}}</td>
					<td>{{{ $offer->description }}}</td>
					<td>{{{ $offer->city_id }}}</td>
					<td>{{{ $offer->company_id }}}</td>
					<td>{{{ $offer->off }}}</td>
					<td>{{{ $offer->image }}}</td>
					<td>{{{ $offer->expires }}}</td>
                    <td>{{ link_to_route('offers.edit', 'Edit', array($offer->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('offers.destroy', $offer->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
