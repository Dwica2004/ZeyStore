<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }
    
    public function dashboard()
    {
        return view('admin.admin_dashboard');
    }
    
    public function show($id)
    {
        $order = Order::with(['customer', 'product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    
    public function updateStatus(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,success,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }
    
    // ... method lainnya ...
} 