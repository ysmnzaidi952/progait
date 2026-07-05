<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Create Appointment</title>

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



                <li class="active">
                    <a href="{{ route('doctor.appointment.list') }}">
                        <i class="fas fa-calendar-check"></i>
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
                <h2>Create New Appointment</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                    <a href="{{ route('doctor.indexdoctor') }}" class="link-btn">Home</a>
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

                <form action="{{ route('doctor.appointment.store') }}" method="POST" class="appointment-form" id="appointmentForm">
                    @csrf
                    
                    <h3 class="form-section-title">Patient Information</h3>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="patientSelect">Patient Name</label>
                            <select id="patientSelect" class="form-control" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option 
                                        value="{{ $patient->patientName }}" 
                                        data-id="{{ $patient->patientID }}" 
                                        data-ic="{{ $patient->patientIC }}" 
                                        data-tel="{{ $patient->patientTel }}"
                                    >
                                        {{ $patient->patientName }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="patient_id" id="patient_id">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="patientIC">NRIC / Passport</label>
                            <input type="text" class="form-control" id="patientIC" name="patientIC" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="patientTel">Telephone Number</label>
                            <input type="tel" class="form-control" id="patientTel" name="patientTel" readonly>
                        </div>
                    </div>
                    
                    <h3 class="form-section-title">Appointment Details</h3>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="typeAmputee">Type of Amputee</label>
                            <select id="typeAmputee" name="typeAmputee" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="Right Hand">Right Hand</option>
                                <option value="Left Hand">Left Hand</option>
                                <option value="Both Hands">Both Hands</option>
                                <option value="Right Leg">Right Leg</option>
                                <option value="Left Leg">Left Leg</option>
                                <option value="Both Legs">Both Legs</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hospitalRefer">Hospital Referral</label>
                            <input type="text" class="form-control" id="hospitalRefer" name="hospitalRefer">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="sponsor">Sponsor</label>
                            <input type="text" class="form-control" id="sponsor" name="sponsor">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nextHospitalAppointment">Next Hospital Appointment</label>
                            <input type="date" class="form-control" id="nextHospitalAppointment" name="nextHospitalAppointment">
                        </div>
                    </div>
                    
                    <h3 class="form-section-title">Walk-in Appointment Schedule</h3>
                    
                    <div class="alert alert-info appointment-info">
                        <i class="fas fa-info-circle"></i> Office hours are Monday to Friday, 9:00 AM to 5:00 PM. Each appointment requires 2 hours.
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="appointmentDate">Appointment Date</label>
                            <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" required>
                            <div id="dateError" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="appointmentTime">Start Time</label>
                            <select class="form-control" id="appointmentTime" name="appointmentTime" required>
                                <option value="">Select Time</option>
                                <!-- Time slots will be populated by JavaScript -->
                            </select>
                            <div id="timeError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="medicalNotes">Medical Notes</label>
                            <textarea class="form-control" id="medicalNotes" name="medicalNotes" rows="3" placeholder="Enter any specific medical information or instructions for this appointment"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="notes">Additional Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="appointment-schedule-container">
                        <h4>Available Time Slots</h4>
                        <div id="scheduleDisplay" class="schedule-display">
                            <p class="text-muted">Please select a date to view available time slots.</p>
                        </div>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calendar-plus"></i> Create Appointment
                        </button>
                        <a href="{{ route('doctor.appointment.list') }}" class="btn btn-secondary">
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

    // Autofill patient IC and Tel when name selected
    const patientSelect = document.getElementById('patientSelect');
    const patientICInput = document.getElementById('patientIC');
    const patientTelInput = document.getElementById('patientTel');
    const patientIdInput = document.getElementById('patient_id');

    if (patientSelect) {
        patientSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            patientICInput.value = selectedOption.dataset.ic || '';
            patientTelInput.value = selectedOption.dataset.tel || '';
            patientIdInput.value = selectedOption.dataset.id || '';
        });
    }

    const appointmentDateInput = document.getElementById('appointmentDate');
    const appointmentTimeSelect = document.getElementById('appointmentTime');
    const scheduleDisplay = document.getElementById('scheduleDisplay');

    // Set minimum date to today
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${yyyy}-${mm}-${dd}`;
    appointmentDateInput.setAttribute('min', formattedToday);

    // On date change
    appointmentDateInput.addEventListener('change', function () {
        if (validateAppointmentDate()) {
            updateAvailableTimeSlots();
        } else {
            appointmentTimeSelect.innerHTML = '<option value="">Select Time</option>';
            scheduleDisplay.innerHTML = '<p class="text-muted">No available time slots.</p>';
        }
    });

    appointmentTimeSelect.addEventListener('change', function () {
        validateAppointmentTime();
    });

    function validateAppointmentDate() {
        const dateError = document.getElementById('dateError');
        const selectedDate = new Date(appointmentDateInput.value);
        const dayOfWeek = selectedDate.getDay();
        let isValid = true;

        dateError.textContent = '';
        appointmentDateInput.classList.remove('is-invalid');

        if (selectedDate < new Date(formattedToday)) {
            dateError.textContent = 'Cannot select a date in the past.';
            appointmentDateInput.classList.add('is-invalid');
            isValid = false;
        }

        if (dayOfWeek === 0 || dayOfWeek === 6) {
            dateError.textContent = 'Appointments are only available Monday to Friday.';
            appointmentDateInput.classList.add('is-invalid');
            isValid = false;
        }

        return isValid;
    }

    function validateAppointmentTime() {
        const selectedTime = appointmentTimeSelect.value;
        const timeError = document.getElementById('timeError');
        let isValid = true;

        timeError.textContent = '';
        appointmentTimeSelect.classList.remove('is-invalid');

        if (!selectedTime) {
            timeError.textContent = 'Please select an available time.';
            appointmentTimeSelect.classList.add('is-invalid');
            isValid = false;
        }

        return isValid;
    }

    function updateAvailableTimeSlots() {
        const selectedDate = appointmentDateInput.value;
        const fixedSlots = [
            { start: 9, end: 11 },
            { start: 11, end: 13 },
            { start: 13, end: 15 },
            { start: 15, end: 17 }
        ];

        fetch(`/doctor/appointment/check-slots/${selectedDate}`)

            .then(response => response.json())
            .then(bookedSlots => {
                appointmentTimeSelect.innerHTML = '<option value="">Select Time</option>';
                scheduleDisplay.innerHTML = '<div class="schedule-slots"></div>';

                fixedSlots.forEach(slot => {
                    const slotStart = `${String(slot.start).padStart(2, '0')}:00`;
                    const slotEnd = `${String(slot.end).padStart(2, '0')}:00`;
                    const label = `${slotStart} - ${slotEnd}`;
                    const isBooked = bookedSlots.some(b => b.start === slot.start);

                    if (!isBooked) {
                        const option = document.createElement('option');
                        option.value = slotStart;
                        option.textContent = label;
                        appointmentTimeSelect.appendChild(option);
                    }

                    const div = document.createElement('div');
                    div.className = `schedule-slot ${isBooked ? 'booked' : 'available'}`;
                    div.innerHTML = `<span class="slot-time">${label}</span><span class="slot-status">${isBooked ? 'Booked' : 'Available'}</span>`;
                    scheduleDisplay.querySelector('.schedule-slots').appendChild(div);

                    if (!isBooked) {
                        div.addEventListener('click', () => {
                            appointmentTimeSelect.value = slotStart;
                            document.querySelectorAll('.schedule-slot').forEach(s => s.classList.remove('selected'));
                            div.classList.add('selected');
                        });
                    }
                });
            });
    }

    const appointmentForm = document.getElementById('appointmentForm');
    appointmentForm.addEventListener('submit', function (event) {
        let valid = true;
        if (!validateAppointmentDate()) valid = false;
        if (!validateAppointmentTime()) valid = false;
        if (!valid) event.preventDefault();
    });

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
    /* Additional styling for appointment creation form */
    .appointment-form {
        padding: 2rem;
    }
    
    .form-section-title {
        font-size: 2rem;
        color: var(--blue);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--light-bg);
    }
    
    .appointment-info {
        font-size: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .appointment-info i {
        margin-right: 0.8rem;
    }
    
    .appointment-schedule-container {
        margin: 2rem 0;
        padding: 2rem;
        background-color: var(--light-bg);
        border-radius: 0.5rem;
    }
    
    .appointment-schedule-container h4 {
        font-size: 1.8rem;
        color: var(--black);
        margin-bottom: 1.5rem;
    }
    
    .schedule-display {
        background-color: var(--white);
        border-radius: 0.5rem;
        padding: 1.5rem;
    }
    
    .schedule-slots {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .schedule-slot {
        display: flex;
        flex-direction: column;
        padding: 1.5rem;
        border-radius: 0.5rem;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }
    
    .schedule-slot.available {
        background-color: rgba(75, 210, 143, 0.1);
        border-color: #4bd28f;
        cursor: pointer;
    }
    
    .schedule-slot.booked {
        background-color: rgba(255, 107, 107, 0.1);
        border-color: #ff6b6b;
        opacity: 0.7;
    }
    
    .schedule-slot.selected {
        background-color: rgba(125, 125, 235, 0.1);
        border-color: var(--blue);
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .schedule-slot:hover.available {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .slot-time {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.5rem;
    }
    
    .slot-status {
        font-size: 1.3rem;
        color: var(--light-color);
    }
    
    .schedule-slot.available .slot-status {
        color: #4bd28f;
    }
    
    .schedule-slot.booked .slot-status {
        color: #ff6b6b;
    }
    
    .error-message {
        background-color: #FFEBEE;
        color: #B71C1C;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        font-size: 1.6rem;
        transition: opacity 1s ease;
    }
    
    .error-message i {
        margin-right: 0.8rem;
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
    
    @media (max-width: 768px) {
        .form-buttons {
            flex-direction: column;
        }
        
        .form-buttons .btn {
            width: 100%;
        }
        
        .schedule-slots {
            grid-template-columns: 1fr;
        }
    }
</style>

</body>
</html>