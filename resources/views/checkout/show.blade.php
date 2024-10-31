@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-white">Checkout</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Form Informasi Pelanggan -->
        <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-white">Informasi Pelanggan</h2>
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', auth()->user()->name) }}" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                    <input type="text" name="phone" id="phone" 
                           value="{{ old('phone', auth()->user()->phone) }}" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('phone')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Process Order
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Ringkasan Pesanan -->
        <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-white">Ringkasan Pesanan</h2>
            <div class="space-y-4">
                @php
                    $subtotal = 0;
                    $cart = Session::get('cart', []);
                    foreach($cart as $item) {
                        $subtotal += $item['price'] * $item['quantity'];
                    }
                    $total = $subtotal;
                @endphp
                
                <div class="space-y-2">
                    @foreach($cart as $item)
                        <div class="flex justify-between text-white">
                            <span>{{ $item['name'] }} ({{ $item['quantity'] }}x)</span>
                            <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between text-white">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-white mt-2">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 