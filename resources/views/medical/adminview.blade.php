<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - View Medical Record</title>

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
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.profile.view') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.stafflist') || request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.stafflist') }}">
                        <i class="fas fa-users"></i>
                        <span>Staff List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.patient.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.patient.patientlist') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.doctor.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.doctor.doctorlist') }}">
                        <i class="fas fa-users"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.medical.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.medical.list') }}">
                        <i class="fas fa-file-medical"></i>
                        <span>Patient Medical Records</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.assessment.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.appointment.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.appointment.list') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Appointment List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.reminder.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reminder.list') }}">
                        <i class="fas fa-bell"></i>
                        <span>Appointment Reminders</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.recommendation') ? 'active' : '' }}">
                    <a href="{{ route('admin.recommendation', ['patientId' => 1]) }}">
                        <i class="fas fa-robot"></i>
                        <span>Recommendation Devices</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </aside>
    <!-- Sidebar End -->

    <!-- Main Content Start -->
    <main class="dashboard-main">
        <div class="dashboard-header">
            <div class="header-left">
                <h2>View Medical Record</h2>
            </div>
            <div class="header-right">
                <div class="header-actions">
                    <a href="" class="action-btn edit-btn">
                        <i class="fas fa-edit"></i> Edit Record
                    </a>
                    <a href="{{ route('admin.medical.list') }}" class="action-btn back-btn">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="content-container">
                <!-- Record Header -->
                <div class="record-header">
                    <div class="record-info">
                        <h3>
                            <i class="fas fa-file-medical"></i> Medical Record #{{ $record->record_id ?? 'MR' . str_pad($record->medID, 4, '0', STR_PAD_LEFT) }}
                        </h3>

                        <div class="record-meta">
                            <span class="meta-item">
                                <i class="fas fa-calendar-plus"></i>
                                Created: {{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y - g:i A') }}
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-calendar-edit"></i>
                                Last Updated: {{ \Carbon\Carbon::parse($record->updated_at)->format('M d, Y - g:i A') }}
                            </span>
                        </div>
                    </div>
                    <div class="record-status">
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $record->status)) }}">
                            {{ $record->status }}
                        </span>
                    </div>
                </div>

                <!-- Patient Information Section -->
                <div class="view-section">
                    <h3 class="section-title">
                        <i class="fas fa-user-check"></i> Patient Information
                    </h3>

                    <div class="patient-card">
                        <div class="patient-avatar-large">
                            {{ substr($record->patient->patientName ?? 'P', 0, 1) }}
                        </div>
                        <div class="patient-info-grid">
                            <div class="info-item">
                                <label>Patient Name</label>
                                <span>{{ $record->patient->patientName ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <label>IC/Passport Number</label>
                                <span>{{ $record->patient->patientIC ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <label>Phone Number</label>
                                <span>{{ $record->patient->patientTel ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <label>Email</label>
                                <span>{{ $record->patient->patientEmail ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical Status Section -->
                <div class="view-section">
                    <h3 class="section-title">
                        <i class="fas fa-heartbeat"></i> Medical Status
                    </h3>

                    <div class="info-grid">
                        <div class="info-item">
                            <label>Treatment Status</label>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $record->status)) }}">
                                {{ $record->status }}
                            </span>
                        </div>
                        <div class="info-item">
                            <label>Assigned Doctor</label>
                            <span>{{ $record->assigned_doctor ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Amputation Details Section -->
                <div class="view-section">
                    <h3 class="section-title">
                        <i class="fas fa-cut"></i> Amputation Details
                    </h3>

                    <div class="info-grid">
                        <div class="info-item">
                            <label>Amputation Level</label>
                            <span>{{ $record->amputation_level ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Amputation Side</label>
                            <span>{{ $record->amputation_side ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Amputation Date</label>
                            <span>{{ $record->amputation_date ? \Carbon\Carbon::parse($record->amputation_date)->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div class="info-item full-width">
                            <label>Cause of Amputation</label>
                            <span>{{ $record->amputation_cause ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Clinical Vitals Section -->
                <div class="view-section">
                    <h3 class="section-title">
                        <i class="fas fa-stethoscope"></i> Clinical Vitals
                    </h3>

                    <div class="vitals-grid">
                        <div class="vital-card">
                            <div class="vital-icon">
                                <i class="fas fa-weight"></i>
                            </div>
                            <div class="vital-info">
                                <label>Weight</label>
                                <span>{{ $record->weight_kg ? $record->weight_kg . ' kg' : 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="vital-card">
                            <div class="vital-icon">
                                <i class="fas fa-ruler-vertical"></i>
                            </div>
                            <div class="vital-info">
                                <label>Height</label>
                                <span>{{ $record->height_cm ? $record->height_cm . ' cm' : 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="vital-card">
                            <div class="vital-icon">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <div class="vital-info">
                                <label>BMI</label>
                                <span>{{ $record->bmi ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="vital-card">
                            <div class="vital-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="vital-info">
                                <label>Blood Pressure</label>
                                <span>{{ $record->blood_pressure ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="vital-card">
                            <div class="vital-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="vital-info">
                                <label>Heart Rate</label>
                                <span>{{ $record->heart_rate ? $record->heart_rate . ' bpm' : 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="vital-card">
                            <div class="vital-icon">
                                <i class="fas fa-tint"></i>
                            </div>
                            <div class="vital-info">
                                <label>Blood Sugar</label>
                                <span>{{ $record->blood_sugar_level ? $record->blood_sugar_level . ' mg/dL' : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prosthetic Assessment Section -->
                <div class="view-section">
                    <h3 class="section-title">
                        <i class="fas fa-robot"></i> Prosthetic Assessment
                    </h3>

                    <div class="assessment-grid">
                        <div class="assessment-card">
                            <div class="assessment-header">
                                <h4>K-Level Assessment</h4>
                                <span class="k-level-badge k-level-{{ strtolower($record->k_level) }}">
                                    {{ $record->k_level ?? 'N/A' }}
                                </span>
                            </div>
                            <p class="assessment-description">
                                @if($record->k_level == 'K0')
                                    No ability to ambulate or transfer safely
                                @elseif($record->k_level == 'K1')
                                    Household ambulator - limited mobility
                                @elseif($record->k_level == 'K2')
                                    Limited community ambulator
                                @elseif($record->k_level == 'K3')
                                    Community ambulator with variable cadence
                                @elseif($record->k_level == 'K4')
                                    Active adult/athlete level
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>

                        <div class="assessment-card">
                            <div class="assessment-header">
                                <h4>Health Condition</h4>
                                <span class="health-indicator health-{{ strtolower($record->health_condition) }}">
                                    <i class="fas fa-circle"></i>
                                    {{ $record->health_condition ?? 'N/A' }}
                                </span>
                            </div>
                            <p class="assessment-description">
                                Overall health status affecting prosthetic use
                            </p>
                        </div>

                        <div class="assessment-card">
                            <div class="assessment-header">
                                <h4>BLARt Score</h4>
                                <div class="blart-score-display">
                                    <span class="blart-number">{{ $record->blart_score ?? 'N/A' }}</span>
                                    @if($record->blart_score)
                                        <span class="blart-category
                                            @if($record->blart_score <= 10) blart-limited
                                            @elseif($record->blart_score <= 20) blart-functional
                                            @else blart-advanced
                                            @endif">
                                            @if($record->blart_score <= 10) Limited Use
                                            @elseif($record->blart_score <= 20) Functional Use
                                            @else Advanced Use
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <p class="assessment-description">
                                Prosthetic functional assessment score (0-30)
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Functional Assessment Section -->
                <div class="view-section">
                    <h3 class="section-title">
                        <i class="fas fa-walking"></i> Functional Assessment
                    </h3>

                    <div class="info-grid">
                        <div class="info-item">
                            <label>Mobility Aid Used</label>
                            <span>{{ $record->mobility_aid_used ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Next Checkup Date</label>
                            <span>{{ $record->next_checkup_date ? \Carbon\Carbon::parse($record->next_checkup_date)->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        <div class="info-item full-width">
                            <label>Rehabilitation Status</label>
                            <div class="text-content">
                                {{ $record->rehabilitation_status ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Treatment Notes Section -->
                <div class="view-section">
                    <h3 class="section-title">
                        <i class="fas fa-notes-medical"></i> Treatment Notes
                    </h3>

                    <div class="notes-content">
                        <div class="text-content">
                            {{ $record->treatment_notes ?? 'No treatment notes available.' }}
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="record-actions">
                    <a href="" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Record
                    </a>
                    <a href="{{ route('admin.medical.list') }}" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Back to List
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteRecord({{ $record->medID }})">
                        <i class="fas fa-trash"></i> Delete Record
                    </button>
                    <button type="button" class="btn btn-info" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Record
                    </button>
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Confirm Deletion
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this medical record? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Warning:</strong> Deleting this medical record will permanently remove all associated medical data.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Record
                    </button>
                </form>
            </div>
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
    // Sidebar functionality
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

    // Animate sections on scroll
    ScrollReveal().reveal('.view-section', {
        origin: 'bottom',
        distance: '30px',
        duration: 800,
        delay: 100,
        interval: 200,
        easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
        reset: false
    });
});

// Delete record function
function deleteRecord(recordId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `{{ route('admin.medical.delete', '') }}/${recordId}`;
    $('#deleteModal').modal('show');
}
</script>

<style>
/* Medical Record View Specific Styles */
:root{
    --blue: #7d7deb;
    --black: #333;
    --white: #fff;
    --light-color: #666;
    --light-bg: #eee;
    --border: .2rem solid rgba(0,0,0,.1);
    --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
}

* {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    outline: none;
    border: none;
    text-decoration: none !important;
}

html {
    font-size: 62.5%;
    overflow-x: hidden;
    overflow-y: auto;
    scroll-behavior: smooth;
    scroll-padding-top: 6.5rem;
}

.dashboard-layout {
    display: flex;
    min-height: 100vh;
    background-color: #f7f7fa;
}

.dashboard-sidebar {
    width: 280px;
    background: var(--white);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 100;
    transition: all 0.3s ease;
    overflow-y: auto;
}

.sidebar-header {
    padding: 2rem 1.5rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.logo-container {
    margin-bottom: 1.5rem;
}

.logo-container img {
    height: 60px;
    width: auto;
}

.admin-info {
    width: 100%;
    text-align: center;
    margin-bottom: 1rem;
}

.admin-info h3 {
    font-size: 1.8rem;
    color: var(--black);
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.admin-info p {
    font-size: 1.4rem;
    color: var(--light-color);
    margin: 0;
}

.admin-info span {
    color: var(--blue);
    font-weight: 600;
}

.sidebar-toggle {
    display: none;
    background: none;
    color: var(--black);
    font-size: 2.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.sidebar-menu {
    padding: 2rem 0;
}

.sidebar-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li {
    margin-bottom: 0.5rem;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    padding: 1.2rem 2rem;
    color: var(--light-color);
    font-size: 1.6rem;
    transition: all 0.3s ease;
    position: relative;
}

.sidebar-menu a:hover {
    color: var(--blue);
    background-color: rgba(125, 125, 235, 0.1);
}

.sidebar-menu li.active a {
    color: var(--blue);
    background-color: rgba(125, 125, 235, 0.1);
    font-weight: 500;
}

.sidebar-menu li.active a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background-color: var(--blue);
}

.sidebar-menu a i {
    margin-right: 1.5rem;
    font-size: 1.8rem;
    width: 2rem;
    text-align: center;
}

.dashboard-main {
    flex: 1;
    padding: 2rem;
    margin-left: 280px;
    transition: all 0.3s ease;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.header-left h2 {
    font-size: 2.4rem;
    color: var(--black);
    font-weight: 600;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 1.5rem;
    border-radius: 0.5rem;
    font-size: 1.4rem;
    transition: all 0.3s ease;
    text-decoration: none;
    font-weight: 500;
}

.edit-btn {
    background-color: #ffab00;
    color: var(--white);
}

.edit-btn:hover {
    background-color: #e08b00;
    transform: translateY(-2px);
    color: var(--white);
}

.back-btn {
    background-color: var(--light-color);
    color: var(--white);
}

.back-btn:hover {
    background-color: #555;
    transform: translateY(-2px);
    color: var(--white);
}

/* Record Header */
.record-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    background-color: var(--white);
    border-radius: 1rem;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border-left: 4px solid var(--blue);
}

.record-info h3 {
    font-size: 2.2rem;
    color: var(--blue);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.record-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.meta-item {
    font-size: 1.4rem;
    color: var(--light-color);
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.meta-item i {
    color: var(--blue);
}

/* View Section */
.view-section {
    background-color: var(--white);
    border-radius: 1rem;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    border-left: 4px solid var(--blue);
}

.section-title {
    font-size: 2rem;
    color: var(--blue);
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--light-bg);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.section-title i {
    font-size: 2.2rem;
}

/* Patient Card */
.patient-card {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 2rem;
    background-color: var(--light-bg);
    border-radius: 1rem;
    border: 2px solid var(--blue);
}

.patient-avatar-large {
    width: 8rem;
    height: 8rem;
    border-radius: 50%;
    background-color: var(--blue);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 600;
    flex-shrink: 0;
}

.patient-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    flex: 1;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

.info-item label {
    font-size: 1.4rem;
    color: var(--light-color);
    font-weight: 500;
}

.info-item span {
    font-size: 1.6rem;
    color: var(--black);
    font-weight: 600;
}

/* Vitals Grid */
.vitals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.vital-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background-color: var(--light-bg);
    border-radius: 0.8rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.vital-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.vital-icon {
    width: 4rem;
    height: 4rem;
    border-radius: 50%;
    background-color: var(--blue);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    flex-shrink: 0;
}

.vital-info {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.vital-info label {
    font-size: 1.3rem;
    color: var(--light-color);
    font-weight: 500;
}

.vital-info span {
    font-size: 1.8rem;
    color: var(--black);
    font-weight: 600;
}

/* Assessment Grid */
.assessment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.assessment-card {
    padding: 2rem;
    background-color: var(--light-bg);
    border-radius: 1rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.assessment-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.assessment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.assessment-header h4 {
    font-size: 1.8rem;
    color: var(--black);
    margin: 0;
}

.assessment-description {
    font-size: 1.4rem;
    color: var(--light-color);
    margin: 0;
    line-height: 1.6;
}

/* Status Badges */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 1.3rem;
    font-weight: 500;
    text-align: center;
    display: inline-block;
}

.status-in-treatment {
    background-color: rgba(255, 171, 0, 0.1);
    color: #ffab00;
}

.status-recovered {
    background-color: rgba(75, 210, 143, 0.1);
    color: #4bd28f;
}

.status-follow-up {
    background-color: rgba(38, 198, 218, 0.1);
    color: #26c6da;
}

.status-deceased {
    background-color: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
}

/* K-Level Badges */
.k-level-badge {
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 1.3rem;
    font-weight: 600;
    text-align: center;
    display: inline-block;
}

.k-level-k0 {
    background-color: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
}

.k-level-k1 {
    background-color: rgba(255, 171, 0, 0.1);
    color: #ffab00;
}

.k-level-k2 {
    background-color: rgba(38, 198, 218, 0.1);
    color: #26c6da;
}

.k-level-k3 {
    background-color: rgba(75, 210, 143, 0.1);
    color: #4bd28f;
}

.k-level-k4 {
    background-color: rgba(125, 125, 235, 0.1);
    color: var(--blue);
}

/* Health Indicators */
.health-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.4rem;
    font-weight: 500;
}

.health-indicator i {
    font-size: 1.2rem;
}

.health-none {
    color: #4bd28f;
}

.health-mild {
    color: #ffab00;
}

.health-moderate {
    color: #ff6b6b;
}

.health-severe {
    color: #d32f2f;
}

/* BLARt Score Display */
.blart-score-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.blart-number {
    font-size: 2.4rem;
    font-weight: 700;
    color: var(--black);
}

.blart-category {
    font-size: 1.2rem;
    padding: 0.3rem 0.8rem;
    border-radius: 1rem;
    font-weight: 500;
    text-align: center;
}

.blart-limited {
    background-color: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
}

.blart-functional {
    background-color: rgba(75, 210, 143, 0.1);
    color: #4bd28f;
}

.blart-advanced {
    background-color: rgba(125, 125, 235, 0.1);
    color: var(--blue);
}

/* Text Content */
.text-content {
    background-color: var(--light-bg);
    padding: 1.5rem;
    border-radius: 0.8rem;
    font-size: 1.5rem;
    line-height: 1.6;
    color: var(--black);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.notes-content {
    margin-top: 1rem;
}

/* Record Actions */
.record-actions {
    display: flex;
    gap: 1.5rem;
    margin-top: 3rem;
    padding: 2rem;
    background-color: var(--light-bg);
    border-radius: 1rem;
    flex-wrap: wrap;
}

.btn {
    padding: 1.2rem 2.5rem;
    font-size: 1.6rem;
    font-weight: 500;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.btn-primary {
    background-color: var(--blue);
    color: var(--white);
}

.btn-primary:hover {
    background-color: #6c6ce9;
    transform: translateY(-2px);
    color: var(--white);
}

.btn-secondary {
    background-color: var(--light-color);
    color: var(--white);
}

.btn-secondary:hover {
    background-color: #555;
    transform: translateY(-2px);
    color: var(--white);
}

.btn-danger {
    background-color: #ff6b6b;
    color: var(--white);
}

.btn-danger:hover {
    background-color: #e05c5c;
    transform: translateY(-2px);
    color: var(--white);
}

.btn-info {
    background-color: #26c6da;
    color: var(--white);
}

.btn-info:hover {
    background-color: #20aac7;
    transform: translateY(-2px);
    color: var(--white);
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
    display: flex;
    align-items: center;
    gap: 1rem;
}

.modal-body {
    padding: 2.5rem;
    font-size: 1.6rem;
    color: var(--black);
}

.modal-footer {
    border-top: none;
    padding: 1.5rem 2rem 2rem;
}

.alert-warning {
    background-color: rgba(255, 171, 0, 0.1);
    border: 1px solid #ffab00;
    color: #e08b00;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-top: 1.5rem;
}

.alert-warning i {
    margin-right: 0.8rem;
}

/* Print Styles */
@media print {
    .dashboard-sidebar,
    .dashboard-header,
    .record-actions,
    .modal {
        display: none !important;
    }

    .dashboard-main {
        margin-left: 0;
        padding: 1rem;
    }

    .view-section {
        break-inside: avoid;
        margin-bottom: 1rem;
    }

    .record-header {
        margin-bottom: 1rem;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-main {
        padding: 1.5rem;
        margin-left: 0;
    }

    .dashboard-sidebar {
        transform: translateX(-100%);
    }

    .sidebar-toggle {
        display: block;
        position: fixed;
        top: 1.5rem;
        left: 1.5rem;
        z-index: 110;
    }

    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
    }

    .header-actions {
        width: 100%;
        justify-content: flex-start;
    }

    .record-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
    }

    .patient-card {
        flex-direction: column;
        text-align: center;
    }

    .patient-info-grid {
        grid-template-columns: 1fr;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .vitals-grid {
        grid-template-columns: 1fr;
    }

    .assessment-grid {
        grid-template-columns: 1fr;
    }

    .record-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .view-section {
        padding: 2rem 1.5rem;
    }

    .section-title {
        font-size: 1.8rem;
        flex-direction: column;
        text-align: center;
    }

    .patient-avatar-large {
        width: 6rem;
        height: 6rem;
        font-size: 2.4rem;
    }

    .vital-card {
        flex-direction: column;
        text-align: center;
    }

    .assessment-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
