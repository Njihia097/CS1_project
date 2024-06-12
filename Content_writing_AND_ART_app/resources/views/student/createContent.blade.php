<x-app-layout>
Create new Stories from here!
    <div class="flex justify-center">
    <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
        
            <div>
                <x-label for="name" value="{{ __('Title') }}" />
                <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>
        
    </div>
    </div>
</x-app-layout>