<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonColor: "#3085d6"
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Swal.fire({
                title: "Oops!",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonColor: "#d33"
            });
        });
    </script>
@endif
