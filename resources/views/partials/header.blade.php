<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Hitung jumlah item di keranjang
$cartItemCount = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartItemCount += $item['quantity'];
    }
}

// Tentukan root URL
$rootUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$rootPath = dirname($_SERVER['PHP_SELF']);
$rootPath = str_replace('/checkout', '', $rootPath); // Hapus '/checkout' jika ada
$rootPath = str_replace('/auth', '', $rootPath); // Hapus '/auth' jika ada
$rootPath = str_replace('/dashboard', '', $rootPath); // Hapus '/dashboard' jika ada
$rootUrl .= $rootPath;
$rootUrl = rtrim($rootUrl, '/');
?>
<nav class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg text-white p-4 sticky top-0 z-50">
    <div class="container mx-auto flex flex-wrap justify-between items-center">
        <h1 class="text-2xl font-bold">ZeyStore</h1>
        <button class="lg:hidden" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>
        <div id="menu" class="hidden w-full lg:flex lg:w-auto lg:items-center">
            @auth
                <span class="block mt-4 lg:inline-block lg:mt-0 mr-4">Halo, {{ Auth::user()->name }}!</span>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                    </a>
                @endif
                <a href="{{ route('welcome') }}" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <a href="{{ route('cart.index') }}" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                    <i class="fas fa-shopping-cart"></i> Keranjang
                    <span id="cartItemCount" class="bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                        {{ Session::get('cart') ? count(Session::get('cart')) : 0 }}
                    </span>
                </a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.orders.index') }}" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                            <i class="fas fa-shopping-bag"></i> Kelola Order
                        </a>
                    @else
                        <a href="{{ route('purchase.history') }}" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                            <i class="fas fa-history"></i> Riwayat Pembelian
                        </a>
                    @endif
                @endauth
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="block mt-4 lg:inline-block lg:mt-0">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('welcome') }}" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <a href="{{ route('cart.index') }}" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                    <i class="fas fa-shopping-cart"></i> Keranjang
                    <span id="cartItemCount" class="bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                        {{ Session::get('cart') ? count(Session::get('cart')) : 0 }}
                    </span>
                </a>
                <a href="{{ route('login') }}" class="block mt-4 lg:inline-block lg:mt-0 mr-4">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ route('register') }}" class="block mt-4 lg:inline-block lg:mt-0">
                    <i class="fas fa-user-plus"></i> Register
                </a>
            @endauth
        </div>
    </div>
</nav>
<script>
    function toggleMenu() {
        const menu = document.getElementById('menu');
        menu.classList.toggle('hidden');
    }
</script> 