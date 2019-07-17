<div id="zapAdminMenuBg"></div>
<div id="zapAdminMenuWrap" class="zap-sidebar">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <ul class="nav flex-column">
        <div class="zap-user-info">
            <div class="zap-image">
                @auth()
                @if (!empty(auth()->user()->employee->profile_img))
                <img src="{{ asset('storage/uploaded/'.auth()->user()->employee->profile_img) }}" border="0" width="48" class="img-circle">
                @else
                <img src="http://sximo5.sximoinc.com/uploads/users/1.jpg" border="0" width="48" class="img-circle">
                @endif
                @endauth
            </div>
            <div class="zap-info-wrap">
                @auth()
                @if (!empty(auth()->user()->employee))
                <div class="name">{{ auth()->user()->employee->first_name }}</div>
                <div class="position">{{ auth()->user()->employee->positions->position }}</div>
                @else
                <div class="name">Link your</div>
                <div class="position">employee ID first.</div>
                @endif
                @endauth
            </div>
        </div>
        <li class="nav-item"><a href="{{ route('dashboard.main') }}" class="nav-link @yield('overview')">OverView</a></li>
        {{-- For HR --}}
        @if (Gate::check('isAdmin') || Gate::check('isHr'))
            <li class="nav-item"><a href="{{ route('hr.dep.department') }}" class="nav-link @yield('reg_dep')">Department</a></li>
            <li class="nav-item"><a href="{{ route('hr.pos.position') }}" class="nav-link @yield('reg_pos')">Position</a></li>
            <li class="nav-item"><a href="{{ route('hr.employees') }}" class="nav-link @yield('employees')">Employees</a></li>
            <li class="nav-item"><a href="{{ route('hr.emp.emp_form') }}" class="nav-link @yield('reg_emp')">Add Employee</a></li>
        @endif
        {{-- For ADMIN, HR, DOCTOR, NURSE --}}
        @if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor'))
            <li class="nav-item"><a href="{{ route('brandname') }}" class="nav-link @yield('brandname')">Brand Name</a></li>
            <li class="nav-item"><a href="{{ route('medicine') }}" class="nav-link @yield('medicine')">Medicines</a></li>
        @endif
        {{-- For Admin --}}
        @if(Gate::check('isAdmin'))
            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link @yield('register')">Register User</a></li>
            <li class="nav-item"><a href="{{ route('dashboard.userRoles') }}" class="nav-link @yield('userRoles')">User Roles</a></li>
            <li class="nav-item"><a href="{{ route('dashboard.roles') }}" class="nav-link @yield('roles')">Roles</a></li>
        @endif
        {{-- For All Users --}}
        @auth()
        @if (!empty(auth()->user()->employee))
            <li class="nav-item"><a href="{{ route('employee', ['employee' => auth()->user()->employee->id]) }}"  class="nav-link @yield('employee')">Profile</a></li>
        @else
            <li class="nav-item"><a href="{{ route('employees') }}"  class="nav-link @yield('employee')">Profile</a></li>
        @endif
        @endauth
    </ul>
</div>
<div class="col-md-3 d-none">
    <div class="card">
        <div class="card-header">Dashboards</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="list-group">
                <a href="{{ route('dashboard.main') }}" class="list-group-item list-group-item-action @yield('overview')">OverView</a>
                {{-- For HR --}}
                @if (Gate::check('isAdmin') || Gate::check('isHr'))
                    <a href="{{ route('hr.dep.department') }}" class="list-group-item list-group-item-action @yield('reg_dep')">Department</a>
                    <a href="{{ route('hr.pos.position') }}" class="list-group-item list-group-item-action @yield('reg_pos')">Position</a>
                    <a href="{{ route('hr.employees') }}" class="list-group-item list-group-item-action @yield('employees')">Employees</a>
                    <a href="{{ route('hr.emp.emp_form') }}" class="list-group-item list-group-item-action @yield('reg_emp')">Add Employee</a>
                @endif
                {{-- For ADMIN, HR, DOCTOR, NURSE --}}
                @if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor'))
                    <li class="nav-item"><a href="{{ route('brandname') }}" class="nav-link @yield('brandname')">Brand Name</a></li>
                @endif
                {{-- For Admin --}}
                @if(Gate::check('isAdmin'))
                    <a href="{{ route('register') }}" class="list-group-item list-group-item-action @yield('register')">Register User</a>
                    <a href="{{ route('dashboard.userRoles') }}" class="list-group-item list-group-item-action @yield('userRoles')">User Roles</a>
                    <a href="{{ route('dashboard.roles') }}" class="list-group-item list-group-item-action @yield('roles')">Roles</a>
                @endif
                {{-- For All Users --}}
                @auth()
                @if (!empty(auth()->user()->employee))
                    <a href="{{ route('employee', ['employee' => auth()->user()->employee->id]) }}"  class="list-group-item list-group-item-action @yield('employee')">Profile</a>
                @else
                    <a href="{{ route('employees') }}"  class="list-group-item list-group-item-action @yield('employee')">Profile</a>
                @endif
                @endauth
            </div>
            
        </div>
    </div>
</div>