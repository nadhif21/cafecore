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
}
