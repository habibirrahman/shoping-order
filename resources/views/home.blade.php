<!DOCTYPE html>
<html lang="en">

<head>
    <title>Beranda - De Aroma</title>
    @include('layouts.apps')
</head>

<body>
    @include('layouts.header')
    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1>Temukan Kue Favoritmu!</h1>
                    <h2>Kami menyediakan berbagai macam roti, kue, dan kue tart</h2>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ asset('assets/img/dearoma.png') }}" class="img-fluid animated" alt="dearoma-logo">
                </div>
            </div>
        </div>
    </section>

    <main id="main">
        <section id="product" class="product">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Produk Kami</h2>
                    <p>Pemesanan segala macam kue memerlukan waktu pembuatan minimal <b>2x24 jam</b> (2 hari kerja)</p>
                </div>
                <ul id="product-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">Semua</li>
                    @foreach ($data['category'] as $category)
                    <li data-filter=".filter-{{ $category->id }}">{{ $category->name }}</li>
                    @endforeach
                </ul>
                <div class="row product-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($data['products'] as $product)
                    <div class="col-lg-3 col-md-4 product-item filter-{{ $product->category_id }}">
                        <div class="product-img">
                            <img class="img-fluid" src="{{ asset('/uploads/'.$product->file_image) }}" alt="{{ $product->slug }}">
                        </div>
                        <div class="product-info">
                            <h4>{{ $product->name }}</h4>
                            @php ($p = number_format($product->price))
                            <p>Rp {{ $p }}</p>
                            <a class="venobox preview-link mr-2" href="{{ asset('/uploads/'.$product->file_image) }}" title="{{ $product->description }}"><i class="fas fa-expand-arrows-alt"></i></a>
                            <a href="{{ route('carts.add', $product->slug) }}" class="details-link ml-2" title="Tambah Pesanan"><i class="fas fa-cart-plus"></i></a>
                            <!-- <a class="venobox preview-link" href="{{ asset('/uploads/'.$product->file_image) }}" title="{{ $product->description }}"><i class="bx bx-expand-alt"></i></a>
                            <a href="{{ route('carts.add', $product->slug) }}" class="details-link" title="Tambah Pesanan"><i class="bx bx-plus"></i></a> -->
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->

    @include('layouts.footer')

    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
    <div id="preloader"></div>
</body>

</html>
