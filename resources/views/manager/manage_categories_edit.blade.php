@extends('manager.index')
@section('content')
<style>
    html,
    body {
        height: 100%;
    }

    .form-data {
        width: 100%;
        max-width: 1000px;
        padding: 15px;
        margin: 0 auto;
    }
</style>
<form class="form-signin" method="post" action="{{ URL('manager-categories-update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $categories->id }}">
    <center>
        <h1 class="h3 mb-3 font-weight-normal">Edit Categories</h1>
    </center>
    <br />
    <div class="container">
        @if ($message = Session::get('alert-edit-categories'))
        <br />
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <center>
                    <div>
                        <?php
                        if (file_exists("./flower_categories/" . $categories->image)) {
                            $path = URL('flower_categories/' . $categories->image);
                        } else {
                            $path = URL('storage/flower_categories/' . $categories->image);
                        }
                        ?>
                        <img src="{{ $path }}" class="img-thumbnail img-preview" style="max-width: 75%; height: auto;">
                    </div>
                </center>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama">Nama Categories</label>
                    <input type="text" name="name" class="form-control <?= ($errors->first('name') != "") ? 'is-invalid' : ''; ?>" id="nama" value="{{ old('name') ?? $categories->name }}">
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
                <button class="btn btn-sm btn-primary btn-block" type="submit">Submit</button>
                <a class="btn btn-sm btn-warning btn-block" style="color: #fff;" type="button" href="{{ URl('manager-categories') }}">Kembali</a>
            </div>
        </div>
    </div>
</form>
@endsection