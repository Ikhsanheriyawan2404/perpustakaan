@extends('layouts.app', compact('title'))

@section('content')
@include('sweetalert::alert')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">{{ $title ?? '' }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{ Breadcrumbs::render('bookloans') }}</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid mb-3 d-flex justify-content-end">
    <div class="row">
        <div class="col-12">
            @can('bookloan-module')
            <button class="btn btn-sm btn-primary" id="createNewItem">Tambah <i class="fa fa-plus"></i></button>
            <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Hapus Semua</button>
            @endcan
        </div>
    </div>
</div>

<div class="container">
    @include('components.alerts')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Peminjaman Buku</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="data-table" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 1%">No.</th>
                        <th class="text-center"><input type="checkbox" name="main_checkbox"><label></label></th>
                        <th>Kode Pinjaman</th>
                        <th>Nama Peminjam</th>
                        <th>Buku</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th class="text-center" style="width: 5%"><i class="fas fa-cogs"></i> </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<!-- MODAL -->
<div class="modal fade" id="modal-md">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="itemForm" name="itemForm">
                @csrf
                <input type="hidden" name="bookloan_id" id="bookloan_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="member_id">Nama Peminjam</label>
                        <select name="member_id" id="member_id" class="form-control form-control-sm select2" required>
                            <option selected disabled>Pilih anggota</option>
                            @foreach ($members as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="book_id">Buku</label>
                        <select name="book_id" id="book_id" class="form-control form-control-sm select2" required>
                            <option selected disabled>Pilih buku</option>
                            @foreach ($books as $data)
                                <option value="{{ $data->id }}">{{ $data->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="borrow_date">Tanggal Pinjam</label>
                        <input type="date" class="form-control form-control-sm mr-2" name="borrow_date" id="borrow_date" required>
                    </div>
                    <div class="form-group">
                        <label for="date_of_return">Tanggal Pengembalian</label>
                        <input type="date" class="form-control form-control-sm mr-2" name="date_of_return" id="date_of_return" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary" id="saveBtn" value="create">Save</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- MODAL SHOW PINJAMAN -->
<div class="modal fade show" id="modalBookLoan" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pinjaman Buku</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><img src="" id="imageLoan" alt="default.jpg" class="img-fluid" width="50%"></li>
                    <li class="list-group-item">Kode Pinjaman : <i id="creditCodeLoan"></i></li>
                    <li class="list-group-item">Nama Peminjam : <i id="nameLoan"></i></li>
                    <li class="list-group-item">Buku : <i id="bookLoan"></i></li>
                    <li class="list-group-item">Tanggal Pinjam : <i id="borrowDateLoan"></i></li>
                    <li class="list-group-item">Tanggal Pengembalian : <i id="dateOfReturnLoan"></i></li>
                    <li class="list-group-item">Status : <i id="statusLoan"></i></li>
                </ul>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('custom-styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('asset')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('asset')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('asset')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/select2/css/select2.min.css">
@endsection
@section('custom-scripts')

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('asset')}}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('asset')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('asset')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('asset')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('asset') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('asset') }}/plugins/toastr/toastr.min.js"></script>
    <script src="{{ asset('asset') }}/plugins/select2/js/select2.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.select2').select2({ width: '100%'});
        $(function () {

            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,

                ajax: "{{ route('bookloans.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'dt-body-center'},
                    {data: 'checkbox',name: 'checkbox',orderable: false,searchable: false,className: 'dt-body-center'},
                    {data: 'credit_code', name: 'credit_code'},
                    {data: 'member_id', name: 'member.name'},
                    {data: 'book_id', name: 'book.title'},
                    {data: 'status', name: 'status'},
                    {data: 'fine', name: 'fine', className: 'dt-body-right'},
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'dt-body-center'},
                ],
            }).on('draw', function() {
                $('input[name="checkbox"]').each(function() {
                    this.checked = false;
                });
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });

            $('#createNewItem').click(function () {
                setTimeout(function () {
                    $('#name').focus();
                }, 500);
                $('#saveBtn').removeAttr('disabled');
                $('#saveBtn').html("Simpan");
                $('#bookloan_id').val('');
                $('#itemForm').trigger("reset");
                $('#modal-title').html("Tambah Buku");
                $('#modal-md').modal('show');
            });

            $('body').on('click', '#showBookLoan', function() {
                var bookloan_id = $(this).data('id');
                $.get("{{ route('bookloans.index') }}" + '/' + bookloan_id, function(data) {
                    $('#modalBookLoan').modal('show');
                    $('#bookloan_id').val(data.id);
                    $('#imageLoan').attr('src', '/storage/' + data.image);
                    $('#creditCodeLoan').html(data.credit_code);
                    $('#nameLoan').html(data.member.name);
                    $('#bookLoan').html(data.book.title);
                    $('#borrowDateLoan').html(data.borrow_date);
                    $('#dateOfReturnLoan').html(data.date_of_return);
                    $('#statusLoan').html((data.status == 2) ? 'Dikembalikan' : 'Masih Di Peminjam');
                    // var jumlahtelat = new Date() - date_of_return;
                    // $('#fineLoan').html((new Date() > data.date_of_return) : 'telat' : 'nggktelat');
                })
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                var formData = new FormData($('#itemForm')[0]);
                $.ajax({
                    data: formData,
                    url: "{{ route('bookloans.store') }}",
                    contentType : false,
                    processData : false,
                    type: "POST",
                    success: function (data) {
                        $('#saveBtn').attr('disabled', 'disabled');
                        $('#saveBtn').html('Simpan ...');
                        $('#itemForm').trigger("reset");
                        $('#modal-md').modal('hide');
                        table.draw();
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data masih kosong!',
                        });
                    }
                });
            });

            $(document).on('click', 'input[name="main_checkbox"]', function() {
                if (this.checked) {
                    $('input[name="checkbox"]').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('input[name="checkbox"]').each(function() {
                        this.checked = false;
                    });
                }
                toggledeleteAllBtn();
            });

            $(document).on('change', 'input[name="checkbox"]', function() {
                if ($('input[name="checkbox"]').length == $('input[name="checkbox"]:checked').length) {
                    $('input[name="main_checkbox"]').prop('checked', true);
                } else {
                    $('input[name="main_checkbox"]').prop('checked', false);
                }
                toggledeleteAllBtn();
            });

            function toggledeleteAllBtn() {
                if ($('input[name="checkbox"]:checked').length > 0) {
                    $('button#deleteAllBtn').text('Hapus (' + $('input[name="checkbox"]:checked').length + ')')
                        .removeClass('d-none');
                } else {
                    $('button#deleteAllBtn').addClass('d-none');
                }
            }

            $(document).on('click', 'button#deleteAllBtn', function() {
                var checkedItem = [];
                $('input[name="checkbox"]:checked').each(function() {
                    checkedItem.push($(this).data('id'));
                });
                var url = '{{ route('bookloans.deleteSelected') }}';
                if (checkedItem.length > 0) {
                    swal.fire({
                        title: 'Apakah yakin?',
                        html: 'Ingin menghapus <b>(' + checkedItem.length + ')</b> pinjaman?',
                        showCancelButton: true,
                        showCloseButton: true,
                        confirmButtonText: 'Ya Hapus',
                        cancelButtonText: 'Tidak',
                        confirmButtonColor: '#556ee6',
                        cancelButtonColor: '#d33',
                        width: 300,
                        allowOutsideClick: false
                    }).then(function(result) {
                        if (result.value) {
                            $.post(url, {
                                id: checkedItem
                            }, function(data) {
                                if (data.code == 1) {
                                    // $('#data-table').DataTable().ajax.reload(null, true);
                                    table.draw();
                                    toastr.success(data.msg);
                                }
                            }, 'json');
                        }
                    })
                }
            });

        });
    </script>

@endsection

