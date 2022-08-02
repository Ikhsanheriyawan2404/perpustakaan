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
            {{-- <li class="breadcrumb-item"><a href="#">{{ Breadcrumbs::render('home') }}</a></li> --}}
            <li class="breadcrumb-item active">{{ Breadcrumbs::render('items') }}</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid mb-3 d-flex justify-content-end">
    <div class="row">
        <div class="col-12">
            {{-- @can('student-create') --}}
                {{-- <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Tambah <i class="fa fa-plus"></i></a> --}}
                <button class="btn btn-sm btn-primary" id="createNewItem">Tambah <i class="fa fa-plus"></i></button>
                <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Hapus Semua</button>
            {{-- @endcan --}}
        </div>
    </div>
</div>

<div class="container">
    @include('components.alerts')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Kategori Barang</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="data-table" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 1%">No.</th>
                        <th style="width: 1%"><input type="checkbox" name="main_checkbox"><label></label></th>
                        <th>Nama Barang</th>
                        <th class="text-center" style="width: 15%"><i class="fas fa-cogs"></i> </th>
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
            <form method="post" id="itemForm" name="itemForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category_id" id="category_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" class="form-control mr-2" name="name" id="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan</button>
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
    <link rel="stylesheet" href="{{ asset('asset')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('asset')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('asset')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/toastr/toastr.min.css">
@endsection
@section('custom-scripts')

<!-- DataTables  & Plugins -->
<script src="{{ asset('asset')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('asset')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('asset')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('asset')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('asset') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="{{ asset('asset') }}/plugins/toastr/toastr.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {

        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,

            ajax: "{{ route('categories.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        }).on('draw', function(){
            $('input[name="checkbox"]').each(function(){this.checked = false;});
            $('input[name="main_checkbox"]').prop('checked', false);
            $('button#deleteAllBtn').addClass('d-none');
        });

        $('#createNewItem').click(function () {
            setTimeout(function () {
                $('#name').focus();
            }, 500);
            $('#saveBtn').removeAttr('disabled');
            $('#saveBtn').html("Simpan");
            $('#category_id').val('');
            $('#itemForm').trigger("reset");
            $('#modal-title').html("Tambah Kategori");
            $('#modal-md').modal('show');
        });

        $('body').on('click', '#editItem', function () {
            var category_id = $(this).data('id');
            $.get("{{ route('categories.index') }}" +'/' + category_id +'/edit', function (data) {
                $('#modal-md').modal('show');
                setTimeout(function () {
                    $('#name').focus();
                }, 500);
                $('#modal-title').html("Edit kategori");
                $('#saveBtn').removeAttr('disabled');
                $('#saveBtn').html("Simpan");
                $('#category_id').val(data.id);
                $('#name').val(data.name);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            var formData = new FormData($('#itemForm')[0]);
            $.ajax({
                // enctype: 'multipart/form-data',
                // data: $('#itemForm').serialize(),
                data: formData,
                url: "{{ route('categories.store') }}",
                contentType : false,
                processData : false,
                type: "POST",
                // dataType: 'json',
                success: function (data) {
                    $('#saveBtn').attr('disabled', 'disabled');
                    $('#saveBtn').html('Simpan ...');
                    $('#itemForm').trigger("reset");
                    $('#modal-md').modal('hide');
                    table.draw();
                },
                error: function (data) {
                    alert("Data masih kosong");
                    console.log('Error:', data);
                }
            });
        });

        $(document).on('click','input[name="main_checkbox"]', function(){
            if (this.checked) {
                $('input[name="checkbox"]').each(function(){
                    this.checked = true;
                });
            } else {
                $('input[name="checkbox"]').each(function(){
                    this.checked = false;
                });
            }
            toggledeleteAllBtn();
        });

        $(document).on('change','input[name="checkbox"]', function(){
            if ($('input[name="checkbox"]').length == $('input[name="checkbox"]:checked').length ){
                $('input[name="main_checkbox"]').prop('checked', true);
            } else {
                $('input[name="main_checkbox"]').prop('checked', false);
            }
            toggledeleteAllBtn();
        });

        function toggledeleteAllBtn(){
            if ($('input[name="checkbox"]:checked').length > 0 ){
                $('button#deleteAllBtn').text('Hapus ('+$('input[name="checkbox"]:checked').length+')').removeClass('d-none');
            } else {
                $('button#deleteAllBtn').addClass('d-none');
            }
        }

        $(document).on('click','button#deleteAllBtn', function(){
            var checkedItem = [];
            $('input[name="checkbox"]:checked').each(function(){
                checkedItem.push($(this).data('id'));
            });
            var url = '{{ route("categories.deleteSelected") }}';
            if(checkedItem.length > 0){
                swal.fire({
                    title:'Apakah yakin?',
                    html:'Ingin menghapus <b>('+checkedItem.length+')</b> barang',
                    showCancelButton:true,
                    showCloseButton:true,
                    confirmButtonText:'Ya Hapus',
                    cancelButtonText:'Tidak',
                    confirmButtonColor:'#556ee6',
                    cancelButtonColor:'#d33',
                    width:300,
                    allowOutsideClick:false
                }).then(function(result){
                    if(result.value){
                        $.post(url,{id:checkedItem},function(data){
                            if(data.code == 1){
                                // $('#data-table').DataTable().ajax.reload(null, true);
                                table.draw();
                                toastr.success(data.msg);
                            }
                        },'json');
                    }
                })
            }
        });

    });
</script>

@endsection

