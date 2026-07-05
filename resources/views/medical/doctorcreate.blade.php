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
            <div class="staff-info">
                <h3>Doctor Dashboard</h3>
                <p>Welcome, <span>Doctor</span></p>
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
                <li>
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
                    <a href="{{ route('doctor.appointment.list') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Appointment List</span>
                    </a>
                </li>
                    <li class="active">
                        <a href="{{ route('doctor.medical.list') }}">
                            <i class="fas fa-calendar-check"></i>
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
                <h2>Create Medical Record</h2>
            </div>
            <div class="header-right">
                <div class="header-notifications">
                    <div class="notifications-icon">
                        <a href="{{ route('doctor.patientlistdoct') }}" class="link-btn">
                            <i class="fas fa-arrow-left"></i> Back to Patient List
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

                <form action="{{ route('doctor.medical.store') }}" method="POST" class="medical-record-form" id="medicalRecordForm">
                    @csrf
                    
                    <!-- Patient Selection Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-check"></i> Patient Selection
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="patient_id">Select Patient <span class="text-danger">*</span></label>
                                <select id="patient_id" name="patient_id" class="form-control" required>
                                    <option value="">-- Select Patient --</option>
                                    @if(isset($patients))
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->patientID }}" 
                                                    data-name="{{ $patient->patientName }}" 
                                                    data-ic="{{ $patient->patientIC }}" 
                                                    data-tel="{{ $patient->patientTel }}">
                                                {{ $patient->patientName }} ({{ $patient->patientIC }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
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
                                <select id="status" name="status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="In Treatment">In Treatment</option>
                                    <option value="Recovered">Recovered</option>
                                    <option value="Follow-up">Follow-up</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="assigned_doctor">Assigned Doctor</label>
                                <select class="form-control" id="assigned_doctor" name="assigned_doctor" required>
                                    <option value="">-- Select Doctor --</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->docName }}">{{ $doctor->docName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Amputation Details Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-cut"></i> Amputation Details
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="amputation_level">Amputation Level <span class="text-danger">*</span></label>
                                <select id="amputation_level" name="amputation_level" class="form-control" required>
                                    <option value="">Select Level</option>
                                    <option value="Below Knee">Below Knee</option>
                                    <option value="Above Knee">Above Knee</option>
                                    <option value="Transradial">Transradial (Below Elbow)</option>
                                    <option value="Transhumeral">Transhumeral (Above Elbow)</option>
                                    <option value="Hip Disarticulation">Hip Disarticulation</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="amputation_side">Amputation Side <span class="text-danger">*</span></label>
                                <select id="amputation_side" name="amputation_side" class="form-control" required>
                                    <option value="">Select Side</option>
                                    <option value="Left">Left</option>
                                    <option value="Right">Right</option>
                                    <option value="Bilateral">Bilateral</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="amputation_date">Amputation Date</label>
                                <input type="date" class="form-control" id="amputation_date" name="amputation_date">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="amputation_cause">Cause of Amputation</label>
                                <input type="text" class="form-control" id="amputation_cause" name="amputation_cause" 
                                       placeholder="e.g., Diabetes, Trauma, Cancer, Infection">
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
                                <input type="number" class="form-control" id="weight_kg" name="weight_kg" 
                                       step="0.01" min="0" max="500" placeholder="0.00">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="height_cm">Height (cm)</label>
                                <input type="number" class="form-control" id="height_cm" name="height_cm" 
                                       step="0.01" min="0" max="300" placeholder="0.00">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="bmi">BMI</label>
                                <input type="number" class="form-control" id="bmi" name="bmi" 
                                       step="0.01" readonly placeholder="Auto-calculated">
                                <small class="form-text text-muted">Automatically calculated from weight and height</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="blood_pressure">Blood Pressure</label>
                                <input type="text" class="form-control" id="blood_pressure" name="blood_pressure" 
                                       placeholder="e.g., 120/80" pattern="[0-9]{2,3}/[0-9]{2,3}">
                                <small class="form-text text-muted">Format: systolic/diastolic (e.g., 120/80)</small>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="heart_rate">Heart Rate (bpm)</label>
                                <input type="number" class="form-control" id="heart_rate" name="heart_rate" 
                                       min="30" max="200" placeholder="e.g., 72">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="blood_sugar_level">Blood Sugar Level (mg/dL)</label>
                                <input type="number" class="form-control" id="blood_sugar_level" name="blood_sugar_level" 
                                       step="0.01" min="0" max="1000" placeholder="e.g., 100.5">
                            </div>
                        </div>
                    </div>

                    <!-- Prosthetic Assessment Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-robot"></i> Prosthetic Assessment
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="k_level">K-Level (Activity Level) <span class="text-danger">*</span></label>
                                <select id="k_level" name="k_level" class="form-control" required>
                                    <option value="">Select K-Level</option>
                                    <option value="K0">K0 – No ability to ambulate</option>
                                    <option value="K1">K1 – Household ambulator</option>
                                    <option value="K2">K2 – Limited community ambulator</option>
                                    <option value="K3">K3 – Community ambulator</option>
                                    <option value="K4">K4 – Active adult / athlete</option>
                                </select>
                                <small class="form-text text-muted">Patient's functional mobility level</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="health_condition">General Health Condition <span class="text-danger">*</span></label>
                                <select id="health_condition" name="health_condition" class="form-control" required>
                                    <option value="">Select Health Condition</option>
                                    <option value="None">None</option>
                                    <option value="Mild">Mild</option>
                                    <option value="Moderate">Moderate</option>
                                    <option value="Severe">Severe</option>
                                </select>
                                <small class="form-text text-muted">Overall health status affecting prosthetic use</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="blart_score">BLARt Score</label>
                                <input type="number" class="form-control" id="blart_score" name="blart_score" 
                                    min="0" max="30" step="1" placeholder="e.g. 10 (Functional use)">
                                <small class="form-text text-muted">
                                    <strong>BLARt Score Range (0-30):</strong>
                                    <span class="d-block mt-1">
                                        <span class="badge badge-info mr-2">0-10: Limited use</span>
                                        <span class="badge badge-success mr-2">11-20: Functional use</span>
                                        <span class="badge badge-warning">21-30: Advanced use</span>
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Functional Assessment Section -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-walking"></i> Functional Assessment
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mobility_aid_used">Mobility Aid Used</label>
                                <input type="text" class="form-control" id="mobility_aid_used" name="mobility_aid_used" 
                                       placeholder="e.g., Cane, Walker, Wheelchair, Prosthetic">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="next_checkup_date">Next Checkup Date</label>
                                <input type="date" class="form-control" id="next_checkup_date" name="next_checkup_date">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="rehabilitation_status">Rehabilitation Status</label>
                                <textarea class="form-control" id="rehabilitation_status" name="rehabilitation_status" 
                                          rows="3" placeholder="Describe patient's current rehabilitation progress, goals, and achievements"></textarea>
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
                                <textarea class="form-control" id="treatment_notes" name="treatment_notes" 
                                          rows="5" placeholder="Enter detailed treatment notes, observations, recommendations, and any relevant medical information"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Medical Record
                        </button>
                        <a href="{{ route('doctor.patientlistdoct') }}" class="btn btn-secondary">
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

    // Set minimum date for future dates
    const nextCheckupDate = document.getElementById('next_checkup_date');
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${yyyy}-${mm}-${dd}`;
    
    nextCheckupDate.setAttribute('min', formattedToday);

    // Form validation
    const medicalRecordForm = document.getElementById('medicalRecordForm');
    
    medicalRecordForm.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Check required fields
        const requiredFields = ['patient_id', 'status', 'amputation_level', 'amputation_side', 'k_level', 'health_condition'];
        
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

    // Auto-hide success messages
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.transition = 'opacity 1s ease';
            successMessage.style.opacity = '0';
            setTimeout(() => {
                successMessage.remove();
            }, 1000);
        }, 5000);
    }

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
}

.btn-primary {
    background-color: var(--blue);
    border-color: var(--blue);
}

.btn-primary:hover {
    background-color: #6c6ce9;
    border-color: #6c6ce9;
    transform: translateY(-2px);
}

.btn-secondary {
    background-color: var(--light-color);
    border-color: var(--light-color);
}

.btn-outline-secondary {
    color: var(--light-color);
    border-color: var(--light-color);
}

.btn-outline-secondary:hover {
    background-color: var(--light-color);
    color: var(--white);
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.text-danger {
    color: #dc3545 !important;
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

/* Responsive adjustments */
@media (max-width: 768px) {
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