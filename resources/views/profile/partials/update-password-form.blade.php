<section>
    <p class="text-muted mb-4">
        Certifique-se de usar uma senha longa e aleatória para manter sua conta segura.
    </p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Senha Atual</label>
            <input type="password" 
                   id="update_password_current_password" 
                   name="current_password" 
                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                   autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">Nova Senha</label>
            <input type="password" 
                   id="update_password_password" 
                   name="password" 
                   class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                   autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Confirmar Senha</label>
            <input type="password" 
                   id="update_password_password_confirmation" 
                   name="password_confirmation" 
                   class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                   autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-shield-check me-1" aria-hidden="true"></i> Atualizar Senha
            </button>

            @if (session('status') === 'password-updated')
                <div class="alert alert-success mt-3 mb-0">
                    <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i>Senha atualizada com sucesso!
                </div>
            @endif
        </div>
    </form>
</section>