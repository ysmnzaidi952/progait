<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Manage Staff</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- bootstrap cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>


<div class="dashboard-layout">
<!-- Sidebar Start -->
<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <img src="{{ asset('images/progait.png') }}" alt="ProGait Logo">
        </div>
        <div class="admin-info">
            <h3>Admin Dashboard</h3>
            <p>Welcome, <span>Admin</span></p>
        </div>

        <button id="sidebar-toggle" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    
    <nav class="sidebar-menu">
        <ul>
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.profile.view') ? 'active' : '' }}">
                <a href="{{ route('admin.profile.view') }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.stafflist') ? 'active' : '' }}">
                <a href="{{ route('admin.stafflist') }}">
                    <i class="fas fa-users"></i>
                    <span>Staff List</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.patient.patientlist') ? 'active' : '' }}">
                <a href="{{ route('admin.patient.patientlist') }}">
                    <i class="fas fa-users"></i>
                    <span>Patient List</span> 
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.doctor.doctorlist') ? 'active' : '' }}">
                <a href="{{ route('admin.doctor.doctorlist') }}">
                    <i class="fas fa-users"></i>
                    <span>Doctor List</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.medical.list') ? 'active' : '' }}">
                <a href="{{ route('admin.medical.list') }}"> 
                    <i class="fas fa-users"></i>
                    <span>Patient Medical Record</span> 
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.assessment.list') ? 'active' : '' }}">
                <a href="{{ route('admin.assessment.list') }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Assessment Form List</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.appointment.list') ? 'active' : '' }}">
                <a href="{{ route('admin.appointment.list') }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Appointment List</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.reminder.list') ? 'active' : '' }}">
                <a href="{{ route('admin.reminder.list') }}">
                    <i class="fas fa-bell"></i>
                    <span>Appointment Reminders</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.recommendation') ? 'active' : '' }}">
                <a href="{{ route('admin.recommendation', ['patientId' => 1]) }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Recommendation Devices</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<!-- Sidebar End -->


    <!-- Main Content Start --> 
    <main class="dashboard-main">
        <div class="dashboard-header">
            <div class="header-left">
                <h2>Manage Staff</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search staff...">
                    <i class="fas fa-search"></i>
                </div>
                <a href="{{ route('staff.register') }}" class="add-staff-btn">
                    <i class="fas fa-user-plus"></i> Add New Staff
                </a>
            </div>
        </div>


            <div class="staff-table-container">
                <div class="table-header">
                    <h3>Staff Directory</h3>
                    <div class="table-actions">
                        <div class="filter-dropdown">
                            <select class="filter-select">
                                <option value="all">All Staff</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <button class="refresh-btn">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="staff-table">
                        <thead>
                            <tr>
                                <th>Staff ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Phone Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staff as $staffMember)
                            <tr>
                                <td><span class="staff-id">{{ $staffMember->staffID }}</span></td>
                                <td>
                                    <div class="staff-name">
                                        <div class="staff-avatar">
                                            <span>{{ substr($staffMember->staffName, 0, 1) }}</span>
                                        </div>
                                        <span>{{ $staffMember->staffName }}</span>
                                    </div>
                                </td>
                                <td>{{ $staffMember->staffEmail }}</td>
                                <td><span class="staff-role role-{{ strtolower($staffMember->staffRole) }}">{{ $staffMember->staffRole }}</span></td>
                                <td>{{ $staffMember->staffTel }}</td>
                                <td>
                                    <div class="staff-actions">
                                        <a href="{{ route('admin.staff.view', $staffMember->staffID) }}" class="action-btn view-btn" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.staff.edit', $staffMember->staffID) }}" class="action-btn edit-btn" title="Edit Staff">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.staff.delete', $staffMember->staffID) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete-btn" title="Delete Staff" onclick="return confirm('Are you sure you want to delete {{ $staffMember->staffName }}? This action cannot be undone.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if(count($staff) == 0)
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <h3>No Staff Found</h3>
                    <p>There are no staff members in the database yet.</p>
                    <a href="{{ route('staff.register') }}" class="link-btn">Add New Staff</a>
                </div>
                @endif
                
                <div class="pagination-container">
                    <!-- Add pagination here if needed -->
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
</div>

<!-- JS files -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="https://unpkg.com/scrollreveal"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle sidebar
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const dashboardLayout = document.querySelector('.dashboard-layout');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                dashboardLayout.classList.toggle('sidebar-collapsed');
            });
        }
        
        // Initialize ScrollReveal
        ScrollReveal().reveal('.stat-card', {
            origin: 'bottom',
            distance: '20px',
            duration: 1000,
            interval: 100,
            delay: 200,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });
        
        ScrollReveal().reveal('.staff-table-container', {
            origin: 'bottom',
            distance: '30px',
            duration: 1000,
            delay: 300,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });
    });
</script>

</body>
</html>