<!DOCTYPE html>
<html>
<head>
	<title>Data Pinjaman {{ $bookloan->member->name }}</title>
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
				<th>Kode Pinjaman</th>
				<th>Nama Peminjam</th>
				<th>Buku</th>
				<th>Tgl Pinjam</th>
				<th>Tgl Pengembalian</th>
				<th>Paraf</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $bookloan->credit_code }}</td>
				<td>{{ $bookloan->member->name }}</td>
				<td>{{ $bookloan->book->title }}</td>
				<td>{{ $bookloan->borrow_date }}</td>
				<td>{{ $bookloan->date_of_return }}</td>
				<td>{{ $bookloan->admin }}</td>
			</tr>
		</tbody>
	</table>

</body>
</html>
