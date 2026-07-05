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
                <h3>Patient Dashboard</h3>
                <p>Welcome, <span>{{ Auth::user()->name }}</span></p>
            </div>

            <button id="sidebar-toggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('patient.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('patient.profile') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('patient.medical-record') }}">
                        <i class="fas fa-file-medical"></i>
                        <span>Medical Record</span>
                    </a>
                </li>
                <li class="active">
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
                <h2>View Appointment Details</h2>
            </div>
            <div class="header-right">
                <div class="header-notifications">
                    <div class="notifications-icon">
                        <a href="{{ route('patient.appointment.list') }}" class="link-btn">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
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

                <div class="appointment-view-card">
                    <div class="appointment-header">
                        <div class="appointment-status {{ $appointment->status == 'Confirmed' ? 'confirmed' : ($appointment->status == 'Pending' ? 'pending' : 'cancelled') }}">
                            <i class="fas {{ $appointment->status == 'Confirmed' ? 'fa-check-circle' : ($appointment->status == 'Pending' ? 'fa-clock' : 'fa-times-circle') }}"></i>
                            {{ $appointment->status }}
                        </div>
                        <div class="appointment-id">
                            <span>Appointment ID:</span> #{{ $appointment->appID }}
                        </div>
                    </div>

                    <div class="appointment-sections">
                        <div class="appointment-section">
                            <h3 class="section-title">
                                <i class="fas fa-calendar-day"></i> Date & Time
                            </h3>
                            <div class="appointment-datetime">
                                <div class="datetime-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ date('l, F d, Y', strtotime($appointment->appointmentDate)) }}</span>
                                </div>
                                <div class="datetime-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ date('h:i A', strtotime($appointment->appointmentTime)) }} - {{ date('h:i A', strtotime($appointment->appointmentTime) + 7200) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="appointment-section">
                            <h3 class="section-title">
                                <i class="fas fa-user-circle"></i> Patient Information
                            </h3>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Name</div>
                                    <div class="info-value">{{ $appointment->patientName }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">IC/Passport</div>
                                    <div class="info-value">{{ $appointment->patientIC }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Contact Number</div>
                                    <div class="info-value">{{ $appointment->patientTel }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="appointment-section">
                            <h3 class="section-title">
                                <i class="fas fa-clipboard-list"></i> Appointment Details
                            </h3>
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Type of Amputee</div>
                                    <div class="info-value">{{ $appointment->typeAmputee }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Hospital Referral</div>
                                    <div class="info-value">{{ $appointment->hospitalRefer ?: 'Not specified' }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Sponsor</div>
                                    <div class="info-value">{{ $appointment->sponsor ?: 'Not specified' }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Next Hospital Appointment</div>
                                    <div class="info-value">{{ $appointment->nextHospitalAppointment ? date('F d, Y', strtotime($appointment->nextHospitalAppointment)) : 'Not specified' }}</div>
                                </div>
                                <div class="info-item full-width">
                                    <div class="info-label">Additional Notes</div>
                                    <div class="info-value notes-value">{{ $appointment->notes ?: 'No additional notes provided.' }}</div>
                                </div>
                            </div>
                        </div>

                        @if($appointment->feedback)
                        <div class="appointment-section">
                            <h3 class="section-title">
                                <i class="fas fa-comment-alt"></i> Staff Feedback
                            </h3>
                            <div class="feedback-content">
                                {{ $appointment->feedback }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="appointment-actions">
                        @if($appointment->status != 'Cancelled')
                            <!-- <a href="{{ route('patient.appointment.edit', $appointment->id) }}" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit Appointment
                            </a> -->

                            <button type="button" class="btn btn-cancel" data-toggle="modal" data-target="#cancelModal">
                                <i class="fas fa-times-circle"></i> Cancel Appointment
                            </button>
                        @else
                            <a href="{{ route('patient.appointment.create') }}" class="btn btn-primary">
                                <i class="fas fa-calendar-plus"></i> Book New Appointment
                            </a>
                        @endif

                        <a href="{{ route('patient.appointment.print', $appointment->appID) }}" class="btn btn-print" target="_blank">
                            <i class="fas fa-print"></i> Print Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
</div>

<!-- Cancel Appointment Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('patient.appointment.cancel', $appointment->appID) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to cancel this appointment scheduled for <strong>{{ date('F d, Y', strtotime($appointment->appointmentDate)) }}</strong> at <strong>{{ date('h:i A', strtotime($appointment->appointmentTime)) }}</strong>?</p>


                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Note: You may reschedule your appointment instead of cancelling if you're unable to make it on the scheduled date.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Keep It</button>
                    <button type="submit" class="btn btn-danger">Yes, Cancel Appointment</button>
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
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const dashboardLayout = document.querySelector('.dashboard-layout');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            dashboardLayout.classList.toggle('sidebar-collapsed');
        });
    }

    // ScrollReveal animation
    ScrollReveal().reveal('.content-container', {
        origin: 'top',
        distance: '20px',
        duration: 1000,
        delay: 200,
        easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
        reset: false
    });

    // Auto-dismiss success message
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.transition = 'opacity 1s ease';
            successMessage.style.opacity = '0';
        }, 5000);
    }
});
</script>

