<div
    class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 bg-center bg-no-repeat bg-contain sm:justify-center sm:pt-0 bg-background-lines">
    <div
        class="md:grid gap-0 w-full bg-white shadow-md mt-16 mb-64 {{ (isset($sidebar) || isset($sidebar_right)) && $slot->toHtml() ? 'md:grid-cols-12 sm:max-w-3xl' : 'md:grid-cols-8 sm:max-w-xl' }}">
        @if(isset($sidebar))
        <div class="@if($slot->toHtml()) col-span-4 @else col-span-8 @endif px-6 py-6 bg-gray-50">
            {{ $sidebar }}
        </div>
        @endif

        @if($slot->toHtml())
        <div class="col-span-8 px-8 py-6">
            {{ $slot }}
        </div>
        @endif
        @if(isset($sidebar_right))
        <div class="col-span-4 px-6 py-6 bg-gray-50">
            {{ $sidebar_right }}
        </div>
        @endif
        @if(isset($footer))
        <div class="flex items-center justify-end col-span-12 px-8 py-3 bg-gray-100 border-t">
            {{ $footer }}
        </div>
        @endif
    </div>
</div>