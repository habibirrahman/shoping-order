<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $data['product']->name }} - My Bakery</title>
    @include('layouts.apps')
</head>

<body>
    @include('layouts.header')
    <div class="space"></div>
    <h1></h1>
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
            <div class="progress mb-5" style="height: 25px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 17%; background-color: #eec07b" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
            </div>
            <div class="section-title">
                <h2>Tambah Pesanan ke Keranjang</h2>
            </div>
            <div class="row">
                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="info">
                        <h4 class="mb-4">{{ $data['product']->name }}</h4>
                        <div class="row">
                            <img class="rounded mx-auto d-block img-fluid" src="{{ asset('/uploads/'.$data['product']->file_image) }}" alt="{{ $data['product']->slug }}" />
                            <table class="table">
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $data['product']->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    @php ($p = number_format($data['product']->price))
                                    <td>Rp {{ $p }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{ $data['product']->description }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0 d-flex align-items-stretch">
                    <form action="{{ route('carts.store', ['slug' => $data['product']->slug]) }}" method="POST" class="php-email-form">
                        @csrf
                        <h4 class="mb-4">Detail Pesanan</h4>
                        <div class="form-group">
                            <label for="name">Nama Anda</label>
                            @auth
                            <!-- // The user is authenticated... -->
                            <input type="text" name="name" readonly value="{{ $data['user']->name }}" class="form-control" id="name" />
                            @endauth
                            @guest
                            <!-- // The user is not authenticated... -->
                            <input type="text" name="name" class="form-control" id="name" />
                            @endguest
                        </div>
                        <div class="form-group">
                            <label for="produk">Produk Pesanan</label>
                            <input type="text" name="produk" readonly value="{{ $data['product']->name }}" class="form-control" id="produk" />
                        </div>
                        <div class="form-group">
                            <label for="price">Harga Produk</label>
                            @php ($p = number_format($data['product']->price))
                            <input type="text" name="price" readonly value="{{ $p }}" class="form-control" id="price" />
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="amount">Jumlah Produk</label>
                                <input onchange="calculate(placeholder)" type="number" placeholder="{{ $data['product']->price }}" class="form-control" name="amount" id="amount" min="1" value="1" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cost">Total Harga</label>
                                @php ($p = number_format($data['product']->price))
                                <input type="text" name="cost" readonly min="{{ $data['product']->price }}" value="{{ $p }}" class="form-control" id="cost" />
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-block">Tambah ke Keranjang</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section>

    @include('layouts.footer')

    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
    <div id="preloader"></div>

    <script>
        function calculate(price) {
            var amount = parseInt(document.getElementById('amount').value);
            var final_price = amount * price;
            var final = new Number(final_price).toLocaleString("en-US");
            document.getElementById('cost').value = final;
        }
    </script>
</body>

</html>
