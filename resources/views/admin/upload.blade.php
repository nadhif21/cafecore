<!-- resources/views/upload.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-poppins bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-[#FEFEFE] shadow-lg sticky top-0 z-10 px-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="../assets/img/logo.png" class="w-auto h-12">
                    </div>
                </div>
                <div class="flex items-center space-x-4 font-semibold">
                    <a href="{{ route('upload') }}" class="text-gray-700 hover:text-[#FDD100]">
                        Upload
                    </a>
                    <div class="rounded-sm">
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button type="submit"
                                class="bg-[#FDD100] rounded text-white p-2 hover:bg-[#333333] hover:text-[#FDD100] transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Form Upload Produk -->
    <div class="container mx-auto p-8">
        <h2 class="text-3xl font-semibold mb-6">Upload Produk</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf

            <!-- Nama Produk -->
            <div class="mb-4">
                <label for="name" class="block text-lg font-medium text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="name" id="name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Gambar Produk -->
            <div class="mb-4">
                <label for="image" class="block text-lg font-medium text-gray-700 mb-2">Gambar Produk</label>
                <input type="file" name="image" id="image" accept="image/*" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Harga Produk -->
            <div class="mb-4">
                <label for="price" class="block text-lg font-medium text-gray-700 mb-2">Harga Produk</label>
                <input type="number" name="price" id="price" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Deskripsi Produk -->
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                <textarea name="description" id="description" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full py-3 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Upload Produk
                </button>
            </div>
        </form>
    </div>

</body>

</html>
