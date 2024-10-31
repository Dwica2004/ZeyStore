@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-white">Checkout Berhasil</h1>
    <p class="text-white">Terima kasih telah berbelanja dengan kami. Pesanan Anda telah berhasil diproses.</p>

    @if(session('success'))
        <div class="alert alert-success bg-green-500 text-white p-4 rounded">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection 