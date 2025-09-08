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
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        placeholder="Enter your name"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                        placeholder="Enter your email"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- TTL -->
                <div class="mb-4">
                    <label for="ttl" class="block text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="ttl" id="ttl" value="{{ old('ttl') }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('ttl')" class="mt-2" />
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" 
                        placeholder="Enter your address"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <!-- No HP -->
                <div class="mb-4">
                    <label for="no_hp" class="block text-gray-700">Nomor HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" 
                        placeholder="Enter your phone number"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                </div>

                <!-- Password -->
               <div class="mb-4 relative">
    <label for="password" class="block text-gray-700">Password</label>
    <input type="password" name="password" id="password" placeholder="Enter password"
        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
    <span onclick="togglePassword('password', this)" 
          class="absolute right-3 top-9 cursor-pointer text-gray-500">
        <!-- Mata tertutup -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
    </span>
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirm Password -->
<div class="mb-6 relative">
    <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" 
        placeholder="Re-enter password"
        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
    <span onclick="togglePassword('password_confirmation', this)" 
          class="absolute right-3 top-9 cursor-pointer text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
    </span>
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
<script>
function togglePassword(fieldId, el) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
        input.type = "text";
        el.innerHTML = `
            <!-- Mata terbuka -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>`;
    } else {
        input.type = "password";
        el.innerHTML = `
            <!-- Mata tertutup -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>`;
    }
}
</script>

</body>
</html>
