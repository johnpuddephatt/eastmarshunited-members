<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Complete your profile') }}
        </h2>
    </x-slot>

    <form method="POST" enctype="multipart/form-data" action="{{ route('profile.store') }}">
        @csrf

        <x-panel-card>
            <x-slot name="sidebar">

                <h2 class="mb-4 text-lg font-semibold leading-tight text-gray-800">
                    {{ __('About you') }}
                </h2>
                <x-image-upload :value="Auth::user()->photo" />

                <!-- Phone -->
                <div>
                    <x-label for="phone" :value="__('Phone number')" />
                    <x-input id="phone" class="block w-full mt-1" type="text" name="phone"
                        :value="old('phone') ?? Auth::user()->phone" />
                </div>

                <!-- Introduction -->
                <div class="mt-4">
                    <x-label for="description" :value="__('Introduce yourself')" />

                    <x-textarea id="description" class="block w-full mt-1" type="date" name="description">
                        {{ old('description') ?? Auth::user()->description }}
                    </x-textarea>
                </div>


            </x-slot>

            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            @if(Auth::user()->type != 'organisation')
            <h2 class="mb-4 text-lg font-semibold leading-tight text-gray-800">
                {{ __('Things you can help with') }}
            </h2>

            @foreach($categories as $category)
            <x-label class="mt-2" :for="$category->id" :value="$category->name">
                <x-input :id="$category->id" class="block mr-2" type="checkbox" name="category[{{$category->id}}]"
                    :checked="old('category[$category->id]') || Auth::user()->categories->where('id', $category->id)->first()" />
            </x-label>
            @endforeach

            @endif


            <x-slot name="footer">
                <x-button>
                    {{ __('Save and visit dashboard') }}
                </x-button>
            </x-slot>
        </x-panel-card>

    </form>



</x-app-layout>