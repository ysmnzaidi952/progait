
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Appointments List</title>

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
                <h2>Appointments List</h2>
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
                <div class="appointment-header">
                    <div class="search-filter">
                        <div class="search-box-container">
                            <input type="text" id="searchInput" class="search-input" placeholder="Search by Name or IC...">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                    </div>

                    <div class="add-new">
                        <a href="{{ route('admin.appointment.create') }}" class="add-appointment-btn">
                            <i class="fas fa-plus"></i> New Appointment
                        </a>
                    </div>

                </div>

                @if(session('success'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="appointment-stats">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Appointments</h3>
                            <h2>{{ $totalAppointments ?? '0' }}</h2>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Upcoming Today</h3>
                            <h2>{{ $todayAppointments ?? '0' }}</h2>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Upcoming This Week</h3>
                            <h2>{{ $weekAppointments ?? '0' }}</h2>
                        </div>
                    </div>
                </div>

                <div class="filter-options">
                    <select class="filter-select" id="statusFilter">
                        <option value="all">All Appointments</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>

                    <div class="date-filter">
                        <input type="date" id="dateFilter" class="date-input">
                        <button class="filter-btn" id="clearDateFilter">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="appointment-table" id="appointmentTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Patient IC</th>
                                <th>Telephone</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($appointments) && count($appointments) > 0)
                                @foreach($appointments as $key => $appointment)
                                    <tr>
                                        <td data-label="No.">{{ $key + 1 }}</td>
                                        <td data-label="Patient Name">{{ $appointment->patient->patientName ?? '-' }}</td>
                                        <td data-label="Patient IC">{{ $appointment->patient->patientIC ?? '-' }}</td>
                                        <td data-label="Telephone">{{ $appointment->patient->patientTel ?? '-' }}</td>
                                        <td data-label="Appointment Date">{{ date('d/m/Y', strtotime($appointment->appointmentDate)) }}</td>
                                        <td data-label="Appointment Time">{{ date('h:i A', strtotime($appointment->appointmentTime)) }}</td>
                                        <td data-label="Status">
                                            @php
                                                $status = $appointment->status ?? 'upcoming';
                                                $statusClass = 'status-upcoming';

                                                if($status == 'completed') {
                                                    $statusClass = 'status-completed';
                                                } else if($status == 'cancelled') {
                                                    $statusClass = 'status-cancelled';
                                                }
                                            @endphp
                                            <span class="status-badge {{ $statusClass }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td data-label="Action">
                                            <div class="appointment-actions">
                                                <a href="{{ route('admin.appointment.show', $appointment->appID) }}" class="action-btn view-btn" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($appointment->status != 'cancelled')
                                                    <a href="{{ route('admin.appointment.edit', $appointment->appID) }}" class="action-btn edit-btn" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @else
                                                    <button class="action-btn edit-btn" title="Edit Unavailable" style="opacity: 0.5; cursor: not-allowed;" disabled>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
                                                @if($appointment->status != 'cancelled')
                                                    <button type="button" class="action-btn cancel-btn" title="Cancel Appointment"
                                                            data-toggle="modal"
                                                            data-target="#cancelModal"
                                                            data-id="{{ $appointment->appID }}"
                                                            data-name="{{ $appointment->patientName }}">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="action-btn cancel-btn" title="Already Cancelled"
                                                            style="opacity: 0.5; cursor: not-allowed;" disabled>
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No appointments found</td>
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

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="cancelForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="cancelModalLabel">Cancel Appointment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to cancel the appointment for <strong id="patientName"></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes, Cancel</button>
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
        const table = document.getElementById('appointmentTable');

        if (searchInput && table) {
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const rows = table.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const patientName = row.cells[1].textContent.toLowerCase();
                    const patientIC = row.cells[2].textContent.toLowerCase();

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
                    if (filterValue === 'all') {
                        row.style.display = '';
                    } else {
                        const statusCell = row.querySelector('td[data-label="Status"] .status-badge');
                        if (statusCell) {
                            const status = statusCell.textContent.trim().toLowerCase();
                            row.style.display = status === filterValue ? '' : 'none';
                        }
                    }
                });
            });
        }

        // Date filter
        const dateFilter = document.getElementById('dateFilter');
        const clearDateFilter = document.getElementById('clearDateFilter');

        if (dateFilter && table) {
            dateFilter.addEventListener('change', function() {
                const filterDate = this.value;
                if (filterDate) {
                    const rows = table.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const dateCell = row.querySelector('td[data-label="Appointment Date"]');
                        if (dateCell) {
                            // Convert display date format (dd/mm/yyyy) to yyyy-mm-dd for comparison
                            const dateParts = dateCell.textContent.trim().split('/');
                            const formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;

                            row.style.display = formattedDate === filterDate ? '' : 'none';
                        }
                    });
                }
            });

            if (clearDateFilter) {
                clearDateFilter.addEventListener('click', function() {
                    dateFilter.value = '';
                    const rows = table.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        row.style.display = '';
                    });

                    // Reset status filter as well
                    if (statusFilter) {
                        statusFilter.value = 'all';
                    }
                });
            }
        }

        // Cancel modal handling
        $('#cancelModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const appointmentId = button.data('id');
            const patientName = button.data('name');

            const modal = $(this);
            modal.find('#patientName').text(patientName);
            modal.find('#cancelForm').attr('action', `/admin/appointment/${appointmentId}/cancel`);
        });


        // Success message fadeout
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.transition = 'opacity 1s ease';
                successMessage.style.opacity = '0';
            }, 5000);
        }
    });
