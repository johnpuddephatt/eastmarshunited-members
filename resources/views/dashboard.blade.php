<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
        <div class="flex items-center">
            <span>Credits: {{ \Auth::user()->type == 'organisation' ? 'unlimited' : \Auth::user()->credits }}</span>
            <x-button-link class="py-2 ml-4" :href="route('proposal.create')">Add new</x-button-link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                @foreach($proposals as $proposal)
                <div class="flex items-center p-6 bg-white border-b border-gray-200">
                    <h3 class="mr-auto text-lg font-bold">{{ $proposal->title}}</h3>

                    @if($proposal->categories)
                    <div class="mr-3">
                        @foreach($proposal->categories as $category)
                        <x-badge type="info" :text="$category->name" />
                        @endforeach
                    </div>
                    @endif

                    @if(Auth::id() == $proposal->user->id)
                    <div class="mr-3">
                        <x-badge type="warning" text="Yours" />
                    </div>
                    @endif


                    <x-button-link href="{{ route('proposal.show', ['proposal' => $proposal->id ]) }}">view
                    </x-button-link>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>