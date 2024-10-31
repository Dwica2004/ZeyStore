@extends('layouts.app')

@section('content')
<div class="content container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Kelola Akun</h2>
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h3 class="text-xl font-semibold mb-4">{{ isset($user) ? 'Edit Akun' : 'Tambah Akun Baru' }}</h3>
        @if (session('message'))
            <div class="mb-4 text-green-500 text-sm text-center">{{ session('message') }}</div>
        @endif
        <form action="{{ isset($user) ? route('admin.update_account', $user->id) : route('admin.store_account') }}" method="POST">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium mb-2">Nama</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-md" value="{{ old('name', $user->name ?? '') }}" required>
                @error('name')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-md" value="{{ old('email', $user->email ?? '') }}" required>
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium mb-2">Telepon</label>
                <input type="text" name="phone" id="phone" class="w-full px-3 py-2 border rounded-md" value="{{ old('phone', $user->phone ?? '') }}" required>
                @error('phone')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium mb-2">Role</label>
                <select name="role" id="role" class="w-full px-3 py-2 border rounded-md" required>
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @error('role')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 transition duration-300">
                    {{ isset($user) ? 'Update Akun' : 'Tambah Akun' }}
                </button>
            </div>
        </form>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <h3 class="text-xl font-semibold mb-4">Daftar Akun</h3>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left px-4 py-2">ID</th>
                    <th class="text-left px-4 py-2">Nama</th>
                    <th class="text-left px-4 py-2">Email</th>
                    <th class="text-left px-4 py-2">Telepon</th>
                    <th class="text-left px-4 py-2">Role</th>
                    <th class="text-left px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="px-4 py-2">{{ $user->id }}</td>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->phone }}</td>
                    <td class="px-4 py-2">{{ $user->role }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.edit_account', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.delete_account', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 