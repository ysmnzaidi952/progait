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
            <div class="admin-info">
                <h3>Patient Dashboard</h3>
                <p>Welcome, <span>{{ Auth::guard('patient')->user()->patientName }}</span></p>
            </div>

            <button id="sidebar-toggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <nav class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('patient.indexpatient') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('patient.profile') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('patient.appointment.list') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Appointment</span>
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
                        <a href="{{ route('patient.indexpatient') }}" class="link-btn">Home</a>
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
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="profile-info">
                            <h3>{{ $patient->patientName }}</h3>
                            <p class="patient-id">Patient ID: <span>{{ $patient->patientID }}</span></p>
                            <p class="registration-date">
                                <i class="fas fa-calendar-plus"></i> 
                                Registered: {{ $patient->created_at->format('d/m/Y') }}
                            </p>
                            @if($patient->dateOfBirth)
                            <p class="age-info">
                                <i class="fas fa-birthday-cake"></i>
                                Age: {{ \Carbon\Carbon::parse($patient->dateOfBirth)->age }} years old
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="profile-actions">
                        <a href="{{ route('patient.profile.edit') }}" class="btn btn-primary">
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
                                <div class="info-value">{{ $patient->patientName }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">NRIC / Passport:</div>
                                <div class="info-value">{{ $patient->patientIC }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Date of Birth:</div>
                                <div class="info-value">
                                    @if($patient->dateOfBirth)
                                        {{ \Carbon\Carbon::parse($patient->dateOfBirth)->format('d/m/Y') }}
                                        <span class="age-badge">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($patient->dateOfBirth)->age }} years old
                                        </span>
                                    @else
                                        <span class="not-provided">Not provided</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Gender:</div>
                                <div class="info-value">
                                    @if($patient->gender)
                                        <span class="gender-badge">
                                            <i class="fas {{ $patient->gender == 'Male' ? 'fa-mars' : ($patient->gender == 'Female' ? 'fa-venus' : 'fa-venus-mars') }}"></i>
                                            {{ $patient->gender }}
                                        </span>
                                    @else
                                        <span class="not-provided">Not specified</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Race/Ethnicity:</div>
                                <div class="info-value">
                                    @if($patient->race)
                                        <span class="race-badge">
                                            <i class="fas fa-users"></i>
                                            {{ $patient->race }}
                                        </span>
                                    @else
                                        <span class="not-provided">Not specified</span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Marital Status:</div>
                                <div class="info-value">
                                    @if($patient->maritalStatus)
                                        <span class="marital-badge">
                                            <i class="fas {{ $patient->maritalStatus == 'Married' ? 'fa-heart' : ($patient->maritalStatus == 'Single' ? 'fa-user' : 'fa-user-friends') }}"></i>
                                            {{ $patient->maritalStatus }}
                                        </span>
                                    @else
                                        <span class="not-provided">Not specified</span>
                                    @endif
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
                                    <a href="mailto:{{ $patient->patientEmail }}" class="contact-link">
                                        <i class="fas fa-envelope"></i> {{ $patient->patientEmail }}
                                    </a>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Telephone Number:</div>
                                <div class="info-value">
                                    <a href="tel:{{ $patient->patientTel }}" class="contact-link">
                                        <i class="fas fa-phone"></i> {{ $patient->patientTel }}
                                    </a>
                                </div>
                            </div>
                            <div class="info-row address-row">
                                <div class="info-label">Address:</div>
                                <div class="info-value">
                                    @if($patient->address)
                                        <div class="address-content">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $patient->address }}</span>
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
                                <div class="info-label">Patient ID:</div>
                                <div class="info-value">
                                    <span class="patient-id-display">{{ $patient->patientID }}</span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Registration Date:</div>
                                <div class="info-value">
                                    {{ $patient->created_at->format('d/m/Y h:i A') }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Last Updated:</div>
                                <div class="info-value">
                                    {{ $patient->updated_at->format('d/m/Y h:i A') }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Profile Completeness:</div>
                                <div class="info-value">
                                    @php
                                        $completedFields = 0;
                                        $totalFields = 8; // Total profile fields based on database
                                        
                                        if($patient->patientName) $completedFields++;
                                        if($patient->patientEmail) $completedFields++;
                                        if($patient->patientTel) $completedFields++;
                                        if($patient->patientIC) $completedFields++;
                                        if($patient->dateOfBirth) $completedFields++;
                                        if($patient->gender) $completedFields++;
                                        if($patient->maritalStatus) $completedFields++;
                                        if($patient->address) $completedFields++;
                                        if($patient->race) $completedFields++;
                                        
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
                                    <h5>{{ $appointment->typeAmputee ?? 'General Consultation' }}</h5>
                                    <p class="appointment-time">
                                        <i class="fas fa-clock"></i> 
                                        {{ date('h:i A', strtotime($appointment->appointmentTime)) }}
                                    </p>
                                    @if($appointment->hospitalRefer)
                                    <p class="hospital-ref">
                                        <i class="fas fa-hospital"></i> 
                                        Referred by: {{ $appointment->hospitalRefer }}
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
                            <a href="{{ route('patient.appointment.list') }}" class="btn btn-outline">
                                <i class="fas fa-eye"></i> View All Appointments
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Appointment Statistics Card -->
                <div class="profile-card">
                    <div class="card-header">
                        <h4><i class="fas fa-chart-bar"></i> Appointment Statistics</h4>
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
                                <div class="stat-icon cancelled">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ $cancelledAppointments ?? '0' }}</h3>
                                    <p>Cancelled</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon total">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ $totalAppointments ?? '0' }}</h3>
                                    <p>Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <a href="{{ route('patient.appointment.create') }}" class="quick-action-btn appointment">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Book Appointment</span>
                    </a>
                    <a href="{{ route('patient.profile.edit') }}" class="quick-action-btn edit">
                        <i class="fas fa-user-edit"></i>
                        <span>Update Profile</span>
                    </a>
                    <a href="" class="quick-action-btn security">
                        <i class="fas fa-key"></i>
                        <span>Change Password</span>
                    </a>
                    <a href="{{ route('patient.appointment.list') }}" class="quick-action-btn medical">
                        <i class="fas fa-file-medical"></i>
                        <span>View Appointments</span>
                    </a>
                </div>

                <!-- Back to Dashboard Button -->
                <div class="appointment-actions">
                    <a href="{{ route('patient.indexpatient') }}" class="btn btn-primary">
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
        easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
        reset: false
    });

    ScrollReveal().reveal('.quick-actions', {
        origin: 'bottom',
        distance: '20px',
        duration: 1000,
        delay: 800,
        easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
        reset: false
    });

    // Success message fadeout
    const successMessage = document.querySelector('.success-message');
    const errorMessage = document.querySelector('.error-message');
    
    if (successMessage) {
        setTimeout(function() {
            successMessage.style.transition = 'opacity 1s ease';
            successMessage.style.opacity = '0';
        }, 5000);
    }
    
    if (errorMessage) {
        setTimeout(function() {
            errorMessage.style.transition = 'opacity 1s ease';
            errorMessage.style.opacity = '0';
        }, 5000);
    }

    // Add click effects to quick action buttons
    const quickActionBtns = document.querySelectorAll('.quick-action-btn');
    quickActionBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
});
</script>

