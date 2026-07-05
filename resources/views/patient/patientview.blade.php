<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Patient Details</title>

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
                <li class="active">
                    <a href="{{ route('admin.patient.patientlist') }}">
                        <i class="fas fa-user-injured"></i>
                        <span>Patient List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.doctor.doctorlist') ? 'active' : '' }}">
                    <a href="{{ route('admin.doctor.doctorlist') }}">
                        <i class="fas fa-user-md"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.medical.list') ? 'active' : '' }}">
                    <a href="{{ route('admin.medical.list') }}">
                        <i class="fas fa-file-medical-alt"></i>
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
                <li class="{{ request()->routeIs('admin.component.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.component.create') }}">
                        <i class="fas fa-cogs"></i>
                        <span>Component Devices</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.recommendation') ? 'active' : '' }}">
                    <a href="{{ route('admin.recommendation', ['patientId' => 1]) }}">
                        <i class="fas fa-lightbulb"></i>
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
                <h2>Patient Details</h2>
                <p class="header-subtitle">View complete patient information and profile</p>
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
                                <i class="fas fa-user-injured"></i>
                            </div>
                        </div>
                        <div class="profile-info">
                            <h3>{{ $patient->patientName }}</h3>
                            <p class="staff-id">Patient ID: <span>{{ $patient->patientID }}</span></p>
                            <p class="staff-role">
                                <i class="fas fa-heartbeat"></i>
                                Patient
                            </p>
                            <p class="registration-date">
                                <i class="fas fa-calendar-plus"></i>
                                Registered: {{ $patient->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <a href="{{ route('admin.patient.patientupdate', $patient->patientID) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
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
                                <div class="info-label">NRIC Number:</div>
                                <div class="info-value">{{ $patient->patientIC }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Date of Birth:</div>
                                <div class="info-value">
                                    @if($patient->dateOfBirth)
                                        {{ date('d/m/Y', strtotime($patient->dateOfBirth)) }}
                                        <span class="age-display">({{ \Carbon\Carbon::parse($patient->dateOfBirth)->age }} years old)</span>
                                    @else
                                        Not provided
                                    @endif
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Gender:</div>
                                <div class="info-value">{{ $patient->gender ?? 'Not specified' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Race:</div>
                                <div class="info-value">{{ $patient->race ?? 'Not specified' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Marital Status:</div>
                                <div class="info-value">{{ $patient->maritalStatus ?? 'Not specified' }}</div>
                            </div>
                            <div class="info-row full-width">
                                <div class="info-label">Address:</div>
                                <div class="info-value">{{ $patient->address ?? 'Not provided' }}</div>
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
                                <div class="info-label">Contact Number:</div>
                                <div class="info-value">
                                    <a href="tel:{{ $patient->patientTel }}" class="contact-link">
                                        <i class="fas fa-phone"></i> {{ $patient->patientTel }}
                                    </a>
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
                                    <span class="staff-id-display">{{ $patient->patientID }}</span>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Account Created:</div>
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
                        </div>
                    </div>
                </div>

                <!-- Back to Patient List Button -->
                <div class="appointment-actions">
                    <a href="{{ route('admin.patient.patientlist') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to Patient List
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

    ScrollReveal().reveal('.appointment-actions', {
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
});
</script>

<style>
    /* Admin Profile View Specific Styles */
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

    .staff-id {
        font-size: 1.4rem;
        color: var(--blue);
        margin-bottom: 0.3rem;
        font-weight: 500;
    }

    .staff-id span {
        font-family: 'Consolas', monospace;
        background-color: rgba(125, 125, 235, 0.1);
        padding: 0.3rem 0.8rem;
        border-radius: 0.3rem;
    }

    .staff-role {
        font-size: 1.3rem;
        color: var(--blue);
        margin-bottom: 0.3rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .staff-id-display {
        font-family: 'Consolas', monospace;
        background-color: rgba(125, 125, 235, 0.1);
        color: var(--blue);
        padding: 0.5rem 1rem;
        border-radius: 0.3rem;
        font-weight: 600;
    }

    .registration-date {
        font-size: 1.3rem;
        color: var(--light-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
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

    .info-row.full-width {
        grid-column: 1 / -1;
    }

    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
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

    .age-display {
        font-size: 1.4rem;
        color: var(--light-color);
        font-style: italic;
        margin-left: 0.5rem;
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
    }

    @media (max-width: 768px) {
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

        .staff-id {
            font-size: 1.3rem;
        }

        .registration-date {
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
</style>

</body>
</html>