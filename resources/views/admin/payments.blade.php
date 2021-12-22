@extends('admin.app')

@section('title', 'Pembayaran De Tasty - Admin')

@section('user')
Admin {{ $data['user']->name }}
@endsection

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Pembayaran, Record response dari Midtrans
            </li>
        </ol>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if (session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="fas fa-table mr-1"></i>Pembayaran</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id Pesanan</th>
                                <th>Diterima</th>
                                <th>Pelanggan</th>
                                <th>Jumlah</th>
                                <th>Tipe</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id Pesanan</th>
                                <th>Diterima</th>
                                <th>Pelanggan</th>
                                <th>Jumlah</th>
                                <th>Tipe</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($data['payments'] as $payment)
                            <tr>
                                <td>{{ $payment->order->key_id }} </td>
                                @php ($create = date("H:i, d M Y ", strtotime($payment->created_at)))
                                <td>{{ $create }}</td>
                                <td>{{ $payment->user->name }}</td>
                                @php ($p = number_format($payment->order->price))
                                <td class="text-right"><strong>{{ $p }}</strong></td>
                                <td>{{ $payment->type }}</td>
                                <td class="text-center">
                                    @if ($payment->status == 'success')
                                    <button disabled class="btn btn-success btn-sm">{{ $payment->status }}</button>
                                    @else
                                    <button disabled class="btn btn-danger btn-sm">{{ $payment->status }}</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
