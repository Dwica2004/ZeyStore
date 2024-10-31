<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function cart()
    {
        $cartItems = session()->get('cart', []);
        return view('cart.index', compact('cartItems'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->route('cart.index')
                ->with('success', 'Cart updated successfully!');
        }
        
        return redirect()->route('cart.index')
            ->with('error', 'Product not found in cart!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')
                ->with('success', 'Product removed from cart successfully!');
        }
        
        return redirect()->route('cart.index')
            ->with('error', 'Product not found in cart!');
    }

    private function getCartItemCount()
    {
        $count = 0;
        $cart = Session::get('cart', []);
        
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        
        return $count;
    }

    private function validateCart()
    {
        if (!Session::has('cart') || empty(Session::get('cart'))) {
            return false;
        }
        return true;
    }

    private function calculateCartTotal()
    {
        $total = 0;
        $cart = Session::get('cart', []);
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }

    public function showCheckout()
    {
        if (!Session::has('cart') || empty(Session::get('cart'))) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja kosong');
        }

        return view('checkout.index');
    }

    public function processCheckout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20'
        ]);

        $cart = Session::get('cart');
        if (!$cart) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong');
        }

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        foreach ($cart as $productId => $item) {
            $subtotal = $item['price'] * $item['quantity'];

            Order::create([
                'customer_id' => auth()->id(),
                'product_id' => $productId,
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'quantity' => $item['quantity'],
                'status' => 'pending',
                'date' => now(),
                'revenue' => $subtotal
            ]);
        }

        Session::forget('cart');

        return redirect()->route('checkout.success')
            ->with('success', 'Pesanan berhasil diproses!');
    }

    public function restoreCart()
    {
        $tempCart = Session::get('temp_cart');
        
        if ($tempCart) {
            Session::put('cart', $tempCart);
            Session::forget('temp_cart');
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    public function purchaseHistory()
    {
        $orders = Order::with('product')
            ->where('customer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('checkout.history', compact('orders'));
    }

    public function confirmOrder(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        if ($order->status !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Order sudah dikonfirmasi'
            ]);
        }

        $order->update(['status' => 'success']);

        return response()->json([
            'status' => 'success',
            'message' => 'Status order berhasil diperbarui'
        ]);
    }

    public function show()
    {
        $cart = session()->get('cart', []);
        return view('checkout.show', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $cart = session()->get('cart', []);
        $subtotal = 0;
        $orderDetails = "Ringkasan Pesanan\n";
        $orderDetails .= "Nama: {$request->name}\n";
        $orderDetails .= "Telepon: {$request->phone}\n\n";

        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $orderDetails .= "{$item['name']} ({$item['quantity']}x)\nRp " . number_format($itemTotal, 0, ',', '.') . "\n";
            $subtotal += $itemTotal;
            
            Order::create([
                'customer_id' => auth()->id(),
                'product_id' => $item['id'],
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'quantity' => $item['quantity'],
                'status' => 'pending',
                'date' => now(),
                'revenue' => $itemTotal
            ]);
        }

        $orderDetails .= "\nSubtotal: Rp " . number_format($subtotal, 0, ',', '.') . "\n";
        $orderDetails .= "Total: Rp " . number_format($subtotal, 0, ',', '.');

        session()->put('temp_cart', $cart);
    }

    public function success()
    {
        return view('checkout.success');
    }
} 