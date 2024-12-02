
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Katalog Produk</title>
        <link rel="icon" type="image/png" href="../assets/img/logo.jpeg">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .overflow-x-scroll::-webkit-scrollbar {
                height: 8px;
            }
            .overflow-x-scroll::-webkit-scrollbar-thumb {
                background: #FDD100;
                border-radius: 10px; 
            }
            .overflow-x-scroll::-webkit-scrollbar-track {
                background: #e0e0e0;
                border-radius: 10px;
            }
            .overflow-x-scroll::-webkit-scrollbar-thumb:hover {
                background: #FFC107;
            }
        </style>
    </head>
    @extends('layouts.adminnavigation')
    @section('content')
    <body class="font-poppins bg-white text-gray-900">
        <div class="bg-gray-100 py-10">
            <div class="container mx-auto px-4">
                <h1 class="text-xl font-bold text-left mb-6">Katalog Produk</h1>
                <div class="overflow-x-scroll whitespace-nowrap space-x-4 pb-4">
                    @foreach($products as $product)
                        <div class="inline-block bg-white shadow-md rounded-lg overflow-hidden w-60 transition-transform transform hover:scale-105 hover:shadow-xl">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover transition-transform duration-300 transform hover:scale-110">
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                                <p class="text-gray-600 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="mt-4 inline-block text-center w-full py-2 bg-[#FDD100] text-white font-semibold rounded hover:bg-yellow-600 transition">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </body>
    @endsection
    </html>
