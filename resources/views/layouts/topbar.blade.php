<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Mobile) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search position-relative" onsubmit="event.preventDefault();">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari menu..." aria-label="Search" aria-describedby="basic-addon2" id="topbarSearchInput" autocomplete="off">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" aria-label="Cari">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
        <!-- Search Dropdown Results -->
        <div id="topbarSearchResults" class="dropdown-menu shadow animated--grow-in w-100" style="position: absolute; top: 100%; left: 0; display: none; z-index: 1000; overflow-y: auto; max-height: 300px;">
        </div>
    </form>

    <!-- Right Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- User Dropdown -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name }}
                </span>
                <img class="img-profile rounded-circle"
                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=fff"
                     alt="profile">
            </a>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}" id="logout-form-topbar">
                    @csrf
                    <button type="button" class="dropdown-item" id="btn-logout-topbar">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const logoutBtns = ["btn-logout", "btn-logout-topbar"];
    logoutBtns.forEach(id => {
        const btn = document.getElementById(id);
        if (btn) {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin mau keluar?',
                    text: "Sesi kamu akan diakhiri.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.closest("form").submit();
                    }
                });
            });
        }
    });

    // Topbar Search Logic
    const userRole = @json(auth()->user()->role);
    const searchInput = document.getElementById('topbarSearchInput');
    const searchResults = document.getElementById('topbarSearchResults');

    const availableMenus = [
        // Admin
        { title: 'Dashboard', url: '{{ route("admin.dashboard") ?? "" }}', roles: ['admin'] },
        { title: 'Absensi Karyawan', url: '/admin/absensi', roles: ['admin'] },
        { title: 'Data Pelanggan', url: '/admin/pelanggans', roles: ['admin'] },
        { title: 'Manajemen Layanan', url: '/admin/layanans', roles: ['admin'] },
        { title: 'Manajemen Treatment', url: '/admin/treatments', roles: ['admin'] },
        { title: 'Data Transaksi', url: '/admin/transaksi', roles: ['admin'] },
        { title: 'Data Karyawan', url: '/admin/karyawan', roles: ['admin'] },
        { title: 'Pengaturan Jam Kerja', url: '/admin/jam-kerja', roles: ['admin'] },
        { title: 'Log Aktivitas', url: '/admin/log-aktivitas', roles: ['admin'] },
        { title: 'Laporan Pendapatan', url: '/admin/laporan', roles: ['admin'] },
        { title: 'Penggajian', url: '/admin/gaji', roles: ['admin'] },

        // Owner / Pimpinan
        { title: 'Dashboard', url: '{{ route("owner.dashboard") ?? "" }}', roles: ['owner'] },
        { title: 'Laporan Pendapatan', url: '/owner/laporan', roles: ['owner'] },
        { title: 'Data Karyawan', url: '/owner/karyawan', roles: ['owner'] },

        // Karyawan / Kasir
        { title: 'Dashboard', url: '{{ route("karyawan.dashboard") ?? "" }}', roles: ['karyawan'] },
        { title: 'Absensi Saya', url: '/karyawan/absensi', roles: ['karyawan'] },
        { title: 'Transaksi Kasir', url: '/karyawan/transaksi', roles: ['karyawan'] },
        { title: 'Data Pelanggan', url: '/karyawan/pelanggan', roles: ['karyawan'] },
        { title: 'Daftar Layanan', url: '/karyawan/layanans', roles: ['karyawan'] },
        { title: 'Daftar Treatment', url: '/karyawan/treatments', roles: ['karyawan'] },
        { title: 'Gaji Saya', url: '/karyawan/gaji', roles: ['karyawan'] },

        // Pelanggan
        { title: 'Dashboard', url: '{{ route("pelanggan.dashboard") ?? "" }}', roles: ['pelanggan'] },
        { title: 'Riwayat Transaksi', url: '/pelanggan/transaksi', roles: ['pelanggan'] },
    ];

    if (searchInput) {
        const allowedMenus = availableMenus.filter(m => m.roles.includes(userRole));

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            searchResults.innerHTML = '';
            
            if (query.length > 0) {
                const matches = allowedMenus.filter(m => m.title.toLowerCase().includes(query));
                
                if (matches.length > 0) {
                    matches.forEach(item => {
                        const a = document.createElement('a');
                        a.href = item.url;
                        a.className = 'dropdown-item d-flex align-items-center py-2';
                        a.innerHTML = `<div class="mr-3"><div class="icon-circle bg-primary"><i class="fas fa-arrow-right text-white"></i></div></div>
                                       <div><span class="font-weight-bold">${item.title}</span></div>`;
                        searchResults.appendChild(a);
                    });
                } else {
                    searchResults.innerHTML = `<span class="dropdown-item text-center text-gray-500 py-3">Menu tidak ditemukan</span>`;
                }
                searchResults.style.display = 'block';
            } else {
                searchResults.style.display = 'none';
            }
        });

        // Hide when clicked outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
    }
});
</script>
@endpush
