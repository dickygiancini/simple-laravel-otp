@extends('layouts.app')

@section('title', 'Add Access to Users')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
                This is a special pages only for a privileged users! If you are not a privileged user but can access this page, kindly report to developers.
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Roles</th>
                            <th>Access</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td width="5%">{{ $loop->index + 1 }}</td>
                                <td width="15%">{{ $role->name }}</td>
                                <td>
                                    <div class="d-flex flex-row">
                                        @foreach ($role->access as $access)
                                            <div class="dropdown mx-2">
                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                                    {{ $access->route_name }}
                                                </a>

                                                <ul class="dropdown-menu">
                                                    <li class="dropdown-item d-flex justify-content-between align-items-center">
                                                        Access
                                                        <span class="badge bg-primary rounded-pill"><i class="fa-solid {{ $access->can_access ? 'fa-check' : 'fa-times' }}"></i></span>
                                                    </li>
                                                    <li class="dropdown-item d-flex justify-content-between align-items-center">
                                                        Create
                                                        <span class="badge bg-primary rounded-pill"><i class="fa-solid {{ $access->can_create ? 'fa-check' : 'fa-times' }}"></i></span>
                                                    </li>
                                                    <li class="dropdown-item d-flex justify-content-between align-items-center">
                                                        Modify
                                                        <span class="badge bg-primary rounded-pill"><i class="fa-solid {{ $access->can_update ? 'fa-check' : 'fa-times' }}"></i></span>
                                                    </li>
                                                    <li class="dropdown-item d-flex justify-content-between align-items-center">
                                                        Delete
                                                        <span class="badge bg-primary rounded-pill"><i class="fa-solid {{ $access->can_delete ? 'fa-check' : 'fa-times' }}"></i></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td width="10%" class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary edit-btn" data-coreui-toggle="modal" data-role-id="{{ $role->id }}" data-role="{{ $role->name }}" data-coreui-target="#exampleModal">
                                        <i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit
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
                <form action="{{ route('privileged.users.update') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="role_id" id="role-id" value="">
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Page</th>
                                                    <th class="text-center">Allow Access</th>
                                                    <th class="text-center">Allow Create</th>
                                                    <th class="text-center">Allow Modify</th>
                                                    <th class="text-center">Allow Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($routings as $routing)
                                                    <tr>
                                                        <input type="hidden" name="route_name[{{ $routing->getName() }}]" value="{{ $routing->getRouteTitle() }}">
                                                        <input type="hidden" name="route_alias[{{ $routing->getName() }}]" value="{{ $routing->getName() }}">
                                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                                        <td class="text-center">{{ $routing->getRouteTitle() }}</td>
                                                        <td class="text-center"><input id="can_access_{{ $routing->getName() }}" class="form-check-input mt-0" type="checkbox" name="can_access[{{ $routing->getName() }}]" value="false"></td>
                                                        <td class="text-center"><input id="can_create_{{ $routing->getName() }}" class="form-check-input mt-0" type="checkbox" name="can_create[{{ $routing->getName() }}]" value="false"></td>
                                                        <td class="text-center"><input id="can_update_{{ $routing->getName() }}" class="form-check-input mt-0" type="checkbox" name="can_update[{{ $routing->getName() }}]" value="false"></td>
                                                        <td class="text-center"><input id="can_delete_{{ $routing->getName() }}" class="form-check-input mt-0" type="checkbox" name="can_delete[{{ $routing->getName() }}]" value="false"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
        $('.edit-btn').on('click', function() {
            var roleName = $(this).data('role');
            var roleId = $(this).data('role-id');
            // Pass the roleName value to your modal or perform any other actions

            $('#exampleModalLabel').html('Edit Access For ' + roleName)
            $('#role-id').val(roleId)

            loadCheckboxes(roleId)
        });

        function loadCheckboxes(roleId) {
            axios.get('{{ route('privileged.users.checkRoles') }}', {
                params: {
                    role_id: roleId
                }
            })
            .then(response => {
                // Handle response
                let data = response.data
                processData(data)
            })
            .catch(error => {
                console.log(error)
            });
        }

        function processData(array) {
            for (let index = 0; index < array.length; index++) {
                const element = array[index];


                if(element.can_access) {
                    $('#can_access_'+element.route_alias).prop('checked', true)
                    $('#can_access_'+element.route_alias).val(true)
                }

                if(element.can_create) {
                    $('#can_create_'+element.route_alias).prop('checked', true)
                    $('#can_create_'+element.route_alias).val(true)
                }

                if(element.can_update) {
                    $('#can_update_'+element.route_alias).prop('checked', true)
                    $('#can_update_'+element.route_alias).val(true)
                }

                if(element.can_delete) {
                    $('#can_delete_'+element.route_alias).prop('checked', true)
                    $('#can_delete_'+element.route_alias).val(true)
                }
            }
        }
    });
</script>
@endsection
