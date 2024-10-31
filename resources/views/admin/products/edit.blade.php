@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Edit Produk</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.update_product', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium mb-2">Nama Produk</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-md" value="{{ $product->name }}" required>
                @error('name')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-2">Deskripsi Produk</label>
                <textarea name="description" id="description" class="w-full px-3 py-2 border rounded-md">{{ $product->description }}</textarea>
                @error('description')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium mb-2">Harga Produk</label>
                <input type="number" name="price" id="price" class="w-full px-3 py-2 border rounded-md" value="{{ $product->price }}" required>
                @error('price')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium mb-2">Gambar Produk</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full px-3 py-2 border rounded-md">
                @error('image')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 transition duration-300">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 