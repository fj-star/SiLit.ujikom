<div class="card shadow-sm border-0 rounded-3 fade-in mb-4">
    <div class="card-header bg-warning fw-bold">
        <i class="fas fa-key me-2"></i> Update Password
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}" class="space-y-3">
            @csrf
            @method('put')

            <div class="mb-3">
                <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="form-control" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-danger mt-2" />
            </div>

            <div class="mb-3">
                <x-input-label for="update_password_password" :value="__('New Password')" />
                <x-text-input id="update_password_password" name="password" type="password" class="form-control" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="text-danger mt-2" />
            </div>

            <div class="mb-3">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-danger mt-2" />
            </div>

            <div class="d-flex align-items-center gap-3">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'password-updated')
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
