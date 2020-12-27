@extends('manager.index')
@section('content')
<style>
    .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 6px;
        font-size: 16px;
    }
</style>
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">{{ $categories->name }}</h1>
    @if ($message = Session::get('alert-delete-product'))
    <br />
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
</div>
<br />
@if($jumlah_produk>0)
<form method="post" action="{{ URL('manager-categories-product/'.$categories->id) }}">
    <div class="container">

        @csrf
        <div class="row">
            <div class="col-md-2 mb-3">
                <select class="form-control" style="padding: 5px;font-size: 16px;" name="filter" id="filter">
                    <option value="1" <?= ($filter_price == "") ? "selected='true'" : ""; ?>>Nama</option>
                    <option value="2" <?= ($filter_price != "") ? "selected='true'" : ""; ?>>Harga</option>
                </select>
            </div>
            <div class="col-md-4 mb-3" id="filter_name" <?= ($filter_price == "") ? "style='display: show;'" : "style='display: none;'"; ?>>
                <input type="text" class="form-control" name="filter_name" placeholder="Name..." value="<?= ($filter_name) ? $filter_name : ''; ?>" />
            </div>
            <div class="col-md-3 mb-3" id="filter_price" <?= ($filter_price != "") ? "style='display: show;'" : "style='display: none;'"; ?>>
                <select class="form-control" style="padding: 5px;font-size: 16px;" name="filter_price">
                    <option value="1" <?= ($filter_price == "1") ? "selected='true'" : ""; ?>>Dari Murah ke Mahal</option>
                    <option value="2" <?= ($filter_price == "2") ? "selected='true'" : ""; ?>>Dari Mahal ke Murah</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <button type="submit" class="btn btn-md btn-block btn-info" href="#">Search</button>
            </div>
        </div>

        <div class="card-deck mb-3 text-center">
            <div class="row">
                @foreach ($product as $produk)
                <div class="col-md-3">
                    <div class="card mb-3 box-shadow">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">{{ $produk->flower_name }}</h4>
                        </div>
                        <div class="card-body">
                            <div>
                                <?php
                                if (file_exists("./flower_image/" . $produk->flower_image)) {
                                    $path = URL('flower_image/' . $produk->flower_image);
                                } else {
                                    $path = URL('storage/flower_image/' . $produk->flower_image);
                                }
                                ?>
                                <a href="{{ URl('manager-categories-product-edit/'.$produk->id) }}"><img src="{{ $path }}" class="img-thumbnail img-preview" style="max-width: 75%; height: auto;"></a>
                            </div>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>
                                    {{ "Rp. ".$produk->flower_price }}
                                </li>
                            </ul>
                            <a type="button" class="btn btn-md btn-block btn-outline-primary" href="{{ URl('manager-categories-product-edit/'.$produk->id) }}">Update Produk</a>
                            <a type="button" class="btn btn-md btn-block btn-outline-danger" href="{{ URl('manager-categories-product-delete/'.$produk->id) }}">Delete Produk</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @if(($filter_name!="") || ($filter_price!="") )
                <div class="col-md-12">
                    &nbsp;
                </div>
                @else
                <div class="col-md-12">
                    {{ $product->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</form>
@else
<p>
    <center>
        <h1 class="display-4">Produk tidak tersedia.</h1>
    </center>
</p>
@endif
@endsection