<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait</title>

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
            <div class="staff-info">
                <h3>Staff Dashboard</h3>
                <p>Welcome, <span>Staff</span></p>
            </div>

            <button id="sidebar-toggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <nav class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="{{ route('staff.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.profile.view') ? 'active' : '' }}">
                    <a href="{{ route('staff.profile.view') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.patient.patientliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.doctor.doctorliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.appointment.list') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Appointments List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.reminder.list') ? 'active' : '' }}">
                    <a href="{{ route('staff.reminder.list') }}">
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
                <h2>Dashboard Overview</h2>
                <p class="header-subtitle">Welcome back! Here's what's happening today.</p>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                        <!-- Home button removed -->
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="stats-cards">
                <div class="stats-card">
                    <div class="stats-info">
                        <h3>Total Patients</h3>
                        <h2>{{ $totalPatients }}</h2>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-user-injured"></i>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="stats-info">
                        <h3>Total Staff</h3>
                        <h2>{{ $totalStaff }}</h2>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="stats-info">
                        <h3>Total Doctors</h3>
                        <h2>{{ $totalDoctors }}</h2>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="stats-info">
                        <h3>Total Appointments</h3>
                        <h2>{{ $totalAppointments }}</h2>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>

            <div class="dashboard-widgets">
                <div class="widget recent-patients">
                    <div class="widget-header">
                        <h3>Recent Patients</h3>
                        <a href="{{ route('staff.patient.patientliststaff') }}" class="view-all">View All</a>
                    </div>
                    <div class="widget-content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Date</th>
                             
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPatients as $patient)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <span>{{ $patient->patientName }}</span>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($patient->created_at)->format('M d, Y') }}</td>
 
                                    <td>
                                        <div class="actions">
                                            <a href="/staffrecommendation/{{ $patient->patientID ?? $patient->id }}" class="btn-action view" title="View Recommendation">
                                                <i class="fas fa-lightbulb"></i>
                                            </a>
                 
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="widget quick-actions">
                    <div class="widget-header">
                        <h3>Quick Actions</h3>
                    </div>
                    <div class="widget-content">
                        <div class="cuba-buttons">
                            <a href="{{ route('patient.register') }}" class="cuba-btn">
                                <i class="fas fa-user-plus"></i>
                                <span>Register Patient</span>
                            </a>
                            <a href="#" class="cuba-btn">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Create Appointment</span>
                            </a>
                            <a href="#" class="cuba-btn">
                                <i class="fas fa-file-medical"></i>
                                <span>Medical Records</span>
                            </a>
                            <a href="#" class="cuba-btn">
                                <i class="fas fa-clipboard-list"></i>
                                <span>Assessment Forms</span>
                            </a>
                        </div>
                    </div>
                </div>
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

        // Initialize ScrollReveal
        ScrollReveal().reveal('.stats-card', {
            origin: 'bottom',
            distance: '20px',
            duration: 1000,
            interval: 100,
            delay: 200,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });

        ScrollReveal().reveal('.widget', {
            origin: 'bottom',
            distance: '30px',
            duration: 1000,
            delay: 300,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });

        ScrollReveal().reveal('.action-card', {
            origin: 'bottom',
            distance: '20px',
            duration: 800,
            interval: 50,
            delay: 400,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });
    });
</script>

<style>
/* Additional styles for enhanced appearance */
.header-subtitle {
    color: #6c757d;
    font-size: 14px;
    margin: 5px 0 0 0;
}

/* User info styling for consistency with admin dashboard */
.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-info img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

/* Status badges */
.status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    text-transform: capitalize;
}

.status.active {
    background: #d4edda;
    color: #155724;
}

.status.pending {
    background: #fff3cd;
    color: #856404;
}

.status.completed {
    background: #d1ecf1;
    color: #0c5460;
}

/* Action buttons */
.actions {
    display: flex;
    gap: 5px;
}

.btn-action {
    width: 28px;
    height: 28px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 12px;
    transition: all 0.3s ease;
}

.btn-action.view {
    background: #e3f2fd;
    color: #1976d2;
}

.btn-action.edit {
    background: #fff3e0;
    color: #f57c00;
}

.btn-action:hover {
    transform: scale(1.1);
    text-decoration: none;
}
</style>

</body>
</html>