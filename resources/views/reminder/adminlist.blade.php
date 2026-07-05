<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Appointment Reminders List</title>

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
                    <h2>Appointment Reminders List</h2>
                </div>
                <div class="header-right">
                    <div class="header-notifications">
                        <div class="notifications-icon">
                            <a href="{{ url('/staff/indexadmin2') }}" class="link-btn">Home</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-content">
                <div class="content-container">
                    <div class="reminder-header">
                        <div class="search-filter">
                            <div class="search-box-container">
                                <input type="text" id="searchInput" class="search-input"
                                    placeholder="Search by Patient Name or IC...">
                                <i class="fas fa-search search-icon"></i>
                            </div>
                        </div>

                        <div class="add-new">
                            <a href="{{ route('admin.reminder.create') }}" class="add-reminder-btn">
                                <i class="fas fa-plus"></i> New Reminder
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="success-message">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="error-message">
                            <i class="fas fa-times-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <!-- Stats Cards -->
                    <div class="reminder-stats">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="stat-info">
                                <h3>Total Reminders</h3>
                                <h2>{{ $totalReminders ?? '0' }}</h2>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-info">
                                <h3>Pending Today</h3>
                                <h2>{{ $todayReminders ?? '0' }}</h2>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <h3>Completed</h3>
                                <h2>{{ $completedReminders ?? '0' }}</h2>
                            </div>
                        </div>

                    </div>

                    <!-- Filter Options -->
                    <div class="filter-options">
                        <select class="filter-select" id="statusFilter">
                            <option value="all">All Reminders</option>
                            <option value="pending">Pending</option>
                            <option value="sent">Sent</option>
                            <option value="completed">Completed</option>
                            <option value="overdue">Overdue</option>
                        </select>

                        <select class="filter-select" id="typeFilter">
                            <option value="all">All Types</option>
                            <option value="first">First (3m)</option>
                            <option value="second">Second (6m)</option>
                            <option value="third">Third (12m)</option>
                        </select>

                        <div class="date-filter">
                            <input type="date" id="dateFilter" class="date-input" placeholder="Filter by date">
                            <button class="filter-btn" id="clearFilters">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Reminders Table -->
                    <div class="table-responsive">
                        <table class="reminder-table" id="reminderTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Patient Information</th>
                                    <th>Reminder Schedule</th>
                                    <th>Status Overview</th>
                                    <th>Next Due</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($reminders) && $reminders->count() > 0)
                                    @foreach ($reminders as $key => $reminder)
                                        <tr class="reminder-row"
                                            data-patient="{{ strtolower($reminder->patient->patientName ?? '') }}"
                                            data-ic="{{ $reminder->patient->patientIC ?? '' }}">
                                            <td data-label="No.">{{ $key + 1 }}</td>
                                            <td data-label="Patient Information">
                                                <div class="patient-info">
                                                    <div class="patient-avatar">
                                                        @if ($reminder->patient)
                                                            {{ strtoupper(substr($reminder->patient->patientName, 0, 1)) }}{{ strtoupper(substr(explode(' ', $reminder->patient->patientName)[1] ?? $reminder->patient->patientName, 0, 1)) }}
                                                        @else
                                                            NA
                                                        @endif
                                                    </div>
                                                    <div class="patient-details">
                                                        <div class="patient-name">
                                                            {{ $reminder->patient->patientName ?? 'Unknown Patient' }}
                                                        </div>
                                                        <div class="patient-ic">IC:
                                                            {{ $reminder->patient->patientIC ?? 'N/A' }}</div>
                                                        <div class="patient-phone">
                                                            {{ $reminder->patient->patientTel ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Reminder Schedule">
                                                <div class="schedule-timeline">
                                                    <div class="timeline-item">
                                                        <span class="timeline-label">1st (3m)</span>
                                                        <span
                                                            class="timeline-date">{{ $reminder->firstDate ? date('d/m/Y', strtotime($reminder->firstDate)) : 'N/A' }}</span>
                                                    </div>
                                                    <div class="timeline-item">
                                                        <span class="timeline-label">2nd (6m)</span>
                                                        <span
                                                            class="timeline-date">{{ $reminder->secondDate ? date('d/m/Y', strtotime($reminder->secondDate)) : 'N/A' }}</span>
                                                    </div>
                                                    <div class="timeline-item">
                                                        <span class="timeline-label">3rd (9m)</span>
                                                        <span
                                                            class="timeline-date">{{ $reminder->thirdDate ? date('d/m/Y', strtotime($reminder->thirdDate)) : 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Status Overview">
                                                <div class="status-overview">
                                                    <div class="status-item">
                                                        @php
                                                            $firstStatus = $reminder->firstStatus ?? 'pending';
                                                        @endphp
                                                        <span class="status-badge status-{{ $firstStatus }}">
                                                            @if ($firstStatus == 'completed')
                                                                <i class="fas fa-check"></i>
                                                            @elseif($firstStatus == 'sent')
                                                                <i class="fas fa-paper-plane"></i>
                                                            @elseif($firstStatus == 'overdue')
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            @else
                                                                <i class="fas fa-clock"></i>
                                                            @endif
                                                            {{ ucfirst($firstStatus) }}
                                                        </span>
                                                    </div>
                                                    <div class="status-item">
                                                        @php
                                                            $secondStatus = $reminder->secondStatus ?? 'pending';
                                                        @endphp
                                                        <span class="status-badge status-{{ $secondStatus }}">
                                                            @if ($secondStatus == 'completed')
                                                                <i class="fas fa-check"></i>
                                                            @elseif($secondStatus == 'sent')
                                                                <i class="fas fa-paper-plane"></i>
                                                            @elseif($secondStatus == 'overdue')
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            @else
                                                                <i class="fas fa-clock"></i>
                                                            @endif
                                                            {{ ucfirst($secondStatus) }}
                                                        </span>
                                                    </div>
                                                    <div class="status-item">
                                                        @php
                                                            $thirdStatus = $reminder->thridStatus ?? 'pending';
                                                        @endphp
                                                        <span class="status-badge status-{{ $thirdStatus }}">
                                                            @if ($thirdStatus == 'completed')
                                                                <i class="fas fa-check"></i>
                                                            @elseif($thirdStatus == 'sent')
                                                                <i class="fas fa-paper-plane"></i>
                                                            @elseif($thirdStatus == 'overdue')
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            @else
                                                                <i class="fas fa-clock"></i>
                                                            @endif
                                                            {{ ucfirst($thirdStatus) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Next Due">
                                                @php
                                                    $today = date('Y-m-d');
                                                    $nextDue = null;
                                                    $nextType = '';
                                                    $nextStatus = '';

                                                    // Check first reminder
                                                    if (
                                                        ($reminder->firstStatus ?? 'pending') !== 'completed' &&
                                                        $reminder->firstDate
                                                    ) {
                                                        if ($reminder->firstDate >= $today || !$nextDue) {
                                                            $nextDue = $reminder->firstDate;
                                                            $nextType = '1st (3m)';
                                                            $nextStatus = $reminder->firstStatus ?? 'pending';
                                                        }
                                                    }

                                                    // Check second reminder if first is completed
                                                    if (
                                                        ($reminder->firstStatus ?? 'pending') === 'completed' &&
                                                        ($reminder->secondStatus ?? 'pending') !== 'completed' &&
                                                        $reminder->secondDate
                                                    ) {
                                                        $nextDue = $reminder->secondDate;
                                                        $nextType = '2nd (6m)';
                                                        $nextStatus = $reminder->secondStatus ?? 'pending';
                                                    }

                                                    // Check third reminder if second is completed
                                                    if (
                                                        ($reminder->secondStatus ?? 'pending') === 'completed' &&
                                                        ($reminder->thirdStatus ?? 'pending') !== 'completed' &&
                                                        $reminder->thirdDate
                                                    ) {
                                                        $nextDue = $reminder->thirdDate;
                                                        $nextType = '3rd (9m)';
                                                        $nextStatus = $reminder->thirdStatus ?? 'pending';
                                                    }
                                                @endphp

                                                @if ($nextDue)
                                                    <div class="next-due">
                                                        <div class="due-type">{{ $nextType }}</div>
                                                        <div class="due-date">{{ date('d/m/Y', strtotime($nextDue)) }}
                                                        </div>
                                                        @php
                                                            $daysLeft = ceil(
                                                                (strtotime($nextDue) - strtotime($today)) /
                                                                    (60 * 60 * 24),
                                                            );
                                                        @endphp
                                                        <div
                                                            class="due-countdown {{ $daysLeft < 0 ? 'urgent' : ($daysLeft <= 3 ? 'urgent' : ($daysLeft <= 7 ? 'warning' : 'normal')) }}">
                                                            @if ($daysLeft < 0)
                                                                {{ abs($daysLeft) }} days overdue
                                                            @elseif($daysLeft == 0)
                                                                Due today
                                                            @else
                                                                {{ $daysLeft }} days left
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="next-due">
                                                        <div class="due-type">All Complete</div>
                                                        <div class="due-date">-</div>
                                                        <div class="due-countdown normal">
                                                            <i class="fas fa-check-circle"></i> Finished
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td data-label="Action">
                                                <div class="reminder-actions">

                                                    <button type="button" class="action-btn send-btn"
                                                        title="Send Reminder"
                                                        onclick="sendReminder(
                                                            {{ $reminder->patient->patientID }},
                                                            '{{ $reminder->patient->patientName ?? 'Patient' }}',
                                                            '{{ $reminder->firstStatus }}',
                                                            '{{ $reminder->secondStatus }}',
                                                            '{{ $reminder->thirdStatus }}'
                                                        )">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>

                                                    <button type="button" class="action-btn delete-btn"
                                                        title="Delete Reminder" data-toggle="modal"
                                                        data-target="#deleteModal" data-id="{{ $reminder->remID }}"
                                                        data-name="{{ $reminder->patient->patientName ?? 'Unknown Patient' }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="empty-state">
                                                <i class="fas fa-bell-slash"></i>
                                                <h3>No Reminders Found</h3>
                                                <p>Create your first appointment reminder to get started.</p>
                                                <a href="{{ route('admin.reminder.create') }}"
                                                    class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus"></i> Create Reminder
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <!-- Main Content End -->
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Reminder</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Warning:</strong> This action cannot be undone.
                        </div>
                        <p>Are you sure you want to delete all reminders for <strong id="patientName"></strong>?</p>
                        <p class="text-muted">This will remove all scheduled reminders (1st, 2nd, and 3rd follow-ups)
                            for this patient.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Send Reminder Modal -->
    <div class="modal fade" id="sendReminderModal" tabindex="-1" role="dialog"
        aria-labelledby="sendReminderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="sendReminderForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendReminderModalLabel">Send Reminder</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Sending reminder to: <strong id="sendPatientName"></strong>
                        </div>
                        <div class="form-group">
                            <label for="reminderType">Select Reminder Type:</label>
                            <select class="form-control" id="reminderType" name="reminderType" required>
                                <option value="">Choose reminder...</option>
                                <option value="first">1st Reminder (3 months)</option>
                                <option value="second">2nd Reminder (6 months)</option>
                                <option value="third">3rd Reminder (9 months)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="reminderMessage">Message (Optional):</label>
                            <textarea class="form-control" id="reminderMessage" name="message" rows="3"
                                placeholder="Add a custom message to the reminder..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Reminder</button>
                    </div>
                </form>
            </div>
        </div>
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

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('reminderTable');

            if (searchInput && table) {
                searchInput.addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    const rows = table.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        if (row.querySelector('.empty-state')) {
                            return; // Skip empty state row
                        }

                        const patientName = row.dataset.patient || '';
                        const patientIC = row.dataset.ic || '';

                        if (patientName.includes(searchValue) || patientIC.includes(searchValue)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Filter by status
            const statusFilter = document.getElementById('statusFilter');
            if (statusFilter && table) {
                statusFilter.addEventListener('change', function() {
                    const filterValue = this.value.toLowerCase();
                    const rows = table.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        if (row.querySelector('.empty-state')) {
                            return; // Skip empty state row
                        }

                        if (filterValue === 'all') {
                            row.style.display = '';
                        } else {
                            const statusBadges = row.querySelectorAll('.status-badge');
                            let hasStatus = false;

                            statusBadges.forEach(badge => {
                                if (badge.classList.contains('status-' + filterValue)) {
                                    hasStatus = true;
                                }
                            });

                            row.style.display = hasStatus ? '' : 'none';
                        }
                    });
                });
            }

            // Filter by type
            const typeFilter = document.getElementById('typeFilter');
            if (typeFilter && table) {
                typeFilter.addEventListener('change', function() {
                    const filterValue = this.value.toLowerCase();
                    const rows = table.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        if (row.querySelector('.empty-state')) {
                            return; // Skip empty state row
                        }

                        if (filterValue === 'all') {
                            row.style.display = '';
                        } else {
                            const nextDueType = row.querySelector('.due-type');
                            if (nextDueType) {
                                const typeText = nextDueType.textContent.toLowerCase();
                                const isMatch = (filterValue === 'first' && typeText.includes(
                                        '1st')) ||
                                    (filterValue === 'second' && typeText.includes('2nd')) ||
                                    (filterValue === 'third' && typeText.includes('3rd'));

                                row.style.display = isMatch ? '' : 'none';
                            }
                        }
                    });
                });
            }

            // Date filter
            const dateFilter = document.getElementById('dateFilter');
            const clearFilters = document.getElementById('clearFilters');

            if (dateFilter && table) {
                dateFilter.addEventListener('change', function() {
                    const filterDate = this.value;
                    if (filterDate) {
                        const rows = table.querySelectorAll('tbody tr');

                        rows.forEach(row => {
                            if (row.querySelector('.empty-state')) {
                                return; // Skip empty state row
                            }

                            const timelineDates = row.querySelectorAll('.timeline-date');
                            let hasMatchingDate = false;

                            timelineDates.forEach(dateElement => {
                                const dateText = dateElement.textContent.trim();
                                if (dateText !== 'N/A') {
                                    const dateParts = dateText.split('/');
                                    const formattedDate =
                                        `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;

                                    if (formattedDate === filterDate) {
                                        hasMatchingDate = true;
                                    }
                                }
                            });

                            row.style.display = hasMatchingDate ? '' : 'none';
                        });
                    }
                });

                if (clearFilters) {
                    clearFilters.addEventListener('click', function() {
                        dateFilter.value = '';
                        statusFilter.value = 'all';
                        typeFilter.value = 'all';
                        searchInput.value = '';

                        const rows = table.querySelectorAll('tbody tr');
                        rows.forEach(row => {
                            row.style.display = '';
                        });
                    });
                }
            }

            // Delete modal handling
            $('#deleteModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const reminderId = button.data('id');
                const patientName = button.data('name');

                const modal = $(this);
                modal.find('#patientName').text(patientName);
                modal.find('#deleteForm').attr('action', `/admin/reminder/${reminderId}`);
            });

            // Success message fadeout
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.transition = 'opacity 1s ease';
                    successMessage.style.opacity = '0';
                }, 5000);
            }

            // Error message fadeout
            const errorMessage = document.querySelector('.error-message');
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.transition = 'opacity 1s ease';
                    errorMessage.style.opacity = '0';
                }, 5000);
            }
        });

        // Action functions
        function sendReminder(id, patientName, firstStatus, secondStatus, thirdStatus) {
            document.getElementById('sendPatientName').textContent = patientName;
            document.getElementById('sendReminderForm').action = `/admin/reminder/send/${id}`;

            const typeSelect = document.getElementById('reminderType');
            typeSelect.innerHTML = '<option value="">Choose reminder...</option>'; // Reset

            const statuses = {
                first: firstStatus,
                second: secondStatus,
                third: thirdStatus
            };

            if (statuses.first !== 'sent') {
                typeSelect.innerHTML += `<option value="first">1st Reminder (3 months)</option>`;
            }
            if (statuses.second !== 'sent') {
                typeSelect.innerHTML += `<option value="second">2nd Reminder (6 months)</option>`;
            }
            if (statuses.third !== 'sent') {
                typeSelect.innerHTML += `<option value="third">3rd Reminder (9 months)</option>`;
            }

            $('#sendReminderModal').modal('show');
        }
    </script>

    <style>
        /* Reminder List Specific Styles */
        .reminder-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .search-filter {
            flex: 1;
            max-width: 40rem;
        }

        .search-box-container {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1.2rem 4.5rem 1.2rem 1.5rem;
            font-size: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            color: var(--black);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 0.2rem rgba(125, 125, 235, 0.25);
            outline: none;
        }

        .search-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-color);
            font-size: 1.6rem;
        }

        .add-reminder-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            background-color: var(--blue);
            color: var(--white);
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .add-reminder-btn:hover {
            background-color: #6c6ce9;
            transform: translateY(-2px);
            color: var(--white);
            box-shadow: 0 4px 10px rgba(125, 125, 235, 0.3);
            text-decoration: none;
        }

        /* Stats Cards */
        .reminder-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background-color: var(--white);
            border-radius: 1rem;
            padding: 2rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 6rem;
            height: 6rem;
            border-radius: 1.2rem;
            background-color: rgba(125, 125, 235, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 2rem;
        }

        .stat-icon i {
            font-size: 2.8rem;
            color: var(--blue);
        }

        .stat-info h3 {
            font-size: 1.5rem;
            color: var(--light-color);
            margin-bottom: 0.5rem;
        }

        .stat-info h2 {
            font-size: 3rem;
            color: var(--black);
            font-weight: 600;
            margin: 0;
        }

        /* Filter Options */
        .filter-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .filter-select {
            padding: 1rem 1.5rem;
            font-size: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            color: var(--black);
            background-color: var(--white);
            min-width: 18rem;
        }

        .date-filter {
            display: flex;
            align-items: center;
        }

        .date-input {
            padding: 1rem 1.5rem;
            font-size: 1.5rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem 0 0 0.5rem;
            color: var(--black);
        }

        .filter-btn {
            background-color: var(--light-bg);
            border: 1px solid #ccc;
            border-left: none;
            padding: 1rem 1.5rem;
            border-radius: 0 0.5rem 0.5rem 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            background-color: #e0e0e0;
        }

        /* Reminder Table */
        .reminder-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .reminder-table thead th {
            background-color: var(--blue);
            color: var(--white);
            font-size: 1.5rem;
            padding: 1.5rem 1rem;
            font-weight: 500;
            text-align: center;
        }

        .reminder-table tbody td {
            font-size: 1.4rem;
            padding: 1.5rem 1rem;
            color: var(--light-color);
            border-bottom: 1px solid var(--light-bg);
            text-align: center;
            vertical-align: middle;
        }

        .reminder-table tbody tr:last-child td {
            border-bottom: none;
        }

        .reminder-table tbody tr:hover td {
            background-color: #f9f9f9;
        }

        /* Patient Information */
        .patient-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            text-align: left;
        }

        .patient-avatar {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 50%;
            background-color: var(--blue);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            font-weight: bold;
            flex-shrink: 0;
        }

        .patient-details {
            flex: 1;
        }

        .patient-name {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--black);
            margin-bottom: 0.3rem;
        }

        .patient-ic {
            font-size: 1.3rem;
            color: var(--light-color);
            margin-bottom: 0.2rem;
        }

        .patient-phone {
            font-size: 1.3rem;
            color: var(--light-color);
        }

        /* Schedule Timeline */
        .schedule-timeline {
            text-align: left;
        }

        .timeline-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            margin-bottom: 0.5rem;
            border-bottom: 1px dashed #e0e0e0;
        }

        .timeline-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .timeline-label {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--blue);
            min-width: 6rem;
        }

        .timeline-date {
            font-size: 1.4rem;
            color: var(--black);
        }

        /* Status Overview */
        .status-overview {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }

        .status-item {
            width: 100%;
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 1.5rem;
            font-size: 1.2rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 10rem;
            justify-content: center;
        }

        .status-pending {
            background-color: rgba(255, 171, 0, 0.1);
            color: #ffab00;
        }

        .status-sent {
            background-color: rgba(38, 198, 218, 0.1);
            color: #26c6da;
        }

        .status-completed {
            background-color: rgba(75, 210, 143, 0.1);
            color: #4bd28f;
        }

        .status-overdue {
            background-color: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
        }

        /* Next Due */
        .next-due {
            text-align: center;
        }

        .due-type {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--blue);
            margin-bottom: 0.3rem;
        }

        .due-date {
            font-size: 1.5rem;
            color: var(--black);
            margin-bottom: 0.3rem;
        }

        .due-countdown {
            font-size: 1.2rem;
            font-weight: 500;
            padding: 0.3rem 0.8rem;
            border-radius: 1rem;
        }

        .due-countdown.normal {
            background-color: rgba(75, 210, 143, 0.1);
            color: #4bd28f;
        }

        .due-countdown.warning {
            background-color: rgba(255, 171, 0, 0.1);
            color: #ffab00;
        }

        .due-countdown.urgent {
            background-color: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
        }

        /* Action Buttons */
        .reminder-actions {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .action-btn {
            width: 3rem;
            height: 3rem;
            border-radius: 0.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .action-btn.view-btn {
            background-color: #26c6da;
        }

        .action-btn.edit-btn {
            background-color: #ffab00;
        }

        .action-btn.send-btn {
            background-color: var(--blue);
        }

        .action-btn.delete-btn {
            background-color: #ff6b6b;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: var(--white);
            text-decoration: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
        }

        .empty-state i {
            font-size: 6rem;
            color: var(--light-color);
            opacity: 0.5;
            margin-bottom: 2rem;
        }

        .empty-state h3 {
            font-size: 2.4rem;
            color: var(--black);
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 1.6rem;
            color: var(--light-color);
            margin-bottom: 2.5rem;
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

        /* Error Message */
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
        }

        .modal-body {
            padding: 2rem;
            font-size: 1.6rem;
            color: var(--black);
        }

        .modal-body .form-group label {
            font-size: 1.5rem;
            color: var(--black);
            font-weight: 500;
            margin-bottom: 0.8rem;
        }

        /* Fixed Dropdown Styling */
        .form-control {
            font-size: 1.5rem;
            padding: 1.2rem 1.5rem;
            border: 2px solid #e0e0e0;
            border-radius: 0.8rem;
            color: var(--black);
            background-color: var(--white);
            transition: all 0.3s ease;
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        /* Custom dropdown arrow */
        .form-group select.form-control {
            background-image: url("data:image/svg+xml;utf8,<svg fill='%23666' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
            background-repeat: no-repeat;
            background-position: right 1.5rem center;
            background-size: 2rem;
            padding-right: 4rem;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 0.3rem rgba(125, 125, 235, 0.25);
            outline: none;
        }

        .form-control:hover {
            border-color: var(--blue);
        }

        .modal-footer {
            border-top: none;
            padding: 1.5rem 2rem 2rem;
        }

        .modal-footer .btn {
            padding: 1rem 2rem;
            font-size: 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-secondary {
            background-color: var(--light-bg);
            color: var(--black);
            border: none;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
        }

        .btn-danger {
            background-color: #ff6b6b;
            color: var(--white);
            border: none;
        }

        .btn-danger:hover {
            background-color: #e05c5c;
        }

        .btn-primary {
            background-color: var(--blue);
            color: var(--white);
            border: none;
        }

        .btn-primary:hover {
            background-color: #6c6ce9;
        }

        /* Responsive Design */
        @media (max-width: 1199px) {
            .reminder-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-options {
                flex-direction: column;
                width: 100%;
            }

            .filter-select,
            .date-filter {
                width: 100%;
            }
        }

        @media (max-width: 991px) {
            .reminder-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }

            .search-filter {
                width: 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .reminder-stats {
                grid-template-columns: 1fr;
            }

            .reminder-table thead {
                display: none;
            }

            .reminder-table tbody tr {
                display: block;
                margin-bottom: 2rem;
                border: 1px solid var(--light-bg);
                border-radius: 0.5rem;
                padding: 1rem;
                background-color: var(--white);
            }

            .reminder-table tbody td {
                display: block;
                text-align: left;
                padding: 1rem 0;
                border-bottom: 1px solid #f0f0f0;
            }

            .reminder-table tbody td:last-child {
                border-bottom: none;
            }

            .reminder-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--blue);
                display: block;
                margin-bottom: 0.5rem;
            }

            .patient-info,
            .schedule-timeline,
            .status-overview,
            .next-due,
            .reminder-actions {
                justify-content: flex-start;
                text-align: left;
            }

            .reminder-actions {
                gap: 1rem;
            }

            .action-btn {
                width: 3.5rem;
                height: 3.5rem;
            }
        }

        @media (max-width: 576px) {
            .stat-card {
                flex-direction: column;
                text-align: center;
            }

            .stat-icon {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }

                /* Your existing action button styles */
        .action-btn {
            width: 4rem;
            height: 4rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1.6rem;
            position: relative;
            overflow: hidden;
        }

        /* Add the send-btn styling */
        .action-btn.send-btn {
            background: linear-gradient(135deg, #7d7deb, #9191ef);
            box-shadow: 0 4px 12px rgba(125, 125, 235, 0.3);
            color: #ffffff; /* Explicitly set icon color to white */
        }

        .action-btn.send-btn i {
            color: #ffffff; /* Ensure icon is white */
        }

        .action-btn.send-btn:hover {
            background: linear-gradient(135deg, #6c6ce9, #8080ed);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 20px rgba(125, 125, 235, 0.4);
        }

        .action-btn.send-btn:hover i {
            color: #ffffff; /* Keep icon white on hover */
        }
    </style>

</body>

</html>
