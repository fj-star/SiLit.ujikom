@extends('layouts.main')
@section('content')
<div class="container-fluid px-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Transaksi Baru</h1>
        <a href="{{ route('admin.transaksi.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Transaksi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transaksi.store') }}" method="POST" id="createTransaksiForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id">Pelanggan <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach($pelanggans as $p)
                                            <option value="{{ $p->id }}" {{ old('user_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->name }} ({{ $p->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="layanan_id">Layanan <span class="text-danger">*</span></label>
                                    <select name="layanan_id" id="layanan_id" class="form-control @error('layanan_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Layanan --</option>
                                        @foreach($layanans as $l)
                                            <option value="{{ $l->id }}" data-harga="{{ $l->harga }}" {{ old('layanan_id') == $l->id ? 'selected' : '' }}>
                                                {{ $l->nama_layanan }} - Rp {{ number_format($l->harga, 0, ',', '.') }}/kg
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('layanan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="treatment_id">Treatment (Opsional)</label>
                                    <select name="treatment_id" id="treatment_id" class="form-control @error('treatment_id') is-invalid @enderror">
                                        <option value="">-- Tanpa Treatment --</option>
                                        @foreach($treatments as $t)
                                            <option value="{{ $t->id }}" data-harga="{{ $t->harga }}" data-diskon="{{ $t->diskon }}" {{ old('treatment_id') == $t->id ? 'selected' : '' }}>
                                                {{ $t->nama_treatment }} - Rp {{ number_format($t->harga, 0, ',', '.') }} (Diskon: {{ $t->diskon }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('treatment_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="berat">Berat (kg) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="berat" id="berat" class="form-control @error('berat') is-invalid @enderror" 
                                               value="{{ old('berat') }}" step="0.1" min="0.1" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </div>
                                    @error('berat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="metode_pembayaran">Metode Pembayaran <span class="text-danger">*</span></label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-control @error('metode_pembayaran') is-invalid @enderror" required>
                                        <option value="">-- Pilih Metode --</option>
                                        @foreach(['cash' => 'Cash', 'transfer' => 'Transfer', 'ewallet' => 'E-Wallet'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('metode_pembayaran') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('metode_pembayaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach(['pending' => 'Pending', 'proses' => 'Proses', 'selesai' => 'Selesai'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Transaksi
                            </button>
                            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Card untuk menampilkan perhitungan harga -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Perhitungan Harga</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Harga Layanan/kg</td>
                                <td class="text-right">Rp <span id="harga-layanan">0</span></td>
                            </tr>
                            <tr>
                                <td>Berat</td>
                                <td class="text-right"><span id="berat-display">0</span> kg</td>
                            </tr>
                            <tr>
                                <td>Subtotal Layanan</td>
                                <td class="text-right">Rp <span id="subtotal-layanan">0</span></td>
                            </tr>
                            <tr>
                                <td>Harga Treatment</td>
                                <td class="text-right">Rp <span id="harga-treatment">0</span></td>
                            </tr>
                            <tr>
                                <td>Diskon Treatment</td>
                                <td class="text-right">- <span id="diskon-treatment">0</span>%</td>
                            </tr>
                            <tr>
                                <td>Diskon Tambahan (≥10kg & ≥Rp100.000)</td>
                                <td class="text-right">- <span id="diskon-tambahan">0</span>%</td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>Total Harga</td>
                                <td class="text-right">Rp <span id="total-harga">0</span></td>
                            </tr>
                        </table>
                    </div>
                    
                    <input type="hidden" name="total_harga" id="total_harga_input" value="{{ old('total_harga') }}">
                    
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle"></i> Total harga akan dihitung otomatis berdasarkan layanan, treatment, dan berat yang dipilih.
                    </div>
                </div>
            </div>
            
            <!-- Card Informasi Penting -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Penting</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Penting:</strong> Pastikan semua data yang diisi sudah benar sebelum menyimpan transaksi.
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Diskon Tambahan:</strong> Akan diberikan 10% jika berat ≥ 10kg dan total harga ≥ Rp100.000.
                    </div>
                    
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <strong>Status Transaksi:</strong> 
                        <ul class="mb-0 mt-2 pl-3">
                            <li><strong>Pending:</strong> Menunggu proses</li>
                            <li><strong>Proses:</strong> Sedang dalam proses pengerjaan</li>
                            <li><strong>Selesai:</strong> Transaksi selesai</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Fungsi untuk menghitung total harga
        function hitungTotalHarga() {
            var layananId = $('#layanan_id').val();
            var treatmentId = $('#treatment_id').val();
            var berat = parseFloat($('#berat').val()) || 0;
            
            var hargaLayanan = 0;
            var hargaTreatment = 0;
            var diskonTreatment = 0;
            var diskonTambahan = 0;
            
            // Ambil harga layanan
            if (layananId) {
                hargaLayanan = parseFloat($('#layanan_id option:selected').data('harga')) || 0;
            }
            
            // Ambil harga dan diskon treatment
            if (treatmentId) {
                hargaTreatment = parseFloat($('#treatment_id option:selected').data('harga')) || 0;
                diskonTreatment = parseFloat($('#treatment_id option:selected').data('diskon')) || 0;
            }
            
            // Hitung subtotal layanan
            var subtotalLayanan = hargaLayanan * berat;
            
            // Hitung total sebelum diskon
            var totalSebelumDiskon = subtotalLayanan + hargaTreatment;
            
            // Hitung diskon treatment
            var nilaiDiskonTreatment = 0;
            if (diskonTreatment > 0) {
                nilaiDiskonTreatment = totalSebelumDiskon * (diskonTreatment / 100);
            }
            
            // Hitung total setelah diskon treatment
            var totalSetelahDiskonTreatment = totalSebelumDiskon - nilaiDiskonTreatment;
            
            // Hitung diskon tambahan (10% jika berat >= 10kg dan total >= 100000)
            if (berat >= 10 && totalSetelahDiskonTreatment >= 100000) {
                diskonTambahan = 10;
            }
            
            var nilaiDiskonTambahan = totalSetelahDiskonTreatment * (diskonTambahan / 100);
            
            // Hitung total akhir
            var totalAkhir = totalSetelahDiskonTreatment - nilaiDiskonTambahan;
            
            // Update tampilan
            $('#harga-layanan').text(number_format(hargaLayanan, 0, ',', '.'));
            $('#berat-display').text(berat);
            $('#subtotal-layanan').text(number_format(subtotalLayanan, 0, ',', '.'));
            $('#harga-treatment').text(number_format(hargaTreatment, 0, ',', '.'));
            $('#diskon-treatment').text(diskonTreatment);
            $('#diskon-tambahan').text(diskonTambahan);
            $('#total-harga').text(number_format(totalAkhir, 0, ',', '.'));
            
            // Update input hidden
            $('#total_harga_input').val(totalAkhir);
        }
        
        // Fungsi format number
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (thousands_sep) {
                var re = /(-?\d+)(\d{3})/;
                while (re.test(s[0])) {
                    s[0] = s[0].replace(re, '$1' + thousands_sep + '$2');
                }
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
        
        // Event listener untuk perubahan input
        $('#layanan_id, #treatment_id, #berat').on('change', function() {
            hitungTotalHarga();
        });
        
        // Hitung total harga saat halaman dimuat
        hitungTotalHarga();
    });
</script>
@endsection