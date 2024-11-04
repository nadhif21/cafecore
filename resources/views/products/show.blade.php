<!-- resources/views/products/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Detail Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body class="font-poppins bg-gray-100 text-gray-900">

    <nav class="bg-[#FEFEFE] shadow-lg sticky top-0 z-10 px-[150px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="../assets/img/logo.png" class="w-auto h-12">
                    </div>
                </div>
                <div class="flex items-center space-x-4 font-semibold">
                    <a href="{{ route('catalog') }}" class="text-gray-700 hover:text-[#FDD100]">
                        &larr; Kembali ke Katalog
                    </a>
                </div>
            </div>
        </div>
    </nav>
    

    <main class="container mx-auto py-10 px-4">
        <div class="flex">
            <div class="w-1/2">
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md">
            </div>
            <div class="w-1/2 pl-8">
                <h2 class="text-xl font-semibold text-gray-800">Detail Produk</h2>
                <p class="text-gray-600 mt-2">{{ $product->description }}</p>
                <p class="text-gray-800 font-bold mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <form method="POST" action="{{ route('products.addToCart', $product->id) }}" class="mt-4">
                    @csrf
                    <div class="flex items-center">
                        <input type="number" name="quantity" value="1" min="1" class="border rounded px-2 py-1 w-20" />
                        <button type="submit" class="ml-4 py-2 px-4 bg-[#FDD100] text-white font-semibold rounded hover:bg-yellow-600 transition">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </form>
                @if(session('success'))
                    <div class="mt-4 text-green-500">{{ session('success') }}</div>
                @endif

            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-gray-100 py-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Katalog Produk. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
