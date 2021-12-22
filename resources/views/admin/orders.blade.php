@extends('admin.app')

@section('title', 'Pesanan De Tasty - Admin')

@section('user')
Admin {{ $data['user']->name }}
@endsection

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pesanan</li>
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
                <h4><i class="fas fa-table mr-1"></i>Pesanan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Untuk Tgl</th>
                                <th>Id</th>
                                <th>Pelanggan</th>
                                <th>Pesanan</th>
                                <th>Status</th>
                                <th>Ubah Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Untuk Tgl</th>
                                <th>Id</th>
                                <th>Pelanggan</th>
                                <th>Pesanan</th>
                                <th>Status</th>
                                <th>Ubah Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($data['orders'] as $order)
                            <tr>
                                @php ($for_date = date("d M Y ", strtotime($order->for_date)))
                                <td>{{ $for_date }}</td>
                                <td>{{ $order->key_id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    @foreach ($order->cart as $cart)
                                    {{$cart->amount}} {{$cart->product->name}}<br>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    @if ($order->status == 'selesai')
                                    <button disabled class="btn btn-success btn-sm">{{ $order->status }}</button>
                                    @else
                                    <button disabled class="btn btn-info btn-sm">{{ $order->status }}</button>
                                    @endif
                                </td>
                                <td class="text-left">

                                    @php ($phone = substr_replace($order->user->phone,'62',0,0))
                                    @if ($order->status == 'produksi')
                                    <form action="{{ route('status.admin', ['id' => $order->id, 'status' => 'packaging']) }}" method="POST">
                                        @csrf
                                        <a target="_blank" href="https://wa.me/{{ $phone }}?text=Halo%20{{ $order->user->name }}%20...%0AKami%20dari%20Admin%20De%20Tasty" class="btn btn-secondary btn-sm">chat</a>
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Apakah Anda yakin ingin mengubah status pesanan {{ $order->key_id }} menjadi packaging?')">packaging</button>
                                    </form>
                                    @elseif ($order->status == 'packaging')
                                    <form action="{{ route('status.admin', ['id' => $order->id, 'status' => 'siap']) }}" method="POST">
                                        @csrf
                                        <a target="_blank" href="https://wa.me/{{ $phone }}?text=Halo%20{{ $order->user->name }}%20...%0AKami%20dari%20Admin%20De%20Tasty" class="btn btn-secondary btn-sm">chat</a>
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Apakah Anda yakin ingin mengubah status pesanan {{ $order->key_id }} menjadi siap?')">siap</button>
                                    </form>
                                    @elseif ($order->status == 'siap')
                                    <form action="{{ route('status.admin', ['id' => $order->id, 'status' => 'selesai']) }}" method="POST">
                                        @csrf
                                        <a target="_blank" href="https://wa.me/{{ $phone }}?text=Halo%20{{ $order->user->name }}%20...%0AKami%20dari%20Admin%20De%20Tasty" class="btn btn-secondary btn-sm">chat</a>
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin mengubah status pesanan {{ $order->key_id }} menjadi selesai?')">diambil & selesai</button>
                                    </form>
                                    @else
                                    <a target="_blank" href="https://wa.me/{{ $phone }}?text=Halo%20{{ $order->user->name }}%20...%0AKami%20dari%20Admin%20De%20Tasty" class="btn btn-secondary btn-sm">chat</a>
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
