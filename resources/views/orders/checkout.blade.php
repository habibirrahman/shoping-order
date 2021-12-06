<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout - My Bakery</title>
    @include('layouts.apps')
</head>

<body>
    @include('layouts.header')

    <div class="space"></div>

    <section class="orders">
        <div class="container w-75" data-aos="fade-up">
            <table class="table table-borderless table-sm mb-0" style="color: #6d3200">
                <tr class="text-right">
                    <th class="col-3">1. Tambah Pesanan</th>
                    <th class="col-3">2. Checkout</th>
                    <th class="col-3">3. Bayar</th>
                    <th class="col-3">4. Selesai</th>
                </tr>
            </table>
            <div class="progress mb-5 align-center" style="height: 25px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 72%; background-color: #eec07b" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
            </div>
            <div class="section-title">
                <h2>Checkout</h2>
            </div>
            <p>
                Silakan Anda memeriksa kembali daftar pesanan Anda pada bagian resi.
                Jika telah sesuai silakan Anda menentukan tanggal pesanan yang Anda inginkan (minimal pesanan akan siap selama 2 hari).
                Namun jika terdapat kesalahan pesanan, silakan kembali ke halaman Keranjang untuk mengubah pesanan Anda terlebih dahulu.
            </p>

            <div class="row">

                <div class="col-lg-7 d-flex align-items-stretch">
                    @php
                    $now = date('Y-m-d H:i T');
                    $i = 1;
                    @endphp
                    <div class="info">
                        <h4>Resi</h4>
                        <hr>
                        <p>{{ $now }}</p>
                        <p class="text-left"> Customer: <mark> {{ $data['user']->name }}</mark></p>
                        <table class="table mt-3">
                            <tr>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Pcs</th>
                                <th class="text-center">Total</th>
                            </tr>
                            @foreach ($data['carts'] as $cart)
                            <tr>
                                <td>{{ $cart->product->name }}</td>
                                @php ($p = number_format($cart->product->price))
                                <td class="text-right">{{ $p }}</td>
                                <td class="text-center">{{ $cart->amount }}</td>
                                @php ($p = number_format($cart->price))
                                <td class="text-right">{{ $p }}</td>
                            </tr>
                            @php ($i += 1)
                            @endforeach
                            <tr>
                                <th colspan="4">
                                    Jumlah Produk: {{ $data['total_item'] }} pcs
                                </th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th class="text-left">Total</th>
                                @php ( $b = number_format($data['bill']))
                                <th class="text-right">{{ $b }}</th>
                            </tr>
                        </table>
                    </div>

                </div>

                <div class="col-lg-5 mt-5 mt-lg-0 d-flex align-items-stretch">
                    <form action="{{ route('orders.pay', $data['carts_id']) }}" method="POST" class="php-email-form">
                        @csrf
                        <h4 class="mb-4">Detail Pemesanan</h4>
                        <div class="form-group">
                            <label for="name">Nama Anda</label>
                            <input type="text" name="name" readonly value="{{ $data['user']->name }}" class="form-control" id="name" />
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor WhatsApp</label>
                            <input type="text" name="phone" readonly value="{{ $data['user']->phone }}" class="form-control" id="phone" />
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" name="address" readonly value="{{ $data['user']->address }}" class="form-control" id="address" />
                        </div>
                        <div class="form-group">
                            <label for="bill">Total Harga</label>
                            @php ($b = number_format($data['bill']))
                            <input type="text" name="bill" readonly value="{{ $b }}" class="form-control" id="bill" />
                        </div>
                        <div class="form-group">
                            <label for="date">Tanggal Pesanan</label>
                            @php ($datemin = date("Y-m-d", strtotime('+2 day')))
                            <input type="date" name="date" min="{{ $datemin }}" class="form-control" id="date" required />
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            </div>
                            <div class="form-group col-md-6">
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-block">Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
    <div id="preloader"></div>
</body>

</html>
