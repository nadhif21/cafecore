// Halaman Admin untuk melihat pesanan yang menunggu konfirmasi
// resources/views/admin/orders/index.blade.php

@extends('layouts.kembali')

@section('content')
    <h1 class="text-xl font-bold">Pesanan Menunggu Konfirmasi</h1>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Nama Produk</th>
                <th class="py-2">Jumlah</th>
                <th class="py-2">Harga</th>
                <th class="py-2">Status</th>
                <th class="py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                @if($item->status == 'pending')
                    <tr>
                        <td class="border px-4 py-2">{{ $item->product->name }}</td>
                        <td class="border px-4 py-2">{{ $item->quantity }}</td>
                        <td class="border px-4 py-2">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
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
                @endif
            @endforeach
        </tbody>
    </table>
@endsection
