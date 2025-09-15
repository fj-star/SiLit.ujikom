<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white rounded-xl shadow-lg w-[800px] grid grid-cols-2 overflow-hidden">
        
        <!-- Bagian Kiri -->
        <div class="p-10">
            <h2 class="text-2xl font-semibold mb-2">Masuk Ke Akun Silit</h2>
            <p class="text-gray-500 mb-6">
                Ga Punya Akun?
                <a href="{{ route('register') }}" class="text-blue-500 font-semibold">Daftar sini</a>
            </p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Username -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" placeholder="masukan email"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="block text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="Masukam Password"
                            class="w-full px-4 py-2 pr-10 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="passwordIcon" class="fas fa-eye-slash text-gray-500 hover:text-gray-700"></i>
                        </button>
                    </div>
                </div>
                <!-- Forgot Password -->
                <div class="text-right mb-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">
                            Lupa password?
                        </a>
                    @endif
                </div>
                <!-- Tombol Login -->
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-full hover:bg-blue-600 transition">
                    Login
                </button>
                 <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
            </form>
        </div>
        <!-- Bagian Kanan -->
        <div class="bg-blue-500 relative">
    <img src="assets/img/logo.jpg" alt="Logo Silit Laundry" 
         alt="Login Illustration"
         class="w-full h-full object-cover">
    <!-- Overlay transparan (opsional biar teks kiri lebih kontras) -->
    {{-- <div class="absolute inset-0 bg-blue-600 bg-opacity-40"></div> --}}
</div>
        
    </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        }
    });
</script>

@if(session('logout_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Logout',
        text: '{{ session('logout_success') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif