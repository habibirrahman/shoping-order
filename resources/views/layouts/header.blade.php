<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        <a name="Home" href="{{ route('home') }}"><img src="{{ asset('assets/img/my-bakery.png') }}" width="100" alt="my-bakery-logo"> </a>
        <h5 class="logo mr-auto ml-3">
            <a href="{{ route('home') }}">
                De Tasty <br>
                Bakery and Cake
            </a>
        </h5>
        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li hidden><a href="{{ route('home') }}">Home<i class="fas fa-home"></i></a></li>
                <li><a href="{{ route('home') }}">Beranda<i class="fas fa-home"></i></a></li>
                <!-- .nav-menu -->
                @guest
                <li><a href="{{ route('login') }}">Login <i class="fas fa-sign-in-alt"></i></a></li>
                <li><a href="{{ route('register') }}">Register <i class="fas fa-user-plus"></i></a></li>
                @endguest
                @auth
                @if ($data['user']->role == 1)
                <li><a href="/products">Admin Dashboard</a></li>
                @elseif ($data['user']->role == 0)
                <!-- <li><a disabled href="">{{ $data['user']->name }}</a></li> -->
                <li><a href="{{ route('carts.index') }}">Keranjang <i class="fas fa-shopping-cart"></i></a></li>
                <li><a href="{{ route('orders.index') }}">Pesanan <i class="fas fa-shopping-bag"></i></a></li>
                @endif
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit(); return confirm('Apakah Anda yakin ingin logout?')">
                            Logout <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </form>
                </li>
                @endauth
            </ul>
        </nav>
    </div>
</header>
<!-- End Header -->
