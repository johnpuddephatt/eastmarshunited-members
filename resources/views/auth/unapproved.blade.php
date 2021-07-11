<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="h-auto w-36" />
            </a>
        </x-slot>
        <h3 class="my-4 text-2xl font-bold">You’re nearly there!</h3>
        <p class="mb-4">Your account needs to be manually approved. You’ll receive an email when your account
            is ready to use.</p>
        <p class="mb-4">If your account hasn’t been activated after three working days, please let us know.</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                {{ __('Logout') }}
            </x-responsive-nav-link>
        </form>
    </x-auth-card>
</x-guest-layout>