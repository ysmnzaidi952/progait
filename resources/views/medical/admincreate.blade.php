<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Create Medical Record</title>

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
                <h2>Create Medical Record</h2>
            </div>
            <div class="header-right">
                <div class="header-notifications">
                    <div class="notifications-icon">
                        <a href="{{ route('admin.medical.list') }}" class="link-btn">
                            <i class="fas fa-arrow-left"></i> Back to Medical Records
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

                <form action="{{ route('admin.medical.store') }}" method="POST" class="medical-record-form" id="medicalRecordForm">
                    @csrf
                    
                    <!-- Patient Selection Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-check"></i> Patient Selection
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="patient_id">Select Patient <span class="text-danger">*</span></label>
                                <select id="patient_id" name="patient_id" class="form-control @error('patient_id') is-invalid @enderror" required>
                                    <option value="">-- Select Patient --</option>
                                    @if(isset($patients))
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->patientID }}" 
                                                    data-name="{{ $patient->patientName }}" 
                                                    data-ic="{{ $patient->patientIC }}" 
                                                    data-tel="{{ $patient->patientTel }}"
                                                    {{ old('patient_id') == $patient->patientID ? 'selected' : '' }}>
                                                {{ $patient->patientName }} ({{ $patient->patientIC }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('patient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Patient Info Display -->
                        <div id="selectedPatientInfo" class="patient-info-display" style="display: none;">
                            <div class="info-card">
                                <h5><i class="fas fa-user"></i> Selected Patient Information</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Name:</strong> <span id="displayName"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>IC/Passport:</strong> <span id="displayIC"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Phone:</strong> <span id="displayTel"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="In Treatment" {{ old('status') == 'In Treatment' ? 'selected' : '' }}>In Treatment</option>
                                    <option value="Recovered" {{ old('status') == 'Recovered' ? 'selected' : '' }}>Recovered</option>
                                    <option value="Follow-up" {{ old('status') == 'Follow-up' ? 'selected' : '' }}>Follow-up</option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
                                            <option value="{{ $doctor->docName }}" {{ old('assigned_doctor') == $doctor->docName ? 'selected' : '' }}>
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
                                    <option value="Below Knee" {{ old('amputation_level') == 'Below Knee' ? 'selected' : '' }}>Below Knee</option>
                                    <option value="Above Knee" {{ old('amputation_level') == 'Above Knee' ? 'selected' : '' }}>Above Knee</option>
                                    <option value="Hip disarticulation" {{ old('amputation_level') == 'Hip disarticulation' ? 'selected' : '' }}>Hip disarticulation</option>
                                    <option value="Below Elbow" {{ old('amputation_level') == 'Below Elbow' ? 'selected' : '' }}>Below Elbow</option>
                                    <option value="Above Elbow" {{ old('amputation_level') == 'Above Elbow' ? 'selected' : '' }}>Above Elbow</option>
                                </select>
                                @error('amputation_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="amputation_date">Amputation Date</label>
                                <input type="date" class="form-control @error('amputation_date') is-invalid @enderror" 
                                       id="amputation_date" name="amputation_date" value="{{ old('amputation_date') }}">
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
                                       id="weight_kg" name="weight_kg" step="0.01" min="0" max="500" 
                                       placeholder="0.00" value="{{ old('weight_kg') }}">
                                @error('weight_kg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="height_cm">Height (cm)</label>
                                <input type="number" class="form-control @error('height_cm') is-invalid @enderror" 
                                       id="height_cm" name="height_cm" step="0.01" min="0" max="300" 
                                       placeholder="0.00" value="{{ old('height_cm') }}">
                                @error('height_cm')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="bmi">BMI</label>
                                <input type="number" class="form-control @error('bmi') is-invalid @enderror" 
                                       id="bmi" name="bmi" step="0.01" readonly placeholder="Auto-calculated" 
                                       value="{{ old('bmi') }}">
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
                                       id="blood_pressure" name="blood_pressure" placeholder="e.g., 120/80" 
                                       pattern="[0-9]{2,3}/[0-9]{2,3}" value="{{ old('blood_pressure') }}">
                                <small class="form-text text-muted">Format: systolic/diastolic (e.g., 120/80)</small>
                                @error('blood_pressure')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="heart_rate">Heart Rate (bpm)</label>
                                <input type="number" class="form-control @error('heart_rate') is-invalid @enderror" 
                                       id="heart_rate" name="heart_rate" min="30" max="200" 
                                       placeholder="e.g., 72" value="{{ old('heart_rate') }}">
                                @error('heart_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="blood_sugar_level">Blood Sugar Level (mg/dL)</label>
                                <input type="number" class="form-control @error('blood_sugar_level') is-invalid @enderror" 
                                       id="blood_sugar_level" name="blood_sugar_level" step="0.01" min="0" max="1000" 
                                       placeholder="e.g., 100.5" value="{{ old('blood_sugar_level') }}">
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
                                    <option value="K0" {{ old('k_level') == 'K0' ? 'selected' : '' }}>K0 – No ability to ambulate</option>
                                    <option value="K1" {{ old('k_level') == 'K1' ? 'selected' : '' }}>K1 – Household ambulator</option>
                                    <option value="K2" {{ old('k_level') == 'K2' ? 'selected' : '' }}>K2 – Limited community ambulator</option>
                                    <option value="K3" {{ old('k_level') == 'K3' ? 'selected' : '' }}>K3 – Community ambulator</option>
                                    <option value="K4" {{ old('k_level') == 'K4' ? 'selected' : '' }}>K4 – Active adult / athlete</option>
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
                                    <option value="Excellent" {{ old('health_condition') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                    <option value="Good" {{ old('health_condition') == 'Good' ? 'selected' : '' }}>Good</option>
                                    <option value="Fair" {{ old('health_condition') == 'Fair' ? 'selected' : '' }}>Fair</option>
                                    <option value="Poor" {{ old('health_condition') == 'Poor' ? 'selected' : '' }}>Poor</option>
                                </select>
                                <small class="form-text text-muted">Overall health status affecting prosthetic use</small>
                                @error('health_condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="blart_score">BLARt Score</label>
                                <input type="number" class="form-control @error('blart_score') is-invalid @enderror" 
                                       id="blart_score" name="blart_score" min="0" max="50" step="1" 
                                       placeholder="e.g., 25" value="{{ old('blart_score') }}">
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
                                       id="mobility_aid_used" name="mobility_aid_used" 
                                       placeholder="e.g., Cane, Walker, Wheelchair, Prosthetic" 
                                       value="{{ old('mobility_aid_used') }}">
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
                                          placeholder="Describe patient's current rehabilitation progress, goals, and achievements">{{ old('rehabilitation_status') }}</textarea>
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
                                          placeholder="Enter detailed treatment notes, observations, recommendations, and any relevant medical information">{{ old('treatment_notes') }}</textarea>
                                @error('treatment_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Medical Record
                        </button>
                        <a href="{{ route('admin.medical.list') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-undo"></i> Reset Form
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

    // Patient selection functionality
    const patientSelect = document.getElementById('patient_id');
    const patientInfoDiv = document.getElementById('selectedPatientInfo');
    const displayName = document.getElementById('displayName');
    const displayIC = document.getElementById('displayIC');
    const displayTel = document.getElementById('displayTel');

    // Show patient info on page load if patient is selected
    if (patientSelect.value) {
        const selectedOption = patientSelect.options[patientSelect.selectedIndex];
        displayName.textContent = selectedOption.dataset.name;
        displayIC.textContent = selectedOption.dataset.ic;
        displayTel.textContent = selectedOption.dataset.tel;
        patientInfoDiv.style.display = 'block';
    }

    patientSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            displayName.textContent = selectedOption.dataset.name;
            displayIC.textContent = selectedOption.dataset.ic;
            displayTel.textContent = selectedOption.dataset.tel;
            patientInfoDiv.style.display = 'block';
        } else {
            patientInfoDiv.style.display = 'none';
        }
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

    // Form validation
    const medicalRecordForm = document.getElementById('medicalRecordForm');
    
    medicalRecordForm.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Check required fields
        const requiredFields = ['patient_id', 'status', 'amputation_level'];
        
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

    // Form reset functionality
    const resetButton = document.querySelector('button[type="reset"]');
    resetButton.addEventListener('click', function() {
        // Reset custom displays
        patientInfoDiv.style.display = 'none';
        bmiInput.value = '';
        
        // Remove validation classes
        document.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });
    });
});
</script>

<style>
/* Medical Record Form Specific Styles */
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

/* Dashboard Layout */
.dashboard-layout {
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
    position: relative;
    background-color: #f7f7fa;
}

/* Sidebar Styles */
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

/* Main Content */
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

.header-right {
    display: flex;
    align-items: center;
    gap: 2rem;
}

/* Link button styling */
.link-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    background-color: var(--blue);
    color: var(--white);
    padding: 0.8rem 1.5rem;
    border-radius: 0.5rem;
    font-size: 1.5rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.link-btn:hover {
    background-color: #6c6ce9;
    transform: translateY(-2px);
    color: var(--white);
    box-shadow: 0 4px 10px rgba(125, 125, 235, 0.3);
    text-decoration: none;
}

/* Medical Record Form Specific Styles */
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

.patient-info-display {
    margin-top: 2rem;
}

.info-card {
    background-color: var(--light-bg);
    padding: 2rem;
    border-radius: 0.8rem;
    border: 2px solid var(--blue);
}

.info-card h5 {
    color: var(--blue);
    margin-bottom: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    font-size: 1.6rem;
}

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
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background-color: var(--blue);
    color: var(--white);
}

.btn-primary:hover {
    background-color: #6c6ce9;
    color: var(--white);
    transform: translateY(-2px);
    text-decoration: none;
}

.btn-secondary {
    background-color: var(--light-color);
    color: var(--white);
}

.btn-secondary:hover {
    background-color: #555;
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
    text-decoration: none;
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

/* Success and Error Messages */
.success-message, .patient-error-message {
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

    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
    }
}

@media (max-width: 576px) {
    .info-card .row > div {
        margin-bottom: 1rem;
    }
    
    .section-title {
        font-size: 1.6rem;
    }
}
</style>

</body>
</html>