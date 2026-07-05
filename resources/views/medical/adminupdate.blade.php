<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Update Medical Record</title>

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
                <h2>Update Medical Record</h2>
            </div>
            <div class="header-right">
                <div class="header-actions">
                    <a href="{{ route('admin.medical.view', $record->medID) }}" class="action-btn view-btn">
                        <i class="fas fa-eye"></i> View Record
                    </a>
                    <a href="{{ route('admin.medical.list') }}" class="action-btn back-btn">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
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
                    <div class="patient-error-message">
                        <i class="fas fa-times-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="patient-error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Please fix the following errors:</strong>
                            <ul class="error-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Record Header -->
                <div class="record-header">
                    <div class="record-info">
                        <h3>
                            <i class="fas fa-edit"></i>
                            Updating Record #MR{{ str_pad($record->medID, 4, '0', STR_PAD_LEFT) }}
                        </h3>
                        <div class="record-meta">
                            <span class="meta-item">
                                <i class="fas fa-user"></i>
                                Patient: {{ $record->patient->patientName ?? 'N/A' }}
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

                <form action="{{ route('admin.medical.update', $record->medID) }}" method="POST" class="medical-record-form" id="medicalRecordForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Patient Information Section (Read-only) -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-check"></i> Patient Information
                        </h3>

                        <div class="patient-info-display">
                            <div class="info-card">
                                <div class="patient-avatar">{{ substr($record->patient->patientName ?? 'P', 0, 1) }}</div>
                                <div class="patient-details">
                                    <h5>{{ $record->patient->patientName ?? 'N/A' }}</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>IC/Passport:</strong> {{ $record->patient->patientIC ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Phone:</strong> {{ $record->patient->patientTel ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Email:</strong> {{ $record->patient->patientEmail ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden field to maintain patient association -->
                        <input type="hidden" name="patient_id" value="{{ $record->patient_id }}">
                    </div>

                    <!-- Medical Status Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-heartbeat"></i> Medical Status
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="status">Treatment Status <span class="text-danger">*</span></label>
                                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">Select Status</option>
                                    <option value="Active" {{ (old('status', $record->status) == 'Active') ? 'selected' : '' }}>Active</option>
                                    <option value="In Treatment" {{ (old('status', $record->status) == 'In Treatment') ? 'selected' : '' }}>In Treatment</option>
                                    <option value="Recovered" {{ (old('status', $record->status) == 'Recovered') ? 'selected' : '' }}>Recovered</option>
                                    <option value="Follow-up" {{ (old('status', $record->status) == 'Follow-up') ? 'selected' : '' }}>Follow-up</option>
                                    <option value="Inactive" {{ (old('status', $record->status) == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="assigned_doctor">Assigned Doctor</label>
                                <select class="form-control @error('assigned_doctor') is-invalid @enderror" id="assigned_doctor" name="assigned_doctor">
                                    <option value="">-- Select Doctor --</option>
                                    @if(isset($doctors))
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->docName }}" {{ (old('assigned_doctor', $record->assigned_doctor) == $doctor->docName) ? 'selected' : '' }}>
                                                {{ $doctor->docName }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('assigned_doctor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Amputation Details Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-cut"></i> Amputation Details
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="amputation_level">Amputation Level <span class="text-danger">*</span></label>
                                <select id="amputation_level" name="amputation_level" class="form-control @error('amputation_level') is-invalid @enderror" required>
                                    <option value="">Select Level</option>
                                    <option value="Below Knee" {{ (old('amputation_level', $record->amputation_level) == 'Below Knee') ? 'selected' : '' }}>Below Knee</option>
                                    <option value="Above Knee" {{ (old('amputation_level', $record->amputation_level) == 'Above Knee') ? 'selected' : '' }}>Above Knee</option>
                                    <option value="Transradial" {{ (old('amputation_level', $record->amputation_level) == 'Transradial') ? 'selected' : '' }}>Transradial (Below Elbow)</option>
                                    <option value="Transhumeral" {{ (old('amputation_level', $record->amputation_level) == 'Transhumeral') ? 'selected' : '' }}>Transhumeral (Above Elbow)</option>
                                    <option value="Hip Disarticulation" {{ (old('amputation_level', $record->amputation_level) == 'Hip Disarticulation') ? 'selected' : '' }}>Hip Disarticulation</option>
                                    <option value="Bilateral" {{ (old('amputation_level', $record->amputation_level) == 'Bilateral') ? 'selected' : '' }}>Bilateral</option>
                                </select>
                                @error('amputation_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="amputation_date">Amputation Date</label>
                                <input type="date" class="form-control @error('amputation_date') is-invalid @enderror" 
                                       id="amputation_date" name="amputation_date"
                                       value="{{ old('amputation_date', $record->amputation_date) }}">
                                @error('amputation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Clinical Vitals Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-stethoscope"></i> Clinical Vitals
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="weight_kg">Weight (kg)</label>
                                <input type="number" class="form-control @error('weight_kg') is-invalid @enderror" 
                                       id="weight_kg" name="weight_kg" value="{{ old('weight_kg', $record->weight_kg) }}"
                                       step="0.01" min="0" max="500" placeholder="0.00">
                                @error('weight_kg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="height_cm">Height (cm)</label>
                                <input type="number" class="form-control @error('height_cm') is-invalid @enderror" 
                                       id="height_cm" name="height_cm" value="{{ old('height_cm', $record->height_cm) }}"
                                       step="0.01" min="0" max="300" placeholder="0.00">
                                @error('height_cm')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="bmi">BMI</label>
                                <input type="number" class="form-control @error('bmi') is-invalid @enderror" 
                                       id="bmi" name="bmi" value="{{ old('bmi', $record->bmi) }}"
                                       step="0.01" readonly placeholder="Auto-calculated">
                                <small class="form-text text-muted">Automatically calculated from weight and height</small>
                                @error('bmi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="blood_pressure">Blood Pressure</label>
                                <input type="text" class="form-control @error('blood_pressure') is-invalid @enderror" 
                                       id="blood_pressure" name="blood_pressure" value="{{ old('blood_pressure', $record->blood_pressure) }}"
                                       placeholder="e.g., 120/80" pattern="[0-9]{2,3}/[0-9]{2,3}">
                                <small class="form-text text-muted">Format: systolic/diastolic (e.g., 120/80)</small>
                                @error('blood_pressure')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="heart_rate">Heart Rate (bpm)</label>
                                <input type="number" class="form-control @error('heart_rate') is-invalid @enderror" 
                                       id="heart_rate" name="heart_rate" value="{{ old('heart_rate', $record->heart_rate) }}"
                                       min="30" max="200" placeholder="e.g., 72">
                                @error('heart_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="blood_sugar_level">Blood Sugar Level (mg/dL)</label>
                                <input type="number" class="form-control @error('blood_sugar_level') is-invalid @enderror" 
                                       id="blood_sugar_level" name="blood_sugar_level" value="{{ old('blood_sugar_level', $record->blood_sugar_level) }}"
                                       step="0.01" min="0" max="1000" placeholder="e.g., 100.5">
                                @error('blood_sugar_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Prosthetic Assessment Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-robot"></i> Prosthetic Assessment
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="k_level">K-Level (Activity Level)</label>
                                <select id="k_level" name="k_level" class="form-control @error('k_level') is-invalid @enderror">
                                    <option value="">Select K-Level</option>
                                    <option value="K0" {{ (old('k_level', $record->k_level) == 'K0') ? 'selected' : '' }}>K0 – No ability to ambulate</option>
                                    <option value="K1" {{ (old('k_level', $record->k_level) == 'K1') ? 'selected' : '' }}>K1 – Household ambulator</option>
                                    <option value="K2" {{ (old('k_level', $record->k_level) == 'K2') ? 'selected' : '' }}>K2 – Limited community ambulator</option>
                                    <option value="K3" {{ (old('k_level', $record->k_level) == 'K3') ? 'selected' : '' }}>K3 – Community ambulator</option>
                                    <option value="K4" {{ (old('k_level', $record->k_level) == 'K4') ? 'selected' : '' }}>K4 – Active adult / athlete</option>
                                </select>
                                <small class="form-text text-muted">Patient's functional mobility level</small>
                                @error('k_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="health_condition">General Health Condition</label>
                                <select id="health_condition" name="health_condition" class="form-control @error('health_condition') is-invalid @enderror">
                                    <option value="">Select Health Condition</option>
                                    <option value="Excellent" {{ (old('health_condition', $record->health_condition) == 'Excellent') ? 'selected' : '' }}>Excellent</option>
                                    <option value="Good" {{ (old('health_condition', $record->health_condition) == 'Good') ? 'selected' : '' }}>Good</option>
                                    <option value="Fair" {{ (old('health_condition', $record->health_condition) == 'Fair') ? 'selected' : '' }}>Fair</option>
                                    <option value="Poor" {{ (old('health_condition', $record->health_condition) == 'Poor') ? 'selected' : '' }}>Poor</option>
                                </select>
                                <small class="form-text text-muted">Overall health status affecting prosthetic use</small>
                                @error('health_condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="blart_score">BLARt Score</label>
                                <input type="number" class="form-control @error('blart_score') is-invalid @enderror" 
                                       id="blart_score" name="blart_score" value="{{ old('blart_score', $record->blart_score) }}"
                                       min="0" max="50" step="1" placeholder="e.g., 25">
                                <small class="form-text text-muted">
                                    <strong>BLARt Score Range (0-50):</strong>
                                    <span class="d-block mt-1">
                                        <span class="badge badge-danger mr-1">0-25: Limited</span>
                                        <span class="badge badge-success mr-1">26-45: Functional</span>
                                        <span class="badge badge-primary">46-50: Advanced</span>
                                    </span>
                                </small>
                                @error('blart_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Functional Assessment Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-walking"></i> Functional Assessment
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="mobility_aid_used">Mobility Aid Used</label>
                                <input type="text" class="form-control @error('mobility_aid_used') is-invalid @enderror" 
                                       id="mobility_aid_used" name="mobility_aid_used" value="{{ old('mobility_aid_used', $record->mobility_aid_used) }}"
                                       placeholder="e.g., Cane, Walker, Wheelchair, Prosthetic">
                                @error('mobility_aid_used')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="rehabilitation_status">Rehabilitation Status</label>
                                <textarea class="form-control @error('rehabilitation_status') is-invalid @enderror" 
                                          id="rehabilitation_status" name="rehabilitation_status" rows="3" 
                                          placeholder="Describe patient's current rehabilitation progress, goals, and achievements">{{ old('rehabilitation_status', $record->rehabilitation_status) }}</textarea>
                                @error('rehabilitation_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Treatment Notes Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-notes-medical"></i> Treatment Notes
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="treatment_notes">Treatment Notes & Observations</label>
                                <textarea class="form-control @error('treatment_notes') is-invalid @enderror" 
                                          id="treatment_notes" name="treatment_notes" rows="5" 
                                          placeholder="Enter detailed treatment notes, observations, recommendations, and any relevant medical information">{{ old('treatment_notes', $record->treatment_notes) }}</textarea>
                                @error('treatment_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Record Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-history"></i> Record Information
                        </h3>

                        <div class="update-info-card">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-calendar-plus"></i>
                                        <div>
                                            <strong>Record Created:</strong><br>
                                            {{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y - g:i A') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <i class="fas fa-calendar-edit"></i>
                                        <div>
                                            <strong>Last Updated:</strong><br>
                                            {{ \Carbon\Carbon::parse($record->updated_at)->format('M d, Y - g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Medical Record
                        </button>
                        <a href="{{ route('admin.medical.view', $record->medID) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> View Record
                        </a>
                        <a href="{{ route('admin.medical.list') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset Changes
                        </button>
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
document.addEventListener('DOMContentLoaded', function () {
    // Store original form values for reset functionality
    const originalValues = {};
    const form = document.getElementById('medicalRecordForm');
    const formElements = form.querySelectorAll('input, select, textarea');

    formElements.forEach(element => {
        originalValues[element.name] = element.value;
    });

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

    // BMI Calculator
    const weightInput = document.getElementById('weight_kg');
    const heightInput = document.getElementById('height_cm');
    const bmiInput = document.getElementById('bmi');

    function calculateBMI() {
        const weight = parseFloat(weightInput.value);
        const height = parseFloat(heightInput.value);

        if (weight > 0 && height > 0) {
            const heightInMeters = height / 100;
            const bmi = weight / (heightInMeters * heightInMeters);
            bmiInput.value = bmi.toFixed(2);
        } else {
            bmiInput.value = '';
        }
    }

    weightInput.addEventListener('input', calculateBMI);
    heightInput.addEventListener('input', calculateBMI);

    // Calculate BMI on page load if values exist
    if (weightInput.value && heightInput.value) {
        calculateBMI();
    }

    // Blood pressure validation
    const bloodPressureInput = document.getElementById('blood_pressure');

    bloodPressureInput.addEventListener('blur', function() {
        const value = this.value.trim();
        if (value && !value.match(/^\d{2,3}\/\d{2,3}$/)) {
            this.setCustomValidity('Please enter blood pressure in format: systolic/diastolic (e.g., 120/80)');
        } else {
            this.setCustomValidity('');
        }
    });

    // Set maximum date for amputation date (cannot be in future)
    const amputationDate = document.getElementById('amputation_date');
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${yyyy}-${mm}-${dd}`;

    amputationDate.setAttribute('max', formattedToday);

    // Form change tracking
    let formChanged = false;

    formElements.forEach(element => {
        element.addEventListener('input', function() {
            formChanged = true;
        });

        element.addEventListener('change', function() {
            formChanged = true;
        });
    });

    // Warn user before leaving if form has changes
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Form validation
    const medicalRecordForm = document.getElementById('medicalRecordForm');

    medicalRecordForm.addEventListener('submit', function(event) {
        let isValid = true;

        // Check required fields
        const requiredFields = ['status', 'amputation_level'];

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Validate blood pressure format if entered
        const bpValue = bloodPressureInput.value.trim();
        if (bpValue && !bpValue.match(/^\d{2,3}\/\d{2,3}$/)) {
            bloodPressureInput.classList.add('is-invalid');
            isValid = false;
        } else {
            bloodPressureInput.classList.remove('is-invalid');
        }

        if (!isValid) {
            event.preventDefault();

            // Scroll to first invalid field
            const firstInvalid = document.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                firstInvalid.focus();
            }
        } else {
            // Form is valid, reset change tracking
            formChanged = false;
        }
    });

    // Auto-hide success/error messages
    const successMessage = document.querySelector('.success-message');
    const errorMessage = document.querySelector('.patient-error-message');

    [successMessage, errorMessage].forEach(message => {
        if (message) {
            setTimeout(() => {
                message.style.transition = 'opacity 1s ease';
                message.style.opacity = '0';
                setTimeout(() => {
                    message.remove();
                }, 1000);
            }, 5000);
        }
    });

    // Global reset function
    window.resetForm = function() {
        if (confirm('Are you sure you want to reset all changes? This will restore all fields to their original values.')) {
            formElements.forEach(element => {
                if (originalValues[element.name] !== undefined) {
                    element.value = originalValues[element.name];
                }
            });

            // Recalculate BMI
            calculateBMI();

            // Remove validation classes
            document.querySelectorAll('.is-invalid').forEach(field => {
                field.classList.remove('is-invalid');
            });

            // Reset change tracking
            formChanged = false;
        }
    };
});
</script>

<style>
/* Medical Record Update Specific Styles */
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

.view-btn {
    background-color: #26c6da;
    color: var(--white);
}

.view-btn:hover {
    background-color: #20aac7;
    transform: translateY(-2px);
    color: var(--white);
    text-decoration: none;
}

.back-btn {
    background-color: var(--light-color);
    color: var(--white);
}

.back-btn:hover {
    background-color: #555;
    transform: translateY(-2px);
    color: var(--white);
    text-decoration: none;
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
    border-left: 4px solid #ffab00;
}

.record-info h3 {
    font-size: 2.2rem;
    color: #ffab00;
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
    color: #ffab00;
}

/* Medical Record Form */
.medical-record-form {
    padding: 0;
}

.form-section {
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

.form-group label {
    font-size: 1.5rem;
    color: var(--black);
    font-weight: 500;
    margin-bottom: 0.8rem;
}

.form-control {
    font-size: 1.4rem;
    padding: 1rem 1.5rem;
    border: 2px solid #e0e0e0;
    border-radius: 0.5rem;
    color: var(--black);
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 0.2rem rgba(125, 125, 235, 0.25);
    outline: none;
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.form-control[readonly] {
    background-color: var(--light-bg);
    cursor: not-allowed;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 1.3rem;
    color: #dc3545;
}

.text-danger {
    color: #dc3545 !important;
}

.form-text {
    margin-top: 0.25rem;
    font-size: 1.2rem;
    color: var(--light-color);
}

/* Patient Info Display */
.patient-info-display {
    margin-top: 1rem;
}

.info-card {
    background-color: var(--light-bg);
    padding: 2rem;
    border-radius: 0.8rem;
    border: 2px solid var(--blue);
    display: flex;
    align-items: center;
    gap: 2rem;
}

.patient-avatar {
    width: 6rem;
    height: 6rem;
    border-radius: 50%;
    background-color: var(--blue);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.4rem;
    font-weight: 600;
    flex-shrink: 0;
}

.patient-details {
    flex: 1;
}

.patient-details h5 {
    color: var(--blue);
    margin-bottom: 1rem;
    font-weight: 600;
    font-size: 1.8rem;
}

/* Update Info Card */
.update-info-card {
    background-color: rgba(255, 171, 0, 0.05);
    border: 1px solid rgba(255, 171, 0, 0.2);
    border-radius: 0.8rem;
    padding: 2rem;
    margin-top: 2rem;
}

.update-info-card .info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.update-info-card .info-item:last-child {
    margin-bottom: 0;
}

.update-info-card .info-item i {
    color: #ffab00;
    font-size: 1.8rem;
    width: 2rem;
}

.update-info-card .info-item div {
    font-size: 1.4rem;
    color: var(--black);
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

.status-active {
    background-color: rgba(75, 210, 143, 0.1);
    color: #4bd28f;
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

.status-inactive {
    background-color: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
}

/* Badge Styles */
.badge {
    font-size: 1.1rem;
    padding: 0.4rem 0.8rem;
}

.badge-danger {
    background-color: #dc3545;
}

.badge-success {
    background-color: #28a745;
}

.badge-primary {
    background-color: var(--blue);
}

/* Form Actions */
.form-actions {
    margin-top: 3rem;
    padding: 2rem;
    background-color: var(--light-bg);
    border-radius: 1rem;
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.form-actions .btn {
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
    text-decoration: none;
}

.btn-secondary {
    background-color: var(--light-color);
    color: var(--white);
}

.btn-secondary:hover {
    background-color: #555;
    transform: translateY(-2px);
    color: var(--white);
    text-decoration: none;
}

.btn-info {
    background-color: #26c6da;
    color: var(--white);
}

.btn-info:hover {
    background-color: #20aac7;
    transform: translateY(-2px);
    color: var(--white);
    text-decoration: none;
}

.btn-outline-secondary {
    background-color: transparent;
    color: var(--light-color);
    border: 2px solid var(--light-color);
}

.btn-outline-secondary:hover {
    background-color: var(--light-color);
    color: var(--white);
    transform: translateY(-2px);
    text-decoration: none;
}

/* Success and Error Messages */
.success-message {
    background-color: #D4EDDA;
    color: #155724;
    padding: 1.5rem 2rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    font-size: 1.6rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.patient-error-message {
    background-color: #FFEBEE;
    color: #B71C1C;
    padding: 1.5rem 2rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    font-size: 1.6rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.error-list {
    margin: 0.5rem 0 0 0;
    padding-left: 1.5rem;
}

.error-list li {
    margin-bottom: 0.3rem;
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

    .info-card {
        flex-direction: column;
        text-align: center;
    }

    .form-section {
        padding: 2rem 1.5rem;
    }

    .section-title {
        font-size: 1.8rem;
        flex-direction: column;
        text-align: center;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .form-section {
        padding: 2rem 1rem;
    }

    .section-title {
        font-size: 1.6rem;
    }

    .patient-avatar {
        width: 5rem;
        height: 5rem;
        font-size: 2rem;
    }
}
</style>

</body>
</html>