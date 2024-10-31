@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-400 hover:text-blue-500">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Order
        </a>
    </div>

    <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-white">Detail Order #{{ $order->id }}</h2>

        <!-- Informasi Pelanggan -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 text-white">Informasi Pelanggan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-300">Nama:</p>
                    <p class="text-white font-medium">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-gray-300">Telepon:</p>
                    <p class="text-white font-medium">{{ $order->customer_phone }}</p>
                </div>
                <div>
                    <p class="text-gray-300">Email:</p>
                    <p class="text-white font-medium">{{ $order->customer->email }}</p>
                </div>
                <div>
                    <p class="text-gray-300">Tanggal Order:</p>
                    <p class="text-white font-medium">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Detail Produk -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 text-white">Detail Produk</h3>
            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $order->product->image) }}" 
                         alt="{{ $order->product->name }}" 
                         class="w-24 h-24 object-cover rounded-lg">
                    <div>
                        <h4 class="text-lg font-medium text-white">{{ $order->product->name }}</h4>
                        <p class="text-gray-300">{{ $order->product->description }}</p>
                        <p class="text-white mt-2">
                            Harga: Rp {{ number_format($order->product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-white">
                            Jumlah: {{ $order->quantity }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Pembayaran -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 text-white">Informasi Pembayaran</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-300">Total Pembayaran:</p>
                    <p class="text-white font-medium">
                        Rp {{ number_format($order->revenue, 0, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-300">Status:</p>
                    <div class="flex items-center mt-1">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($order->status === 'pending')
                                bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'success')
                                bg-green-100 text-green-800
                            @else
                                bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4 text-white">Update Status</h3>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center space-x-4">
                @csrf
                @method('PATCH')
                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="success" {{ $order->status === 'success' ? 'selected' : '' }}>Success</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    Update Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 