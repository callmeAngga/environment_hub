<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="p-10 bg-gray-50">
    <div class="bg-white p-6 rounded shadow-lg">
        <h1 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 mt-2">Anda berhasil masuk ke sistem.</p>

        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</button>
        </form>
    </div>
</body>
</html>