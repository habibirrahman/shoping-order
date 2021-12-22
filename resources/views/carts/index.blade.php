<!DOCTYPE html>
<html lang="en">

<head>
    <title>Keranjang - De Tasty</title>
    @include('layouts.apps')
</head>

<body>
    @include('layouts.header')

    <div class="space"></div>

    <div class="my-orders mb-5">
        <div class="container-fluid w-75" data-aos="fade-up">

            <div class="row">
                <div class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                    <div class="content">
                        <div class="mt-3">
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
                        </div>
                        <table class="table table-borderless table-sm mb-0" style="color: #6d3200">
                            <tr class="text-right">
                                <th class="col-3">1. Tambah Pesanan</th>
                                <th class="col-3">2. Checkout</th>
                                <th class="col-3">3. Bayar</th>
                                <th class="col-3">4. Selesai</th>
                            </tr>
                        </table>
                        <div class="progress mb-5 align-center" style="height: 25px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 45%; background-color: #eec07b" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                        </div>
                        <div class="section-title">
                            <h2>Keranjang Pesanan</h2>
                        </div>
                        <h3>Hello <strong>{{ $data['user']->name }}</strong></h3>
                        <p>
                            Pada halaman Keranjang ini, akan menampilkan semua produk yang ingin Anda pesan.
                            Anda bisa mengubah jumlah pesanan dengan menekan tombol <i>edit</i> pada produk yang diinginkan.
                            Silakan pilih <i>(checklist)</i> dan lakukan pembayaran pada produk yang ingin dipesan dengan menekan tombol <i>checkout</i>.
                            Proses produksi pesanan akan segera dilaksanakan setelah Anda melunasi pembayaran.
                        </p>
                    </div>

                    <form action="{{ route('orders.checkout') }}" method="POST" class="php-email-form">
                        @csrf
                        <div class="accordion-list">
                            <ul>
                                @php ($i = 1)
                                @foreach ($data['carts'] as $cart)
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input name="{{ $i }}" class="form-check-input" type="checkbox" value="{{ $cart->id }}" checked>
                                            @php ($p = number_format($cart->price))
                                            <a data-toggle="collapse" class="collapsed" href="#accordion-list-{{ $i }}"><span>{{ $cart->amount }} pcs</span>{{ $cart->product->name }} : Rp {{ $p }}<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                                        </label>
                                    </div>
                                    <div id="accordion-list-{{ $i }}" class="collapsed mt-3 collapse" data-parent=".accordion-list">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <img class="rounded mx-auto d-block img-fluid" src="{{ asset('/uploads/'.$cart->product->file_image) }}" alt="{{ $cart->product->slug }}" />
                                                <p>{{ $cart->product->description }}</p>
                                            </div>
                                            <div class="col-lg-7 mt-3 mt-lg-0">
                                                <div class="form-group">
                                                    <label>Harga Produk</label>
                                                    @php ($p = number_format($cart->product->price))
                                                    <input class="form-control" readonly value="{{ $p }}" />
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Jumlah Produk</label>
                                                        <input class="form-control" readonly value="{{ $cart->amount }}" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Harga Total</label>
                                                        @php ($p = number_format($cart->price))
                                                        <input class="form-control" readonly value="{{ $p }}" />
                                                    </div>
                                                </div>
                                                <p class="mt-2">
                                                    <a class="btn btn-warning text-white" href="{{ route('carts.edit', $cart->id) }}">Edit</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @php ($i += 1)
                                @endforeach
                            </ul>
                            @if ($data['carts'] == '[]')
                            <div class="text-center mt-2">
                                <a type="submit" href="{{ route('home')}}" class="btn btn-primary btn-block">Beranda</a>
                            </div>
                            @else
                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary btn-block">Checkout</button>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
    <div id="preloader"></div>
</body>

</html>
