<div class="card shadow-sm border-0 rounded-3 fade-in">
    <div class="card-header bg-danger text-white fw-bold">
        <i class="fas fa-trash-alt me-2"></i> Delete Account
    </div>
    <div class="card-body">
        <p class="text-muted">
            {{ __('Once your account is deleted, all data will be permanently removed. Please download any data you want to keep.') }}
        </p>

        <button class="btn btn-danger" 
            x-data 
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            <i class="fas fa-exclamation-triangle me-1"></i> {{ __('Delete Account') }}
        </button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                @csrf
                @method('delete')

                <h5 class="fw-bold text-danger mb-2">{{ __('Are you sure?') }}</h5>
                <p class="text-muted mb-3">
                    {{ __('This action cannot be undone. Please confirm by entering your password.') }}
                </p>

                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" class="form-control" placeholder="••••••••" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="text-danger mt-2" />
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <x-secondary-button x-on:click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
                    <x-danger-button>{{ __('Delete Permanently') }}</x-danger-button>
                </div>
            </form>
        </x-modal>
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
