<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@extends('layouts.kembali')

@section('content')
<body class="font-poppins bg-gray-100 text-gray-900">

    <main class="container mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Pesanan</h1>
        
        <!-- Tabel untuk pesanan yang statusnya "pending" -->
        <h2 class="text-xl font-semibold mb-2">Pesanan Menunggu Konfirmasi</h2>
        @if($pendingItems->isEmpty())
            <p class="text-gray-600">Tidak ada pesanan yang menunggu konfirmasi.</p>
        @else
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4">ID Pesanan</th>
                            <th class="py-2 px-4">Nama Produk</th>
                            <th class="py-2 px-4">Jumlah</th>
                            <th class="py-2 px-4">Total Harga</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingItems as $orderId => $items)
                            <tr>
                                <td class="border px-4 py-2" rowspan="{{ count($items) }}">{{ $orderId }}</td>

                                @foreach($items as $key => $item)
                                    @if ($key > 0)
                                        <tr>
                                    @endif
                                        <td class="border px-4 py-2">{{ $item->product->name }}</td>
                                        <td class="border px-4 py-2">{{ $item->quantity }}</td>
                                        <td class="border px-4 py-2">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                        <td class="border px-4 py-2">{{ ucfirst($item->status) }}</td>
                                        @if ($key === 0)
                                            <td class="border px-4 py-2" rowspan="{{ count($items) }}">
                                                <form action="{{ route('admin.orders.confirm', $orderId) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success text-white bg-green-500 hover:bg-green-700 py-2 px-4 rounded">
                                                        konfirmasi
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.orders.cancel', $orderId) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger text-white bg-red-500 hover:bg-red-700 py-2 px-4 rounded">
                                                        Batalkan Pesanan
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    @if ($key > 0)
                                        </tr>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Tabel untuk pesanan yang statusnya selain "pending" -->
        <h2 class="text-xl font-semibold mb-2">Pesanan Selesai atau Dibayar</h2>
        @if($completedItems->isEmpty())
            <p class="text-gray-600">Tidak ada pesanan yang selesai atau dibayar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4">ID Pesanan</th>
                            <th class="py-2 px-4">Nama Produk</th>
                            <th class="py-2 px-4">Jumlah</th>
                            <th class="py-2 px-4">Total Harga</th>
                            <th class="py-2 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedItems as $orderId => $items)
                            <tr>
                                <!-- Tampilkan ID Pesanan hanya sekali -->
                                <td class="border px-4 py-2" rowspan="{{ count($items) }}">{{ $orderId }}</td>
                
                                <!-- Tampilkan Nama Produk, Jumlah, dan Total Harga untuk setiap item dalam order -->
                                @foreach($items as $key => $item)
                                    @if ($key > 0)
                                        <tr> <!-- Buat baris baru jika bukan item pertama dalam order -->
                                    @endif
                                        <td class="border px-4 py-2">{{ $item->product->name }}</td>
                                        <td class="border px-4 py-2">{{ $item->quantity }}</td>
                                        <td class="border px-4 py-2">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                
                                        <!-- Tampilkan Status hanya sekali untuk setiap order_id -->
                                        @if ($key == 0)
                                            <td class="border px-4 py-2" rowspan="{{ count($items) }}">
                                                {{ ucfirst($item->status) }}
                                            </td>
                                        @endif
                                    @if ($key > 0)
                                        </tr> <!-- Tutup baris jika bukan item pertama dalam order -->
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        @endif
    </main>

    @if(session('success'))
        <div class="alert alert-success bg-green-200 text-green-800 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger bg-red-200 text-red-800 p-4 rounded">
            {{ session('error') }}
        </div>
    @endif

</body>
@endsection
</html>
