<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
	<link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<style>
		table form { margin-bottom: 0; }
		form ul { margin-left: 0; list-style: none; }
		.error { color: red; font-style: italic; }
		body { padding-top: 20px; }
		input, textarea, .uneditable-input {width: 50%; min-width: 200px;}
	</style>
	@yield('styles')
</head>

<body>

<div class="container">

	@if(Auth::check())
		<ul class="nav nav-pills">
			<li>{{ link_to_route('offers.index', 'Скидки') }}</li>
			<li>{{ link_to_route('tags.index', 'Тэги') }}</li>
			<li>{{ link_to_route('roles.index', 'Роли') }}</li>
			<li>{{ link_to_route('cities.index', 'Города') }}</li>
			<li>{{ link_to_route('comments.index', 'Комментарии') }}</li>
			<li>{{ link_to_route('companies.index', 'Компании') }}</li>
			<li class="pull-right">{{ link_to_route('login.logout', 'Выход') }}</li>
		</ul>
	@endif

	@if (Session::has('message'))
		<div class="flash alert">
			<p>{{ Session::get('message') }}</p>
		</div>
	@endif

	@yield('main')
</div>

<script type="text/javascript" src="//code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
@yield('scripts')

</body>

</html>