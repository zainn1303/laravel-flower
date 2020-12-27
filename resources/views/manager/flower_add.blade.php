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
<form class="form-signin" method="post" action="{{ URL('manager-add-flower') }}" enctype="multipart/form-data">
    @csrf
    <center>
        <h1 class="h3 mb-3 font-weight-normal">Add Flower</h1>
    </center>
    @if ($message = Session::get('alert-add-flower'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <div class="form-group">
        <label for="kategori">Kategori</label>
        <select class="form-control <?= ($errors->first('categories') != "") ? 'is-invalid' : ''; ?>" style="padding: 5px;font-size: 14px;" name="categories" id="kategori">
            <?php $categorie1 = \App\Categorie::all(); ?>
            @foreach($categorie1 as $row1)
            <option value="{{ $row1->id }}" <?= (old('kategori') == $row1->id) ? "selected='true'" : ""; ?>>{{ $row1->name }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            {{ $errors->first('categories') }}
        </div>
    </div>
    <div class="form-group">
        <label for="nama">Nama Bunga</label>
        <input type="text" name="flower_name" class="form-control <?= ($errors->first('flower_name') != "") ? 'is-invalid' : ''; ?>" id="nama" value="{{ old('flower_name') }}">
        <div class="invalid-feedback">
            {{ $errors->first('flower_name') }}
        </div>
    </div>
    <div class="form-group">
        <label for="harga">Harga Bunga</label>
        <input type="number" name="flower_price" class="form-control <?= ($errors->first('flower_price') != "") ? 'is-invalid' : ''; ?>" id="harga" value="{{ old('flower_price') ?? '5000' }}">
        <div class="invalid-feedback">
            {{ $errors->first('flower_price') }}
        </div>
    </div>
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea class="form-control <?= ($errors->first('description') != "") ? 'is-invalid' : ''; ?>" name="description" id="deskripsi">{{ old('description') }}</textarea>
        <div class="invalid-feedback">
            {{ $errors->first('description') }}
        </div>
    </div>
    <div class="form-group">
        <label for="file">Gambar Bunga</label>
        <input type="file" name="file" class="form-control <?= ($errors->first('file') != "") ? 'is-invalid' : ''; ?>" id="file">
        <div class="invalid-feedback">
            {{ $errors->first('file') }}
        </div>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
</form>
@endsection