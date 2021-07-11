@props(['value' => null])
<div x-data="{photoName: null, photoPreview: null }" class="mb-4">
    <!-- Photo File Input -->
    <input name="photo" type="file" capture="user" accept="image/png, image/jpeg" capture="" class="hidden"
        x-ref="photo" x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
    ">

    <label class="block mb-2 text-sm text-gray-700" for="photo">
        Profile Photo <span class="text-red-600"> </span>
    </label>

    <div class="text-center">
        <!-- Current Profile Photo -->
        @if(isset($value))
        <div class="mt-4" x-show="!photoPreview">
            <img src="{{ $value }}" class="w-32 h-32 m-auto rounded-full shadow">
        </div>
        @else
        <div class="mt-4" x-show="!photoPreview">
            <img src="https://eu.ui-avatars.com/api/?name={{ Auth::user()->name }}&background=26983c&color=fff"
                class="w-32 h-32 m-auto rounded-full shadow">
        </div>
        @endif

        <!-- New Profile Photo Preview -->
        <div class="mt-4" x-show="photoPreview" style="display: none;">
            <span class="block w-32 h-32 m-auto rounded-full shadow"
                x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'"
                style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
            </span>
        </div>
        <button type="button"
            class="inline-flex items-center px-4 py-2 mt-2 text-xs text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50"
            x-on:click.prevent="$refs.photo.click()">
            Select New Photo
        </button>
    </div>
</div>