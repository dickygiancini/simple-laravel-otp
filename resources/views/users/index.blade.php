@extends('layouts.app')

@section('title', 'Registered Users')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Users') }}
        </div>

        {{-- <div class="alert alert-info" role="alert">Sample table page</div> --}}

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">Email</th>
                    <th scope="col" class="text-center">Date Created</th>
                    <th scope="col" class="text-center">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">{{ $user->created_at }}</td>
                        <td class="text-center">
                            @if ($user->is_verified)
                                <span class="badge text-bg-success text-white">Verified</span>
                            @else
                                <span class="badge text-bg-danger text-white">Not Verified</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
@endsection
