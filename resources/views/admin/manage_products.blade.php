@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Kelola Produk</h2>
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h3 class="text-xl font-semibold mb-4">{{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}</h3>
        @if (session('message'))
            <div class="mb-4 text-green-500 text-sm text-center">{{ session('message') }}</div>
        @endif
        <form action="{{ isset($product) ? route('admin.update_product', $product->id) : route('admin.store_product') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium mb-2">Nama Produk</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-md" value="{{ old('name', $product->name ?? '') }}" required>
                @error('name')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-2">Deskripsi Produk</label>
                <textarea name="description" id="description" class="w-full px-3 py-2 border rounded-md" required>{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium mb-2">Harga Produk</label>
                <input type="text" name="price" id="price" class="w-full px-3 py-2 border rounded-md" value="{{ old('price', $product->price ?? '') }}" required>
                @error('price')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium mb-2">Gambar Produk</label>
                <input type="file" name="image" id="image" accept="image/*" class="w-full px-3 py-2 border rounded-md" {{ isset($product) ? '' : 'required' }}>
                @error('image')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 transition duration-300">
                    {{ isset($product) ? 'Update Produk' : 'Tambah Produk' }}
                </button>
            </div>
        </form>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4">Daftar Produk</h3>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left px-4 py-2">ID</th>
                    <th class="text-left px-4 py-2">Nama</th>
                    <th class="text-left px-4 py-2">Deskripsi</th>
                    <th class="text-left px-4 py-2">Harga</th>
                    <th class="text-left px-4 py-2">Gambar</th>
                    <th class="text-left px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td class="px-4 py-2">{{ $product->id }}</td>
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">{{ $product->description }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover">
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.edit_product', $product->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.delete_product', $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 