@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Dashboard Admin</h2>
    
    {{-- Menu Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
        <a href="{{ route('admin.orders.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-100 transition duration-300">
            <h3 class="text-xl font-semibold mb-2">Kelola Orderan</h3>
            <p>Kelola orderan pending atau sukses.</p>
        </a>
        <a href="{{ route('admin.users.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-100 transition duration-300">
            <h3 class="text-xl font-semibold mb-2">Kelola Akun</h3>
            <p>Kelola akun pengguna.</p>
        </a>
        <a href="{{ route('admin.products.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:bg-gray-100 transition duration-300">
            <h3 class="text-xl font-semibold mb-2">Kelola Produk</h3>
            <p>Tambah, edit, dan hapus produk.</p>
        </a>
    </div>
</div>
@endsection