</script>

<style>
    /* Additional styling specific to the appointments list */
    .appointment-header {
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

    .add-appointment-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        background-color: var(--blue);
        color: var(--white);
        padding: 1rem 2rem;
        border-radius: 0.5rem;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .add-appointment-btn:hover {
        background-color: #6c6ce9;
        transform: translateY(-2px);
        color: var(--white);
        box-shadow: 0 4px 10px rgba(125, 125, 235, 0.3);
        text-decoration: none;
    }

    .appointment-stats {
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
        min-width: 20rem;
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

    .appointment-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .appointment-table thead th {
        background-color: var(--blue);
        color: var(--white);
        font-size: 1.5rem;
        padding: 1.5rem 1rem;
        font-weight: 500;
        text-align: center;
    }

    .appointment-table tbody td {
        font-size: 1.5rem;
        padding: 1.5rem 1rem;
        color: var(--light-color);
        border-bottom: 1px solid var(--light-bg);
        text-align: center;
        vertical-align: middle;
    }

    .appointment-table tbody tr:last-child td {
        border-bottom: none;
    }

    .appointment-table tbody tr:hover td {
        background-color: #f9f9f9;
    }

    .status-badge {
        padding: 0.6rem 1.2rem;
        border-radius: 2rem;
        font-size: 1.3rem;
        font-weight: 500;
        display: inline-block;
    }

    .status-upcoming {
        background-color: rgba(125, 125, 235, 0.1);
        color: var(--blue);
    }

    .status-completed {
        background-color: rgba(75, 210, 143, 0.1);
        color: #4bd28f;
    }

    .status-cancelled {
        background-color: rgba(255, 107, 107, 0.1);
        color: #ff6b6b;
    }

    .appointment-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .action-btn {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .action-btn.view-btn {
        background-color: #26c6da;
    }

    .action-btn.edit-btn {
        background-color: #ffab00;
    }

    .action-btn.cancel-btn {
        background-color: #ff6b6b;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }


    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        margin: 0 0.5rem;
    }

    .pagination .page-link {
        border-radius: 0.5rem;
        color: var(--blue);
        font-size: 1.4rem;
        padding: 0.8rem 1.5rem;
        transition: all 0.3s ease;
    }

    .pagination .active .page-link {
        background-color: var(--blue);
        border-color: var(--blue);
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
    }

    .modal-body {
        padding: 2rem;
        font-size: 1.6rem;
        color: var(--black);
    }

    .modal-body p {
        margin-bottom: 2rem;
    }

    .modal-body .form-group label {
        font-size: 1.5rem;
        color: var(--black);
        font-weight: 500;
        margin-bottom: 0.8rem;
    }

    .modal-body .form-control {
        font-size: 1.5rem;
        padding: 1rem 1.2rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        color: var(--black);
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

    @media (max-width: 991px) {
        .appointment-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.5rem;
        }

        .search-filter {
            width: 100%;
            max-width: 100%;
        }

        .filter-options {
            flex-direction: column;
            width: 100%;
        }

        .filter-select,
        .date-filter {
            width: 100%;
        }

        .date-input {
            flex: 1;
        }
    }

    @media (max-width: 768px) {
        .appointment-table thead {
            display: none;
        }

        .appointment-table tbody tr {
            display: block;
            margin-bottom: 2rem;
            border: 1px solid var(--light-bg);
            border-radius: 0.5rem;
            padding: 1rem;
        }

        .appointment-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            text-align: right;
            border-bottom: 1px solid #f0f0f0;
        }

        .appointment-table tbody td:last-child {
            border-bottom: none;
        }

        .appointment-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--black);
            text-align: left;
        }

        .appointment-actions {
            justify-content: flex-end;
        }
    }
</style>

</body>
</html>
