@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pengaturan Profil</h1>

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-body text-center py-5">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center shadow mb-4" 
                         style="width: 140px; height: 140px; border: 5px solid #fff;">
                        <span class="text-white font-weight-bold" style="font-size: 4rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    
                    <h4 class="font-weight-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted text-uppercase small mb-4">
                        <span class="badge badge-primary px-3">{{ $user->role }}</span>
                    </p>
                    
                    <div class="text-left px-3">
                        <hr>
                        <div class="mb-2">
                            <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem;">WhatsApp</small>
                            <span class="text-dark">{{ $user->no_hp }}</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.65rem;">Email</small>
                            <span class="text-dark">{{ $user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Personal</h6>
                </div>
                <div class="card-body">
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Profil kamu berhasil diperbarui, bray! ✅
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror shadow-sm">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small">Email Aktif</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror shadow-sm">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small">Nomor WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="form-control @error('no_hp') is-invalid @enderror shadow-sm">
                                @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small">Tempat, Tanggal Lahir</label>
                                <input type="text" name="ttl" value="{{ old('ttl', $user->ttl) }}" class="form-control @error('ttl') is-invalid @enderror shadow-sm" placeholder="Contoh: Bandung, 20 Mei 2008">
                                @error('ttl') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="font-weight-bold small">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror shadow-sm">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4 border-left-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="m-0 font-weight-bold text-danger">Keamanan Akun</h6>
                            <p class="text-muted small mb-0">Disarankan ganti password secara berkala biar aman bray.</p>
                        </div>
                        <a href="{{ route('profile.edit') }}#update-password" class="btn btn-outline-danger btn-sm">Ganti Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection