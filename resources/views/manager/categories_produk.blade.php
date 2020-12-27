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
<form class="form-signin" method="post" action="{{ URL('manager-categories-product-update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $flower->id }}">
    <center>
        <h1 class="h3 mb-3 font-weight-normal">Edit Produk</h1>
    </center>
    <br />
    <div class="container">
        @if ($message = Session::get('alert-edit-product'))
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
                        if (file_exists("./flower_image/" . $flower->flower_image)) {
                            $path = URL('flower_image/' . $flower->flower_image);
                        } else {
                            $path = URL('storage/flower_image/' . $flower->flower_image);
                        }
                        ?>
                        <img src="{{ $path }}" class="img-thumbnail img-preview" style="max-width: 75%; height: auto;">
                    </div>
                </center>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kategori">Categories Produk</label>
                    <select class="form-control <?= ($errors->first('categories') != "") ? 'is-invalid' : ''; ?>" style="padding: 5px;font-size: 14px;" name="categories" id="kategori">
                        <?php $categorie1 = \App\Categorie::all(); ?>
                        @foreach($categorie1 as $row1)
                        <option value="{{ $row1->id }}" <?= ($flower->categorie_id == $row1->id) ? "selected='true'" : ""; ?>>{{ $row1->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        {{ $errors->first('categories') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Produk</label>
                    <input type="text" name="flower_name" class="form-control <?= ($errors->first('flower_name') != "") ? 'is-invalid' : ''; ?>" id="nama" value="{{ old('flower_name') ?? $flower->flower_name }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('flower_name') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="harga">Harga Produk</label>
                    <input type="number" name="flower_price" class="form-control <?= ($errors->first('flower_price') != "") ? 'is-invalid' : ''; ?>" id="harga" value="{{ old('flower_price') ?? $flower->flower_price }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('flower_price') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description">{{ old('description') ?? $flower->description }}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->first('flower_price') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="file">Gambar Produk</label>
                    <input type="file" name="file" class="form-control <?= ($errors->first('file') != "") ? 'is-invalid' : ''; ?>" id="file">
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                </div>
                <button class="btn btn-sm btn-primary btn-block" type="submit">Submit</button>
                <a class="btn btn-sm btn-warning btn-block" style="color: #fff;" type="button" href="{{ URl('manager-categories-product/'.$flower->categorie_id) }}">Kembali</a>
            </div>
        </div>
    </div>
</form>
@endsection