<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
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
                            <th class="py-2">ID Pesanan</th>
                            <th class="py-2">Nama Produk</th>
                            <th class="py-2">Jumlah</th>
                            <th class="py-2">Total Harga</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingItems as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->id }}</td>
                                <td class="border px-4 py-2">{{ $item->product->name }}</td>
                                <td class="border px-4 py-2">{{ $item->quantity }}</td>
                                <td class="border px-4 py-2">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </td>
                                <td class="border px-4 py-2">{{ ucfirst($item->status) }}</td>
                                <td class="border px-4 py-2">
                                    <form method="POST" action="{{ route('admin.orders.confirm', $item->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-2 rounded hover:bg-green-600">
                                            Konfirmasi Pembayaran
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Tabel untuk pesanan yang statusnya selain "pending" -->
        <h2 class="text-xl font-semibold mb-2">Histori</h2>
        @if($completedItems->isEmpty())
            <p class="text-gray-600">kosong.</p>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedItems as $item)
                            <tr>
                                <td class="border px-4 py-2">{{ $item->id }}</td>
                                <td class="border px-4 py-2">{{ $item->product->name }}</td>
                                <td class="border px-4 py-2">{{ $item->quantity }}</td>
                                <td class="border px-4 py-2">
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </td>
                                <td class="border px-4 py-2">{{ ucfirst($item->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

</body>
@endsection
</html>
