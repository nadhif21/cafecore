<?php
// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->where('status', 'cart')
            ->get();
        
        // Menghitung total keseluruhan
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    
        return view('cart.index', compact('cartItems', 'total'));
    }

public function list()

{
    // Mengambil pesanan yang statusnya pending dan selain pending
    $pendingItems = Cart::where('status', 'pending')->with('product')->get()->groupBy('order_id');
    $completedItems = Cart::where('status', '!=', 'pending')->with('product')->get()->groupBy('order_id');

    return view('admin.index', compact('pendingItems', 'completedItems'));
}

public function histori()
{
    $userId = auth()->id(); // Ambil user_id dari session auth
    
    // Pesanan dengan status 'pending'
    $pendingItems = Cart::where('user_id', $userId)->where('status', 'pending')->get();
    
    // Pesanan dengan status selain 'pending' dan 'cart'
    $completedItems = Cart::where('user_id', $userId)
                          ->whereNotIn('status', ['pending', 'cart']) // Mengambil status selain 'pending' dan 'cart'
                          ->get();

    return view('user.histori', compact('pendingItems', 'completedItems'));
}


    public function destroy($id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->first();
        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    // Menambah jumlah item
    public function increase($id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->first();
        if ($cartItem) {
            $cartItem->increment('quantity');
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah item berhasil ditambahkan.');
    }

    // Mengurangi jumlah item
    public function decrease($id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->first();
        if ($cartItem) {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                // Jika jumlah item 1 dan pengguna ingin menghapusnya, kita hapus item dari keranjang
                $cartItem->delete();
            }
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah item berhasil dikurangi.');
    }

    public function checkout(Request $request)
    {
        // Generate order_id yang unik
        $orderId = rand(100000, 999999);
        
        // Update status semua cart items milik user menjadi 'pending'
        $cartItems = Cart::where('user_id', auth()->id())->where('status', '=', 'cart')->get();
        
        foreach ($cartItems as $item) {
            $item->update([
                'status' => 'pending',
                'order_id' => $orderId
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Keranjang Anda telah diproses, menunggu konfirmasi admin.');
    }

    public function cancel(Request $request, $order_id)
    {
        $cartItems = Cart::where('user_id', auth()->id())->where('order_id', $order_id)->where('status', '=', 'pending');
        
        if ($cartItems->count() > 0) {
            $cartItems->update([
                'status' => 'canceled',
            ]);
            
            return redirect()->route('user.histori')->with('success', 'Pesanan Anda telah dibatalkan.');
        } else {
            return redirect()->route('user.histori')->with('error', 'Pesanan tidak ditemukan!');
        }
    }
    // Fungsi untuk admin mengkonfirmasi pembayaran
    public function confirmPayment($orderId)
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
    
        // Cek apakah user adalah admin
        if (auth()->user()->is_admin) {
            // Temukan semua item dalam order_id yang sama
            $cartItems = Cart::where('order_id', $orderId)
                             ->where('status', 'pending')  // Hanya yang status 'pending'
                             ->get();
    
            // Periksa jika tidak ada pesanan yang perlu dikonfirmasi
            if ($cartItems->isEmpty()) {
                return redirect()->route('admin.index')->with('error', 'Tidak ada pesanan yang menunggu konfirmasi.');
            }
    
            // Update status menjadi completed untuk semua item
            foreach ($cartItems as $cartItem) {
                $cartItem->status = 'completed';
                $cartItem->save();  // Simpan perubahan
            }
    
            return redirect()->route('admin.index')->with('success', 'Semua pesanan dengan Order ID ' . $orderId . ' berhasil dikonfirmasi.');
        }
    
        return redirect()->route('admin.index')->with('error', 'Anda tidak memiliki hak akses untuk mengonfirmasi pembayaran.');
    }

    public function cancelPayment($orderId)
{
    // Pastikan user sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // Cek apakah user adalah admin
    if (auth()->user()->is_admin) {
        // Temukan semua item dalam order_id yang sama
        $cartItems = Cart::where('order_id', $orderId)
                         ->where('status', 'pending')  // Hanya yang status 'pending'
                         ->get();

        // Periksa jika tidak ada pesanan yang perlu dibatalkan
        if ($cartItems->isEmpty()) {
            return redirect()->route('admin.index')->with('error', 'Tidak ada pesanan yang dapat dibatalkan.');
        }

        // Update status menjadi cancelled untuk semua item
        foreach ($cartItems as $cartItem) {
            $cartItem->status = 'canceled';
            $cartItem->save();  // Simpan perubahan
        }

        return redirect()->route('admin.index')->with('success', 'Semua pesanan dengan Order ID ' . $orderId . ' berhasil dibatalkan.');
    }

    return redirect()->route('admin.index')->with('error', 'Anda tidak memiliki hak akses untuk membatalkan pesanan.');
}
    
}
