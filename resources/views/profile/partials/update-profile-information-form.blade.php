<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Foto de Perfil -->
        <div>
            <x-input-label for="profile_photo" value="Foto de Perfil" />
            <div class="mt-2 flex items-center gap-4">
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto de perfil" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px; font-size: 32px;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <div class="flex-grow-1">
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/jpg,image/png,image/webp" class="form-control">
                    <p class="text-sm text-gray-600 mt-1">JPEG, PNG ou WEBP. Máximo 2MB.</p>
                    @if($user->profile_photo_path)
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="remove_photo" name="remove_photo" value="1">
                            <label class="form-check-label text-sm" for="remove_photo">
                                Remover foto atual
                            </label>
                        </div>
                    @endif
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <x-alert type="success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </x-alert>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <x-alert type="success">
                    {{ __('Saved.') }}
                </x-alert>
            @endif
        </div>
    </form>
</section>