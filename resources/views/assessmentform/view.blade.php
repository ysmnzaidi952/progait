<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Assessment Details</title>

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
            <li class="active">
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
                <h2>Assessment Details</h2>
            </div>
            <div class="header-right">
                <div class="header-notifications">
                    <div class="notifications-icon">
                    <a href="{{ url('/staff/indexadmin2') }}" class="link-btn">Home</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="content-container">
                <div class="assessment-details-header">
                    <h3 class="patient-name">{{ $assessment->patient->patientName ?? 'Unknown Patient' }}</h3>
                    <div class="assessment-meta">
                        <span class="assessment-date">
                            <i class="far fa-calendar-alt"></i> {{ $assessment->created_at->format('d/m/Y') }}
                        </span>
                        <span class="assessment-time">
                            <i class="far fa-clock"></i> {{ $assessment->created_at->format('h:i A') }}
                        </span>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('admin.assessment.list') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('admin.assessment.edit', $assessment->formID) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </div>

                <!-- Patient Information Card -->
                <div class="assessment-card">
                    <div class="card-header">
                        <h4><i class="fas fa-user"></i> Patient Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <div class="info-label">Patient Name:</div>
                            <div class="info-value">{{ $assessment->patient->patientName ?? 'Not available' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">NRIC / Passport:</div>
                            <div class="info-value">{{ $assessment->patient->patientIC ?? 'Not available' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Phone Number:</div>
                            <div class="info-value">{{ $assessment->patient->patientTel ?? 'Not available' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Assessment Information Card -->
                <div class="assessment-card">
                    <div class="card-header">
                        <h4><i class="fas fa-notes-medical"></i> Assessment Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <div class="info-label">Hospital:</div>
                            <div class="info-value">{{ $assessment->hospital ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Foot Size:</div>
                            <div class="info-value">{{ $assessment->footSize ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Liner Size:</div>
                            <div class="info-value">{{ $assessment->linerSize ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Prosthesis No:</div>
                            <div class="info-value">{{ $assessment->prosthesisNo ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Reason for Amputation:</div>
                            <div class="info-value">{{ $assessment->reasonAmputation ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Patient Assessment:</div>
                            <div class="info-value">{{ $assessment->patientAssessment ?? 'Not provided' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Dialysis Days:</div>
                            <div class="info-value">
                                @if(isset($assessment->dialysisDay) && !empty($assessment->dialysisDay))
                                @php
                                    $dialysisDays = $assessment->dialysisDay ? explode(',', $assessment->dialysisDay) : [];
                                @endphp
                                    @if(!empty($dialysisDays))
                                        @foreach($dialysisDays as $day)
                                            <span class="dialysis-day-badge">{{ trim($day) }}</span>
                                        @endforeach
                                    @else
                                        None
                                    @endif
                                @else
                                    None
                                @endif
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Component Suggestions:</div>
                            <div class="info-value">{{ $assessment->componentSuggestions ?? 'Not provided' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Attended By:</div>
                            <div class="info-value">{{ $assessment->attendedBy ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Prescribed By:</div>
                            <div class="info-value">{{ $assessment->prescribedBy ?? 'Not specified' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Receive Date:</div>
                            <div class="info-value">{{ $assessment->receiveDate ? date('d/m/Y', strtotime($assessment->receiveDate)) : 'Not specified' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the assessment record for <strong>{{ $assessment->patient->patientName ?? 'this patient' }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form action="{{ route('admin.assessment.destroy', $assessment->formID) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
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
        ScrollReveal().reveal('.assessment-card', {
            origin: 'bottom',
            distance: '20px',
            duration: 1000,
            interval: 200,
            delay: 200,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });
    });
</script>

<style>
    /* Additional styling specific to the assessment view */
    .assessment-details-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--light-bg);
    }

    .patient-name {
        font-size: 2.5rem;
        color: var(--black);
        font-weight: 600;
        margin: 0;
    }

    .assessment-meta {
        display: flex;
        gap: 2rem;
    }

    .assessment-date,
    .assessment-time {
        font-size: 1.6rem;
        color: var(--light-color);
        display: flex;
        align-items: center;
        gap: 0.8rem;
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

    .assessment-card {
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

    .dialysis-day-badge {
        display: inline-block;
        background-color: rgba(125, 125, 235, 0.1);
        color: var(--blue);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 1.3rem;
        margin-right: 0.8rem;
        margin-bottom: 0.8rem;
    }

    .modal-header {
        background-color: var(--blue);
        color: var(--white);
    }

    .modal-title {
        font-size: 1.8rem;
    }

    .modal-body {
        font-size: 1.5rem;
        padding: 2rem;
    }

    .modal-footer .btn {
        padding: 1rem 2rem;
        font-size: 1.5rem;
        border-radius: 0.5rem;
    }

    @media (max-width: 768px) {
        .assessment-details-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .assessment-meta {
            flex-direction: column;
            gap: 0.8rem;
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

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
        }
    }
</style>

</body>
</html>