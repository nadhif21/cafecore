<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Cart;


class ProductController extends Controller
{

    public function addToCart(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::findOrFail($id);

    // Cek apakah produk sudah ada di keranjang
    $cartItem = Cart::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->first();

    if ($cartItem) {
        // Jika produk sudah ada, tingkatkan jumlahnya
        $cartItem->quantity += $request->quantity;
        $cartItem->save();
    } else {
        // Jika produk belum ada, tambahkan ke keranjang
        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
        ]);
    }

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}

    // Menampilkan daftar produk
    public function index()
    {
        // Ambil semua produk dari database
        $products = Product::all(); 

        // Kembalikan view dengan daftar produk
        return view('catalog', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        // Simpan gambar
        $path = $request->file('image')->store('images', 'public');

        // Buat produk baru
        Product::create([
            'name' => $request->name,
            'image' => $path,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('catalog')->with('success', 'Produk berhasil di-upload!');
    }

    public function show($id)
{
    $product = Product::findOrFail($id); // Mengambil produk berdasarkan ID
    return view('products.show', compact('product')); // Mengirim data produk ke view
}
}
