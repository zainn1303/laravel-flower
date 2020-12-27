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
    <h1 class="display-4">{{ "History Transaction" }}</h1>
</div>
<br />
<div class="form-data table-responsive">
    <table class="table table-stripped" style="width: 100%;">
        <thead>
            <th>#</th>
            <th>Deskripsi</th>
        </thead>
        <tbody>
            <?php $seq_number = 1; ?>
            @forelse ($transaction as $row)
            <tr>
                <td>{{ $seq_number }}</td>
                <td>
                    <a href="{{ URL('history-transaction-detail/'.$row->id) }}">Transaction at {{ $row->created_at }}</a>
                </td>
            </tr>
            <?php $seq_number++; ?>
            @empty
            <tr>
                <td colspan="2">
                    <center>Tidak ada data.</center>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection