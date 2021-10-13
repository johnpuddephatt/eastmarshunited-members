<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-40 h-auto" />
            </a>
        </x-slot>
        <h3 class="my-4 text-2xl font-bold">Sign up</h3>
        <p>There are two ways to join East Marsh United – either as a member or as a supporter.</p>
        <x-button-link href="{{ route('register.type', ['type' => 'member']) }}" class="mt-6 w-100">
            <h3 class="text-xl">Become a member</h3>
            <p class="font-normal normal-case">If you’re 16 or over you can become a
                member – just £1 buys you a share in the EMU organisation.</p>
        </x-button-link>
        <x-button-link href="{{ route('register.type',  ['type' => 'supporter']) }}" class="block mt-3 mb-4 w-100">
            <h3 class="text-xl">Become a supporter</h3>
            <p class="font-normal normal-case">Under 16 or want to show support without becoming a member? Become a
                supporter.
                You’ll still
                receive updates from us and be able to get involved in our work, plus you can convert to full membership
                at a later date.</p>
            </x-button>

            <p>If you’re a community organisation wanting to use time banking, <a class="underline"
                    href="{{ route('register.type',  ['type' => 'organisation']) }}">register here</a>.</p>

            <div class="pt-3 mt-4 border-t">
                Already registered? <a class="underline" href="{{ route('login') }}">Sign in</a>
            </div>
    </x-auth-card>
</x-guest-layout>