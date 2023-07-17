@extends('layouts.guest')

@section('content')
    <div class="col-md-6">
        <div class="card mb-4 mx-4">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item text-end" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-account-logout') }}"></use>
                        </svg>
                        {{ __('Logout') }}
                    </a>
                </form>
                <h1>{{ __('It seems that you are not verified!') }}</h1>

                @if (session('error'))
                    <div class="alert alert-success" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="text-medium-emphasis">{{ __('Before proceeding, please check your email for an OTP') }}. {{ __('Please enter the OTP below from the email and submit to finish your verification process') }}</p>

                <form action="{{ route('verification.verify') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fa-regular fa-user"></i>
                                </div>
                                <input class="form-control @error('otp') is-invalid @enderror" type="text" name="otp" placeholder="{{ __('OTP') }}" required autofocus oninput="validatePin(this)">
                                @error('otp')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-block btn-success text-white" type="submit">{{ __('Verify') }}</button>
                        </div>
                    </div>
                </form>

                <form id="resubmit-mail">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary"
                                    type="submit"><i class="fa-regular fa-paper-plane"></i>&nbsp;{{ __('Click here to request another') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById("resubmit-mail");

            form.addEventListener("submit", function(event) {
                event.preventDefault();

                axios.get('{{ route('verification.resend') }}')
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'We have sent a new email containing your new OTP! Check your inbox/spam',
                            showCloseButton: true,
                            timer: 1500
                        })
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.data.message,
                            showCloseButton: true,
                            timer: 1500
                        })
                    })
            })

        })

        function validatePin(input) {
            const pin = input.value.trim()

            if(pin.length > 6) {
                input.value = pin.slice(0, 6)
                return
            }

            const numericPin = pin.replace(/\D/g, '');
            input.value = numericPin;
        }
    </script>

@endsection
