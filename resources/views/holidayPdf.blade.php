<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<title>Title</title>

	<style>
		h2 {
			width: 100%;
			text-align: center;
		}

		table {
			border-collapse: collapse;
			font-family: Tahoma, Geneva, sans-serif;
			width: 100%;
		}

		table td {
			padding: 15px;
		}

		table thead th {
			background-color: #54585d;
			color: #ffffff;
			font-weight: bold;
			font-size: 13px;
			border: 1px solid #54585d;
		}

		table tbody td {
			color: #636363;
			border: 1px solid #dddfe1;
		}

		table tbody tr {
			background-color: #f9fafb;
		}

		table tbody tr:nth-child(odd) {
			background-color: #ffffff;
		}
	</style>
</head>

<body>
	<h2>
		Holiday Plans
	</h2>

	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Date</th>
				<th>Location</th>
				<th>Participants</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($content as $holiday)
			<tr>
				<td>{{ $holiday['title'] }}</td>
				<td>{{ $holiday['description'] }}</td>
				<td>{{ $holiday['date'] }}</td>
				<td>{{ $holiday['location'] }}</td>
				<td>
					@if(count($holiday['participants']))
					{{ $holiday['participants']->pluck('name')->implode(', ') }}
					@else
					-
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>

</html>