<style>
/* Additional styling for appointment view page */
.appointment-view-card {
    background-color: var(--white);
    border-radius: 1rem;
    box-shadow: var(--box-shadow);
    overflow: hidden;
}

.appointment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 2rem;
    background-color: var(--light-bg);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.appointment-status {
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 1.5rem;
    border-radius: 5rem;
    font-size: 1.6rem;
    font-weight: 600;
}

.appointment-status.confirmed {
    background-color: rgba(75, 210, 143, 0.1);
    color: #4bd28f;
}

.appointment-status.pending {
    background-color: rgba(255, 171, 0, 0.1);
    color: #ffab00;
}

.appointment-status.cancelled {
    background-color: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
}

.appointment-id {
    font-size: 1.5rem;
    color: var(--light-color);
}

.appointment-id span {
    font-weight: 600;
}

.appointment-sections {
    padding: 2rem;
}

.appointment-section {
    margin-bottom: 2.5rem;
    padding-bottom: 2.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.appointment-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.section-title {
    font-size: 2rem;
    color: var(--blue);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.appointment-datetime {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
}

.datetime-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 1.8rem;
    color: var(--black);
}

.datetime-item i {
    color: var(--blue);
    font-size: 2rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-label {
    font-size: 1.4rem;
    color: var(--light-color);
    font-weight: 500;
}

.info-value {
    font-size: 1.6rem;
    color: var(--black);
    font-weight: 600;
}

.notes-value {
    padding: 1.5rem;
    background-color: var(--light-bg);
    border-radius: 0.5rem;
    font-weight: normal;
    white-space: pre-line;
}

.feedback-content {
    padding: 1.5rem;
    background-color: rgba(125, 125, 235, 0.05);
    border-radius: 0.5rem;
    border-left: 4px solid var(--blue);
    font-size: 1.6rem;
    color: var(--black);
    white-space: pre-line;
}

.appointment-actions {
    padding: 2rem;
    display: flex;
    gap: 1.5rem;
    background-color: var(--light-bg);
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.btn {
    padding: 1.2rem 2rem;
    font-size: 1.6rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-edit {
    background-color: #ffab00;
    color: var(--white);
}

.btn-edit:hover {
    background-color: #e69900;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255, 171, 0, 0.2);
}

.btn-cancel {
    background-color: #ff6b6b;
    color: var(--white);
}

.btn-cancel:hover {
    background-color: #e05c5c;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255, 107, 107, 0.2);
}

.btn-print {
    background-color: var(--black);
    color: var(--white);
    margin-left: auto;
}

.btn-print:hover {
    background-color: #444;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.modal-content {
    border-radius: 1rem;
    overflow: hidden;
}

.modal-header {
    background-color: var(--blue);
    color: var(--white);
    padding: 1.5rem 2rem;
}

.modal-title {
    font-size: 2rem;
    font-weight: 600;
}

.modal-body {
    padding: 2rem;
    font-size: 1.6rem;
}

.modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.modal-footer .btn {
    font-size: 1.5rem;
}

.alert-warning {
    background-color: #FFF3CD;
    color: #856404;
    padding: 1.5rem;
    border-radius: 0.5rem;
    font-size: 1.4rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.alert-warning i {
    font-size: 1.8rem;
    color: #ffab00;
}

@media (max-width: 768px) {
    .appointment-header {
        flex-direction: column;
        gap: 1.5rem;
        align-items: flex-start;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .appointment-datetime {
        flex-direction: column;
        gap: 1rem;
    }

    .appointment-actions {
        flex-direction: column;
    }

    .btn-print {
        margin-left: 0;
    }
}
</style>

</body>
</html>
