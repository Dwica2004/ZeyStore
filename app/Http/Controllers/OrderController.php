<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['product', 'customer'])
                      ->where('customer_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->get();
                      
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'customer_phone' => 'required|string|max:20'
            ]);

            if (!Auth::check()) {
                throw new \Exception('User tidak terautentikasi');
            }

            $product = Product::findOrFail($request->product_id);
            $revenue = $request->quantity * $product->price;

            $order = new Order();
            $order->product_id = $request->product_id;
            $order->customer_id = Auth::id();
            $order->customer_name = Auth::user()->name;
            $order->customer_phone = $request->customer_phone;
            $order->quantity = $request->quantity;
            $order->status = 'pending';
            $order->revenue = $revenue;
            $order->date = now();
            
            if (!$order->save()) {
                throw new \Exception('Gagal menyimpan order');
            }

            DB::commit();

            return redirect()->route('orders.history')
                ->with('success', 'Order berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal membuat order: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        if ($order->customer_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,success,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status order berhasil diperbarui!'
        ]);
    }

    public function history()
    {
        if (!auth()->user()->isMember()) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $orders = Order::with(['product'])
            ->where('customer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.history', compact('orders'));
    }

    public function dashboard()
    {
        $orderData = Order::select('date', 'revenue')->get();
        return view('admin.admin_dashboard', compact('orderData'));
    }
} 