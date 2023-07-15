@extends('layouts.guest')

@section('content')
    <div class="col-md-6">
        <div class="card mb-4 mx-4">
            <div class="card-body p-4">
                <h1 class="mb-3">Register</h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fa-regular fa-user"></i>
                                </div>
                                <input class="form-control" type="text" name="name" placeholder="{{ __('Name') }}" required
                                    autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <input class="form-control" type="text" name="email" placeholder="{{ __('Email') }}" required
                                    autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fa-solid fa-key"></i>
                                </div>
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    name="password" placeholder="{{ __('Password') }}" required>
                                @error('password')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-text">
                                    <i class="fa-solid fa-key"></i>
                                </div>
                                <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password"
                                    name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <input class="form-control @error('pin') is-invalid @enderror" type="password"
                                    id="pin" name="pin" placeholder="{{ __('PIN') }}" required oninput="validatePin(this)">
                                @error('pin')
                                <span class="invalid-feedback invalid-feedback-pin">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <input class="form-control @error('pin_confirmation') is-invalid @enderror" type="password"
                                    id="pin-confirmation" name="pin_confirmation" placeholder="{{ __('Confirm PIN') }}" required oninput="validatePinConfirmation(this)">
                                <p id="confirmPinError" style="color: red;"></p>
                            </div>
                        </div>

                        <button class="btn btn-block btn-success text-white" type="submit">{{ __('Register') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validatePin(input) {
            const pin = input.value.trim()

            if(pin.length > 6) {
                input.value = pin.slice(0, 6)
                return
            }

            const numericPin = pin.replace(/\D/g, '');
            input.value = numericPin;

            const pinInput = document.getElementById('pin');
            const confirmPinInput = document.getElementById('pin-confirmation');
            const confirmPinError = document.getElementById('confirmPinError');

            if(confirmPinInput.value) {
                if(confirmPinInput.value !== pinInput.value) {
                    confirmPinError.textContent = 'Confirm PIN does not match PIN';
                } else {
                    confirmPinError.textContent = '';
                }
            }

        }

        function validatePinConfirmation(input) {
            const pin = input.value.trim()

            if(pin.length > 6) {
                input.value = pin.slice(0, 6)
                return
            }

            const numericPin = pin.replace(/\D/g, '');
            input.value = numericPin;

            const pinInput = document.getElementById('pin');
            const confirmPinInput = document.getElementById('pin-confirmation');
            const confirmPinError = document.getElementById('confirmPinError');

            if(confirmPinInput.value !== pinInput.value) {
                confirmPinError.textContent = 'Confirm PIN does not match PIN';
            } else {
                confirmPinError.textContent = '';
            }
        }
    </script>
@endsection
