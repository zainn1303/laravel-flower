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
    <h3>{{ "Your Transaction At ".$transaction_detail->created_at }}</h3>
</div>
<br />
<div class="form-data table-responsive">
    <table class="table table-stripped" style="width: 100%;">
        <thead>
            <th>#</th>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Sub Total</th>
            <th>Quantity</th>
        </thead>
        <tbody>
            <?php $seq_number = 1; ?>
            @forelse ($transaction as $row)
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
                    {{ $row->total_price }}
                </td>
                <td>
                    {{ $row->qty }}
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
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <a class="btn btn-sm btn-warning" type="button" href="{{ URl('history-transaction') }}">Kembali</a>
</div>
@endsection