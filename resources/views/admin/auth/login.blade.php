<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-6">

            {{-- Judul --}}
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-1">
                Login Admin
            </h2>
            <p class="text-sm text-center text-gray-500 mb-6">
                Silakan masuk untuk mengelola e-commerce
            </p>

            {{-- Form --}}
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf

                {{-- Email --}}
                <label class="block mb-3">
                    <span class="text-gray-700 text-sm font-semibold">Email</span>
                    <input 
                        type="email" 
                        name="email"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-red-400 focus:outline-none"
                        placeholder="Masukkan email admin"
                        required>
                </label>

                {{-- Password --}}
                <label class="block mb-4">
                    <span class="text-gray-700 text-sm font-semibold">Password</span>
                    <input 
                        type="password"
                        name="password"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-red-400 focus:outline-none"
                        placeholder="Masukkan password"
                        required>
                </label>

                {{-- Error Message --}}
                @if(session('error'))
                    <p class="text-red-600 text-sm mb-3">
                        {{ session('error') }}
                    </p>
                @endif

                {{-- Tombol Login --}}
                <button 
                    type="submit"
                    class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                    Login
                </button>
            </form>

        </div>
    </div>

</body>
</html>
