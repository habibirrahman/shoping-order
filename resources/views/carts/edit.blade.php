<!DOCTYPE html>
<html lang="en">

<head>
    <title>Keranjang - De Aroma</title>
    @include('layouts.apps')
</head>

<body>
    @include('layouts.header')

    <div class="space"></div>

    <section class="orders">
        <div class="container w-75" data-aos="fade-up">

            <div class="section-title">
                <h2>Edit Pesanan</h2>
            </div>

            <div class="row">

                <div class="col-lg-6 d-flex align-items-stretch">
                    <div class="info">
                        <h4 class="mb-4">{{ $data['cart']->product->name }}</h4>
                        <div class="row">
                            <img class="rounded mx-auto d-block img-fluid" src="{{ asset('/uploads/'.$data['cart']->product->file_image) }}" alt="{{ $data['cart']->product->slug }}" />
                            <table class="table">
                                <tr>
                                    <th>Kategori</th>
                                    <td>{{ $data['cart']->product->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    @php ($p = number_format($data['cart']->product->price))
                                    <td>Rp {{ $p }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{ $data['cart']->product->description }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-5 mt-lg-0 d-flex align-items-stretch">
                    <form action="{{ route('carts.update', $data['cart']->id) }}" method="POST" class="php-email-form">
                        @csrf
                        @method('PUT')
                        <h4 class="mb-4">Detail Pesanan</h4>
                        <div class="form-group">
                            <label for="name">Nama Anda</label>
                            <input type="text" name="name" readonly value="{{ $data['cart']->user->name }}" class="form-control" id="name" />
                        </div>
                        <div class="form-group">
                            <label for="produk">Produk Pesanan</label>
                            <input type="text" name="produk" readonly value="{{ $data['cart']->product->name }}" class="form-control" id="produk" />
                        </div>
                        <div class="form-group">
                            <label for="price">Harga Produk</label>
                            @php ($p = number_format($data['cart']->product->price))
                            <input type="text" name="price" readonly value="{{ $p }}" class="form-control" id="price" />
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="amount">Jumlah Produk</label>
                                <input onchange="calculate()" type="number" class="form-control" name="amount" id="amount" min="0" value="{{ $data['cart']->amount }}" data-rule="minlen:1" data-msg="Please enter at least 1 item" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="final_price">Total Harga</label>
                                <input type="number" name="final_price" readonly min="{{ $data['cart']->price }}" value="{{ $data['cart']->price }}" class="form-control" id="final_price" />
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
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

<script type="text/javascript">
    function calculate() {
        var amount = parseInt(document.getElementById('amount').value);
        var product_price = parseInt(document.getElementById('price').value);
        var final_price = amount * product_price;
        document.getElementById('final_price').value = final_price;
    }
</script>

</html>