<style>
    /* Patient Profile View Specific Styles */
    .profile-view-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem 2rem;
        background-color: var(--white);
        border-radius: 1rem;
        box-shadow: var(--box-shadow);
    }

    .profile-avatar-section {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .profile-avatar-large {
        width: 8rem;
        height: 8rem;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid var(--blue);
        box-shadow: 0 4px 15px rgba(125, 125, 235, 0.3);
        flex-shrink: 0;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background-color: var(--light-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--light-color);
    }

    .avatar-placeholder i {
        font-size: 3.5rem;
    }

    .profile-info h3 {
        font-size: 2.2rem;
        color: var(--black);
        margin-bottom: 0.3rem;
        font-weight: 600;
        line-height: 1.2;
    }

    .patient-id {
        font-size: 1.4rem;
        color: var(--blue);
        margin-bottom: 0.3rem;
        font-weight: 500;
    }

    .patient-id span {
        font-family: 'Consolas', monospace;
        background-color: rgba(125, 125, 235, 0.1);
        padding: 0.3rem 0.8rem;
        border-radius: 0.3rem;
    }

    .patient-id-display {
        font-family: 'Consolas', monospace;
        background-color: rgba(125, 125, 235, 0.1);
        color: var(--blue);
        padding: 0.5rem 1rem;
        border-radius: 0.3rem;
        font-weight: 600;
    }

    .registration-date, .age-info {
        font-size: 1.3rem;
        color: var(--light-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0.2rem 0;
        line-height: 1.2;
    }

    .profile-actions {
        display: flex;
        gap: 1rem;
        flex-shrink: 0;
    }

    /* Card styling */
    .profile-card {
        background-color: var(--white);
        border-radius: 1rem;
        box-shadow: var(--box-shadow);
        margin-bottom: 2.5rem;
        overflow: hidden;
    }

    .card-header {
        background-color: var(--light-bg);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-header h4 {
        font-size: 1.8rem;
        color: var(--black);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
    }

    .card-header h4 i {
        color: var(--blue);
    }

    .card-body {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    .info-row {
        display: flex;
        flex-direction: column;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        padding-bottom: 1.5rem;
    }

    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .address-row {
        grid-column: 1 / -1; /* Full width for address */
    }

    .info-label {
        font-size: 1.4rem;
        color: var(--light-color);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .info-value {
        font-size: 1.6rem;
        color: var(--black);
        font-weight: 500;
    }

    .contact-link {
        color: var(--blue);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .contact-link:hover {
        color: #6c6ce9;
        transform: translateX(3px);
        text-decoration: none;
    }

    /* Enhanced Badge Styles */
    .status-badge, .age-badge, .race-badge, .marital-badge, .gender-badge {
        padding: 0.6rem 1.2rem;
        border-radius: 2rem;
        font-size: 1.3rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-upcoming {
        background-color: rgba(125, 125, 235, 0.1);
        color: var(--blue);
    }

    .status-completed {
        background-color: rgba(75, 210, 143, 0.1);
        color: #4bd28f;
    }

    .status-cancelled {
        background-color: rgba(255, 107, 107, 0.1);
        color: #ff6b6b;
    }

    .age-badge {
        background-color: rgba(255, 171, 0, 0.1);
        color: #ffab00;
        font-size: 1.2rem;
        margin-left: 1rem;
    }

    .race-badge {
        background-color: rgba(38, 198, 218, 0.1);
        color: #26c6da;
    }

    .marital-badge {
        background-color: rgba(156, 39, 176, 0.1);
        color: #9c27b0;
    }

    .gender-badge {
        background-color: rgba(233, 30, 99, 0.1);
        color: #e91e63;
    }

    .not-provided {
        color: var(--light-color);
        font-style: italic;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .address-content {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        line-height: 1.5;
    }

    .address-content i {
        color: var(--blue);
        margin-top: 0.2rem;
        flex-shrink: 0;
    }

    /* Progress Bar Styles */
    .progress-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .progress-bar {
        flex: 1;
        height: 1rem;
        background-color: #e0e0e0;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--blue), #4bd28f);
        border-radius: 0.5rem;
        transition: width 0.8s ease;
    }

    .progress-text {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--blue);
        min-width: 6rem;
    }

    /* Recent Appointments styling */
    .appointments-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .appointment-item {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        background-color: var(--light-bg);
        border-radius: 0.8rem;
        transition: all 0.3s ease;
    }

    .appointment-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .appointment-date {
        text-align: center;
        margin-right: 1.5rem;
        min-width: 6rem;
    }

    .date-day {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--blue);
        line-height: 1;
    }

    .date-month {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--light-color);
        text-transform: uppercase;
    }

    .date-year {
        font-size: 1.1rem;
        color: var(--light-color);
    }

    .appointment-details {
        flex: 1;
        margin-right: 1.5rem;
    }

    .appointment-details h5 {
        font-size: 1.6rem;
        color: var(--black);
        margin-bottom: 0.8rem;
        font-weight: 600;
    }

    .appointment-time, .hospital-ref, .appointment-notes {
        font-size: 1.3rem;
        color: var(--light-color);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .appointment-time i, .hospital-ref i, .appointment-notes i {
        color: var(--blue);
        width: 1.5rem;
    }

    .appointment-status {
        margin-left: auto;
    }

    .view-all-appointments {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        background-color: var(--light-bg);
        border-radius: 0.8rem;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon i {
        font-size: 2.2rem;
        color: var(--white);
    }

    .stat-icon.completed {
        background-color: #4bd28f;
    }

    .stat-icon.upcoming {
        background-color: var(--blue);
    }

    .stat-icon.cancelled {
        background-color: #ff6b6b;
    }

    .stat-icon.total {
        background-color: #26c6da;
    }

    .stat-info h3 {
        font-size: 2.5rem;
        color: var(--black);
        margin-bottom: 0.3rem;
        font-weight: 700;
    }

    .stat-info p {
        font-size: 1.4rem;
        color: var(--light-color);
        margin: 0;
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .quick-action-btn {
        background-color: var(--white);
        border-radius: 1rem;
        padding: 2rem;
        text-align: center;
        text-decoration: none;
        color: var(--black);
        box-shadow: var(--box-shadow);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .quick-action-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: var(--black);
    }

    .quick-action-btn i {
        font-size: 3rem;
        color: var(--blue);
        transition: all 0.3s ease;
    }

    .quick-action-btn.appointment i {
        color: #4bd28f;
    }

    .quick-action-btn.edit i {
        color: #ffab00;
    }

    .quick-action-btn.security i {
        color: #ff6b6b;
    }

    .quick-action-btn.medical i {
        color: #26c6da;
    }

    .quick-action-btn:hover i {
        transform: scale(1.1);
    }

    .quick-action-btn span {
        font-size: 1.5rem;
        font-weight: 500;
    }

    /* Button styling */
    .btn {
        padding: 1rem 2rem;
        font-size: 1.5rem;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--blue);
        color: var(--white);
    }

    .btn-primary:hover {
        background-color: #6c6ce9;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(125, 125, 235, 0.3);
        color: var(--white);
        text-decoration: none;
    }

    .btn-info {
        background-color: #26c6da;
        color: var(--white);
    }

    .btn-info:hover {
        background-color: #21b0c2;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(38, 198, 218, 0.3);
        color: var(--white);
        text-decoration: none;
    }

    .btn-outline {
        background-color: transparent;
        color: var(--blue);
        border: 2px solid var(--blue);
    }

    .btn-outline:hover {
        background-color: var(--blue);
        color: var(--white);
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(125, 125, 235, 0.3);
        text-decoration: none;
    }

    /* Appointment actions styling */
    .appointment-actions {
        padding: 2rem;
        display: flex;
        justify-content: flex-start;
        gap: 1.5rem;
        background-color: var(--white);
        border-radius: 1rem;
        box-shadow: var(--box-shadow);
    }

    /* Success and Error messages */
    .success-message, .error-message {
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        font-size: 1.6rem;
        transition: opacity 1s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .success-message {
        background-color: #D4EDDA;
        color: #155724;
    }

    .error-message {
        background-color: #FFEBEE;
        color: #B71C1C;
    }

    /* Responsive Design */
    @media (max-width: 1199px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 991px) {
        .profile-view-header {
            flex-direction: column;
            gap: 2rem;
            text-align: center;
        }

        .profile-avatar-section {
            flex-direction: column;
            text-align: center;
        }

        .profile-actions {
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }

        .profile-actions {
            flex-direction: column;
            width: 100%;
        }

        .profile-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .card-body {
            padding: 1.5rem;
        }

        .info-grid {
            gap: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .appointment-item {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .appointment-date {
            margin-right: 0;
        }

        .appointment-details {
            margin-right: 0;
        }

        .appointment-status {
            margin-left: 0;
        }

        .appointment-actions {
            flex-direction: column;
            align-items: flex-start;
        }

        .appointment-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }

        .profile-view-header {
            padding: 1.5rem;
        }

        .profile-avatar-large {
            width: 6rem;
            height: 6rem;
        }

        .avatar-placeholder i {
            font-size: 2.5rem;
        }

        .profile-info h3 {
            font-size: 2rem;
        }

        .patient-id {
            font-size: 1.3rem;
        }

        .registration-date, .age-info {
            font-size: 1.2rem;
        }

        .card-header h4 {
            font-size: 1.6rem;
        }

        .info-label {
            font-size: 1.3rem;
        }

        .info-value {
            font-size: 1.4rem;
        }
    }

    /* Print styles */
    @media print {
        .dashboard-sidebar,
        .dashboard-header,
        .profile-actions,
        .quick-actions,
        .appointment-actions {
            display: none !important;
        }

        .dashboard-main {
            margin-left: 0 !important;
        }

        .profile-card {
            box-shadow: none;
            border: 1px solid #ccc;
            margin-bottom: 2rem;
            page-break-inside: avoid;
        }

        .card-header {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
        }

        body {
            font-size: 12pt;
        }

        .profile-view-header {
            page-break-after: avoid;
        }
    }
</style>

</body>
</html>