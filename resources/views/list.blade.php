<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Dump</title>
	</head>
	<body>
		<h3>List of Dumps</h3>
		<ul>
			@foreach($hostnames as $hostname)
				<li>
					<b>{{ $hostname->name }}</b>
					<i>{{ number_format($hostname->dump->size/1000000., 3, '.', ' ') }}</i> MB
					<small>{{ $hostname->dump->created_at->format('Y-m-d H:i:s') }}</small>
				</li>
			@endforeach
		</ul>
	</body>
</html>
