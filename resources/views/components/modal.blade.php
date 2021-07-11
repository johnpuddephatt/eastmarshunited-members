@props(['title'])

<div class="fixed inset-0 top-0 left-0 z-50 flex items-center justify-center h-screen bg-center bg-no-repeat bg-cover outline-none min-w-screen animated fadeIn faster focus:outline-none"
    id="modal-id">
    <div class="absolute inset-0 z-0 bg-black opacity-80"></div>
    <div class="relative w-full max-w-lg p-5 mx-auto my-auto bg-white shadow-lg">
        <div class="p-5">
            <h2 class="py-4 text-xl font-bold ">{{ $title ?? 'Confirm' }}</h3>
                {!! $slot !!}
        </div>
    </div>
</div>