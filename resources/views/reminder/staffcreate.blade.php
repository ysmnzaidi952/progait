<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Schedule Appointment Reminders</title>

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
                <li class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('staff.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.profile.view') ? 'active' : '' }}">
                    <a href="{{ route('staff.profile.view') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.patient.patientliststaff') ? 'active' : '' }}">
                    <a href="{{ route('staff.patient.patientliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.doctor.doctorliststaff') ? 'active' : '' }}">
                    <a href="{{ route('staff.doctor.doctorliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.assessment.list') ? 'active' : '' }}">
                    <a href="{{ route('staff.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.appointment.list') ? 'active' : '' }}">
                    <a href="{{ route('staff.appointment.list') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Appointments List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.reminder.create') || request()->routeIs('staff.reminder.list') ? 'active' : '' }}">
                    <a href="{{ route('staff.reminder.list') }}">
                        <i class="fas fa-bell"></i>
                        <span>Appointment Reminders</span>
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
                <h2>Schedule Appointment Reminders</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                        <a href="{{ route('staff.dashboard') }}" class="link-btn">Home</a>
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

                <div class="reminder-layout">
                    <!-- Left Panel - Patient Selection & Schedules -->
                    <div class="reminder-left-panel">
                        <form action="{{ route('staff.reminder.store') }}" method="POST" class="reminder-form" id="reminderForm">
                            @csrf

                            <!-- Patient Information Section -->
                            <div class="reminder-section">
                                <h3 class="section-title">
                                    <i class="fas fa-user"></i> Patient Information
                                </h3>

                                <div class="form-group">
                                    <label for="patientSelect">
                                        <i class="fas fa-search"></i> Patient Name
                                    </label>
                                    <select id="patientSelect" name="patientName" class="form-control patient-select" required>
                                        <option value="">Select Patient</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->patientName }}"
                                                    data-id="{{ $patient->patientID }}"
                                                    data-ic="{{ $patient->patientIC }}"
                                                    data-tel="{{ $patient->patientTel }}">
                                                {{ $patient->patientName }} - {{ $patient->patientIC }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="patientDetails" class="patient-details-card" style="display: none;">
                                    <div class="patient-info-row">
                                        <span class="info-label">Name:</span>
                                        <span id="displayName" class="info-value">-</span>
                                    </div>
                                    <div class="patient-info-row">
                                        <span class="info-label">IC Number:</span>
                                        <span id="displayIC" class="info-value">-</span>
                                    </div>
                                    <div class="patient-info-row">
                                        <span class="info-label">Phone Number:</span>
                                        <span id="displayPhone" class="info-value">-</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Schedules Section -->
                            <div class="reminder-section">
                                <h3 class="section-title">
                                    <i class="fas fa-calendar-alt"></i> Date Schedules
                                </h3>

                                <div class="alert alert-info reminder-info">
                                    <i class="fas fa-info-circle"></i>
                                    Select the first appointment date. The system will automatically calculate 6-month and 9-month follow-ups. Only one patient can be scheduled per day.
                                </div>

                                <div class="schedule-list">
                                    <div class="schedule-item">
                                        <div class="schedule-number">1</div>
                                        <div class="schedule-content">
                                            <label class="schedule-label">First 3m</label>
                                            <input type="date" id="firstDate" name="firstDate" class="form-control schedule-date" required>
                                            <div id="firstDateError" class="invalid-feedback"></div>
                                        </div>
                                        <div class="schedule-status" id="firstStatus">
                                            <i class="fas fa-clock text-warning"></i> Pending
                                        </div>
                                    </div>

                                    <div class="schedule-item">
                                        <div class="schedule-number">2</div>
                                        <div class="schedule-content">
                                            <label class="schedule-label">Second 6m</label>
                                            <input type="date" id="secondDate" name="secondDate" class="form-control schedule-date" readonly>
                                        </div>
                                        <div class="schedule-status" id="secondStatus">
                                            <i class="fas fa-clock text-muted"></i> Auto-calculated
                                        </div>
                                    </div>

                                    <div class="schedule-item">
                                        <div class="schedule-number">3</div>
                                        <div class="schedule-content">
                                            <label class="schedule-label">Third 9m</label>
                                            <input type="date" id="thirdDate" name="thirdDate" class="form-control schedule-date" readonly>
                                        </div>
                                        <div class="schedule-status" id="thirdStatus">
                                            <i class="fas fa-clock text-muted"></i> Auto-calculated
                                        </div>
                                    </div>
                                </div>

                                <div class="confirm-button-container">
                                    <button type="submit" class="btn btn-confirm" id="confirmBtn" disabled>
                                        <i class="fas fa-check"></i> CONFIRM
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Right Panel - Calendar -->
                    <div class="reminder-right-panel">
                        <div class="calendar-section">
                            <h3 class="section-title">
                                <i class="fas fa-calendar"></i> Select Date
                            </h3>

                            <div class="calendar-header">
                                <button type="button" class="calendar-nav" id="prevMonth">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <div class="calendar-title" id="calendarTitle">April 2024</div>
                                <button type="button" class="calendar-nav" id="nextMonth">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>

                            <div class="calendar-grid">
                                <div class="calendar-weekdays">
                                    <div class="weekday">M</div>
                                    <div class="weekday">T</div>
                                    <div class="weekday">W</div>
                                    <div class="weekday">T</div>
                                    <div class="weekday">F</div>
                                    <div class="weekday">S</div>
                                    <div class="weekday">S</div>
                                </div>
                                <div class="calendar-days" id="calendarDays">
                                    <!-- Days will be generated by JavaScript -->
                                </div>
                            </div>

                            <div class="calendar-legend">
                                <div class="legend-item">
                                    <div class="legend-color available"></div>
                                    <span>Available</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color booked"></div>
                                    <span>Booked</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color weekend"></div>
                                    <span>Weekend</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color selected"></div>
                                    <span>Selected</span>
                                </div>
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
document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle
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

    // Patient selection and auto-fill
    const patientSelect = document.getElementById('patientSelect');
    const patientDetails = document.getElementById('patientDetails');
    const displayName = document.getElementById('displayName');
    const displayIC = document.getElementById('displayIC');
    const displayPhone = document.getElementById('displayPhone');
    const confirmBtn = document.getElementById('confirmBtn');

    patientSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (this.value) {
            displayName.textContent = selectedOption.dataset.patientname || this.value;
            displayIC.textContent = selectedOption.dataset.ic || '';
            displayPhone.textContent = selectedOption.dataset.tel || '';
            patientDetails.style.display = 'block';

            // Enable confirm button if dates are also selected
            checkFormValidity();
        } else {
            patientDetails.style.display = 'none';
            confirmBtn.disabled = true;
        }
    });

    // Date handling
    const firstDateInput = document.getElementById('firstDate');
    const secondDateInput = document.getElementById('secondDate');
    const thirdDateInput = document.getElementById('thirdDate');

    // Set minimum date to today
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${yyyy}-${mm}-${dd}`;
    firstDateInput.setAttribute('min', formattedToday);

    // Auto-calculate follow-up dates
    firstDateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);

        if (validateReminderDate(selectedDate)) {
            // Calculate 3 months later (6th month from start)
            const threeMonthsLater = new Date(selectedDate);
            threeMonthsLater.setMonth(threeMonthsLater.getMonth() + 3);

            // Calculate 6 months later (9th month from start)
            const sixMonthsLater = new Date(selectedDate);
            sixMonthsLater.setMonth(sixMonthsLater.getMonth() + 6);

            // Format dates
            secondDateInput.value = formatDateForInput(threeMonthsLater);
            thirdDateInput.value = formatDateForInput(sixMonthsLater);

            // Update calendar
            updateCalendarSelection(selectedDate);

            // Check availability for this date
            checkDateAvailability(this.value);

            checkFormValidity();
        } else {
            secondDateInput.value = '';
            thirdDateInput.value = '';
            confirmBtn.disabled = true;
        }
    });

    function validateReminderDate(selectedDate) {
        const dateError = document.getElementById('firstDateError');
        const dayOfWeek = selectedDate.getDay();
        let isValid = true;

        dateError.textContent = '';
        firstDateInput.classList.remove('is-invalid');

        // Check if date is in the past
        if (selectedDate < new Date(formattedToday)) {
            dateError.textContent = 'Cannot select a date in the past.';
            firstDateInput.classList.add('is-invalid');
            isValid = false;
        }

        // Check if it's a weekend
        if (dayOfWeek === 0 || dayOfWeek === 6) {
            dateError.textContent = 'Reminders can only be scheduled Monday to Friday.';
            firstDateInput.classList.add('is-invalid');
            isValid = false;
        }

        return isValid;
    }

    function checkDateAvailability(selectedDate) {
        // Check if date is already booked for reminders
        fetch(`/staff/reminder/check-availability/${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                const firstStatus = document.getElementById('firstStatus');

                if (data.available) {
                    firstStatus.innerHTML = '<i class="fas fa-check text-success"></i> Available';
                    firstStatus.className = 'schedule-status status-available';
                } else {
                    firstStatus.innerHTML = '<i class="fas fa-times text-danger"></i> Booked';
                    firstStatus.className = 'schedule-status status-booked';

                    const dateError = document.getElementById('firstDateError');
                    dateError.textContent = 'This date is already booked for another patient.';
                    firstDateInput.classList.add('is-invalid');
                    confirmBtn.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error checking availability:', error);
            });
    }

    function formatDateForInput(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function checkFormValidity() {
        const patientSelected = patientSelect.value !== '';
        const dateSelected = firstDateInput.value !== '';
        const dateValid = !firstDateInput.classList.contains('is-invalid');

        confirmBtn.disabled = !(patientSelected && dateSelected && dateValid);
    }

    // Calendar functionality
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    let selectedDate = null;
    let bookedDates = []; // Will be populated from server

    function initializeCalendar() {
        updateCalendarTitle();
        generateCalendarDays();
        fetchBookedDates();
    }

    function updateCalendarTitle() {
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        document.getElementById('calendarTitle').textContent = `${monthNames[currentMonth]} ${currentYear}`;
    }

    function generateCalendarDays() {
        const calendarDays = document.getElementById('calendarDays');
        calendarDays.innerHTML = '';

        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const startDate = new Date(firstDay);

        // Adjust to start on Monday
        const dayOfWeek = firstDay.getDay();
        const mondayOffset = dayOfWeek === 0 ? 6 : dayOfWeek - 1;
        startDate.setDate(startDate.getDate() - mondayOffset);

        // Generate 42 days (6 weeks)
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);

            const dayElement = createDayElement(date);
            calendarDays.appendChild(dayElement);
        }
    }

    function createDayElement(date) {
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        dayElement.textContent = date.getDate();

        const isCurrentMonth = date.getMonth() === currentMonth;
        const isWeekend = date.getDay() === 0 || date.getDay() === 6;
        const isPast = date < new Date(formattedToday);
        const dateString = formatDateForInput(date);
        const isBooked = bookedDates.includes(dateString);
        const isSelected = selectedDate && formatDateForInput(selectedDate) === dateString;

        if (!isCurrentMonth) {
            dayElement.classList.add('other-month');
        } else if (isPast) {
            dayElement.classList.add('past');
        } else if (isWeekend) {
            dayElement.classList.add('weekend');
        } else if (isBooked) {
            dayElement.classList.add('booked');
        } else {
            dayElement.classList.add('available');
            dayElement.addEventListener('click', () => selectDate(date));
        }

        if (isSelected) {
            dayElement.classList.add('selected');
        }

        return dayElement;
    }

    function selectDate(date) {
        selectedDate = date;
        firstDateInput.value = formatDateForInput(date);

        // Trigger change event to update follow-up dates
        firstDateInput.dispatchEvent(new Event('change'));

        // Regenerate calendar to show selection
        generateCalendarDays();
    }

    function updateCalendarSelection(date) {
        selectedDate = date;
        generateCalendarDays();
    }

    function fetchBookedDates() {
        fetch(`/staff/reminder/booked-dates/${currentYear}/${currentMonth + 1}`)
            .then(response => response.json())
            .then(data => {
                bookedDates = data.bookedDates || [];
                generateCalendarDays();
            })
            .catch(error => {
                console.error('Error fetching booked dates:', error);
            });
    }

    // Calendar navigation
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendarTitle();
        generateCalendarDays();
        fetchBookedDates();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendarTitle();
        generateCalendarDays();
        fetchBookedDates();
    });

    // Form validation before submit
    document.getElementById('reminderForm').addEventListener('submit', function(event) {
        let valid = true;

        if (!patientSelect.value) {
            valid = false;
            alert('Please select a patient.');
        }

        if (!firstDateInput.value) {
            valid = false;
            alert('Please select a first appointment date.');
        }

        if (firstDateInput.classList.contains('is-invalid')) {
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    // Success message fadeout
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.transition = 'opacity 1s ease';
            successMessage.style.opacity = '0';
        }, 5000);
    }

    // Initialize calendar
    initializeCalendar();
});
</script>

