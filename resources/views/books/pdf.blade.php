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
				<th>Judul</th>
				<th>ISBN</th>
				<th>Penulis</th>
				<th>Penerbit</th>
				<th>Tahun Terbit</th>
				<th>Harga</th>
				<th>Kuantitas</th>
				<th>Deskripsi</th>
			</tr>
		</thead>
		<tbody>
			@foreach($books as $book)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $book->title }}</td>
				<td>{{ $book->isbn }}</td>
				<td>{{ $book->author }}</td>
				<td>{{ $book->publisher }}</td>
				<td>{{ $book->publish_year }}</td>
				<td>{{ $book->price }}</td>
				<td>{{ $book->description }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>
