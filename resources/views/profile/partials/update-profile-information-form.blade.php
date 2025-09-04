<div class="card shadow-sm border-0 rounded-3 fade-in mb-4">
    <div class="card-header bg-primary text-white fw-bold">
        <i class="fas fa-user me-2"></i> Profile Information
    </div>
    <div class="card-body">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-3">
            @csrf
            @method('patch')

            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="form-control"
                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2 text-danger" :messages="$errors->get('name')" />
            </div>

            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="form-control"
                    :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <small class="text-warning">{{ __('Your email address is unverified.') }}</small>
                        <button form="send-verification" class="btn btn-link p-0">
                            {{ __('Click here to re-send verification.') }}
                        </button>
                    </div>
                @endif
            </div>

            <div class="d-flex align-items-center gap-3">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <span class="badge bg-success fade-in">✔ Saved</span>
                @endif
            </div>
        </form>
    </div>
</div>
@push('styles')
<style>
.fade-in { opacity:0; transform: translateY(10px); animation: fadeInUp .5s forwards ease; }
@keyframes fadeInUp { to { opacity:1; transform:translateY(0);} }
.btn { transition: all 0.2s ease-in-out; }
.btn:hover { transform: translateY(-2px) scale(1.03); box-shadow:0 4px 12px rgba(0,0,0,0.15); }
</style>
@endpush
