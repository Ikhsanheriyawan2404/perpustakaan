@extends('layouts.app', compact('title'))

@section('content')

{{-- {{ dd($role->name) }} --}}
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
            <li class="breadcrumb-item active">{{ Breadcrumbs::render('edit_role', $role) }}</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
<!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
        <h3 class="card-title">Edit Role</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name">Nama role</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukan nama role" value="{{ old('name') ??  $role->name }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="customCheckbox1">Izin</label>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="check_all" type="checkbox" onClick="toggle(this)">
                                <label for="check_all" class="custom-control-label">check semua</label>
                            </div>
                            @foreach ($permissions as $permission)
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="{{ $permission->name }}" name="permission[]" type="checkbox" value="{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : ''}}>
                                    <label for="{{ $permission->name }}" class="custom-control-label">{{ $permission->name }}</label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">Tambah</button>
            </div>
        </form>
    </div>
<!-- /.card -->
</div>

@endsection

@section('custom-scripts')

    <script language="JavaScript">
        function toggle(source) {
            checkboxes = document.getElementsByName('permission[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endsection
