<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Update Appointment</title>

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
                <h3>Staff Dashboard</h3>
                <p>Welcome, <span>Staff</span></p>
            </div>

            <button id="sidebar-toggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <ul>
                <li >
                    <a href="{{ route('staff.indexstaff') }}">
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
                <li >
                    <a href="{{ route('staff.patient.patientliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </li>
                <li >
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
                <li  class="active">
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
                <h2>Update Appointment</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                    <a href="{{ url('/staff/indexstaff2') }}" class="link-btn">Home</a>
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

                <div class="appointment-detail-header">
                    <h3>Updating Appointment for {{ $appointment->patientName }}</h3>
                    <div class="appointment-meta">
                        <span class="appointment-id">
                            <i class="fas fa-hashtag"></i> ID: {{ $appointment->appID }}
                        </span>
                        <span class="appointment-created">
                            <i class="fas fa-calendar-plus"></i> Created: {{ $appointment->created_at->format('d/m/Y h:i A') }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('staff.appointment.update', $appointment->appID) }}" method="POST" class="appointment-form" id="appointmentForm">
                    @csrf
                    @method('PUT')

                    <h3 class="form-section-title">Patient Information</h3>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="patientName">Patient Name</label>
                            <input type="text" class="form-control" id="patientName" name="patientName" value="{{ $appointment->patientName }}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="patientIC">NRIC / Passport</label>
                            <input type="text" class="form-control" id="patientIC" name="patientIC" value="{{ $appointment->patientIC }}" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="patientTel">Telephone Number</label>
                            <input type="tel" class="form-control" id="patientTel" name="patientTel" value="{{ $appointment->patientTel }}" readonly>
                        </div>
                    </div>

                    <h3 class="form-section-title">Appointment Details</h3>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="typeAmputee">Type of Amputee</label>
                            <select id="typeAmputee" name="typeAmputee" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="Right Hand" {{ $appointment->typeAmputee == 'Right Hand' ? 'selected' : '' }}>Right Hand</option>
                                <option value="Left Hand" {{ $appointment->typeAmputee == 'Left Hand' ? 'selected' : '' }}>Left Hand</option>
                                <option value="Both Hands" {{ $appointment->typeAmputee == 'Both Hands' ? 'selected' : '' }}>Both Hands</option>
                                <option value="Right Leg" {{ $appointment->typeAmputee == 'Right Leg' ? 'selected' : '' }}>Right Leg</option>
                                <option value="Left Leg" {{ $appointment->typeAmputee == 'Left Leg' ? 'selected' : '' }}>Left Leg</option>
                                <option value="Both Legs" {{ $appointment->typeAmputee == 'Both Legs' ? 'selected' : '' }}>Both Legs</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="hospitalRefer">Hospital Referral</label>
                            <input type="text" class="form-control" id="hospitalRefer" name="hospitalRefer" value="{{ $appointment->hospitalRefer }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="sponsor">Sponsor</label>
                            <input type="text" class="form-control" id="sponsor" name="sponsor" value="{{ $appointment->sponsor }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nextHospitalAppointment">Next Hospital Appointment</label>
                            <input type="date" class="form-control" id="nextHospitalAppointment" name="nextHospitalAppointment" value="{{ $appointment->nextHospitalAppointment }}">
                        </div>
                    </div>

                    <h3 class="form-section-title">Walk-in Appointment Schedule</h3>

                    <div class="alert alert-info appointment-info">
                        <i class="fas fa-info-circle"></i> Office hours are Monday to Friday, 9:00 AM to 5:00 PM. Each appointment requires a minimum of 1 hour and maximum of 2 hours.
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="appointmentDate">Appointment Date</label>
                            <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" value="{{ $appointment->appointmentDate }}" required>
                            <div id="dateError" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="appointmentTime">Start Time</label>
                            <select class="form-control" id="appointmentTime" name="appointmentTime" required>
                                <option value="">Select Time</option>
                                @php
                                    $currentTime = date('H:i', strtotime($appointment->appointmentTime));
                                    // Define fixed time slots for easier management
                                    $timeSlots = [
                                        '09:00' => '09:00 - 11:00',
                                        '11:00' => '11:00 - 13:00',
                                        '13:00' => '13:00 - 15:00',
                                        '15:00' => '15:00 - 17:00'
                                    ];
                                @endphp

                                @foreach($timeSlots as $value => $label)
                                    <option value="{{ $value }}" {{ $currentTime == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div id="timeError" class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $appointment->notes }}</textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="status">Appointment Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="upcoming" {{ $appointment->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="appointment-schedule-container">
                        <h4>Available Time Slots</h4>
                        <div id="scheduleDisplay" class="schedule-display">
                            <p class="text-muted">Loading available time slots...</p>
                        </div>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Appointment
                        </button>
                        <a href="{{ route('staff.appointment.list') }}" class="btn btn-secondary">
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

    const appointmentDateInput = document.getElementById('appointmentDate');
    const appointmentTimeSelect = document.getElementById('appointmentTime');
    const scheduleDisplay = document.getElementById('scheduleDisplay');
    const currentAppointmentId = {{ $appointment->appID }};

    // Store the original date and time for comparison
    const originalDate = "{{ $appointment->appointmentDate }}";
    const originalTime = "{{ date('H:i', strtotime($appointment->appointmentTime)) }}";

    // Set minimum date to today
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${yyyy}-${mm}-${dd}`;

    // Don't restrict the date if it's the original date (allows keeping past appointments)
    if (new Date(originalDate) >= new Date(formattedToday)) {
        appointmentDateInput.setAttribute('min', formattedToday);
    }

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

        // Allow the original date even if it's in the past
        if (appointmentDateInput.value === originalDate) {
            return true;
        }

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

        // Fetch booked slots from the server, excluding the current appointment
        fetch(`/staff/appointment/check-slots/${selectedDate}?exclude=${currentAppointmentId}`)

            .then(response => response.json())
            .then(bookedSlots => {
                // Clear existing options except the placeholder
                appointmentTimeSelect.innerHTML = '<option value="">Select Time</option>';

                // Initialize the schedule display
                scheduleDisplay.innerHTML = '<div class="schedule-slots"></div>';
                const slotsContainer = scheduleDisplay.querySelector('.schedule-slots');

                // Add each time slot to the dropdown and visual display
                fixedSlots.forEach(slot => {
                    const slotStart = `${String(slot.start).padStart(2, '0')}:00`;
                    const slotEnd = `${String(slot.end).padStart(2, '0')}:00`;
                    const label = `${slotStart} - ${slotEnd}`;

                    // Check if this slot is booked (by someone else)
                    const isBooked = bookedSlots.some(b => b.start === slot.start);

                    // Check if this was the original time slot
                    const isOriginalSlot = selectedDate === originalDate && slotStart === originalTime;

                    // If it's available or it's the original slot, add to dropdown
                    if (!isBooked || isOriginalSlot) {
                        const option = document.createElement('option');
                        option.value = slotStart;
                        option.textContent = label;

                        // Select this option if it's the current appointment time
                        if (isOriginalSlot) {
                            option.selected = true;
                        }

                        appointmentTimeSelect.appendChild(option);
                    }

                    // Create the visual representation of the slot
                    const div = document.createElement('div');

                    // Determine the class for the slot
                    let slotClass = 'schedule-slot';
                    if (isBooked && !isOriginalSlot) {
                        slotClass += ' booked';
                    } else if (isOriginalSlot) {
                        slotClass += ' available selected';
                    } else {
                        slotClass += ' available';
                    }

                    div.className = slotClass;

                    // Set the slot content
                    let statusText = isBooked ? 'Booked' : 'Available';
                    if (isOriginalSlot) {
                        statusText = 'Current Selection';
                    }

                    div.innerHTML = `
                        <span class="slot-time">${label}</span>
                        <span class="slot-status">${statusText}</span>
                    `;

                    slotsContainer.appendChild(div);

                    // Add click event to available slots
                    if (!isBooked || isOriginalSlot) {
                        div.addEventListener('click', () => {
                            appointmentTimeSelect.value = slotStart;

                            // Update the visual selection
                            document.querySelectorAll('.schedule-slot').forEach(s => {
                                s.classList.remove('selected');
                            });
                            div.classList.add('selected');
                        });
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching slot data:', error);
                scheduleDisplay.innerHTML = '<p class="text-danger">Failed to load time slots. Please try again.</p>';
            });
    }

    // Initialize time slots display on page load
    updateAvailableTimeSlots();

    const appointmentForm = document.getElementById('appointmentForm');
    appointmentForm.addEventListener('submit', function (event) {
        let valid = true;

        // Only validate the date if it's changed from the original
        if (appointmentDateInput.value !== originalDate) {
            if (!validateAppointmentDate()) valid = false;
        }

        if (!validateAppointmentTime()) valid = false;

        if (!valid) event.preventDefault();
    });

    // Success message fadeout
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
    /* Additional styling for appointment update form */
    .appointment-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--light-bg);
    }

    .appointment-detail-header h3 {
        font-size: 2.2rem;
        color: var(--black);
        margin: 0;
    }

    .appointment-meta {
        display: flex;
        gap: 2rem;
    }

    .appointment-meta span {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-size: 1.5rem;
        color: var(--light-color);
    }

    .appointment-meta i {
        color: var(--blue);
    }

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

    @media (max-width: 991px) {
        .appointment-detail-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .appointment-meta {
            margin-top: 1rem;
        }
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
