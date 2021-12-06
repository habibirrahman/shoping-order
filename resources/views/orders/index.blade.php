<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pesanan - My Bakery</title>
    @include('layouts.apps')
</head>

<body>
    @include('layouts.header')

    <div class="space"></div>

    <div class="my-orders mb-5">
        <div class="container-fluid" data-aos="fade-up">
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
                        <div class="section-title">
                            <h2>Pesanan</h2>
                        </div>
                        <h3>Hello <strong>{{ $data['user']->name }}</strong></h3>
                        <p>
                            Halaman Pesanan ini digunakan untuk memantau status pesanan setelah melakukan pembayaran.
                        </p>
                    </div>

                    <section id="product" class="product pt-3">
                        <div class="container" data-aos="fade-up">
                            <ul id="product-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                                <li data-filter="*" class="filter-active">Semua</li>
                                <li data-filter=".filter-proses">Dalam Proses</li>
                                <li data-filter=".filter-selesai">Selesai</li>
                            </ul>
                            <div class="accordion-list">
                                <ul class="product-container row">

                                    @foreach ($data['orders'] as $order)
                                    @php
                                    if ($order->status == 'produksi' || $order->status == 'packaging') {
                                    $temp = 'proses';
                                    } elseif ($order->status == 'siap' || $order->status == 'selesai') {
                                    $temp = 'selesai';
                                    }
                                    $for_date = date("d M Y", strtotime($order->for_date));
                                    @endphp
                                    <li class="col-lg-12 col-md-12 mt-2 mb-0 p-0 product-item filter-{{ $temp }}" style="background-color: #fff8ed">
                                        <div class="form-check col-12 m-2 mb-0">
                                            <label class="form-check-label col-12">
                                                <a data-toggle="collapse" class="collapsed" href="#accordion-list-{{ $order->id }}">
                                                    Pesanan: <br>
                                                    @foreach($order->cart as $cart)
                                                    - {{ $cart->product->name }} <br>
                                                    @endforeach
                                                    Untuk tanggal: <span>{{ $for_date }},</span>berstatus: <span>{{ $order->status }}</span><br>
                                                    @if ($order->status == 'siap')
                                                    <span>Silakan datang ke Toko untuk mengambil pesanan Anda</span><br>
                                                    @endif
                                                    <i class="bx bx-chevron-down icon-show"></i>
                                                    <i class="bx bx-chevron-up icon-close"></i>
                                                </a>
                                            </label>
                                        </div>
                                        <div id="accordion-list-{{ $order->id }}" class="collapsed mt-0 mb-0 collapse" data-parent=".accordion-list">
                                            <div class="col position-sticky sticky-top bg-white p-0 mb-0">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">Produk</th>
                                                            <th class="text-center">Harga</th>
                                                            <th class="text-center">Jumlah</th>
                                                            <th class="text-center">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php ($i = 1)
                                                        @foreach($order->cart as $cart)
                                                        <tr>
                                                            <th class="text-center">{{ $i }}</th>
                                                            <td>{{ $cart->product->name }}</td>
                                                            @php ($p = number_format($cart->product->price))
                                                            <td class="text-right">{{ $p }}</td>
                                                            <td class="text-center">{{ $cart->amount }}</td>
                                                            @php ($p = number_format($cart->price))
                                                            <td class="text-right">{{ $p }}</td>
                                                        </tr>
                                                        @php ($i += 1)
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2">
                                                                @php ($updated = date("H:i, d M Y ", strtotime($order->updated_at)))
                                                                <b>Last-update</b> : {{ $updated }}
                                                            </td>
                                                            <td colspan="2">
                                                                <div class="form-row m-0">
                                                                    <div class="form-group col mb-0">
                                                                        <a target="_blank" class="btn btn-success text-white p-0" href="https://wa.me/6285234116872?text=Halo%20Admin%20My%20Bakery...%0ANama%20Saya%20{{$order->user->name}},%20Saya%20ingin%20bertanya%20mengenai%20pesanan%20saya%20untuk%20tanggal%20{{$for_date}},%20">
                                                                            chat
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            @php ($p = number_format($order->price))
                                                            <th class="text-right">{{ $p }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="content">
                            <h3>Keterangan <strong>status</strong> :</h3>
                            <table class="table">
                                <tr>
                                    <th>produksi</th>
                                    <td>pesanan sedang dalam proses pembuatan</td>
                                </tr>
                                <tr>
                                    <th>packaging</th>
                                    <td>pesanan telah selesai dibuat, dan sedang dikemas</td>
                                </tr>
                                <tr>
                                    <th>siap</th>
                                    <td>pesanan telah siap dan Pelanggan bisa mengambil pesanan di Toko Kue My Bakery</td>
                                </tr>
                                <tr>
                                    <th>selesai</th>
                                    <td>pesanan selesai dan telah diambil oleh Pelanggan</td>
                                </tr>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
    <div id="preloader"></div>
</body>

</html>
