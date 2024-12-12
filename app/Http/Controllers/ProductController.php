<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; 
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
            // Jika produk belum ada, tambahkan ke keranjang dengan status "cart"
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'status' => 'cart', // Tambahkan status "cart"
            ]);
        }
    
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    // Menampilkan daftar produk
    public function index()
{
    // Ambil semua produk dari database
    $products = Product::all(); 

    // Cek apakah user yang terautentikasi adalah user atau admin
    if (Auth::user()->role === 'user') {
        // Jika user, kembalikan ke view user.catalog
        return view('user.catalog', compact('products'));
    } elseif (Auth::user()->role === 'admin') {
        // Jika admin, kembalikan ke view admin.home
        return view('admin.home', compact('products'));
    }

    // Jika tidak terdeteksi role, arahkan ke login (misalnya)
    return redirect()->route('login');
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

        return redirect()->route('user.catalog')->with('success', 'Produk berhasil di-upload!');
    }

    public function show($id)
{
    $product = Product::findOrFail($id); // Mengambil produk berdasarkan ID
    return view('products.show', compact('product')); // Mengirim data produk ke view
}

public function edit($id)
{
    // Cari produk berdasarkan ID
    $product = Product::findOrFail($id);

    // Tampilkan form edit
    return view('admin.edit_product', compact('product'));
}

public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'name' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar bersifat opsional
        'price' => 'required|numeric',
        'description' => 'required|string',
    ]);

    // Cari produk berdasarkan ID
    $product = Product::findOrFail($id);

    // Jika ada file gambar baru yang diunggah
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }

        // Simpan gambar baru
        $path = $request->file('image')->store('images', 'public');
        $product->image = $path;
    }

    // Perbarui data produk
    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;

    // Simpan perubahan
    $product->save();

    return redirect()->route('admin.home')->with('success', 'Produk berhasil diperbarui!');
}

public function destroy($id)
{
    // Cari produk berdasarkan ID
    $product = Product::findOrFail($id);

    // Hapus gambar jika ada
    if ($product->image && Storage::exists('public/' . $product->image)) {
        Storage::delete('public/' . $product->image);
    }

    // Hapus produk
    $product->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.home')->with('success', 'Produk berhasil dihapus!');
}

}
