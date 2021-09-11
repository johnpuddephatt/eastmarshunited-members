<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-40 h-auto" />
            </a>
        </x-slot>
        <h3 class="my-4 text-2xl font-bold">Thank you</h3>
        <p class="mb-4">Your registration is complete, thank you for joining.</p>
        {{-- <x-button-link :href="route('dashboard')">Go to timebanking</x-button-link> --}}
    </x-auth-card>
</x-guest-layout>