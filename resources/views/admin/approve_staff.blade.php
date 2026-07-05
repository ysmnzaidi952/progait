<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Staff Approval</title>

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
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.stafflist') }}">
                        <i class="fas fa-users"></i>
                        <span>Staff List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.patient.patientlist') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span> 
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.doctor.doctorlist') }}">
                        <i class="fas fa-users"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('admin.medical.list') }}">
                        <i class="fas fa-file-medical"></i>
                        <span>Patient Medical Records</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.appointment.list') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Appointment List</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('admin.reminder.list') }}">
                        <i class="fas fa-bell"></i>
                        <span>Appointment Reminders</span>
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
                <h2>Staff Approval</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                    <a href="{{ url('/staff/indexadmin2') }}" class="link-btn">Home</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <!-- Content Section -->
            <div class="content-container">
                <h1 class="page-title">Pending Staff Registrations</h1>

                @if(session('success'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="approval-table">
                    <thead>
                        <tr>
                            <th>Staff ID</th>
                            <th>Name</th>
                            <th>IC Number</th>  <!-- Added IC column -->
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingStaff as $staffMember)
                            <tr>
                                <td>{{ $staffMember->staffID }}</td>
                                <td>{{ $staffMember->staffName }}</td>
                                <td>{{ $staffMember->staffIC }}</td>  <!-- Show staffIC -->
                                <td>{{ $staffMember->staffEmail }}</td>
                                <td>{{ $staffMember->staffRole }}</td>
                                <td><span class="status-pending">{{ $staffMember->status }}</span></td>
                                <td>
                                    <form action="{{ route('admin.approve-staff', ['staffID' => $staffMember->staffID]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="approve-btn">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                
                @if(count($pendingStaff) == 0)
                    <div class="empty-state">
                        <i class="fas fa-clipboard-check"></i>
                        <p>No pending staff registrations at the moment.</p>
                    </div>
                @endif

                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
</div>

<!-- JS files -->
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
        
        // Animation for content container
        ScrollReveal().reveal('.content-container', {
            origin: 'top',
            distance: '50px',
            duration: 1000,
            delay: 200,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });
        
        // Success message fadeout
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.transition = 'opacity 1s ease';
                successMessage.style.opacity = '0';
            }, 5000);
        }
    });
</script>

</body>
</html>