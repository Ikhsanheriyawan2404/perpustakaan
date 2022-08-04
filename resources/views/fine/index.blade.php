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

<div class="container">
    @include('components.alerts')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Denda</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="data-table" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 1%">No.</th>
                        <th>Nominal / Hari <small>(Klik angka nominal untuk merubah nominal denda)</small></th>
                        {{-- <th class="text-center" style="width: 5%"><i class="fas fa-cogs"></i> </th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>1. </th>
                        <td>
                            <a href="" class="update" data-name="fine" data-type="number" data-pk="{{ $fine->id }}" data-title="Masukkan nominal">{{ $fine->nominal }}</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection

@section('custom-styles')
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
@endsection

@section('custom-scripts')
<script>$.fn.poshytip={defaults:null}</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>

<script>

    $.fn.editable.defaults.mode = 'inline';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $('.update').editable({
        url: "{{ route('fine.update') }}",
        type: 'text',
        pk: 1,
        name: 'name',
        title: 'Enter name'
    });

</script>
@endsection
