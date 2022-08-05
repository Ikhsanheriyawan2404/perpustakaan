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
                        <li class="breadcrumb-item active">{{ Breadcrumbs::render('books') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container-fluid mb-3 d-flex justify-content-end">
        <div class="row">
            <div class="col-12">
                @can('book-module')
                    <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#importExcel">Impor <i
                            class="fa fa-file-import"></i></a>
                    <a href="{{ route('books.export') }}" class="btn btn-sm btn-success">Ekspor <i class="fa fa-file-export"></i></a>
                    <a href="{{ route('books.printpdf') }}" class="btn btn-sm btn-danger">Print PDF <i class="fa fa-file-pdf"></i></a>
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
                <h3 class="card-title">Data Buku</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="data-table" class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 1%">No.</th>
                            <th class="text-center"><input type="checkbox" name="main_checkbox"><label></label></th>
                            <th>Nama Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Lokasi</th>
                            <th>Terbit</th>
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
                    <input type="hidden" name="book_id" id="book_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm mr-2" name="title" id="title"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="booklocation_id">Lokasi / Kategori Buku <span class="text-danger">*</span></label>
                            <select name="booklocation_id" id="booklocation_id" class="form-control form-control-sm select2"
                                required>
                                <option selected disabled>Pilih lokasi buku</option>
                                @foreach ($booklocation as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="isbn" id="isbn"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="author">Penulis</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="author" id="author"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="publisher">Penerbit</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="publisher" id="publisher"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="publish_year">Tahun Terbit</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="publish_year" id="publish_year"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="text" class="form-control form-control-sm mr-2" name="price" id="price"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Kuantitas <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm mr-2" name="quantity" id="quantity"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea type="text" class="form-control form-control-sm mr-2" name="description" id="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar</label>
                            <input type="file" class="form-control form-control-sm mr-2" name="image" id="image">
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

    <!-- MODAL SHOW BOOK -->
    <div class="modal fade show" id="modalBook" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Buku</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><img src="" id="imageBook" alt="default.jpg" class="img-fluid" width="50%"></li>
                        <li class="list-group-item">Judul : <i id="titleBook"></i></li>
                        <li class="list-group-item">ISBN : <i id="isbnBook"></i></li>
                        <li class="list-group-item">Penulis : <i id="authorBook"></i></li>
                        <li class="list-group-item">Penerbit : <i id="publisherBook"></i></li>
                        <li class="list-group-item">Tahun : <i id="publishYearBook"></i></li>
                        <li class="list-group-item">Jumlah : <i id="qtyBook"></i></li>
                        <li class="list-group-item">Harga : <i id="priceBook"></i></li>
                        <li class="list-group-item">Deskripsi : <i id="descBook"></i></li>
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

    <!-- MODAL IMPORT EXCEL -->
    <div class="modal fade" id="importExcel">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="{{ route('books.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title">Import Excel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div>
                        <div class="modal-body">
                            <div class="card card-primary">
                                <div class="card-header"></div>
                                <div class="card-body">
                                    <ul>
                                        <li>Kolom 1 = Judul Buku <span class="text-danger">*</span></li>
                                        <li>Kolom 2 = Penulis Buku</li>
                                        <li>Kolom 3 = Penerbit</li>
                                        <li>Kolom 4 = Tahun Terbit</li>
                                        <li>Kolom 5 = ISBN</li>
                                        <li>Kolom 6 = Kuantitas</li>
                                        <li>Kolom 7 = Harga</li>
                                        <li>Kolom 8 = Deskripsi</li>
                                        <li>Kolom 9 = Lokasi Buku <span class="text-danger">*</span> (Berdasarkan id data lokasi buku)</li>
                                    </ul>
                                </div>
                            </div>
                            @csrf
                            <div class="form-group">
                                <label for="customFile">Masukan file excel <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="file"
                                        class="custom-file-input @error('file') is-invalid @enderror" id="customFile"
                                        required>
                                    <label class="custom-file-label" for="customFile">Pilih file</label>
                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal import excel -->
@endsection

@section('custom-styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/toastr/toastr.min.css">
@endsection
@section('custom-scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('asset') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('asset') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('asset') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('asset') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('asset') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('asset') }}/plugins/toastr/toastr.min.js"></script>
    <script src="{{ asset('asset') }}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            bsCustomFileInput.init();

            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,

                ajax: "{{ route('books.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        className: 'dt-body-center'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'author',
                        name: 'author'
                    },
                    {
                        data: 'publisher',
                        name: 'publisher'
                    },
                    {
                        data: 'booklocation',
                        name: 'booklocation.name'
                    },
                    {
                        data: 'publish_year',
                        name: 'publish_year'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'dt-body-center'
                    },
                ],
            }).on('draw', function() {
                $('input[name="checkbox"]').each(function() {
                    this.checked = false;
                });
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });

            $('#createNewItem').click(function() {
                setTimeout(function() {
                    $('#name').focus();
                }, 500);
                $('#saveBtn').removeAttr('disabled');
                $('#saveBtn').html("Simpan");
                $('#item_id').val('');
                $('#itemForm').trigger("reset");
                $('#modal-title').html("Tambah Buku");
                $('#modal-md').modal('show');
            });

            $('body').on('click', '#showBook', function() {
                var book_id = $(this).data('id');
                $.get("{{ route('books.index') }}" + '/' + book_id, function(data) {
                    $('#modalBook').modal('show');
                    $('#book_id').val(data.id);
                    $('#imageBook').attr('src', '/storage/' + data.image);
                    $('#titleBook').html(data.title);
                    $('#isbnBook').html(data.isbn);
                    $('#authorBook').html(data.author);
                    $('#publisherBook').html(data.publisher);
                    $('#publishYearBook').html(data.publish_year);
                    $('#qtyBook').html(data.quantity);
                    $('#priceBook').html(data.price);
                    $('#descBook').html(data.description);
                })
            });

            $('body').on('click', '#editBook', function() {
                var book_id = $(this).data('id');
                $.get("{{ route('books.index') }}" + '/' + book_id + '/edit', function(data) {
                    $('#modal-md').modal('show');
                    setTimeout(function() {
                        $('#title').focus();
                    }, 500);
                    $('#modal-title').html("Edit Barang");
                    $('#saveBtn').removeAttr('disabled');
                    $('#saveBtn').html("Simpan");
                    $('#book_id').val(data.id);
                    $('#title').val(data.title);
                    $('#isbn').val(data.isbn);
                    $('#author').val(data.author);
                    $('#publisher').val(data.publisher);
                    $('#publish_year').val(data.publish_year);
                    $('#price').val(data.price);
                    $('#quantity').val(data.quantity);
                    $('#description').val(data.description);
                    $('#booklocation_id').val(data.booklocation_id);
                })
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var formData = new FormData($('#itemForm')[0]);
                $.ajax({
                    data: formData,
                    url: "{{ route('books.store') }}",
                    contentType: false,
                    processData: false,
                    type: "POST",
                    success: function(data) {
                        $('#saveBtn').attr('disabled', 'disabled');
                        $('#saveBtn').html('Simpan ...');
                        $('#itemForm').trigger("reset");
                        $('#modal-md').modal('hide');
                        table.draw();
                    },
                    error: function(data) {
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
                var url = '{{ route('books.deleteSelected') }}';
                if (checkedItem.length > 0) {
                    swal.fire({
                        title: 'Apakah yakin?',
                        html: 'Ingin menghapus <b>(' + checkedItem.length + ')</b> buku',
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
