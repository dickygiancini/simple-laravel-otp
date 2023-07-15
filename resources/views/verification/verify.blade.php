@extends('layouts.guest')

@section('content')
    <div class="col-md-6">
        <div class="card mb-4 mx-4">
            <div class="card-body p-4">
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
                                <input class="form-control" type="number" name="otp" placeholder="{{ __('OTP') }}" required autofocus>
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
    </script>

@endsection
