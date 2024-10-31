@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">Checkout</h2>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <input type="hidden" id="product_id" value="{{ $product->id }}">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Jumlah</label>
                <input type="number" 
                       id="quantity" 
                       min="1" 
                       value="1" 
                       class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nomor WhatsApp</label>
                <input type="text" 
                       id="customer_phone" 
                       class="w-full px-3 py-2 border rounded"
                       placeholder="Contoh: 628123456789">
            </div>
            
            <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Process Order
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function processCheckout() {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const formData = new FormData(document.getElementById('checkoutForm'));

    fetch('/checkout/process', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Order berhasil diproses!');
            window.location.href = '/checkout/success';
        } else {
            alert('Gagal memproses order: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses order');
    });
}
</script>
@endpush
@endsection 