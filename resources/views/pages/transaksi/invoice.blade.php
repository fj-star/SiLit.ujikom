<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstaWash</title>
    <!-- Tailwind untuk UI cepat dan rapi saat diprint -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: white !important;}
            .no-print { display: none !important; }
            #invoice { box-shadow: none !important; width: 100% !important; max-width: 100% !important; }
            /* Memotong margin bawaan kertas browser jika bisa */
            @page { margin: 0; }
        }
        body { font-family: 'Courier New', Courier, monospace; }
    </style>
</head>
<body class="bg-gray-200 flex justify-center py-6 md:py-10">

    <div class="bg-white p-6 md:p-8 w-full max-w-sm md:max-w-md shadow-2xl rounded" id="invoice">
        <!-- Logo and Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold tracking-widest uppercase mb-1">InstaWash Laundry</h1>
            <p class="text-xs text-gray-600">Jl. Raya Bandung No.117, Ciranjang, Cianjur</p>
            <p class="text-xs text-gray-600 mb-2">WhatsApp: 0838-7330-4630</p>
            <div class="border-b-2 border-dashed border-gray-400 my-4"></div>
            <h2 class="font-bold text-lg tracking-widest">INVOICE</h2>
        </div>

        <!-- Meta Data -->
        <div class="mb-4 text-sm mt-4">
            <div class="flex justify-between mb-1">
                <span>Pelanggan:</span>
                <span class="font-bold">
                    @if($transaksi->pelanggan)
                        {{ $transaksi->pelanggan->name }}
                    @elseif($transaksi->nama_tamu)
                        {{ $transaksi->nama_tamu }}
                    @else
                        Guest
                    @endif
                </span>
            </div>
        </div>
        
        <div class="border-b-2 border-dashed border-gray-400 my-4"></div>

        <!-- Items -->
        <div class="text-sm">
            <div class="font-bold mb-2">Rincian Layanan:</div>
            
            <div class="flex justify-between mb-2">
                <div>
                    {{ $transaksi->layanan->nama_layanan ?? '-' }} <br>
                    <small>Rp{{ number_format($transaksi->layanan->harga ?? 0, 0, ',', '.') }} x {{ $transaksi->berat }} kg</small>
                </div>
                <div class="mt-4">Rp{{ number_format(($transaksi->layanan->harga ?? 0) * $transaksi->berat, 0, ',', '.') }}</div>
            </div>

            @if($transaksi->treatment)
            <div class="flex justify-between mb-2 mt-4">
                <div>
                    (+) {{ $transaksi->treatment->nama_treatment }} <br>
                    @if($transaksi->treatment->diskon > 0)
                        <small class="text-red-500">Diskon {{ $transaksi->treatment->diskon }}%</small>
                    @endif
                </div>
                @php
                    $treatment_harga = $transaksi->treatment->harga;
                    if($transaksi->treatment->diskon > 0) {
                        $treatment_harga -= ($treatment_harga * ($transaksi->treatment->diskon / 100));
                    }
                @endphp
                <div class="mt-4">Rp{{ number_format($treatment_harga, 0, ',', '.') }}</div>
            </div>
            @endif
        </div>

        <div class="border-b-2 border-dashed border-gray-400 my-4"></div>

        <!-- Total -->
        <div class="text-sm mb-6">
            <div class="flex justify-between font-bold text-lg">
                <span>TOTAL TAGIHAN:</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-500 mt-8 mb-4 border-t-2 border-dashed border-gray-400 pt-4">
            <p class="font-bold mb-1">Terima kasih atas kepercayaannya!</p>
            <p>Barang yang tidak diambil lebih dari 30 hari bukan tanggung jawab kami.</p>
        </div>

        <!-- Action / Print Button -->
        <div class="mt-8 text-center no-print">
            @if($isPrint)
                <button onclick="window.print()" class="bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 shadow-lg w-full mb-3">
                    🖨️ Cetak Struk
                </button>
            @endif
            <button onclick="window.history.back()" class="bg-gray-400 text-white font-bold py-3 px-6 rounded-lg hover:bg-gray-500 shadow-lg w-full">
                Kembali
            </button>
        </div>
    </div>

    @if($isPrint)
    <script>
        // Otomatis menampilkan dialog print jika tombol cetak tersedia
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
    @endif
</body>
</html>
