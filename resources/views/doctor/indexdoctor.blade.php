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
                    <h3>Doctor Dashboard</h3>
                    <p>Welcome, <span>Doctor</span></p>
                </div>

                <button id="sidebar-toggle" class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <nav class="sidebar-menu">
                <ul>
                    <li class="active">
                        <a href="{{ route('doctor.indexdoctor') }}">
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
                        <a href="{{ route('doctor.patientlistdoct') }}">
                            <i class="fas fa-users"></i>
                            <span>Patient List</span>
                        </a>
                    </li>



                    <li>
                        <a href="{{ route('doctor.appointment.list') }}">
                            <i class="fas fa-calendar-check"></i>
                            <span>Appointment List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.medical.list') }}">
                            <i class="fas fa-calendar-check"></i>
                            <span>Medical record patient</span> 
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
                    <a href="{{ url('/doctor/indexdoctor2') }}" class="link-btn">Home</a>
                    </div>
                </div>
            </div>
        </div>

        

            <div class="dashboard-widgets">
                <div class="widget recent-patients">
                    <div class="widget-header">
                        <h3>Recent Patients</h3>
                        <a href="#" class="view-all">View All</a>
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
                                            <a href="/recommendation/{{ $patient->patientID }}" class="btn-action view" title="View Recommendation"><i class="fas fa-lightbulb"></i></a>
                                    
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="cuba quick-actions">
                    <div class="cuba-header">
                        <h3>Quick Actions</h3>
                    </div>
                    <div class="cuba-content">
                        <div class="cuba-buttons">
                            <a href="{{ route('patient.register') }}" class="cuba-btn">
                                <i class="fas fa-user-plus"></i>
                                <span>Add New Patient</span>
                            </a>
                            <a href="" class="cuba-btn">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Schedule Appointment</span>
                            </a>
                            <a href="" class="cuba-btn">
                                <i class="fas fa-file-medical"></i>
                                <span>Medical Records</span>
                            </a>
                            <a href="" class="cuba-btn">
                                <i class="fas fa-diagnoses"></i>
                                <span>New Assessment</span>
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
    });
</script>

</body>
</html>
