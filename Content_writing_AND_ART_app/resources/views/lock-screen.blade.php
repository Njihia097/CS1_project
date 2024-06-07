<x-guest-layout>
   
        <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
            <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">

            <h2 class="text-lg font-extrabold text-center">Lock Screen</h2>
            
            
            @if (session('error'))
                <div class="mb-4 text-sm font-medium text-red-600">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('unlock') }}">
                @csrf
                
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus placeholder="Insert your currently logged in email to unlock" />
                </div>

                @if ($errors->has('email'))
                    <span class="mb-4 text-sm font-medium text-red-600">{{ $errors->first('email') }}</span>
                @endif

                <div class="flex flex-col items-center justify-end mt-4 space-y-4">

                    <x-button class="flex justify-center ms-4">
                        {{ __('Unlock') }}
                    </x-button>
                </div>
            </form>
            </div>
        </div>
    <script>
        // Prevent navigation back to previous page
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>
</x-guest-layout>
