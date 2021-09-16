<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-40 h-auto" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h3 class="my-4 text-2xl font-bold">Join as @if($type != 'organisation') a @else an @endif{{ $type }}</h3>


            <input name="membership_type" type="hidden" value="{{ $type }}" />

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required
                    autofocus />
            </div>

            <!-- Date of birth -->

            @if($type != 'organisation')
            <div class="mt-4">
                <x-label for="date_of_birth" :value="__('Date of birth')" />

                <x-input id="date_of_birth" class="block w-full mt-1" type="date" name="date_of_birth"
                    :value="old('date_of_birth') ?? '1980-01-01'" />
            </div>
            @endif

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block w-full mt-1" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            {{-- <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block w-full mt-1"
                                type="password"
                                name="password_confirmation" required />
            </div> --}}

            @if(isset($_GET['type']) && $_GET['type'] == 'member')
            <div class="flex mt-4">
                <x-input id="agree" class="mr-2" type="checkbox" name="agree" required />
                <x-label for="agree">
                    I agree to East Marsh United’s <a class="text-blue-600 underline"
                        href="https://eastmarshunited.org/join#more-information" target="_blank">membership rules</a>
                </x-label>
            </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                {{-- <a class="text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
                </a> --}}

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>