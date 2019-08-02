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
                    <img src="{{ url( '/images/default.png' ) }}" border="0" width="48" class="img-circle">
                @endif
                @endauth
            </div>
            <div class="zap-info-wrap">
                @auth()
                @if (!empty(auth()->user()->employee))
                <div class="name">{{ auth()->user()->employee->first_name }}</div>
                <div class="position">{{ auth()->user()->employee->positions->position }}</div>
                @else
                <div class="name">Employee Name</div>
                <div class="position">Employee Position</div>
                @endif
                @endauth
            </div>
        </div>
        <li class="nav-item"><a href="{{ route('dashboard.main') }}" class="nav-link @yield('overview')"><i class="fas fa-tachometer-alt"></i> <span class="collapse-label">Dashboard</span></a></li>
        {{-- For HR --}}
        @if (Gate::check('isAdmin') || Gate::check('isHr'))
            <li class="nav-item"><a href="{{ route('hr.dep.department') }}" class="nav-link @yield('reg_dep')"><i class="fas fa-building"></i> <span class="collapse-label">Department</span></a></li>
            <li class="nav-item"><a href="{{ route('hr.pos.position') }}" class="nav-link @yield('reg_pos')"><i class="fas fa-tasks"></i> <span class="collapse-label">Position</span></a></li>
            <li class="nav-item"><a href="{{ route('hr.employees') }}" class="nav-link @yield('employees')"><i class="fas fa-users"></i> <span class="collapse-label">Employees</span></a></li>
            <li class="nav-item"><a href="{{ route('hr.emp.emp_form') }}" class="nav-link @yield('reg_emp')"><i class="fas fa-user-plus"></i> <span class="collapse-label">Add Employee</span></a></li>
        @endif
        {{-- For ADMIN, HR, DOCTOR, NURSE --}}
        @if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse'))
        @if (!empty(auth()->user()->employee))
        
            <li class="nav-item"><a href="{{ route('genericname') }}" class="nav-link @yield('genericname')">Generic Name</a></li>
            <li class="nav-item"><a href="{{ route('brandname') }}" class="nav-link @yield('brandname')"><i class="fas fa-file-prescription"></i><span class="collapse-label"> Brand Name</span></a></li>
            <li class="nav-item"><a href="{{ route('medicine') }}" class="nav-link @yield('medicine')"><i class="fas fa-pills"></i> <span class="collapse-label">Medicines</span></a></li>

            <li class="nav-item"><a href="{{ route('medical.listsofemployees') }}" class="nav-link @yield('employeesMedical')">List of Employees</a></li>
        @endif
        @endif
        {{-- For Admin --}}
        @if(Gate::check('isAdmin'))
            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link @yield('register')"><i class="fas fa-user-edit"></i> <span class="collapse-label">Register User</span></a></li>
            <li class="nav-item"><a href="{{ route('dashboard.userRoles') }}" class="nav-link @yield('userRoles')"><i class="fas fa-user-cog"></i> <span class="collapse-label">User Roles</span></a></li>
            <li class="nav-item"><a href="{{ route('dashboard.roles') }}" class="nav-link @yield('roles')"><i class="fas fa-cogs"></i> <span class="collapse-label">Roles</span></a></li>
        @endif
        {{-- For All Users --}}
        @auth()
        @if (!empty(auth()->user()->employee))
            <li class="nav-item"><a href="{{ route('employee', ['employee' => auth()->user()->employee->id]) }}"  class="nav-link @yield('employee')"><span class="collapse-label">Profile</span></a></li>
        @else
            <li class="nav-item"><a href="{{ route('employees') }}"  class="nav-link @yield('employee')"><i class="fas fa-user"></i> <span class="collapse-label">Profile</span></a></li>
        @endif
        @endauth
        <li class="nav-item" id="collapse-menu">
            <button type="button" id="collapse-button">
                <span class="collapse-button-icon"><i class="fas fa-chevron-left"></i></span>
                <span class="collapse-label">Collapse Menu</span>
            </button>
        </li>
    </ul>
</div>