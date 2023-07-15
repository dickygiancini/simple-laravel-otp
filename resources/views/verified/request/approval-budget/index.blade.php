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

        <div class="col-md-12 mt-5">
            <div class="col-md-12 d-flex justify-content-between mb-3">
                <h3>Approval Request Budget</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Requestor</th>
                            <th>Balance Requested</th>
                            <th>Date Requested</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($datas) == 0)
                            <td colspan="4">No Transcation History Made</td>
                        @endif
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->user->name }}</td>
                                <td>{{ $data->balance }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td class="text-center">
                                    <button class="btn btn-success approve-btn text-white" data-id="{{ $data->id }}" data-status-id="2" data-status="Approve" data-coreui-toggle="modal" data-coreui-target="#exampleModal">
                                        <i class="fa-solid fa-thumbs-up"></i>
                                    </button>
                                    <button class="btn btn-danger approve-btn text-white" data-id="{{ $data->id }}" data-status-id="3" data-status="Reject" data-coreui-toggle="modal" data-coreui-target="#exampleModal">
                                        <i class="fa-solid fa-thumbs-down"></i>
                                    </button>
                                </td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Approve Request Budget</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('approve.request.budget.approve') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="request_id">
                                <input type="hidden" name="status_id" id="request_status">
                                Are you sure you want to <span id="status-selected"></span> this budget request?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal" aria-label="Close">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        // Your jQuery code goes here
        $('.approve-btn').on('click', function() {
            var statusName = $(this).data('status');
            var request_id = $(this).data('id');
            var request_status = $(this).data('status-id');
            // Pass the roleName value to your modal or perform any other actions

            $('#status-selected').html(statusName)
            $('#request_id').val(request_id)
            $('#request_status').val(request_status)
        });
    });
</script>
@endsection
