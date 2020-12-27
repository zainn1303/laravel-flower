@extends('manager.index')
@section('content')
<style>
    html,
    body {
        height: 100%;
    }

    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }

    .form-signin .checkbox {
        font-weight: 400;
    }

    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }

    .form-signin .form-control:focus {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
<form class="form-signin" method="post" action="{{ URL('manager-categories-create') }}" enctype="multipart/form-data">
    @csrf
    <center>
        <h1 class="h3 mb-3 font-weight-normal">Add Categories</h1>
    </center>
    @if ($message = Session::get('alert-add-categories'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <div class="form-group">
        <label for="nama">Nama Categories</label>
        <input type="text" name="name" class="form-control <?= ($errors->first('name') != "") ? 'is-invalid' : ''; ?>" id="nama" value="{{ old('name') }}">
        <div class="invalid-feedback">
            {{ $errors->first('name') }}
        </div>
    </div>
    <div class="form-group">
        <label for="file">Gambar Categories</label>
        <input type="file" name="file" class="form-control <?= ($errors->first('file') != "") ? 'is-invalid' : ''; ?>" id="file">
        <div class="invalid-feedback">
            {{ $errors->first('file') }}
        </div>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
    <a class="btn btn-lg btn-warning btn-block" style="color: #fff;" type="button" href="{{ URl('manager-categories') }}">Kembali</a>
</form>
@endsection