<style>
/* Reminder-specific styles */
.reminder-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    min-height: 60vh;
}

.reminder-left-panel,
.reminder-right-panel {
    background-color: var(--white);
    border-radius: 1rem;
    box-shadow: var(--box-shadow);
    padding: 2rem;
}

.reminder-section {
    margin-bottom: 3rem;
}

.reminder-section:last-child {
    margin-bottom: 0;
}

.section-title {
    font-size: 1.8rem;
    color: var(--blue);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--light-bg);
}

.section-title i {
    font-size: 2rem;
}

.patient-select {
    font-size: 1.5rem;
    padding: 1rem 1.5rem;
    border: 1px solid #ccc;
    border-radius: 0.5rem;
}

.patient-details-card {
    background-color: var(--light-bg);
    border-radius: 0.8rem;
    padding: 1.5rem;
    margin-top: 1.5rem;
    border-left: 4px solid var(--blue);
}

.patient-info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.patient-info-row:last-child {
    margin-bottom: 0;
}

.info-label {
    font-size: 1.4rem;
    color: var(--light-color);
    font-weight: 500;
}

.info-value {
    font-size: 1.5rem;
    color: var(--black);
    font-weight: 600;
}

.reminder-info {
    font-size: 1.4rem;
    margin-bottom: 2rem;
    background-color: #E3F2FD;
    border: 1px solid #2196F3;
    color: #1976D2;
}

