<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Manage Patients</title>

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
                <li>
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
                <li class="active">
                    <a href="{{ route('doctor.patientlistdoct') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('doctor.assessment.list') || request()->routeIs('doctor.assessment.show') ? 'active' : '' }}">
                    <a href="{{ route('doctor.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Appointment List</span>
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
                <h2>My Patients</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search patient...">
                    <i class="fas fa-search"></i>
                </div>
                <a href="{{ route('patient.register') }}" class="add-staff-btn">
                    <i class="fas fa-user-plus"></i> Add New Patient
                </a>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="staff-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>My Patients</h3>
                        <h2>{{ count($patients) }}</h2>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Active Cases</h3>
                        <h2>{{ $patients->where('status', 'Active')->count() }}</h2>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-procedures"></i>
                    </div>
                    <div class="stat-info">
                        <h3>In Treatment</h3>
                        <h2>{{ $patients->where('status', 'In Treatment')->count() ?? 0 }}</h2>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Completed</h3>
                        <h2>{{ $patients->where('status', 'Completed')->count() ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <div class="staff-table-container">
                <div class="table-header">
                    <h3>Patient Directory</h3>
                    <div class="table-actions">
                        <div class="filter-dropdown">
                            <select class="filter-select">
                                <option value="all">All Patients</option>
                                <option value="active">Active</option>
                                <option value="in-treatment">In Treatment</option>
                                <option value="completed">Completed</option>
                                <option value="inactive">Inactive</option>
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
                                <th>Patient ID</th>
                                <th>IC</th>
                                <th>Name</th>
                                <th>Last Visit</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="staff-id">{{ $patient->patientIC }}</span></td>
                                <td>
                                    <div class="staff-name">
                                        <div class="staff-avatar">
                                            <span>{{ substr($patient->patientName, 0, 1) }}</span>
                                        </div>
                                        <span>{{ $patient->patientName }}</span>
                                    </div>
                                </td>
                                <td>{{ $patient->lastVisit ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $patient->status == 'Active' ? 'success' : ($patient->status == 'In Treatment' ? 'primary' : ($patient->status == 'Completed' ? 'info' : 'secondary')) }}">
                                        {{ $patient->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="staff-actions">
                                        <a href="{{ route('doctor.patientviewdoct', $patient->patientID) }}" class="action-btn view-btn" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('doctor.patientupdatedoct', $patient->patientID) }}" class="action-btn edit-btn" title="Edit Patient">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="" class="action-btn add-record-btn" title="Add Medical Record" style="background-color: #28a745;">
                                            <i class="fas fa-notes-medical"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if(count($patients) == 0)
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <h3>No Patients Found</h3>
                    <p>There are no patients in the database yet.</p>
                    <a href="{{ route('patient.register') }}" class="link-btn">Add New Patient</a>
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