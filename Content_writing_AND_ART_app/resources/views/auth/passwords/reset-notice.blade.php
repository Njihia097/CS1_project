<x-guest-layout>
    @section('content')

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Password Setup Required') }}</div>

                        <div class="card-body">
                            <p>{{ __('Your email has been verified. A password setup link has been sent to your email address. Please check your email and follow the instructions to set up your password.') }}</p>
                            <p>{{ __('If you did not receive the email') }}, <a href="{{ route('password.request') }}">{{ __('click here ') }}</a>, {{__('to request another')}}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-guest-layout>