@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold mb-8 text-center text-white">Riwayat Pembelian</h2>
    
    @if($orders->count() > 0)
        <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg p-6 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 bg-opacity-50">
                        <th class="border border-gray-300 px-4 py-2">ID Order</th>
                        <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                        <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                        <th class="border border-gray-300 px-4 py-2">Total Harga</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Tanggal Pembelian</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-100 hover:bg-opacity-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $order->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->product->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->quantity }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                Rp {{ number_format($order->product->price * $order->quantity, 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-sm 
                                    @if($order->status === 'pending')
                                        bg-yellow-200 text-yellow-800
                                    @elseif($order->status === 'success')
                                        bg-green-200 text-green-800
                                    @else
                                        bg-red-200 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($order->status === 'pending')
                                    <button onclick="confirmOrder({{ $order->id }})" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                                        Konfirmasi Pembayaran
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center">
            <p class="text-gray-200 text-lg mb-4">Anda belum memiliki riwayat pembelian.</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-colors duration-300">
                Mulai Berbelanja
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
function confirmOrder(orderId) {
    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        text: "Apakah Anda sudah melakukan pembayaran untuk pesanan ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, sudah bayar!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/orders/${orderId}/confirm`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire(
                        'Berhasil!',
                        'Status pesanan telah diperbarui.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Gagal!',
                        data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                Swal.fire(
                    'Error!',
                    'Terjadi kesalahan saat memproses permintaan.',
                    'error'
                );
            });
        }
    });
}
</script>
@endpush
@endsection 