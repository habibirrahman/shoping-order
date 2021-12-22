<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile - De Tasty</title>
    @include('layouts.apps')
</head>


<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
            <h1 class="logo mr-auto"><a href="{{ route('home') }}">De Tasty</a></h1>
            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li><a href="#">My Order</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- End Header -->
    <section id="hero"></section>

    <x-app-layout>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                @livewire('profile.update-profile-information-form')
            </div>
        </div>
    </x-app-layout>
    @include('layouts.footer')
</body>

</html>
