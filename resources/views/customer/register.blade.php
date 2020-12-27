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
<form class="form-signin" method="post" action="{{ URL('customer-register') }}">
    @csrf
    <center>
        <h1 class="h3 mb-3 font-weight-normal">Register</h1>
    </center>
    @if ($message = Session::get('alert-register'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" class="form-control <?= ($errors->first('username') != "") ? 'is-invalid' : ''; ?>" id="username" value="{{ old('username') }}">
        <div class="invalid-feedback">
            {{ $errors->first('username') }}
        </div>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" class="form-control <?= ($errors->first('email') != "") ? 'is-invalid' : ''; ?>" id="email" value="{{ old('email') }}">
        <div class="invalid-feedback">
            {{ $errors->first('email') }}
        </div>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control <?= ($errors->first('password') != "") ? 'is-invalid' : ''; ?>" id="password" value="{{ old('password') }}">
        <div class="invalid-feedback">
            {{ $errors->first('password') }}
        </div>
    </div>
    <div class="form-group">
        <label for="confirmation_password">Konfirmasi Password</label>
        <input type="password" name="confirmation_password" class="form-control <?= ($errors->first('confirmation_password') != "") ? 'is-invalid' : ''; ?>" id="confirmation_password">
        <div class="invalid-feedback">
            {{ $errors->first('confirmation_password') }}
        </div>
    </div>
    <div class="form-group">
        <label for="password">Jenis Kelamin</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input <?= ($errors->first('gender') != "") ? 'is-invalid' : ''; ?>" type="radio" name="gender" id="inlineRadio1" value="L" <?= (old('gender') == "L") ? 'checked' : ''; ?>>
                <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input <?= ($errors->first('gender') != "") ? 'is-invalid' : ''; ?>" type="radio" name="gender" id="inlineRadio2" value="P" <?= (old('gender') == "P") ? 'checked' : ''; ?>>
                <label class="form-check-label" for="inlineRadio2">Perempuan</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="birthday">Tanggal Lahir</label>
        <input type="date" name="birthday" class="form-control <?= ($errors->first('birthday') != "") ? 'is-invalid' : ''; ?>" id="birthday">
        <div class="invalid-feedback">
            {{ $errors->first('birthday') }}
        </div>
    </div>
    <div class="form-group">
        <label for="address">Alamat</label>
        <textarea class="form-control <?= ($errors->first('address') != "") ? 'is-invalid' : ''; ?>" name="address" id="address"></textarea>
        <div class="invalid-feedback">
            {{ $errors->first('address') }}
        </div>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
    <center>
        <p class="mt-5 mb-3 text-muted">&copy; 2020</p>
    </center>
</form>
@endsection