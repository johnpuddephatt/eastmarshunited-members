@props(['value'])

<label {{ $attributes->merge(['class' => 'flex items-center font-medium text-sm text-gray-700']) }}>
    {!! $slot !!}
    {!! $value ?? '' !!}
</label>