.reminder-info i {
    margin-right: 0.8rem;
}

.schedule-list {
    margin-bottom: 2rem;
}

.schedule-item {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background-color: #f8f9fa;
    border-radius: 0.8rem;
    margin-bottom: 1rem;
    border-left: 4px solid var(--blue);
}

.schedule-item:last-child {
    margin-bottom: 0;
}

.schedule-number {
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    background-color: var(--blue);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    font-weight: bold;
    margin-right: 1.5rem;
    flex-shrink: 0;
}

.schedule-content {
    flex: 1;
    margin-right: 1.5rem;
}

.schedule-label {
    display: block;
    font-size: 1.4rem;
    color: var(--light-color);
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.schedule-date {
    font-size: 1.4rem;
    padding: 0.8rem 1rem;
    border: 1px solid #ccc;
    border-radius: 0.5rem;
    width: 100%;
}

.schedule-date:read-only {
    background-color: #f8f9fa;
    color: var(--light-color);
}

.schedule-status {
    font-size: 1.3rem;
    font-weight: 500;
    white-space: nowrap;
}

.status-available {
    color: #4bd28f;
}

.status-booked {
    color: #ff6b6b;
}

.confirm-button-container {
    text-align: center;
    margin-top: 2rem;
}

.btn-confirm {
    background-color: var(--blue);
    color: var(--white);
    padding: 1.2rem 3rem;
    font-size: 1.6rem;
    font-weight: bold;
    border-radius: 0.8rem;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 1rem;
}

.btn-confirm:hover:not(:disabled) {
    background-color: #6c6ce9;
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(125, 125, 235, 0.4);
}

.btn-confirm:disabled {
    background-color: #ccc;
    cursor: not-allowed;
    opacity: 0.6;
}

/* Calendar Styles */
.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.calendar-nav {
    width: 4rem;
    height: 4rem;
    border-radius: 50%;
    background-color: var(--blue);
    color: var(--white);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.calendar-nav:hover {
    background-color: #6c6ce9;
    transform: scale(1.1);
}

.calendar-title {
    font-size: 1.8rem;
    font-weight: bold;
    color: var(--black);
}

.calendar-grid {
    border-radius: 0.8rem;
    overflow: hidden;
    border: 1px solid var(--light-bg);
}

.calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background-color: var(--blue);
}

.weekday {
    padding: 1rem;
    text-align: center;
    font-size: 1.4rem;
    font-weight: bold;
    color: var(--white);
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background-color: var(--white);
}

.calendar-day {
    padding: 1rem;
    text-align: center;
    font-size: 1.4rem;
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 4.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid transparent;
}

.calendar-day:hover.available {
    background-color: rgba(125, 125, 235, 0.1);
    transform: scale(1.05);
}

.calendar-day.other-month {
    color: #ccc;
    background-color: #f8f9fa;
    cursor: not-allowed;
}

.calendar-day.past {
    color: #ccc;
    background-color: #f8f9fa;
    cursor: not-allowed;
}

.calendar-day.weekend {
    background-color: #ffe6e6;
    color: #ff6b6b;
    cursor: not-allowed;
}

.calendar-day.booked {
    background-color: #ffebee;
    color: #ff6b6b;
    cursor: not-allowed;
}

.calendar-day.available {
    background-color: #e8f5e8;
    color: #4bd28f;
    cursor: pointer;
}

.calendar-day.selected {
    background-color: var(--blue);
    color: var(--white);
    font-weight: bold;
    border: 2px solid #6c6ce9;
}

.calendar-legend {
    display: flex;
    justify-content: space-around;
    margin-top: 1.5rem;
    padding: 1rem;
    background-color: var(--light-bg);
    border-radius: 0.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.2rem;
}

.legend-color {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
}

.legend-color.available {
    background-color: #4bd28f;
}

.legend-color.booked {
    background-color: #ff6b6b;
}

.legend-color.weekend {
    background-color: #ffe6e6;
    border: 1px solid #ff6b6b;
}

.legend-color.selected {
    background-color: var(--blue);
}

/* Error message */
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

/* Success Message */
.success-message {
    background-color: #D4EDDA;
    color: #155724;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    font-size: 1.6rem;
    transition: opacity 1s ease;
}

.success-message i {
    margin-right: 0.8rem;
}

/* Responsive Design */
@media (max-width: 1199px) {
    .reminder-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .reminder-left-panel,
    .reminder-right-panel {
        padding: 1.5rem;
    }

    .schedule-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .schedule-number {
        margin-right: 0;
    }

    .schedule-content {
        margin-right: 0;
        width: 100%;
    }

    .calendar-legend {
        flex-direction: column;
        gap: 0.8rem;
    }

    .calendar-day {
        min-height: 3.5rem;
        font-size: 1.2rem;
    }
}
</style>

</body>
</html>