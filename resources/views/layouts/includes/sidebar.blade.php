<div id="zapAdminMenuBg"></div>
<div id="zapAdminMenuWrap" class="zap-sidebar">
{{--     @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif --}}

    <ul class="nav flex-column">
        <div class="zap-user-info">
            <div class="zap-image">
                @auth()
                @if (!empty(auth()->user()->employee->profile_img))
                    <img src="{{ asset('storage/uploaded/'.auth()->user()->employee->profile_img) }}"  onerror="javascript:this.src='{{url( '/images/default.png' )}}'" border="0" width="48" class="img-circle">
                @else
                    <img src="{{ url( '/images/default.png' ) }}" border="0" width="48" class="img-circle">
                @endif
                @endauth
            </div>
            <div class="zap-info-wrap">
                @auth()
                @if (!empty(auth()->user()->employee))
                    <div class="name">{{ auth()->user()->employee->first_name }} {{ auth()->user()->employee->last_name }}</div>
                    {{-- <div class="position">{{ auth()->user()->employee->positions->position }}</div> --}}
                    @if (!empty(auth()->user()->employee))
                        <a href="{{ route('employee', ['employee' => auth()->user()->employee->emp_id]) }}" class="position text-white">View Profile</a>
                    @else
                        <a href="{{ route('employees') }}" > Profile</a>
                    @endif
                @else
                    <a href="{{ route('employees') }}" >
                        <div class="name text-white">Employee Name</div>
                        <div class="position text-white">Sync Profile</div>
                    </a>
                @endif
                @endauth
            </div>
        </div> 
       
        <li class="nav-item"><a href="{{ route('dashboard.main') }}" class="nav-link @yield('overview')"><i class="fas fa-tachometer-alt"></i> <span class="collapse-label">Dashboard</span></a></li>
        {{-- For ADMIN, HR, DOCTOR, NURSE --}}
        @if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse'))
            @if (!empty(auth()->user()->employee))
             @if ( Request::is('posts') || Request::is('posts/*') || Request::is('media') || Request::is('category') )
                @php  
                    $ariaexpand = "true";
                    $showactive = "show";
                    $collap = "";
                @endphp
            @else
             @php  
            $ariaexpand = "false";
            $showactive = "";
            $collap = "collapsed";
        @endphp
             @endif
                <li class="nav-item">
                    <a href="#posts" data-toggle="collapse" aria-expanded="{{ $ariaexpand }}" class="nav-link dropdown-toggle {{$collap}}"><i class="fas fa-book"></i> <span class="collapse-label">Posts</span></a>
                    <ul class="zp-dropdown nav collapse {{ $showactive }}" id="posts">
                        <li class="nav-item"><a href="{{ route('post.create') }}" class="nav-link @yield('new_post')"><i class="fas fa-pencil-alt"></i> <span class="collapse-label">New Post</span></a></li>
                        <li class="nav-item"><a href="{{ route('post.index') }}" class="nav-link @yield('posts')"><i class="fas fa-book"></i> <span class="collapse-label">All Posts</span></a></li>
                        <li class="nav-item"><a href="{{ route('tag.index') }}" class="nav-link @yield('category')"><i class="fas fa-folder"></i> <span class="collapse-label">Categories</span></a></li>
                        <li class="nav-item"><a href="{{ route('media.index') }}" class="nav-link @yield('medias')"><i class="fas fa-photo-video"></i> <span class="collapse-label">Media</span></a></li>
                    </ul>
                </li>
            @endif
        @endif
        {{-- For HR --}}
        @if (Gate::check('isAdmin') || Gate::check('isHr'))
        @if ( Request::is('hr') || Request::is('hr/*') )
           @php  
               $ariaexpand = "true";
               $showactive = "show";
               $collap = "";
           @endphp
        @else
         @php  
            $ariaexpand = "false";
            $showactive = "";
            $collap = "collapsed";
        @endphp
        @endif
            <li class="nav-item">
                <a href="#employees" data-toggle="collapse" aria-expanded="{{ $ariaexpand }}" class="nav-link dropdown-toggle {{$collap}}"><i class="fas fa-users"></i> <span class="collapse-label">Employees</span></a>
                <ul class="zp-dropdown nav collapse {{ $showactive }}" id="employees">
                    <li class="nav-item"><a href="{{ route('hr.employees') }}" class="nav-link @yield('employees')"><i class="fas fa-users"></i> <span class="collapse-label">All Employees</span></a></li>
                    <li class="nav-item"><a href="{{ route('hr.dep.department') }}" class="nav-link @yield('reg_dep')"><i class="fas fa-building"></i> <span class="collapse-label">Departments</span></a></li>
                    <li class="nav-item"><a href="{{ route('hr.pos.position') }}" class="nav-link @yield('reg_pos')"><i class="fas fa-tasks"></i> <span class="collapse-label">Positions</span></a></li>
                    <li class="nav-item"><a href="{{ route('hr.emp.emp_form') }}" class="nav-link @yield('reg_emp')"><i class="fas fa-user-plus"></i> <span class="collapse-label">Add Employee</span></a></li>                    
                </ul>

            </li>
        @endif
        {{-- For ADMIN, HR, DOCTOR, NURSE --}}
        @if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse'))
        @if (!empty(auth()->user()->employee))
        @if ( Request::is('medical') || Request::is('medical/*') || Request::is('inventory') || Request::is('inventory/*') )
           @php  
               $ariaexpand = "true";
               $showactive = "show";
               $collap = "";
           @endphp
        @else
         @php  
            $ariaexpand = "false";
            $showactive = "";
            $collap = "collapsed";
        @endphp
        @endif
        <li class="nav-item">
            <a href="#clinic" data-toggle="collapse" aria-expanded="{{ $ariaexpand }}" class="nav-link dropdown-toggle {{$collap}}"><i class="fas fa-clinic-medical"></i> <span class="collapse-label">Clinic</span></a>
            <ul class="zp-dropdown nav collapse {{ $showactive }}" id="clinic">
                <a href="#inventory" data-toggle="collapse" aria-expanded="{{ $ariaexpand }}" class="nav-link dropdown-toggle {{$collap}} zp-sublink-dropdown"><i class="fas fa-warehouse"></i> <span class="collapse-label">Inventory</span></a>
                <ul class="zp-sub-dropdown nav collapse {{ $showactive }}" id="inventory">
                    <li class="nav-item"><a href="{{ route('genericname') }}" class="nav-link @yield('genericname')"><i class="fas fa-tablets"></i><span class="collapse-label"> Generic Name</span></a></li>
                    <li class="nav-item"><a href="{{ route('brandname') }}" class="nav-link @yield('brandname')"><i class="fas fa-file-prescription"></i><span class="collapse-label"> Brand Name</span></a></li>
                    <li class="nav-item"><a href="{{ route('medicine') }}" class="nav-link @yield('medicine')"><i class="fas fa-pills"></i> <span class="collapse-label">Medicines</span></a></li>                    
                </ul>
                <li class="nav-item"><a href="{{ route('medical.listsofemployees') }}" class="nav-link @yield('employeesMedical')"><i class="fas fa-list"></i><span class="collapse-label">List of Employees</span></a></li>
                <li class="nav-item"><a href="{{ route('medical.empsRecords') }}" class="nav-link @yield('employeesWithRecord')"><i class="fas fa-list"></i><span class="collapse-label">Employees with Record</span></a></li>
