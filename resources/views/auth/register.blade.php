<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white rounded-xl shadow-lg w-[800px] grid grid-cols-2 overflow-hidden">
        
        <!-- Bagian Kiri -->
        <div class="p-10">
            <h2 class="text-2xl font-semibold mb-2">Buat Akun</h2>
            <p class="text-gray-500 mb-6">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-500 font-semibold">Login</a>
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                        placeholder="Masukkan email"
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
                        placeholder="Masukkan alamat lengkap"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <!-- No HP -->
                <div class="mb-4">
                    <label for="no_hp" class="block text-gray-700">Nomor HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" 
                        placeholder="Masukkan nomor HP"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4 relative">
                    <label for="password" class="block text-gray-700">Kata Sandi</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan kata sandi"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <span onclick="togglePassword('password', this)" 
                        class="absolute right-3 top-9 cursor-pointer text-gray-500">
                        👁️
                    </span>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-6 relative">
                    <label for="password_confirmation" class="block text-gray-700">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        placeholder="Masukkan ulang kata sandi"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    <span onclick="togglePassword('password_confirmation', this)" 
                        class="absolute right-3 top-9 cursor-pointer text-gray-500">
                        👁️
                    </span>
                </div>

                <!-- Tombol Register -->
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-full hover:bg-blue-600 transition">
                    Daftar
                </button>
            </form>
        </div>

        <!-- Bagian Kanan -->
        <div class="bg-blue-500 relative">
            <img src="assets/img/logo.jpg" alt="Logo Silit Laundry" 
                class="w-full h-full object-cover">
        </div>
    </div>

<script>
function togglePassword(fieldId, el) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>

</body>
</html>
