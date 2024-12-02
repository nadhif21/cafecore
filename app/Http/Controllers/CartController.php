<?php
// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
{
    $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
    
    // Menghitung total keseluruhan
    $total = $cartItems->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });

    return view('cart.index', compact('cartItems', 'total'));
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
        // Update status semua cart items milik user menjadi 'pending'
        $cartItems = Cart::where('user_id', auth()->id())->where('status', '!=', 'completed')->get();
        
        foreach ($cartItems as $item) {
            $item->update(['status' => 'pending']);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang Anda telah diproses, menunggu konfirmasi admin.');
    }

    // Fungsi untuk admin mengkonfirmasi pembayaran
    public function confirmPayment($id)
    {
        // Cek apakah user adalah admin (ini bisa disesuaikan dengan role atau permission)
        if (auth()->user()->is_admin) {
            $cartItem = Cart::findOrFail($id);

            // Mengubah status menjadi 'completed'
            $cartItem->update(['status' => 'completed']);

            return redirect()->route('admin.orders.index')->with('success', 'Pembayaran telah dikonfirmasi.');
        } else {
            return redirect()->route('cart.index')->with('error', 'Anda tidak memiliki hak akses untuk mengonfirmasi pembayaran.');
        }
    }
}
