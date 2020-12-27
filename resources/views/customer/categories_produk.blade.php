@extends('customer.index')
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
<form class="form-signin" method="post" action="{{ URL('categories-product-add-cart') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $flower->id }}">
    <center>
        <h1 class="h3 mb-3 font-weight-normal">Detail Produk</h1>
    </center>
    <br />
    <div class="container">
        @if ($message = Session::get('alert-detail-product'))
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
                    <div>
                        {{ $flower->categorie->name }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Produk</label>
                    <div>
                        {{ $flower->flower_name }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="harga">Harga Produk</label>
                    <div>
                        {{ "Rp. ".$flower->flower_price }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <div>
                        {{ $flower->description }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="qty">QTY</label>
                    <input type="number" name="qty" class="form-control <?= ($errors->first('qty') != "") ? 'is-invalid' : ''; ?>" id="qty" value="{{ old('qty') ?? 1 }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('qty') }}
                    </div>
                </div>
                @if(!session('customer_id'))
                <a class="btn btn-sm btn-primary btn-block" style="color: #fff;" type="button" href="{{ URl('customer-login') }}">Tambahkan ke Cart</a>
                @else
                <button class="btn btn-sm btn-primary btn-block" type="submit">Tambahkan Ke Cart</button>
                @endif
                <a class="btn btn-sm btn-warning btn-block" style="color: #fff;" type="button" href="{{ URl('categories/'.$flower->categorie_id) }}">Kembali</a>
            </div>
        </div>
    </div>
</form>
@endsection