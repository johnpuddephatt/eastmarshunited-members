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

            @if(isset($_GET['type']))
                <h3 class="text-2xl font-bold my-4">Become a {{ $_GET['type'] }}</h3>
            @endif

            <select @if(isset($_GET['type'])) hidden @endif class="w-full" name="membership_type">
                <option @if(isset($_GET['type']) && $_GET['type'] == 'member') selected @endif value="member">Member</option>
                <option @if(isset($_GET['type']) && $_GET['type'] == 'supporter') selected @endif value="supporter">Supporter</option>
            </select>

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Date of birth -->
            <div class="mt-4">
                <x-label for="date_of_birth" :value="__('Date of birth')" />

                <x-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            {{-- <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div> --}}

            @if(isset($_GET['type']) && $_GET['type'] == 'member')
                <div class="mt-4 flex">
                    <x-input id="agree" class="mr-2"
                                    type="checkbox"
                                    name="agree"
                                    required />
                    <x-label for="agree">
                        I agree to East Marsh United’s <a class="text-blue-600 underline" href="https://eastmarshunited.org/join#more-information" target="_blank">membership rules</a>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a> --}}

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
