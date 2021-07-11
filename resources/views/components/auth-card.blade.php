<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 bg-background-lines bg-contain bg-no-repeat bg-center">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-8 py-6 bg-white shadow-md overflow-hidden">
        {{ $slot }}
    </div>
</div>
