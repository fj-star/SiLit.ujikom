<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white rounded-xl shadow-lg w-[800px] grid grid-cols-2 overflow-hidden">
        
        <!-- Bagian Kiri -->
        <div class="p-10">
            <h2 class="text-2xl font-semibold mb-2">Create Account</h2>
            <p class="text-gray-500 mb-6">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-500 font-semibold">Login</a>
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4 relative">
                    <label for="name" class="block text-gray-700">Full Name</label>
                    <span class="absolute left-3 top-10 text-gray-400">
                        <!-- Heroicon: User -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A6 6 0 1118.879 17.804M12 14a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </span>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter your name"
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4 relative">
                    <label for="email" class="block text-gray-700">Email Address</label>
                    <span class="absolute left-3 top-10 text-gray-400">
                        <!-- Heroicon: Mail -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8-6H8m8 12H8M21 12c0 4.418-7.582 8-9 8s-9-3.582-9-8 7.582-8 9-8 9 3.582 9 8z" />
                        </svg>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email"
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4 relative">
                    <label for="password" class="block text-gray-700">Password</label>
                    <span class="absolute left-3 top-10 text-gray-400">
                        <!-- Heroicon: Lock -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.105.895-2 2-2s2 .895 2 2v2H8v-2c0-1.105.895-2 2-2s2 .895 2 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 11V7a6 6 0 1112 0v4" />
                        </svg>
                    </span>
                    <input type="password" name="password" id="password" placeholder="Enter password"
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6 relative">
                    <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                    <span class="absolute left-3 top-10 text-gray-400">
                        <!-- Heroicon: Check -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-enter password"
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Tombol Register -->
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-full hover:bg-blue-600 transition">
                    Register
                </button>
            </form>
        </div>

        <!-- Bagian Kanan -->
        <div class="bg-blue-500"></div>

    </div>

</body>
</html>
