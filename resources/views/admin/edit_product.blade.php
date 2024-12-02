<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
@extends('layouts.kembali')
@section('content')
<body class="font-poppins bg-gray-100 text-gray-900">

    <div class="container mx-auto px-4 py-10">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Produk</h1>

        <!-- Tampilkan pesan sukses/error jika ada -->
        @if (session('success'))
            <div class="bg-green-100 text-green-800 border border-green-200 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Edit Produk -->
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Produk -->
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-2">Nama Produk</label>
                <input type="text" id="name" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400" 
                       value="{{ old('name', $product->name) }}" required>
            </div>

            <!-- Gambar Produk -->
            <div>
                <label for="image" class="block text-gray-700 font-medium mb-2">Gambar Produk</label>
                <input type="file" id="image" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                @if ($product->image)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="w-40 h-auto rounded-lg shadow-md">
                    </div>
                @endif
            </div>

            <!-- Harga Produk -->
            <div>
                <label for="price" class="block text-gray-700 font-medium mb-2">Harga Produk</label>
                <input type="number" id="price" name="price" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400" 
                       value="{{ old('price', $product->price) }}" required>
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi Produk</label>
                <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-400 focus:border-yellow-400" rows="5" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Tombol Update -->
            <div class="flex justify-between items-center">
                <button type="submit" class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition">
                    Perbarui Produk
                </button>
            </div>
        </form>

        <!-- Form Hapus Produk -->
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="mt-6">
            @csrf
            @method('DELETE')

            <button type="submit" class="w-full py-2 px-4 bg-red-500 text-white font-semibold rounded hover:bg-red-600 transition" 
                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                Hapus Produk
            </button>
        </form>
    </div>
</body>
@endsection
</html>
