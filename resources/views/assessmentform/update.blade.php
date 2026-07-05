<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Edit Assessment</title>

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
                <h2>Edit Assessment</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                    <a href="{{ url('/staff/indexadmin2') }}" class="link-btn">Home</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="content-container">
                <div class="edit-header">
                    <h3>Edit Assessment for {{ $assessment->patient->patientName ?? 'Unknown Patient' }}</h3>
                    <div class="timestamp">
                        <span><i class="far fa-calendar-alt"></i> Created: {{ $assessment->created_at->format('d/m/Y h:i A') }}</span>
                    </div>
                </div>

                <form action="{{ route('admin.assessment.update', $assessment->formID) }}" method="POST" class="assessment-form">
                    @csrf
                    @method('PUT')

                    <h3 class="form-section-title">Patient Information</h3>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="patient_id">Patient</label>
                            <select class="form-control" id="patient_id" name="patient_id" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->patientID }}" 
                                        {{ $assessment->patient_id == $patient->patientID ? 'selected' : '' }}>
                                        {{ $patient->patientName }} ({{ $patient->patientIC }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="hospital">Hospital</label>
                            <input type="text" class="form-control" id="hospital" name="hospital" value="{{ $assessment->hospital }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="footSize">Foot Size</label>
                            <input type="text" class="form-control" id="footSize" name="footSize" value="{{ $assessment->footSize }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="linerSize">Liner Size</label>
                            <input type="text" class="form-control" id="linerSize" name="linerSize" value="{{ $assessment->linerSize }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="prosthesisNo">Prosthesis No</label>
                            <input type="text" class="form-control" id="prosthesisNo" name="prosthesisNo" value="{{ $assessment->prosthesisNo }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="reasonAmputation">Reason for Amputation</label>
                            <input type="text" class="form-control" id="reasonAmputation" name="reasonAmputation" value="{{ $assessment->reasonAmputation }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="patientAssessment">Patient Assessment</label>
                            <textarea class="form-control" id="patientAssessment" name="patientAssessment" rows="4">{{ $assessment->patientAssessment }}</textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Dialysis (Day)</label>
                            <div class="dialysis-days">
                                @php
                                    $dialysisDays = [];
                                    if ($assessment->dialysisDay) {
                                        $dialysisDays = is_array($assessment->dialysisDay) ? $assessment->dialysisDay : explode(',', $assessment->dialysisDay);
                                    }
                                @endphp
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dialysisSun" name="dialysisDay[]" value="Sunday" {{ in_array('Sunday', $dialysisDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dialysisSun">Sun</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dialysisMon" name="dialysisDay[]" value="Monday" {{ in_array('Monday', $dialysisDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dialysisMon">Mon</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dialysisTue" name="dialysisDay[]" value="Tuesday" {{ in_array('Tuesday', $dialysisDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dialysisTue">Tue</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dialysisWed" name="dialysisDay[]" value="Wednesday" {{ in_array('Wednesday', $dialysisDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dialysisWed">Wed</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dialysisThu" name="dialysisDay[]" value="Thursday" {{ in_array('Thursday', $dialysisDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dialysisThu">Thu</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dialysisFri" name="dialysisDay[]" value="Friday" {{ in_array('Friday', $dialysisDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dialysisFri">Fri</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="dialysisSat" name="dialysisDay[]" value="Saturday" {{ in_array('Saturday', $dialysisDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dialysisSat">Sat</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="componentSuggestions">Component Suggestions</label>
                            <textarea class="form-control" id="componentSuggestions" name="componentSuggestions" rows="3">{{ $assessment->componentSuggestions }}</textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="attendedBy">Attended By</label>
                            <select class="form-control" id="attendedBy" name="attendedBy" required>
                                <option value="">Select Staff</option>
                                @foreach($staff as $staffMember)
                                    <option value="{{ $staffMember->staffName }}" 
                                        {{ $assessment->attendedBy == $staffMember->staffName ? 'selected' : '' }}>
                                        {{ $staffMember->staffName }} ({{ $staffMember->staffRole }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="prescribedBy">Prescribed By</label>
                            <select class="form-control" id="prescribedBy" name="prescribedBy" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->docName }}" 
                                        {{ $assessment->prescribedBy == $doctor->docName ? 'selected' : '' }}>
                                        {{ $doctor->docName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="receiveDate">Receive Date</label>
                            <input type="date" class="form-control" id="receiveDate" name="receiveDate" value="{{ $assessment->receiveDate }}">
                        </div>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Assessment
                        </button>
                        <a href="{{ route('admin.assessment.show', $assessment->formID) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
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
        ScrollReveal().reveal('.content-container', {
            origin: 'top',
            distance: '20px',
            duration: 1000,
            delay: 200,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });

        // Patient selection change handler
        $('#patient_id').on('change', function() {
            const patientId = $(this).val();
            if (patientId) {
                // You can add AJAX call here to fetch patient details if needed
                console.log('Selected patient ID:', patientId);
            }
        });
    });
</script>

<style>
    /* Additional styling specific to the assessment form */
    .edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--light-bg);
    }

    .edit-header h3 {
        font-size: 2.2rem;
        color: var(--black);
        font-weight: 600;
        margin: 0;
    }

    .timestamp {
        font-size: 1.4rem;
        color: var(--light-color);
    }

    .timestamp i {
        margin-right: 0.5rem;
    }

    .assessment-form {
        padding: 2rem;
    }

    .form-section-title {
        font-size: 2rem;
        color: var(--blue);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--light-bg);
    }

    .form-row {
        margin-bottom: 1.5rem;
    }

    .form-control {
        font-size: 1.5rem;
        padding: 1rem 1.2rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        color: var(--black);
    }

    .form-control:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 0.2rem rgba(125, 125, 235, 0.25);
    }

    .form-control[readonly] {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    .form-group label {
        font-size: 1.5rem;
        color: var(--black);
        font-weight: 500;
        margin-bottom: 0.8rem;
    }

    .dialysis-days {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .form-check-inline {
        margin-right: 1.5rem;
    }

    .form-check-input {
        width: 1.6rem;
        height: 1.6rem;
        margin-top: 0.3rem;
    }

    .form-check-label {
        font-size: 1.4rem;
        color: var(--black);
        margin-left: 0.5rem;
    }

    .form-buttons {
        display: flex;
        gap: 1.5rem;
        margin-top: 3rem;
    }

    .form-buttons .btn {
        padding: 1.2rem 2.5rem;
        font-size: 1.6rem;
        font-weight: 500;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .btn-primary {
        background-color: var(--blue);
        color: var(--white);
        border: none;
    }

    .btn-primary:hover {
        background-color: #6c6ce9;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background-color: var(--light-bg);
        color: var(--black);
        border: none;
    }

    .btn-secondary:hover {
        background-color: #e0e0e0;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 991px) {
        .edit-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-buttons {
            flex-direction: column;
        }

        .form-buttons .btn {
            width: 100%;
            margin-bottom: 1rem;
        }
    }
</style>

</body>
</html>