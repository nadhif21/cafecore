<!-- resources/views/cart/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        
        @if($cartItems->isEmpty())
            <p class="text-gray-600">Keranjang Anda kosong.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2">Produk</th>
                            <th class="py-2">Harga</th>
                            <th class="py-2">Jumlah</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->product->name }}</td>
                                <td class="border px-4 py-2">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                <td class="border px-4 py-2 flex items-center space-x-2">
                                    <form method="POST" action="{{ route('cart.decrease', $item->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-gray-300 text-black px-2 rounded hover:bg-gray-400 transition">
                                            -
                                        </button>
                                    </form>
                                    <span>{{ $item->quantity }}</span>
                                    <form method="POST" action="{{ route('cart.increase', $item->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-gray-300 text-black px-2 rounded hover:bg-gray-400 transition">
                                            +
                                        </button>
                                    </form>
                                </td>
                                <td class="border px-4 py-2">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
                                <td class="border px-4 py-2">
                                    <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <h2 class="text-xl font-bold">Total Keseluruhan: Rp {{ number_format($total, 0, ',', '.') }}</h2>
            </div>
        @endif
    </main>
    <a href="" class="ml-[120px] bg-[#FDD100] rounded text-white p-2  hover:bg-[#333333] hover:text-[#FDD100] transition">Bayar Sekarang</a>

</body>
</html>
