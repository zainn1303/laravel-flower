@extends('manager.index')
@section('content')
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Manage Categories</h1>
    <br />
    <a type="button" class="btn btn-md btn-block btn-outline-primary" href="{{ URl('manager-categories-create') }}">Tambah Kategori</a>
    @if ($message = Session::get('alert-delete-categories'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
</div>
<?php $categorie = \App\Categorie::all(); ?>
@if($categorie!=NULL)
<div class="container">
    <div class="card-deck mb-3 text-center">
        <div class="row">
            @foreach ($categorie as $cat)
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{ $cat->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <?php
                            if (file_exists("./flower_categories/" . $cat->image)) {
                                $path = URL('flower_categories/' . $cat->image);
                            } else {
                                $path = URL('storage/flower_categories/' . $cat->image);
                            }
                            ?>
                            <img src="{{ $path }}" class="img-thumbnail img-preview" style="max-width: 75%; height: auto;">
                        </div>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>
                                <?php
                                $product = \App\Flower::where(['categorie_id' => $cat->id])->count();
                                echo $product . " Produk";
                                ?>
                            </li>
                        </ul>
                        <a type="button" class="btn btn-md btn-block btn-outline-success" href="{{ URl('manager-categories-product/'.$cat->id) }}">Lihat Semua Produk</a>
                        <a type="button" class="btn btn-md btn-block btn-outline-primary" href="{{ URl('manager-categories-edit/'.$cat->id) }}">Update Category</a>
                        <a type="button" class="btn btn-md btn-block btn-outline-danger" href="{{ URl('manager-categories-delete/'.$cat->id) }}">Delete Category</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
<p>
    <h1 class="display-4">Kategori produk tidak tersedia.</h1>
</p>
@endif
@endsection