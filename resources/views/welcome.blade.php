<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white rounded-xl shadow-lg w-[800px] grid grid-cols-2 overflow-hidden">
        
        <!-- Bagian Kiri -->
        <div class="p-10">
            <h2 class="text-2xl font-semibold mb-2">Get's Started</h2>
            <p class="text-gray-500 mb-6">
                Don't have Account?
                <a href="{{ route('register') }}" class="text-blue-500 font-semibold">Sign Up</a>
            </p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Username -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Username</label>
                    <input type="email" name="email" id="email" placeholder="Insert Username"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" placeholder="Insert Password"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- Forgot Password -->
                <div class="text-right mb-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <!-- Tombol Login -->
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-full hover:bg-blue-600 transition">
                    Login
                </button>
            </form>
        </div>

        <!-- Bagian Kanan -->
        <div class="bg-blue-500"></div>

    </div>

</body>
</html>
