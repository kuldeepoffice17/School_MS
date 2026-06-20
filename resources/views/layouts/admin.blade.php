<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Best school management system')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My School')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
            --sidebar-width: 250px;
            --header-height: 70px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        @media (max-width: 768px) {

            .sidebar {
                left: -250px;
                width: 250px;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

        }
        
        .sidebar.closed {
            left: -250px;
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h4 {
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 0;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .sidebar-menu .menu-item:hover,
        .sidebar-menu .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid white;
        }
        
        .sidebar-menu .menu-item i {
            font-size: 20px;
            width: 24px;
        }
        
        .sidebar-menu .menu-item span {
            font-size: 14px;
            font-weight: 500;
        }
        
        .sidebar-menu .menu-category {
            padding: 15px 20px 5px;
            font-size: 12px;
            text-transform: uppercase;
            opacity: 0.6;
            letter-spacing: 1px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        /* Header Styles */
        .header {
            background: white;
            padding: 0 25px;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: var(--dark-color);
            cursor: pointer;
            padding: 5px;
        }
        
        .search-bar {
            background: #f8f9fc;
            padding: 8px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .search-bar input {
            border: none;
            background: none;
            outline: none;
            width: 250px;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .notification-btn {
            position: relative;
            cursor: pointer;
        }
        
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger-color);
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 50%;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        /* Content Area */
        .content {
            padding: 25px;
        }
        
        /* Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
            color: white;
            transition: all 0.3s ease;
            z-index: 1050;
            overflow-y: auto;
        }
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.show {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .search-bar input {
                width: 150px;
            }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }
        #sidebarOverlay{
            position: fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.5);
            z-index:1040;
            display:none;
        }

        #sidebarOverlay.show{
            display:block;
        }
        @media (max-width:768px){

            .search-bar{
                display:none;
            }

            .header{
                padding:0 15px;
            }

            .content{
                padding:15px;
            }

            .user-info{
                display:none;
            }
        }
        .stat-card{
            height:100%;
        }

        @media (max-width:768px){

            .stat-card{
                margin-bottom:15px;
            }

            .stat-card h3{
                font-size:22px;
            }

            .stat-card i{
                font-size:28px !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
     <div id="sidebarOverlay"></div>
    <div class="sidebar" id="sidebar">
       
        <div class="sidebar-header">
            <h4><i class="bi bi-mortarboard"></i> SchoolMS</h4>
            <p>School Management System</p>
        </div>
        
        {{-- <div class="sidebar-menu">
            <div class="menu-category">MAIN</div>
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            
            @role('super-admin|admin')
            <div class="menu-category">MANAGEMENT</div>
            <a href="{{ route('admin.students.index') }}" class="menu-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Students</span>
            </a>
            
            <a href="{{ route('admin.teachers.index') }}" class="menu-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                <span>Teachers</span>
            </a>
            
            <a href="{{ route('admin.classes.index') }}" class="menu-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Classes</span>
            </a>
            
            <a href="{{ route('admin.subjects.index') }}" class="menu-item {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Subjects</span>
            </a>
            @endrole
            
            @role('super-admin|admin|teacher')
            <div class="menu-category">ACADEMIC</div>
            <a href="{{ route('admin.academic-years.index') }}" class="menu-item">
                <i class="bi bi-calendar"></i>
                <span>Academic Years</span>
            </a>
            <a href="{{ route('admin.exams.index') }}" class="menu-item {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i>
                <span>Exams</span>
            </a>
            
            <a href="{{ route('admin.attendance.index') }}" class="menu-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Attendance</span>
            </a>
            @endrole
            
            @role('super-admin|admin|accountant')
            <div class="menu-category">FINANCE</div>
            <a href="{{ route('admin.fees.index') }}" class="menu-item {{ request()->routeIs('admin.fees.*') ? 'active' : '' }}">
                <i class="bi bi-currency-dollar"></i>
                <span>Fees Collection</span>
            </a>
            @endrole
            
            <div class="menu-category">SYSTEM</div>
            <a href="{{ route('admin.settings.general') }}" class="menu-item">
                <i class="bi bi-gear"></i>
                <span>General Settings</span>
            </a>
            <a href="{{ route('admin.grades.index') }}" class="menu-item">
                <i class="bi bi-star"></i>
                <span>Grading System</span>
            </a>
            
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-item">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div> --}}
        <div class="sidebar-menu">
    <div class="menu-category">MAIN</div>
    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>
    
    <!-- Show for Admin Only -->
    @if(Auth::user()->role == 'admin')
    <div class="menu-category">MANAGEMENT</div>
    
    <!-- User Verification - Important -->
    <a href="{{ route('admin.users.verification') }}" 
        class="menu-item {{ request()->routeIs('admin.users.verification') ? 'active' : '' }}">
            <i class="bi bi-person-check"></i>
            <span>User Verification</span>
            @php 
                $pendingCount = \App\Models\User::where('is_verified', false)->where('role', '!=', 'admin')->count(); 
            @endphp
            @if($pendingCount > 0)
                <span class="badge bg-danger ms-auto">{{ $pendingCount }}</span>
            @endif
    </a>
    
    <a href="{{ route('admin.students.index') }}" class="menu-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        <span>Students</span>
    </a>
    
    <a href="{{ route('admin.teachers.index') }}" class="menu-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
        <i class="bi bi-person-badge"></i>
        <span>Teachers</span>
    </a>
    
    <a href="{{ route('admin.classes.index') }}" class="menu-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
        <i class="bi bi-building"></i>
        <span>Classes</span>
    </a>
    
    <a href="{{ route('admin.subjects.index') }}" class="menu-item {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
        <i class="bi bi-book"></i>
        <span>Subjects</span>
    </a>
    
    <div class="menu-category">ACADEMIC</div>
    <a href="{{ route('admin.academic-years.index') }}" class="menu-item">
        <i class="bi bi-calendar"></i>
        <span>Academic Years</span>
    </a>
    <a href="{{ route('admin.exams.index') }}" class="menu-item {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}">
        <i class="bi bi-file-text"></i>
        <span>Exams</span>
    </a>
    
    <a href="{{ route('admin.attendance.index') }}" class="menu-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
        <i class="bi bi-calendar-check"></i>
        <span>Attendance</span>
    </a>
    
    <div class="menu-category">FINANCE</div>
    <a href="{{ route('admin.fees.index') }}" class="menu-item {{ request()->routeIs('admin.fees.*') ? 'active' : '' }}">
        <i class="bi bi-currency-dollar"></i>
        <span>Fees Collection</span>
    </a>
    @endif
    
    <!-- Show for Teachers -->
    @if(Auth::user()->role == 'teacher')
    <div class="menu-category">ACADEMIC</div>
    <a href="{{ route('admin.exams.index') }}" class="menu-item">
        <i class="bi bi-file-text"></i>
        <span>Exams</span>
    </a>
    <a href="{{ route('admin.attendance.index') }}" class="menu-item">
        <i class="bi bi-calendar-check"></i>
        <span>Attendance</span>
    </a>
    @endif
    
    <!-- Show for Accountants -->
    @if(Auth::user()->role == 'accountant')
    <div class="menu-category">FINANCE</div>
    <a href="{{ route('admin.fees.index') }}" class="menu-item">
        <i class="bi bi-currency-dollar"></i>
        <span>Fees Collection</span>
    </a>
    @endif
    
    <!-- Show for Students & Parents (Limited Access) -->
    @if(Auth::user()->role == 'student' || Auth::user()->role == 'parent')
    <div class="menu-category">MY ACCOUNT</div>
    <a href="#" class="menu-item">
        <i class="bi bi-person"></i>
        <span>My Profile</span>
    </a>
    <a href="#" class="menu-item">
        <i class="bi bi-journal"></i>
        <span>My Results</span>
    </a>
    <a href="#" class="menu-item">
        <i class="bi bi-calendar-check"></i>
        <span>My Attendance</span>
    </a>
    @endif
    
    <div class="menu-category">SYSTEM</div>
    @if(Auth::user()->role == 'admin')
    <a href="{{ route('admin.settings.general') }}" class="menu-item">
        <i class="bi bi-gear"></i>
        <span>General Settings</span>
    </a>
    <a href="{{ route('admin.grades.index') }}" class="menu-item">
        <i class="bi bi-star"></i>
        <span>Grading System</span>
    </a>
    @endif
    
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-item">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <button class="toggle-btn" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div class="search-bar">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
            </div>
            
            <div class="header-right">
                <div class="notification-btn">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="notification-badge">3</span>
                </div>
                
                <div class="user-menu dropdown">
                    <div class="user-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div class="user-info">
                        <strong>{{ Auth::user()->name }}</strong>
                        <small class="d-block text-muted">{{ Auth::user()->roles->pluck('name')->implode(', ') }}</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Page Content -->
        <div class="content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Toggle Sidebar
        // document.getElementById('toggleSidebar').addEventListener('click', function() {
        //     document.getElementById('sidebar').classList.toggle('closed');
        //     document.getElementById('mainContent').classList.toggle('expanded');
        // });
        // document.getElementById('toggleSidebar').addEventListener('click', function() {

        //     if(window.innerWidth <= 768){
        //         document.getElementById('sidebar').classList.toggle('show');
        //     }else{
        //         document.getElementById('sidebar').classList.toggle('closed');
        //         document.getElementById('mainContent').classList.toggle('expanded');
        //     }

        // });
        
        // Initialize DataTables
        $(document).ready(function() {
            $('.datatable').DataTable({
                responsive: true,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries"
                }
            });
        });
        
        // SweetAlert confirm delete
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        
        // Mobile sidebar handling
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.add('closed');
        }
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        document.getElementById('toggleSidebar').addEventListener('click', function () {

            if(window.innerWidth <= 768){

                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');

            }else{

                sidebar.classList.toggle('closed');
                document.getElementById('mainContent').classList.toggle('expanded');
            }
        });

        overlay.addEventListener('click', function(){

            sidebar.classList.remove('show');
            overlay.classList.remove('show');

        });
        
    </script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

        <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    @stack('scripts')
</body>
</html>