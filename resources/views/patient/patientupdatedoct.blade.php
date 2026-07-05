<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Update Patient</title>

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
                <li class="active">
                    <a href="{{ route('doctor.patientlistdoct') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('doctor.assessment.list') || request()->routeIs('doctor.assessment.show') ? 'active' : '' }}">
                    <a href="{{ route('doctor.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Appointment List</span>
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
                <h2 class="page-title">Update Patient Details</h2>
                <p class="header-subtitle">Modify patient information and personal details</p>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="update-form-container">
                <div class="section-header">
                    <h3 class="update-form-heading">
                        <i class="fas fa-user-injured"></i>
                        Edit Patient: {{ $patient->patientName }}
                    </h3>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('doctor.updatedoc', $patient->patientID) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-id-card"></i>
                            Basic Information
                        </h4>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="patientName"><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" class="form-control" id="patientName" name="patientName" 
                                       value="{{ old('patientName', $patient->patientName) }}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="patientIC"><i class="fas fa-id-card-alt"></i> IC Number</label>
                                <input type="text" class="form-control" id="patientIC" name="patientIC" 
                                       value="{{ old('patientIC', $patient->patientIC) }}" required 
                                       placeholder="e.g., 991231-01-1234">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="patientEmail"><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" class="form-control" id="patientEmail" name="patientEmail" 
                                       value="{{ old('patientEmail', $patient->patientEmail) }}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="patientTel"><i class="fas fa-phone"></i> Phone Number</label>
                                <input type="text" class="form-control" id="patientTel" name="patientTel" 
                                       value="{{ old('patientTel', $patient->patientTel) }}" required 
                                       placeholder="e.g., 013-123-4567">
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-user-circle"></i>
                            Personal Information
                        </h4>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="dateOfBirth"><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                                <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" 
                                       value="{{ old('dateOfBirth', $patient->dateOfBirth) }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="gender"><i class="fas fa-venus-mars"></i> Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="race"><i class="fas fa-globe"></i> Race</label>
                                <select class="form-control" id="race" name="race">
                                    <option value="">Select Race</option>
                                    <option value="Malay" {{ old('race', $patient->race) == 'Malay' ? 'selected' : '' }}>Malay</option>
                                    <option value="Chinese" {{ old('race', $patient->race) == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                    <option value="Indian" {{ old('race', $patient->race) == 'Indian' ? 'selected' : '' }}>Indian</option>
                                    <option value="Others" {{ old('race', $patient->race) == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="maritalStatus"><i class="fas fa-heart"></i> Marital Status</label>
                                <select class="form-control" id="maritalStatus" name="maritalStatus">
                                    <option value="">Select Status</option>
                                    <option value="Single" {{ old('maritalStatus', $patient->maritalStatus) == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('maritalStatus', $patient->maritalStatus) == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Divorced" {{ old('maritalStatus', $patient->maritalStatus) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="Widowed" {{ old('maritalStatus', $patient->maritalStatus) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" 
                                      placeholder="Enter complete address">{{ old('address', $patient->address) }}</textarea>
                        </div>
                    </div>

                    <div class="update-form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Update Patient Information
                        </button>
                        <a href="{{ route('doctor.patientviewdoct', $patient->patientID) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
</div>

<!-- JS files -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
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
        
        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
        
        // Initialize ScrollReveal
        ScrollReveal().reveal('.update-form-container', {
            origin: 'bottom',
            distance: '30px',
            duration: 1000,
            delay: 200,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });
    });
</script>

<style>
/* Additional styles for the update form */
.form-section {
    background-color: var(--white);
    border-radius: 1rem;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.form-section-title {
    font-size: 1.8rem;
    color: var(--blue);
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(125, 125, 235, 0.2);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.form-section-title i {
    color: var(--blue);
}

.form-group label {
    font-weight: 600;
    color: var(--black);
    margin-bottom: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.form-group label i {
    color: var(--light-color);
    width: 1.5rem;
}

.form-control {
    padding: 1.2rem 1.5rem;
    font-size: 1.5rem;
    border: 1px solid #ddd;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 0.2rem rgba(125, 125, 235, 0.1);
}

.form-control.is-invalid {
    border-color: #ff6b6b;
}

.alert {
    padding: 1.5rem;
    border-radius: 0.8rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.alert-success {
    background-color: rgba(75, 210, 143, 0.1);
    color: #4bd28f;
    border: 1px solid rgba(75, 210, 143, 0.2);
}

.alert-danger {
    background-color: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
    border: 1px solid rgba(255, 107, 107, 0.2);
}

.alert ul {
    margin: 0;
    padding-left: 1.5rem;
}

.update-form-actions {
    display: flex;
    gap: 1.5rem;
    margin-top: 3rem;
    justify-content: center;
}

.update-form-actions .btn {
    padding: 1.2rem 2.5rem;
    font-size: 1.6rem;
    font-weight: 500;
    border-radius: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    min-width: 180px;
    justify-content: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-section {
        padding: 2rem;
    }
    
    .update-form-actions {
        flex-direction: column;
    }
    
    .update-form-actions .btn {
        width: 100%;
    }
}
</style>

</body>
</html>