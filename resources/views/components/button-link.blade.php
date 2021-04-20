<a {{ $attributes->merge(['href' => '', 'class' => 'block px-4 py-4 border-2 border-green-600 rounded-md text-lg font-semibold text-green-700 hover:text-white hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
