@extends('layouts.main')

@section('title', 'Profile')

@section('content')
<div class="py-4">
    <h2 class="h4 mb-4 text-gray-800">Profile Saya</h2>

    <div class="row">
        {{-- Update Profile Information --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 rounded-3 fade-in">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-user-edit me-1"></i> Update Profile
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 rounded-3 fade-in">
                <div class="card-header bg-warning text-dark fw-bold">
                    <i class="fas fa-key me-1"></i> Update Password
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>

    {{-- Delete User --}}
    {{-- <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow border-0 rounded-3 fade-in">
                <div class="card-header bg-danger text-white fw-bold">
                    <i class="fas fa-trash-alt me-1"></i> Hapus Akun
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@push('styles')
<style>
    /* Animasi Fade */
    .fade-in { opacity: 0; transform: translateY(15px); animation: fadeInUp .6s forwards ease-in-out; }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

    /* Tombol Animasi */
    .btn {
        transition: all 0.25s ease-in-out;
        border-radius: 8px;
    }
    .btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }
    .btn:active {
        transform: scale(0.95);
    }
</style>
@endpush
