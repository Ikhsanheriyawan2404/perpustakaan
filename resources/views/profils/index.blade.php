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
                    <li class="breadcrumb-item active">{{ Breadcrumbs::render('profils') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container">
    @include('components.alerts')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Profil Perpustakaan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="data-table" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama Perpustakaan</th>
                        <th>Image</th>
                        <th class="text-center" style="width: 5%"><i class="fas fa-cogs"></i> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $profil->name }}</td>
                        <td><img src="{{ $profil->takeImage }}" class="img-fluid"></td>
                        <td>
                            <div class="btn-group">
                                <a class="badge badge-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0)" data-id="{{ $profil->id }}" class="btn btn-primary btn-sm" id="editProfil">Edit</a>
                                </div>
                            </div>
                        </td>
                    </tr>
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
                <input type="hidden" name="profil_id" id="profil_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Perpustakaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm mr-2" name="name" id="name"
                            required>
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

            $('body').on('click', '#editProfil', function() {
                var profil_id = $(this).data('id');
                $.get("{{ route('profils.index') }}" + '/' + profil_id + '/edit', function(data) {
                    $('#modal-md').modal('show');
                    setTimeout(function() {
                        $('#title').focus();
                    }, 500);
                    $('#modal-title').html("Edit Profil");
                    $('#saveBtn').removeAttr('disabled');
                    $('#saveBtn').html("Simpan");
                    $('#profil_id').val(data.id);
                    $('#name').val(data.name);
                })
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var formData = new FormData($('#itemForm')[0]);
                $.ajax({
                    data: formData,
                    url: "{{ route('profils.store') }}",
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
        });
    </script>
@endsection
