<!-- resources/views/history.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
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
                    <a href="{{ route('user.catalog') }}" class="text-gray-700 hover:text-[#FDD100]">
                        &larr; Kembali ke Katalog
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto py-10 px-4">
        <h2 class="text-xl font-bold mb-2">Histori</h2>

<!-- Tabel untuk pesanan yang sudah selesai -->
<h3 class="text-lg font-semibold mb-2">Pesanan yang Sudah Selesai</h3>
@if($completedItems->isEmpty())
    <p class="text-gray-600">Tidak ada pesanan yang sudah selesai.</p>
@else
    <div class="overflow-x-auto mb-4">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">ID Pesanan</th>
                    <th class="py-2">Nama Produk</th>
                    <th class="py-2">Jumlah</th>
                    <th class="py-2">Total Harga</th>
                    <th class="py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($completedItems->groupBy('order_id') as $orderId => $items)
                    <tr>
                        <td class="border px-4 py-2">{{ $orderId }}</td>
                        <td class="border px-4 py-2">
                            @foreach($items as $item)
                                {{ $item->product->name }} ({{ $item->quantity }}) <br>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">
                            @foreach($items as $item)
                                {{ $item->quantity }} <br>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">
                            Rp {{ number_format($items->sum(function ($item) { return $item->product->price * $item->quantity; }), 0, ',', '.') }}
                        </td>
                        <td class="border px-4 py-2">{{ ucfirst($items->first()->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<!-- Tabel untuk pesanan yang masih pending -->
<h3 class="text-lg font-semibold mb-2">Pesanan yang Masih Pending</h3>
@if($pendingItems->isEmpty())
    <p class="text-gray-600">Tidak ada pesanan yang masih pending.</p>
@else
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">ID Pesanan</th>
                    <th class="py-2">Nama Produk</th>
                    <th class="py-2">Jumlah</th>
                    <th class="py-2">Total Harga</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingItems->groupBy('order_id') as $orderId => $items)
                    <tr>
                        <td class="border px-4 py-2">{{ $orderId }}</td>
                        <td class="border px-4 py-2">
                            @foreach($items as $item)
                                {{ $item->product->name }} ({{ $item->quantity }}) <br>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">
                            @foreach($items as $item)
                                {{ $item->quantity }} <br>
                            @endforeach
                        </td>
                        <td class="border px-4 py-2">
                            Rp {{ number_format($items->sum(function ($item) { return $item->product->price * $item->quantity; }), 0, ',', '.') }}
                        </td>
                        <td class="border px-4 py-2">{{ ucfirst($items->first()->status) }}</td>
                        <td class="border px-4 py -2">
                            <form action="{{ route('user.cancel', $orderId) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Batalkan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
    </main>
</body>
</html>