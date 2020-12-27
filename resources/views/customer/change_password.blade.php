@extends('customer.index')
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
<form class="form-signin" method="post" action="{{ URL('customer-change-password') }}">
    @csrf
    <center>
        <h1 class="h3 mb-3 font-weight-normal">Change Password</h1>
    </center>
    @if ($message = Session::get('alert-change-password'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <div class="form-group">
        <label for="exampleInputEmail1">Password Saat Ini</label>
        <input type="password" name="password_now" class="form-control <?= ($errors->first('password_now') != "") ? 'is-invalid' : ''; ?>" id="exampleInputEmail1">
        <div class="invalid-feedback">
            {{ $errors->first('password_now') }}
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password Baru</label>
        <input type="password" name="password_new" class="form-control <?= ($errors->first('password_new') != "") ? 'is-invalid' : ''; ?>" id="exampleInputPassword1">
        <div class="invalid-feedback">
            {{ $errors->first('password_new') }}
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" class="form-control <?= ($errors->first('password_confirmation') != "") ? 'is-invalid' : ''; ?>" id="exampleInputPassword1">
        <div class="invalid-feedback">
            {{ $errors->first('password_confirmation') }}
        </div>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
</form>
@endsection