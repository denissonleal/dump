<!DOCTYPE html>
<html>
	<head>
		<meta name = "viewport" content = "user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
		<meta charset="utf-8">
		<title>Dump</title>
	</head>
	<body>
		<h3>List of last dumps</h3>
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
