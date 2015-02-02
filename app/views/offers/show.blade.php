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
		<th>Тэги</th>
		<th>Действие до</th>
	</tr>
	</thead>

	<tbody>
	<tr>
		<td>{{{ $offer->title }}}</td>
		<td>{{ $offer->webDescription(array('shorten' => true, 'length' => 60)) }}</td>
		<td>{{{ $offer->city->name }}}</td>
		<td>{{{ $offer->company->title }}}</td>
		<td>{{{ $offer->off }}}</td>
		<td><img src="{{{ $offer->image }}}" style="max-width: 200px; max-height:150px;"/></td>
		<td>
			@foreach($offer->tags as $tag)
				<span class="badge">{{{ $tag->title }}}</span>
			@endforeach
		</td>
		<td>{{{ $offer->expires }}}</td>
	</tbody>
</table>

@stop
