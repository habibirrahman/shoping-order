@extends('admin.app')

@section('title', 'Pelanggan De Aroma - Admin')

@section('user')
Admin {{ $data['user']->name }}
@endsection

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pelanggan</li>
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
                <h4><i class="fas fa-table mr-1"></i>Data Pelanggan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tgl Join</th>
                                <th>Nama</th>
                                <th>WhatsApp</th>
                                <th>Alamat</th>
                                <th>Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tgl Join</th>
                                <th>Nama</th>
                                <th>WhatsApp</th>
                                <th>Alamat</th>
                                <th>Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($data['users'] as $user)
                            <tr>
                                @php ($create = date("d M Y ", strtotime($user->created_at)))
                                <td>{{ $create }}</td>
                                <td>{{ $user->name }}<br>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->address }}</td>
                                <td>
                                    @foreach ($user->order as $order)
                                    @if ($order->status != null)
                                    @php ($for_date = date("d M Y ", strtotime($order->for_date)))
                                    status: <b>{{ $order->status }}</b><br>
                                    untuk tgl: <b>{{ $for_date }}</b><br>
                                    @foreach ($order->cart as $cart)
                                    {{ $cart->amount }} {{ $cart->product->name }}<br>
                                    @endforeach
                                    <hr>
                                    @endif
                                    @endforeach
                                </td>
                                <th class="text-center">
                                    @php ($phone = substr_replace($user->phone,'62',0,0))
                                    <a target="_blank" href="https://wa.me/{{ $phone }}?text=Halo%20{{ $user->name }}%20...%0AKami%20dari%20Admin%20De%20Aroma" type="submit" class="btn btn-secondary btn-sm">chat</a>
                                </th>
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
