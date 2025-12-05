<section>
    <p class="text-muted mb-4">
        Atualize as informações de perfil e endereço de e-mail da sua conta.
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Foto de Perfil -->
        <div class="mb-4">
            <label class="form-label">Foto de Perfil</label>
            <div class="d-flex align-items-center gap-3">
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto de perfil" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px; font-size: 32px;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <div class="flex-grow-1">
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/jpg,image/png,image/webp" class="form-control @error('profile_photo') is-invalid @enderror">
                    <small class="text-muted">JPEG, PNG ou WEBP. Máximo 2MB.</small>
                    @error('profile_photo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @if($user->profile_photo_path)
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="remove_photo" name="remove_photo" value="1">
                            <label class="form-check-label small" for="remove_photo">
                                Remover foto atual
                            </label>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $user->name) }}" 
                   class="form-control @error('name') is-invalid @enderror" 
                   required 
                   autofocus 
                   autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email', $user->email) }}" 
                   class="form-control @error('email') is-invalid @enderror" 
                   required 
                   autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted small">
                        Seu endereço de e-mail não está verificado.

                        <button form="send-verification" class="btn btn-link p-0 text-decoration-none">
                            Clique aqui para reenviar o e-mail de verificação.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success alert-sm">
                            Um novo link de verificação foi enviado para seu e-mail.
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Salvar Alterações
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success mt-3 mb-0">
                    <i class="bi bi-check-circle-fill me-2"></i>Perfil atualizado com sucesso!
                </div>
            @endif
        </div>
    </form>
</section>