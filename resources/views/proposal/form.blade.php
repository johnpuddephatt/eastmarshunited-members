<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            @if(isset($proposal)) {{ __('Edit proposal') }} @else {{ __('Create something new') }} @endif
        </h2>
    </x-slot>

    <form method="POST"
        action="{{ isset($proposal) ? route('proposal.update', ['proposal' => $proposal]) : route('proposal.store') }}">
        @csrf

        <x-panel-card>
            {{-- <x-slot name="sidebar_right">

                <h2 class="mb-4 text-lg font-semibold leading-tight text-gray-800">
                    {{ __('Your balance') }}
            </h2>


            </x-slot> --}}
            <x-auth-validation-errors class="mb-4" :errors="$errors" />


            <div class="mb-3">
                <x-label for="title" :value="__('Title')" />
                <x-input id="title" class="block w-full mt-1" type="text" name="title"
                    :value="old('title') ?? (isset($proposal) ? $proposal->title : null)" />
            </div>

            <div class="mb-3">
                <x-label for="type" :value="__('Type')" />
                <x-select :value="old('type') ?? (isset($proposal) ? $proposal->type : 'ask')" name="type"
                    :options="$types" />
            </div>



            <div class="mb-3">
                <x-label for="type" :value="__('Category')" />
                <x-multiselect name="categories" :options="$categories"
                    :value="old('categories') ?? (isset($proposal) ? $proposal->categories : [])" />
            </div>

            <div>
                <x-label for="description" :value="__('Description')" />
                <x-textarea rows="6" id="description" class="block w-full mt-1" name="description">
                    {{ old('description') ??  (isset($proposal) ? $proposal->description : null) }}
                </x-textarea>
            </div>

            <div class="mt-4 md:space-x-4 md:flex">
                <div class="mb-3">
                    <x-label for="places" :value="__('Number of people')" />
                    <x-input id="places" class="block w-full mt-1" type="number" name="places"
                        :value="old('places') ?? (isset($proposal) ? $proposal->places : null)" />
                </div>

                <div class="mb-3">
                    <x-label for="hours" :value="__('Hours per person')" />
                    <x-input id="hours" class="block w-full mt-1" type="number" name="hours"
                        :value="old('hours') ?? (isset($proposal) ? $proposal->hours : null)" />
                </div>
            </div>

            <x-slot name="footer">
                <x-button>
                    {{ __('Save') }}
                </x-button>
            </x-slot>
        </x-panel-card>

    </form>



</x-app-layout>