<<<<<<< HEAD

=======
>>>>>>> 383c59a5c4b8a59fd8de17ec6f9a4a7b2d95bde9
            </ul>
        </li>
        @endif
        @endif
        {{-- For Admin --}}
        @if(Gate::check('isAdmin'))
            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link @yield('register')"><i class="fas fa-user-edit"></i> <span class="collapse-label">Register User</span></a></li>
            <li class="nav-item"><a href="{{ route('password.request') }}" class="nav-link @yield('reset_pwd')"><i class="fas fa-user-edit"></i> <span class="collapse-label">Reset Password</span></a></li>
            <li class="nav-item"><a href="{{ route('dashboard.userRoles') }}" class="nav-link @yield('userRoles')"><i class="fas fa-user-cog"></i> <span class="collapse-label">User Roles</span></a></li>
            <li class="nav-item"><a href="{{ route('dashboard.roles') }}" class="nav-link @yield('roles')"><i class="fas fa-cogs"></i> <span class="collapse-label">Roles</span></a></li>
        @endif
        {{-- For All Users --}}
{{--         @auth()
        @if (!empty(auth()->user()->employee))
            <li class="nav-item"><a href="{{ route('employee', ['employee' => auth()->user()->employee->emp_id]) }}"  class="nav-link @yield('employee')"><span class="collapse-label"><i class="far fa-address-card"></i><span class="collapse-label">Profile</span></span></a></li>
        @else
            <li class="nav-item"><a href="{{ route('employees') }}"  class="nav-link @yield('employee')"><i class="fas fa-user"></i> <span class="collapse-label"><i class="far fa-address-card"></i><span class="collapse-label">Profile</span></span></a></li>
        @endif
        @endauth --}}
        <li class="nav-item" id="collapse-menu">
            <button type="button" id="collapse-button">
                <span class="collapse-button-icon"><i class="fas fa-chevron-left"></i></span>
                <span class="collapse-label">Collapse Menu</span>
            </button>
        </li>
    </ul>
</div>