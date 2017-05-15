<!DOCTYPE html>
<html>
	<head>
		<meta name = "viewport" content = "user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="1800">
		<title>Dump</title>
		<link rel="shortcut icon" href="favicon.png">
	</head>
	<body>
		<div style="text-align: center;">
			<h3>List of last dumps</h3>
			<table style="text-align: left; width: 500px; margin: auto; max-width: 90%;">
				<thead>
					<tr>
						<th>#</th>
						<th>Server</th>
						<th>Size</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($hostnames as $i => $hostname)
					<tr>
						<td>{{ $i+1 }}</td>
						<td><b>{{ $hostname->name }}</b></td>
						<td align="right"><i>{{ number_format($hostname->dump->size/1000000., 3, '.', ' ') }}</i> MB</td>
						<td>
							<small>{{ $hostname->dump->created_at->format('Y-m-') }}</small>
							{{ $hostname->dump->created_at->format('d') }}
							<small>{{ $hostname->dump->created_at->format(' H:i:s') }}</small>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<p>
				Free space {{ $free }}
			</p>

			{{-- <ul style="text-align: left; width: 500px; margin: auto; max-width: 90%;">
				@foreach($hostnames as $hostname)
				<li>
					<b>{{ $hostname->name }}</b>
					<i>{{ number_format($hostname->dump->size/1000000., 3, '.', ' ') }}</i> MB
					<small>{{ $hostname->dump->created_at->format('Y-m-d H:i:s') }}</small>
				</li>
				@endforeach
			</ul> --}}
		</div>
	</body>
</html>
