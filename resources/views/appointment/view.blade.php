<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - View Appointment</title>

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
            <li class="active">
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
                <h2>View Appointment</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                    <a href="{{ url('/staff/indexdoctor2') }}" class="link-btn">Home</a>
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

                <div class="appointment-view-header">
                    <div class="appointment-status-badge">
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
                            <i class="fas {{ $statusIcon }}"></i> {{ ucfirst($status) }}
                        </span>
                    </div>
                    <h3>Appointment for {{ $appointment->patientName }}</h3>
                    <div class="appointment-meta">
                        <span class="appointment-id">
                            <i class="fas fa-hashtag"></i> ID: {{ $appointment->appID }}
                        </span>
                        <span class="appointment-created">
                            <i class="fas fa-calendar-plus"></i> Created: {{ $appointment->created_at->format('d/m/Y h:i A') }}
                        </span>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('admin.appointment.list') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('admin.appointment.edit', $appointment->appID) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelModal">
                        <i class="fas fa-times-circle"></i> Cancel Appointment
                    </button>

                </div>

                <!-- Appointment Information Card -->
                <div class="info-row">
                    <div class="info-label">Patient Name:</div>
                    <div class="info-value">{{ $appointment->patient->patientName ?? 'Not specified' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">NRIC / Passport:</div>
                    <div class="info-value">{{ $appointment->patient->patientIC ?? 'Not specified' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Telephone Number:</div>
                    <div class="info-value">{{ $appointment->patient->patientTel ?? 'Not specified' }}</div>
                </div>

                <!-- Appointment Details Card -->
                <div class="appointment-card">
                    <div class="card-header">
                        <h4><i class="fas fa-calendar-alt"></i> Appointment Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <div class="info-label">Hospital Referral:</div>
                            <div class="info-value">{{ $appointment->hospitalRefer ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Sponsor:</div>
                            <div class="info-value">{{ $appointment->sponsor ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Next Hospital Appointment:</div>
                            <div class="info-value">
                                {{ $appointment->nextHospitalAppointment ? date('d/m/Y', strtotime($appointment->nextHospitalAppointment)) : 'Not specified' }}
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Walk-in Appointment Date:</div>
                            <div class="info-value">{{ date('d/m/Y', strtotime($appointment->appointmentDate)) }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Walk-in Appointment Time:</div>
                            <div class="info-value">
                                @php
                                    $startTime = date('h:i A', strtotime($appointment->appointmentTime));
                                    $endTime = date('h:i A', strtotime('+2 hours', strtotime($appointment->appointmentTime)));
                                @endphp
                                {{ $startTime }} - {{ $endTime }}
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Notes:</div>
                            <div class="info-value">{{ $appointment->notes ?? 'No notes provided' }}</div>
                        </div>
                        @if($appointment->status == 'cancelled' && $appointment->cancelReason)
                        <div class="info-row">
                            <div class="info-label">Cancellation Reason:</div>
                            <div class="info-value">{{ $appointment->cancelReason }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="appointment-card">
                    <div class="card-header">
                        <h4><i class="fas fa-history"></i> Appointment Timeline</h4>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-point">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Appointment Created</h5>
                                    <p class="timeline-date">{{ $appointment->created_at->format('d/m/Y h:i A') }}</p>
                                    <p>Appointment was scheduled by Doctor</p>
                                </div>
                            </div>

                            @if($appointment->updated_at && $appointment->updated_at != $appointment->created_at)
                            <div class="timeline-item">
                                <div class="timeline-point">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Appointment Updated</h5>
                                    <p class="timeline-date">{{ $appointment->updated_at->format('d/m/Y h:i A') }}</p>
                                    <p>Appointment details were modified</p>
                                </div>
                            </div>
                            @endif

                            @if($appointment->status == 'completed')
                            <div class="timeline-item">
                                <div class="timeline-point completed">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Appointment Completed</h5>
                                    <p class="timeline-date">{{ $appointment->completedAt ? date('d/m/Y h:i A', strtotime($appointment->completedAt)) : 'Date not recorded' }}</p>
                                    <p>Patient attended the appointment</p>
                                </div>
                            </div>
                            @elseif($appointment->status == 'cancelled')
                            <div class="timeline-item">
                                <div class="timeline-point cancelled">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Appointment Cancelled</h5>
                                    <p class="timeline-date">{{ $appointment->cancelledAt ? date('d/m/Y h:i A', strtotime($appointment->cancelledAt)) : 'Date not recorded' }}</p>
                                    <p>Reason: {{ $appointment->cancelReason ?? 'No reason provided' }}</p>
                                </div>
                            </div>
                            @elseif(strtotime($appointment->appointmentDate . ' ' . $appointment->appointmentTime) > time())
                            <div class="timeline-item">
                                <div class="timeline-point upcoming">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5>Upcoming Appointment</h5>
                                    <p class="timeline-date">{{ date('d/m/Y h:i A', strtotime($appointment->appointmentDate . ' ' . $appointment->appointmentTime)) }}</p>
                                    <p>Patient is expected to attend</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.appointment.cancel', $appointment->appID) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Cancel Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel the appointment for <strong>{{ $appointment->patientName }}</strong>?</p>

                    <div class="form-group">
                        <label for="cancelReason">Reason for Cancellation:</label>
                        <textarea class="form-control" id="cancelReason" name="cancelReason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS files -->
<script src="{{ asset('js/script.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
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
        ScrollReveal().reveal('.appointment-card', {
            origin: 'bottom',
            distance: '20px',
            duration: 1000,
            interval: 200,
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

        // If the appointment is completed or cancelled, disable the cancel button
        @if($appointment->status == 'completed' || $appointment->status == 'cancelled')
            const cancelButton = document.querySelector('.btn-danger[data-toggle="modal"]');
            if (cancelButton) {
                cancelButton.disabled = true;
                cancelButton.classList.add('disabled');
                cancelButton.setAttribute('title', 'Cannot cancel a {{ $appointment->status }} appointment');
            }
        @endif
    });
</script>

<style>

    /* Additional styling for appointment view */
    .appointment-view-header {
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--light-bg);
    }

    .appointment-view-header h3 {
        font-size: 2.5rem;
        color: var(--black);
        margin: 1rem 0;
    }

    .appointment-status-badge {
        display: flex;
        justify-content: flex-end;
    }

    .appointment-status-badge .status-badge {
        padding: 0.8rem 1.5rem;
        font-size: 1.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
    }

    .appointment-meta {
        display: flex;
        gap: 2rem;
    }

    .appointment-meta span {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-size: 1.5rem;
        color: var(--light-color);
    }

    .appointment-meta i {
        color: var(--blue);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 1rem 2rem;
        font-size: 1.5rem;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        transition: all 0.3s ease;
    }

    .btn-back {
        background-color: var(--light-bg);
        color: var(--black);
    }

    .btn-back:hover {
        background-color: #e0e0e0;
        color: var(--black);
    }

    .btn-primary {
        background-color: var(--blue);
        color: var(--white);
        border: none;
    }

    .btn-primary:hover {
        background-color: #6c6ce9;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(125, 125, 235, 0.3);
    }

    .btn-danger {
        background-color: #ff6b6b;
        color: var(--white);
        border: none;
    }

    .btn-danger:hover {
        background-color: #e05c5c;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
    }

    .btn-danger.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-danger.disabled:hover {
        transform: none;
        box-shadow: none;
    }

    .btn-info {
        background-color: #26c6da;
        color: var(--white);
        border: none;
    }

    .btn-info:hover {
        background-color: #21b0c2;
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(38, 198, 218, 0.3);
    }

    .appointment-card {
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
    }

    .card-header h4 i {
        color: var(--blue);
    }

    .card-body {
        padding: 2rem;
    }

    .info-row {
        display: flex;
        margin-bottom: 1.5rem;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.05);
        padding-bottom: 1.5rem;
    }

    .info-row:last-child {
        margin-bottom: 0;
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        width: 30%;
        font-size: 1.5rem;
        color: var(--light-color);
        font-weight: 500;
    }

    .info-value {
        width: 70%;
        font-size: 1.6rem;
        color: var(--black);
    }

    /* Timeline styling */
    .timeline {
        position: relative;
        padding-left: 3rem;
    }

    .timeline:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 2px;
        background-color: var(--light-bg);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2.5rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-point {
        position: absolute;
        left: -3rem;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
        background-color: var(--blue);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    .timeline-point i {
        font-size: 1.8rem;
    }

    .timeline-point.completed {
        background-color: #4bd28f;
    }

    .timeline-point.cancelled {
        background-color: #ff6b6b;
    }

    .timeline-point.upcoming {
        background-color: #ffab00;
    }

    .timeline-content {
        padding-left: 2rem;
        padding-bottom: 1rem;
    }

    .timeline-content h5 {
        font-size: 1.8rem;
        color: var(--black);
        margin-bottom: 0.5rem;
    }

    .timeline-date {
        font-size: 1.4rem;
        color: var(--light-color);
        font-style: italic;
        margin-bottom: 0.8rem;
    }

    .timeline-content p {
        font-size: 1.5rem;
        color: var(--light-color);
        margin-bottom: 0.5rem;
    }

    /* Modal Styling */
    .modal-header {
        background-color: var(--blue);
        color: var(--white);
        border-bottom: none;
        padding: 1.5rem 2rem;
    }

    .modal-title {
        font-size: 2rem;
        font-weight: 600;
    }

    .modal-body {
        padding: 2rem;
        font-size: 1.6rem;
        color: var(--black);
    }

    .modal-body p {
        margin-bottom: 2rem;
    }

    .modal-body .form-group label {
        font-size: 1.5rem;
        color: var(--black);
        font-weight: 500;
        margin-bottom: 0.8rem;
    }

    .modal-body .form-control {
        font-size: 1.5rem;
        padding: 1rem 1.2rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        color: var(--black);
    }

    .modal-footer {
        border-top: none;
        padding: 1.5rem 2rem 2rem;
    }

    .modal-footer .btn {
        padding: 1rem 2rem;
        font-size: 1.5rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
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

    @media (max-width: 991px) {
        .appointment-view-header {
            text-align: center;
        }

        .appointment-meta {
            justify-content: center;
            flex-wrap: wrap;
        }

        .action-buttons {
            justify-content: center;
        }

        .info-row {
            flex-direction: column;
        }

        .info-label,
        .info-value {
            width: 100%;
        }

        .info-label {
            margin-bottom: 0.5rem;
        }
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }

        .appointment-status-badge {
            justify-content: center;
        }
    }
</style>

</body>
</html>
