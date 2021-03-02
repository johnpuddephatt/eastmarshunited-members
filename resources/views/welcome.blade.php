<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-36 h-auto" />
            </a>
        </x-slot>
        <h3 class="text-xl font-bold my-4">Sign up</h3>
        <p>There are two ways to join East Marsh United – either as a member or as a supporter.</p>
        <p class="mt-2">To become a member you must be 16 or over, agree to our aims and pay £1. Becoming a supporter is open to anyone and is free, but you won’t be able to vote at our AGM or stand to be a director.</p>
        <x-button-link href="{{ route('register', ['type' => 'member']) }}" class="mt-6 w-100">
            Become a member
        </x-button-link>
        <x-button-link href="{{ route('register',  ['type' => 'supporter']) }}" class="mt-2 mb-4 w-100 block">
            Become a supporter
        </x-button>
    </x-auth-card>
</x-guest-layout>
