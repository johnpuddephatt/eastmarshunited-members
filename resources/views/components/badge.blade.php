@props(['type','text'])

<span x-data="{}" class="px-3 pb-0.5 ml-2 text-xs align-middle rounded-full"
    :class="{ 'bg-blue-200 text-blue-900' : '{{ $type }}' == 'info', 'bg-yellow-200 text-yellow-900' : '{{ $type }}' == 'warning', 'bg-green-200 text-green-900' : '{{ $type }}' == 'success' }">{{ $text }}</span>