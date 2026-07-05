<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - My Profile</title>

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
                <p>Welcome, <span>{{ Auth::guard('doctor')->user()->docName }}</span></p>
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
                <li class="active">
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
                    <a href="{{ route('doctor.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
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
                        <i class="fas fa-file-medical-alt"></i>
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
                <h2>My Profile</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                        <a href="{{ route('doctor.indexdoctor') }}" class="link-btn">Home</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="content-container">
                @if(session('success'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="error-message">
                        <i class="fas fa-times-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <!-- Profile Header -->
                <div class="profile-view-header">
                    <div class="profile-avatar-section">
                        <div class="profile-avatar-large">
                            <div class="avatar-placeholder">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </div>
                        <div class="profile-info">
                            <h3>Dr. {{ $doctor->docName }}</h3>
                            <p class="doctor-id">Doctor ID: <span>{{ $doctor->docID }}</span></p>
                            <p class="registration-date">
                                <i class="fas fa-calendar-plus"></i> 
                                Registered: {{ $doctor->created_at->format('d/m/Y') }}
                            </p>
                            @if($doctor->dateOfBirth)
                            <p class="age-info">
                                <i class="fas fa-birthday-cake"></i>
                                Age: {{ \Carbon\Carbon::parse($doctor->dateOfBirth)->age }} years old
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="profile-actions">
                        <a href="{{ route('doctor.profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        <button type="button" class="btn btn-info" onclick="window.print()">
                            <i class="fas fa-print"></i> Print Profile
                        </button>
                    </div>
                </div>

                <!-- Personal Information Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <h4><i class="fas fa-user-circle"></i> Personal Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-row">
                                <div class="info-label">Full Name:</div>
                                <div class="info-value">Dr. {{ $doctor->docName }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">NRIC / Passport:</div>
                                <div class="info-value">{{ $doctor->docIC }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Date of Birth:</div>
                                <div class="info-value">
                                    @if($doctor->dateOfBirth)
                                        {{ \Carbon\Carbon::parse($doctor->dateOfBirth)->format('d/m/Y') }}
                                        <span class="age-badge">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($doctor->dateOfBirth)->age }} years old
                                        </span>
                                    @else
                                        <span class="not-provided">Not provided</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Gender:</div>
                                <div class="info-value">
                                    @if($doctor->gender)
                                        <span class="gender-badge">
                                            <i class="fas {{ $doctor->gender == 'Male' ? 'fa-mars' : ($doctor->gender == 'Female' ? 'fa-venus' : 'fa-venus-mars') }}"></i>
                                            {{ $doctor->gender }}
                                        </span>
                                    @else
                                        <span class="not-provided">Not specified</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Race/Ethnicity:</div>
                                <div class="info-value">
                                    @if($doctor->race)
                                        <span class="race-badge">
                                            <i class="fas fa-users"></i>
                                            {{ $doctor->race }}
                                        </span>
                                    @else
                                        <span class="not-provided">Not specified</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Marital Status:</div>
                                <div class="info-value">
                                    @if($doctor->maritalStatus)
                                        <span class="marital-badge">
                                            <i class="fas {{ $doctor->maritalStatus == 'Married' ? 'fa-heart' : ($doctor->maritalStatus == 'Single' ? 'fa-user' : 'fa-user-friends') }}"></i>
                                            {{ $doctor->maritalStatus }}
                                        </span>
                                    @else
                                        <span class="not-provided">Not specified</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Doctor ID:</div>
                                <div class="info-value">
                                    <span class="doctor-id-display">{{ $doctor->docID }}</span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Registration Date:</div>
                                <div class="info-value">
                                    {{ $doctor->created_at->format('d/m/Y h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <h4><i class="fas fa-address-book"></i> Contact Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-row">
                                <div class="info-label">Email Address:</div>
                                <div class="info-value">
                                    <a href="mailto:{{ $doctor->docEmail }}" class="contact-link">
                                        <i class="fas fa-envelope"></i> {{ $doctor->docEmail }}
                                    </a>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Telephone Number:</div>
                                <div class="info-value">
                                    <a href="tel:{{ $doctor->docTel }}" class="contact-link">
                                        <i class="fas fa-phone"></i> {{ $doctor->docTel }}
                                    </a>
                                </div>
                            </div>
                            <div class="info-row address-row">
                                <div class="info-label">Address:</div>
                                <div class="info-value">
                                    @if($doctor->address)
                                        <div class="address-content">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $doctor->address }}</span>
                                        </div>
                                    @else
                                        <span class="not-provided">
                                            <i class="fas fa-map-marker-alt"></i>
                                            Address not provided
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <h4><i class="fas fa-cog"></i> Account Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-row">
                                <div class="info-label">Account Status:</div>
                                <div class="info-value">
                                    <span class="status-badge {{ $doctor->status == 'active' ? 'status-active' : ($doctor->status == 'approved' ? 'status-approved' : ($doctor->status == 'pending' ? 'status-pending' : 'status-inactive')) }}">
                                        <i class="fas {{ $doctor->status == 'active' ? 'fa-check-circle' : ($doctor->status == 'approved' ? 'fa-thumbs-up' : ($doctor->status == 'pending' ? 'fa-clock' : 'fa-times-circle')) }}"></i>
                                        {{ ucfirst($doctor->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Registration Date:</div>
                                <div class="info-value">
                                    {{ $doctor->created_at->format('d/m/Y h:i A') }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Last Updated:</div>
                                <div class="info-value">
                                    {{ $doctor->updated_at->format('d/m/Y h:i A') }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Profile Completeness:</div>
                                <div class="info-value">
                                    @php
                                        $completedFields = 0;
                                        $totalFields = 9; // Total profile fields including gender
                                        
                                        if($doctor->docName) $completedFields++;
                                        if($doctor->docEmail) $completedFields++;
                                        if($doctor->docTel) $completedFields++;
                                        if($doctor->docIC) $completedFields++;
                                        if($doctor->dateOfBirth) $completedFields++;
                                        if($doctor->gender) $completedFields++;
                                        if($doctor->maritalStatus) $completedFields++;
                                        if($doctor->address) $completedFields++;
                                        if($doctor->race) $completedFields++;
                                        
                                        $completionPercentage = round(($completedFields / $totalFields) * 100);
                                    @endphp
                                    <div class="progress-container">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $completionPercentage }}%"></div>
                                        </div>
                                        <span class="progress-text">{{ $completionPercentage }}% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Total Patients:</div>
                                <div class="info-value">
                                    <span class="patient-count">{{ $totalPatients ?? '0' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Appointments Card -->
                @if(isset($recentAppointments) && count($recentAppointments) > 0)
                <div class="profile-card">
                    <div class="card-header">
                        <h4><i class="fas fa-calendar-alt"></i> Recent Appointments</h4>
                    </div>
                    <div class="card-body">
                        <div class="appointments-list">
                            @foreach($recentAppointments as $appointment)
                            <div class="appointment-item">
                                <div class="appointment-date">
                                    <div class="date-day">{{ date('d', strtotime($appointment->appointmentDate)) }}</div>
                                    <div class="date-month">{{ date('M', strtotime($appointment->appointmentDate)) }}</div>
                                    <div class="date-year">{{ date('Y', strtotime($appointment->appointmentDate)) }}</div>
                                </div>
                                <div class="appointment-details">
                                    <h5>{{ $appointment->patientName ?? 'Patient Consultation' }}</h5>
                                    <p class="appointment-time">
                                        <i class="fas fa-clock"></i> 
                                        {{ date('h:i A', strtotime($appointment->appointmentTime)) }}
                                    </p>
                                    @if($appointment->typeAmputee)
                                    <p class="appointment-type">
                                        <i class="fas fa-stethoscope"></i> 
                                        Type: {{ $appointment->typeAmputee }}
                                    </p>
                                    @endif
                                    @if($appointment->notes)
                                    <p class="appointment-notes">
                                        <i class="fas fa-sticky-note"></i> 
                                        {{ Str::limit($appointment->notes, 50) }}
                                    </p>
                                    @endif
                                </div>
                                <div class="appointment-status">
                                    @php
                                        $status = $appointment->status ?? 'upcoming';
                                        $statusClass = 'status-upcoming';
                                        $statusIcon = 'fa-calendar-check';
                                        
                                        if($status == 'completed') {
                                            $statusClass = 'status-completed';
                                            $statusIcon = 'fa-check-circle';
                                        } else if($status == 'cancelled') {
                                            $statusClass = 'status-cancelled';
                                            $statusIcon = 'fa-times-circle';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="fas {{ $statusIcon }}"></i> 
                                        {{ ucfirst($status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="view-all-appointments">
                            <a href="{{ route('doctor.appointment.list') }}" class="btn btn-outline">
                                <i class="fas fa-eye"></i> View All Appointments
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Appointment & Patient Statistics Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <h4><i class="fas fa-chart-bar"></i> Professional Statistics</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-icon completed">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ $completedAppointments ?? '0' }}</h3>
                                    <p>Completed</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon upcoming">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ $upcomingAppointments ?? '0' }}</h3>
                                    <p>Upcoming</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon patients">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ $totalPatients ?? '0' }}</h3>
                                    <p>Patients</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon total">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ $totalAssessments ?? '0' }}</h3>
                                    <p>Assessments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <a href="{{ route('doctor.appointment.list') }}" class="quick-action-btn appointment">
                        <i class="fas fa-calendar-check"></i>
                        <span>View Appointments</span>
                    </a>
                    <a href="{{ route('doctor.profile.edit') }}" class="quick-action-btn edit">
                        <i class="fas fa-user-edit"></i>
                        <span>Update Profile</span>
                    </a>
                    <a href="" class="quick-action-btn security">
                        <i class="fas fa-key"></i>
                        <span>Change Password</span>
                    </a>
                    <a href="{{ route('doctor.patientlistdoct') }}" class="quick-action-btn medical">
                        <i class="fas fa-users"></i>
                        <span>View Patients</span>
                    </a>
                </div>

                <!-- Back to Dashboard Button -->
                <div class="appointment-actions">
                    <a href="{{ route('doctor.indexdoctor') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
</div>

<!-- JS files -->
<script src="{{ asset('js/script.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/scrollreveal"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const dashboardLayout = document.querySelector('.dashboard-layout');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            dashboardLayout.classList.toggle('sidebar-collapsed');
        });
    }

    // ScrollReveal animations
    ScrollReveal().reveal('.content-container', {
        origin: 'top',
        distance: '20px',
        duration: 1000,
        delay: 200,
        easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
        reset: false
    });

    ScrollReveal().reveal('.profile-card', {
        origin: 'bottom',
        distance: '20px',
        duration: 1000,
        interval: 200,
        delay: 300,
        easing