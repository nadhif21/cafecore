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
    $pendingItems = Cart::where('status', 'pending')->get();
    $completedItems = Cart::where('status', '!=', 'pending')->get();

    return view('admin.index', compact('pendingItems', 'completedItems'));
}

public function histori()
{
    $userId = auth()->id(); // Ambil user_id dari session auth
    $pendingItems = Cart::where('user_id', $userId)->where('status', 'pending')->get();
    $completedItems = Cart::where('user_id', $userId)->where('status', '!=', 'pending')->get();

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
    // Pastikan user sudah login
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // Cek apakah user adalah admin
    if (auth()->user()->is_admin) {
        $cartItem = Cart::findOrFail($id);

        if ($cartItem->status === 'pending') {
            $cartItem->status = 'completed'; // Ubah status menjadi "completed"
            $cartItem->save(); // Simpan perubahan

            return redirect()->route('admin.index')->with('success', 'Pesanan berhasil dikonfirmasi.');
        }

        return redirect()->route('admin.index')->with('error', 'Status pesanan bukan pending.');
    }

    return redirect()->route('admin.index')->with('error', 'Anda tidak memiliki hak akses untuk mengonfirmasi pembayaran.');
}


}
