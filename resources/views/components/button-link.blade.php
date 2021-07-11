<a
    {{ $attributes->merge(['href' => '', 'class' => ' text-gray-700 lowercase antialiased font-bold block px-4 pt-1.5 pb-2 border-2 border-green-600 focus:outline-none focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>