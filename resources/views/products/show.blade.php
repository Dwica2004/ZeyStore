<button onclick="addToCart({{ $product->id }}, '{{ csrf_token() }}')" 
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Tambah ke Keranjang
</button> 