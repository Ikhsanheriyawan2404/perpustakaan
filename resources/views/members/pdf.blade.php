<!DOCTYPE html>
<html>
<head>
	<title>Data Siswa</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Jenis Kelamin</th>
				<th>Email</th>
				<th>No HP</th>
				<th>Alamat</th>
			</tr>
		</thead>
		<tbody>
			@foreach($members as $member)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $member->name }}</td>
				<td>{{ $member->gender }}</td>
				<td>{{ $member->email }}</td>
				<td>{{ $member->phone_number }}</td>
				<td>{{ $member->address }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>
