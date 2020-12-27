@extends('customer.index')
@section('content')
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    @if ($message = Session::get('alert-login'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    @if(session('customer_id'))
    <?php $data_cutomer = \App\Customer::find(session('customer_id')); ?>
    @endif

    @if(!session('customer_id'))
    <h1 class="display-4">Selamat Datang, Guest</h1>
    <p class="lead">Silahkan melihat katalog yang tersedia dan silahkan login untuk memesan bunga, jika anda tidak mempunyai akun silahkan register.</p>
    @else
    <h1 class="display-4">Halo, {{ $data_cutomer->username }}</h1>
    <p class="lead">Silahkan melihat katalog dan produk yang tersedia.</p>
    @endif
</div>
<center>
    <?php $categorie = \App\Categorie::all(); ?>
    @if($categorie!=NULL)
    <div class="container">
        <p>Beberapa Kategori Bunga</p>
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
                            <a type="button" class="btn btn-md btn-block btn-outline-primary" href="{{ URl('categories/'.$cat->id) }}">Lihat Semua Produk</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <p>Untuk list semua produk dari kategori yang tersedia silahkan klik pada tombol lihat semua produk atau pada menu categories di menu navigasi atas.</p>
    </div>
    @else
    <p>
        <h1 class="display-4">Maaf kategori produk tidak tersedia.</h1>
    </p>
    @endif
</center>
@endsection