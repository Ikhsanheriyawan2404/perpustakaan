@extends('layouts.app', compact('title'))

@section('content')
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
            <li class="breadcrumb-item active">{{ Breadcrumbs::render('edit_user', $user) }}</li>
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
        <h3 class="card-title">Edit Pengguna {{ $user->name }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name">Nama lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukan nama" value="{{ $user->name ?? old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Alamat email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="cth: user@mail.test" value="{{ $user->email ?? old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Pengguna aktif</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio1" name="is_active" value="1" {{ $user->is_active == '1' ? 'checked' : ''}}>
                                <label for="customRadio1" class="custom-control-label">Aktif</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="is_active" value="0" {{ $user->is_active == '0' ? 'checked' : ''}}>
                                <label for="customRadio2" class="custom-control-label">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Role</label>
                            <select name="roles[]" class="form-control select2 @error('roles') is-invalid @enderror" style="width: 100%;">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->name == $user->roles->first()->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat tempat tinggal</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror">{{ $user->address ?? old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">Edit</button>
            </div>
        </form>
    </div>
<!-- /.card -->
</div>

@endsection

@section('custom-styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/select2/css/select2.min.css">
@endsection

@section('custom-scripts')
    <!-- Select2 -->
    <script src="{{ asset('asset') }}/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
