<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Mot de passe')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm hover:text-gray-900" style="color:#fcd45d" 
                     href="{{ route('password.request') }}">
                        {{ __('Mot de passe Oublié ?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end mt-4">


                <x-button class="ml-3">
                    {{ __('Se connecter') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
