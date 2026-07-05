<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Edit My Profile</title>

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
                <h3>Staff Dashboard</h3>
                <p>Welcome, <span>{{ auth()->user()->staffName ?? 'Staff' }}</span></p>
            </div>

            <button id="sidebar-toggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('staff.indexstaff') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('staff.profile.view') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.patient.patientliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.doctor.doctorliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff.appointment.list') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Appointments List</span>
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
                <h2>Edit My Profile</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                        <a href="{{ route('staff.indexstaff') }}" class="link-btn">Home</a>
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

                @if ($errors->any())
                    <div class="error-message">
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

                <!-- Profile Edit Header -->
                <div class="profile-edit-header">
                    <div class="profile-avatar-section">
                        <div class="profile-avatar-large">
                            <div class="avatar-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="profile-info">
                            <h3>Editing Profile for</h3>
                            <p class="staff-name">{{ $staff->staffName }}</p>
                            <p class="staff-id">
                                <i class="fas fa-hashtag"></i>
                                Staff ID: {{ $staff->staffID }}
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('staff.profile.update') }}" method="POST" class="profile-edit-form" id="profileForm">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-user-circle"></i> Personal Information
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="staffName">Full Name <span class="required">*</span></label>
                                <input type="text"
                                       class="form-control @error('staffName') is-invalid @enderror"
                                       id="staffName"
                                       name="staffName"
                                       value="{{ old('staffName', $staff->staffName) }}"
                                       required>
                                @error('staffName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="staffIC">NRIC Number <span class="required">*</span></label>
                                <input type="text"
                                       class="form-control @error('staffIC') is-invalid @enderror"
                                       id="staffIC"
                                       name="staffIC"
                                       value="{{ old('staffIC', $staff->staffIC) }}"
                                       required>
                                @error('staffIC')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Format: YYMMDD-PB-###G
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dateOfBirth">Date of Birth <span class="required">*</span></label>
                                <input type="date"
                                       class="form-control @error('dateOfBirth') is-invalid @enderror"
                                       id="dateOfBirth"
                                       name="dateOfBirth"
                                       value="{{ old('dateOfBirth', $staff->dateOfBirth) }}"
                                       required>
                                @error('dateOfBirth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="gender">Gender <span class="required">*</span></label>
                                <select class="form-control @error('gender') is-invalid @enderror"
                                        id="gender"
                                        name="gender"
                                        required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $staff->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $staff->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="race">Race</label>
                                <select class="form-control @error('race') is-invalid @enderror"
                                        id="race"
                                        name="race">
                                    <option value="">Select Race</option>
                                    <option value="Malay" {{ old('race', $staff->race) == 'Malay' ? 'selected' : '' }}>Malay</option>
                                    <option value="Chinese" {{ old('race', $staff->race) == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                    <option value="Indian" {{ old('race', $staff->race) == 'Indian' ? 'selected' : '' }}>Indian</option>
                                    <option value="Others" {{ old('race', $staff->race) == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                                @error('race')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="maritalStatus">Marital Status</label>
                                <select class="form-control @error('maritalStatus') is-invalid @enderror"
                                        id="maritalStatus"
                                        name="maritalStatus">
                                    <option value="">Select Marital Status</option>
                                    <option value="Single" {{ old('maritalStatus', $staff->maritalStatus) == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('maritalStatus', $staff->maritalStatus) == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Divorced" {{ old('maritalStatus', $staff->maritalStatus) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="Widowed" {{ old('maritalStatus', $staff->maritalStatus) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                                @error('maritalStatus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address"
                                          name="address"
                                          rows="3"
                                          placeholder="Enter full address">{{ old('address', $staff->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-address-book"></i> Contact Information
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="staffEmail">Email Address <span class="required">*</span></label>
                                <input type="email"
                                       class="form-control @error('staffEmail') is-invalid @enderror"
                                       id="staffEmail"
                                       name="staffEmail"
                                       value="{{ old('staffEmail', $staff->staffEmail) }}"
                                       required>
                                @error('staffEmail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-envelope"></i> This email will be used for system notifications
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="staffTel">Contact Number <span class="required">*</span></label>
                                <input type="tel"
                                       class="form-control @error('staffTel') is-invalid @enderror"
                                       id="staffTel"
                                       name="staffTel"
                                       value="{{ old('staffTel', $staff->staffTel) }}"
                                       required>
                                @error('staffTel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-phone"></i> Include country code (e.g., +60123456789)
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-briefcase"></i> Professional Information
                        </h3>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="staffID">Staff ID</label>
                                <input type="text"
                                       class="form-control"
                                       id="staffID"
                                       name="staffID"
                                       value="{{ $staff->staffID }}"
                                       readonly>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Staff ID is automatically assigned and cannot be changed
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="staffRole">Role Type</label>
                                <select class="form-control"
                                        id="staffRole"
                                        name="staffRole"
                                        disabled>
                                    <option value="admin" {{ $staff->staffRole == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="staff" {{ $staff->staffRole == 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Role type can only be changed by Administrator
                                </small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="status">Account Status</label>
                                <select class="form-control"
                                        id="status"
                                        name="status"
                                        disabled>
                                    <option value="pending" {{ $staff->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $staff->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Account status is managed by administrators
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Account Security Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-shield-alt"></i> Account Security
                        </h3>

                        <div class="security-info">
                            <div class="security-item">
                                <div class="security-icon">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div class="security-content">
                                    <h5>Change Password</h5>
                                    <p>Update your password to keep your account secure</p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-key"></i> Change Password
                                    </a>
                                </div>
                            </div>

                            <div class="security-item">
                                <div class="security-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="security-content">
                                    <h5>Last Updated</h5>
                                    <p>Profile was last updated on {{ $staff->updated_at->format('d/m/Y h:i A') }}</p>
                                </div>
                            </div>

                            <div class="security-item">
                                <div class="security-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="security-content">
                                    <h5>Account Created</h5>
                                    <p>Account was created on {{ $staff->created_at->format('d/m/Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <a href="{{ route('staff.profile.view') }}" class="btn btn-secondary">
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

    ScrollReveal().reveal('.form-section', {
        origin: 'bottom',
        distance: '20px',
        duration: 1000,
        interval: 200,
        delay: 300,
        easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
        reset: false
    });

    // Form validation
    const profileForm = document.getElementById('profileForm');
    const nameInput = document.getElementById('staffName');
    const emailInput = document.getElementById('staffEmail');
    const phoneInput = document.getElementById('staffTel');
    const icInput = document.getElementById('staffIC');
    const dobInput = document.getElementById('dateOfBirth');

    // Real-time validation
    nameInput.addEventListener('input', function() {
        validateName(this);
    });

    emailInput.addEventListener('input', function() {
        validateEmail(this);
    });

    phoneInput.addEventListener('input', function() {
        validatePhone(this);
    });

    icInput.addEventListener('input', function() {
        validateIC(this);
    });

    dobInput.addEventListener('change', function() {
        validateDateOfBirth(this);
    });

    function validateName(input) {
        const value = input.value.trim();
        const nameRegex = /^[a-zA-Z\s]+$/;

        if (value.length < 2) {
            showFieldError(input, 'Name must be at least 2 characters long');
            return false;
        } else if (!nameRegex.test(value)) {
            showFieldError(input, 'Name should only contain letters and spaces');
            return false;
        } else {
            showFieldSuccess(input);
            return true;
        }
    }

    function validateEmail(input) {
        const value = input.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(value)) {
            showFieldError(input, 'Please enter a valid email address');
            return false;
        } else {
            showFieldSuccess(input);
            return true;
        }
    }

    function validatePhone(input) {
        const value = input.value.trim();
        const phoneRegex = /^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/;

        if (value.length < 10) {
            showFieldError(input, 'Phone number must be at least 10 digits');
            return false;
        } else if (!phoneRegex.test(value.replace(/\s|-/g, ''))) {
            showFieldError(input, 'Please enter a valid Malaysian phone number');
            return false;
        } else {
            showFieldSuccess(input);
            return true;
        }
    }

    function validateIC(input) {
        const value = input.value.trim();
        const icRegex = /^\d{6}-\d{2}-\d{4}$|^\d{12}$/;

        if (!icRegex.test(value)) {
            showFieldError(input, 'Please enter a valid IC number (YYMMDD-PB-####)');
            return false;
        } else {
            showFieldSuccess(input);
            return true;
        }
    }

    function validateDateOfBirth(input) {
        const value = input.value;
        const selectedDate = new Date(value);
        const today = new Date();
        const minAge = 18;
        const maxAge = 65;

        let age = today.getFullYear() - selectedDate.getFullYear();
        const monthDiff = today.getMonth() - selectedDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < selectedDate.getDate())) {
            age--;
        }

        if (selectedDate > today) {
            showFieldError(input, 'Date of birth cannot be in the future');
            return false;
        } else if (age < minAge) {
            showFieldError(input, 'Must be at least 18 years old');
            return false;
        } else if (age > maxAge) {
            showFieldError(input, 'Age cannot exceed 65 years');
            return false;
        } else {
            showFieldSuccess(input);
            return true;
        }
    }

    function showFieldError(input, message) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');

        let feedback = input.parentNode.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            input.parentNode.appendChild(feedback);
        }
        feedback.textContent = message;
    }

    function showFieldSuccess(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }

    // Form submission validation
    profileForm.addEventListener('submit', function(event) {
        const nameValid = validateName(nameInput);
        const emailValid = validateEmail(emailInput);
        const phoneValid = validatePhone(phoneInput);
        const icValid = validateIC(icInput);
        const dobValid = validateDateOfBirth(dobInput);

        if (!nameValid || !emailValid || !phoneValid || !icValid || !dobValid) {
            event.preventDefault();

            // Show error message
            showNotification('Please fix the validation errors before submitting', 'error');

            // Focus on first invalid field
            const firstInvalid = profileForm.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.focus();
            }
        }
    });

    // Reset form functionality
    const resetButton = profileForm.querySelector('button[type="reset"]');
    if (resetButton) {
        resetButton.addEventListener('click', function(event) {
            event.preventDefault();

            if (confirm('Are you sure you want to reset all changes? This will restore the original values.')) {
                profileForm.reset();

                // Remove validation classes
                const inputs = profileForm.querySelectorAll('.form-control');
                inputs.forEach(input => {
                    input.classList.remove('is-valid', 'is-invalid');
                });

                showNotification('Form has been reset to original values', 'info');
            }
        });
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} alert-dismissible fade show`;
        notification.innerHTML = `
            <i class="fas ${type === 'error' ? 'fa-exclamation-triangle' : type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i>
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        `;

        const container = document.querySelector('.content-container');
        container.insertBefore(notification, container.firstChild);

        // Auto dismiss after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

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
/* Same styling as admin edit profile - all the CSS from admin edit */
.profile-edit-form {
    background-color: var(--white);
    border-radius: 1rem;
    box-shadow: var(--box-shadow);
    padding: 2rem;
}

.form-section {
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--light-bg);
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
}

.form-section-title {
    font-size: 2rem;
    color: var(--blue);
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--light-bg);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.form-section-title i {
    color: var(--blue);
}

.form-group label {
    font-size: 1.5rem;
    color: var(--black);
    font-weight: 500;
    margin-bottom: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.required {
    color: #ff6b6b;
    font-weight: bold;
}

.form-control {
    font-size: 1.5rem;
    padding: 1.2rem 1.5rem;
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

.form-control.is-valid {
    border-color: #4bd28f;
}

.form-control.is-invalid {
    border-color: #ff6b6b;
}

.form-control[readonly], .form-control[disabled] {
    background-color: var(--light-bg);
    border-color: #e0e0e0;
    cursor: not-allowed;
    opacity: 0.8;
}

.form-text {
    font-size: 1.3rem;
    color: var(--light-color);
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.invalid-feedback {
    display: block;
    font-size: 1.3rem;
    color: #ff6b6b;
    margin-top: 0.5rem;
}

.valid-feedback {
    display: block;
    font-size: 1.3rem;
    color: #4bd28f;
    margin-top: 0.5rem;
}

/* Security Section */
.security-info {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.security-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background-color: var(--light-bg);
    border-radius: 0.8rem;
    transition: all 0.3s ease;
}

.security-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.security-icon {
    width: 5rem;
    height: 5rem;
    border-radius: 50%;
    background-color: var(--blue);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.security-icon i {
    font-size: 2rem;
}

.security-content h5 {
    font-size: 1.6rem;
    color: var(--black);
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.security-content p {
    font-size: 1.4rem;
    color: var(--light-color);
    margin-bottom: 1rem;
}

/* Form buttons */
.form-buttons {
    display: flex;
    gap: 1.5rem;
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid var(--light-bg);
}

.btn {
    padding: 1.2rem 2.5rem;
    font-size: 1.6rem;
    font-weight: 500;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    border: none;
    text-decoration: none;
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

.btn-secondary {
    background-color: var(--light-bg);
    color: var(--black);
    border: 2px solid #e0e0e0;
}

.btn-secondary:hover {
    background-color: #e0e0e0;
    color: var(--black);
    text-decoration: none;
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.btn-outline-secondary {
    background-color: transparent;
    color: var(--light-color);
    border: 2px solid #e0e0e0;
}

.btn-outline-secondary:hover {
    background-color: var(--light-bg);
    color: var(--black);
    border-color: var(--light-color);
    text-decoration: none;
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.btn-outline-primary {
    background-color: transparent;
    color: var(--blue);
    border: 2px solid var(--blue);
}

.btn-outline-primary:hover {
    background-color: var(--blue);
    color: var(--white);
    text-decoration: none;
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(125, 125, 235, 0.3);
}

.btn-sm {
    padding: 0.8rem 1.5rem;
    font-size: 1.4rem;
}

/* Error messages */
.success-message, .error-message {
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    font-size: 1.6rem;
    transition: opacity 1s ease;
    display: flex;
    align-items: flex-start;
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

.error-list {
    margin: 0.5rem 0 0 0;
    padding-left: 1.5rem;
}

.error-list li {
    margin-bottom: 0.3rem;
}

/* Profile Edit Header */
.profile-edit-header {
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

.staff-name {
    font-size: 1.8rem;
    color: var(--blue);
    margin-bottom: 0.3rem;
    font-weight: 600;
}

.staff-id {
    font-size: 1.3rem;
    color: var(--light-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
    line-height: 1.2;
}

/* Responsive design */
@media (max-width: 991px) {
    .profile-edit-header {
        flex-direction: column;
        gap: 2rem;
        text-align: center;
    }

    .profile-avatar-section {
        flex-direction: column;
        text-align: center;
    }

    .security-info {
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .form-buttons {
        flex-direction: column;
    }

    .form-buttons .btn {
        width: 100%;
        justify-content: center;
    }

    .profile-edit-form {
        padding: 1.5rem;
    }

    .security-item {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .profile-edit-header {
        padding: 1.5rem;
    }
}

@media (max-width: 576px) {
    .profile-avatar-large {
        width: 6rem;
        height: 6rem;
    }

    .avatar-placeholder i {
        font-size: 2.5rem;
    }

    .form-section-title {
        font-size: 1.8rem;
    }

    .staff-name {
        font-size: 1.6rem;
    }
}
</style>
</body>
</html>