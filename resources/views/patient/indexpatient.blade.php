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
                <div class="admin-info">
                    <h3>Patient Dashboard</h3>
                    <p>Welcome, <span>Patient</span> : {{ auth()->guard('patient')->user()->patientName }}</p>
                </div>

                <button id="sidebar-toggle" class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <nav class="sidebar-menu">
                <ul>
                    <li class="active">
                        <a href="{{ route('patient.indexpatient') }}">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('patient.profile') ? 'active' : '' }}">
                        <a href="{{ route('patient.profile') }}">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fas fa-file-medical"></i>
                            <span>Medical Record</span>
                        </a>
                    </li>
                    <li >
                        <a href="{{ route('patient.appointment.list') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>My Appointment</span>
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
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="header-notifications">
                        <div class="notifications-icon">
                            <a href="{{ url('/patient/indexpatient2') }}" class="link-btn">Home</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-content">
                <div class="cuba quick-actions">
                    <div class="cuba-header">
                        <h3>Quick Actions</h3>
                    </div>
                    <div class="cuba-content">
                        <div class="cuba-buttons">
                            <a href="" class="cuba-btn">
                                <i class="fas fa-user-plus"></i>
                                <span>View Profile</span>
                            </a>
                            <a href="" class="cuba-btn">
                                <i class="fas fa-file-medical"></i>
                                <span>Medical Record</span>
                            </a>
                            <a href="{{ route('patient.appointment.create') }}" class="cuba-btn">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Appointments</span>
                            </a>

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
            ScrollReveal().reveal('.cuba-btn', {
                origin: 'bottom',
                distance: '20px',
                duration: 1000,
                interval: 100,
                delay: 200,
                easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
                reset: false
            });
        });
    </script>

</body>

</html>