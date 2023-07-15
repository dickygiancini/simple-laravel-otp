@extends('layouts.app')

@section('title', 'Add Access to Users')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @error('balance')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror

            @error('pin')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-12">
            <span class="badge rounded-pill text-bg-primary">Current Balance : {{ auth()->user()->balance->balance }}</span>
        </div>

        <div class="col-md-12 mt-5">
            <div class="col-md-12 d-flex justify-content-between mb-3">
                <h3>History</h3>
                <button class="btn btn-success text-white" data-coreui-toggle="modal" data-coreui-target="#exampleModal">
                    New Request
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Balance Requested</th>
                            <th>Status</th>
                            <th>Date Requested</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($datas) == 0)
                            <td colspan="4">No Transcation History Made</td>
                        @endif
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->balance }}</td>
                                <td>{{ $data->status->name }}</td>
                                <td>{{ $data->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal modal-lg fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Request</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('request.budget.create') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Balance</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                        <input class="form-control" type="text" name="balance" oninput="formatRupiah(this)" placeholder="{{ __('Balance Requested') }}" required autofocus>
                                        @error('balance')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">PIN</label>
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
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal" aria-label="Close">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    var modal = document.getElementById('exampleModal');

    modal.addEventListener('hidden.coreui.modal', function () {
        var inputs = modal.querySelectorAll('.modal-body input');
        inputs.forEach(function (input) {
            input.value = '';
        });
    });

    function validatePin(input) {
        const pin = input.value.trim()

        if(pin.length > 6) {
            input.value = pin.slice(0, 6)
            return
        }

        const numericPin = pin.replace(/\D/g, '');
        input.value = numericPin;
    }

    function formatRupiah(input) {
        // Remove non-numeric characters
        const numericValue = input.value.replace(/[^\d]/g, '');

        // Format the numeric value as Rupiah
        const formattedValue = new Intl.NumberFormat('id-ID', { style: 'decimal', currency: 'IDR', minimumFractionDigits: 0 }).format(numericValue);

        input.value = formattedValue
    }
</script>
@endsection
