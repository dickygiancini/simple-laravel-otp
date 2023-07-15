<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            {{ __('Dashboard') }}
        </a>
    </li>

    @if (in_array(auth()->user()->role->level, [1,2,3]))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('privileged.users.index') }}">
                {{ __('Add Access Pages') }}
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
                {{ __('Users') }}
            </a>
        </li>

        <li class="nav-group" aria-expanded="false">
            <a class="nav-link nav-group-toggle" href="#">
                Master
            </a>
            <ul class="nav-group-items" style="height: 0px;">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('privileged.master.status.index') }}" target="_top">
                        Master Status
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('approve.request.budget.index') }}">
                {{ __('Approval Request Budget') }}
            </a>
        </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('request.budget.index') }}">
            {{ __('Request Budget') }}
        </a>
    </li>

    {{-- <li class="nav-group" aria-expanded="false">
        <a class="nav-link nav-group-toggle" href="#">
            Two-level menu
        </a>
        <ul class="nav-group-items" style="height: 0px;">
            <li class="nav-item">
                <a class="nav-link" href="#" target="_top">
                    Child menu
                </a>
            </li>
        </ul>
    </li> --}}
</ul>
