@extends('customer.index')
@section('content')
<style>
    html,
    body {
        height: 100%;

    }

    .form-data {
        width: 100%;
        max-width: 1300px;
        padding: 15px;
        margin: 0 auto;
    }
</style>
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">{{ "My Cart" }}</h1>
    @if ($message = Session::get('alert-cart'))
    <br />
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
</div>
<br />
<div class="form-data table-responsive">
    <table class="table table-stripped" style="width: 100%;">
        <thead>
            <th>#</th>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Quantity</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php $seq_number = 1; ?>
            @forelse ($cart as $row)
            <tr>
                <td>{{ $seq_number }}</td>
                <td style="width: 400px;">
                    <center>
                        <?php
                        if (file_exists("./flower_image/" . $row->flower->flower_image)) {
                            $path = URL('flower_image/' . $row->flower->flower_image);
                        } else {
                            $path = URL('storage/flower_image/' . $row->flower->flower_image);
                        }
                        ?>
                        <img src="{{ $path }}" class="img-thumbnail img-preview" style="max-width: 15%; height: auto;">
                    </center>
                </td>
                <td>
                    {{ $row->flower->flower_name }}
                </td>
                <td>
                    <?php
                    $aa = $row->flower->flower_price * $row->qty;
                    echo "Rp. " . $aa;
                    ?>
                </td>
                <td>
                    <input type="number" id="<?php echo 'qty_' . $row->id; ?>" class="form-control" value="{{ $row->qty }}">
                </td>
                <td>
                    <button class="btn btn-sm btn-primary" type="button" onclick="ubah_qty(<?= $row->id; ?>)">Update</button>
                </td>
            </tr>
            <?php $seq_number++; ?>
            @empty
            <tr>
                <td colspan="6">
                    <center>Tidak ada data.</center>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($jumlah_cart > 0)
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <a class="btn btn-sm btn-info" type="button" href="{{ URl('my-cart-checkout') }}">Checkout</a>
</div>
@endif
@endsection