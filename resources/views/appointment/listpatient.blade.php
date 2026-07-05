<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Appointment List</title>

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
                <h3>Patient Dashboard</h3>
                <p>Welcome, <span>{{ Auth::user()->name }}</span></p>
            </div>

            <button id="sidebar-toggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <ul>
                    <li class="active">
                        <a href="{{ route('patient.indexpatient') }}">
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
                        <a href="">
                            <i class="fas fa-file-medical"></i>
                            <span>Medical Record</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{ route('patient.appointment.list') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>My Appointment</span>
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
                <h2>My Appointments</h2>
            </div>
            <div class="header-right">
                <div class="header-notifications">
                    <div class="notifications-icon">
                    <a href="{{ url('/patient/indexpatient') }}" class="link-btn">Home</a>
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

                <div class="appointment-controls">
                    <div class="appointment-filters">
                        <div class="filter-group">
                            <label for="statusFilter">Filter By Status:</label>
                            <select id="statusFilter" class="form-control">
                                <option value="all">All Appointments</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="dateFilter">Filter By Date:</label>
                            <select id="dateFilter" class="form-control">
                                <option value="all">All Dates</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="appointment-actions">
                        <a href="{{ route('patient.appointment.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> New Appointment
                        </a>
                    </div>
                </div>

                <div class="appointment-summary">
                    <div class="summary-card upcoming">
                        <div class="summary-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="summary-info">
                            <h3>{{ $upcomingAppointments ?? 0 }}</h3>
                            <p>Upcoming</p>
                        </div>
                    </div>
                    <div class="summary-card completed">
                        <div class="summary-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="summary-info">
                            <h3>{{ $completedAppointments ?? 0 }}</h3>
                            <p>Completed</p>
                        </div>
                    </div>
                    <div class="summary-card cancelled">
                        <div class="summary-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <div class="summary-info">
                            <h3>{{ $cancelledAppointments ?? 0 }}</h3>
                            <p>Cancelled</p>
                        </div>
                    </div>
                </div>

                <div class="appointment-list">
                    <div class="table-responsive">
                        <table class="table appointment-table">
                            <thead>
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Type of Amputee</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="appointmentTableBody">
                                @if(count($appointments) > 0)
                                    @foreach($appointments as $appointment)
                                    <tr data-status="{{ $appointment->status }}" data-date="{{ $appointment->appointmentDate }}">
                                        <td>APT-{{ str_pad($appointment->appID, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointmentDate)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointmentTime)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->appointmentTime)->addHours(2)->format('h:i A') }}</td>
                                        <td>{{ $appointment->typeAmputee }}</td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower($appointment->status) }}">
                                                {{ $appointment->status }}
                                            </span>
                                        </td>
                                        <td class="action-buttons">
                                            <!-- <a href="{{ route('patient.appointment.show', $appointment->appID) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a> -->

                                            @if($appointment->status == 'Pending' || $appointment->status == 'Confirmed')
                                                @if(\Carbon\Carbon::parse($appointment->appointmentDate)->greaterThan(now()))
                                                <!-- <a href="{{ route('patient.appointment.edit', $appointment->appID) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a> -->
                                                <button type="button" class="btn btn-sm btn-danger cancel-appointment" data-id="{{ $appointment->appID }}" data-toggle="tooltip" title="Cancel">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">No appointments found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $appointments->links() }}
                </div>

                <!-- Cancel Appointment Modal -->
                <div class="modal fade" id="cancelAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="cancelAppointmentModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelAppointmentModalLabel">Cancel Appointment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to cancel this appointment? This action cannot be undone.</p>
                                <form id="cancelAppointmentForm" action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    {{--
                                    <div class="form-group">
                                        <label for="cancelReason">Reason for Cancellation:</label>
                                        <textarea class="form-control" id="cancelReason" name="cancelReason" rows="3" required></textarea>
                                    </div>
                                    --}}
                                </form>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" id="confirmCancel">Cancel Appointment</button>
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

    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Handle status filter change
    $('#statusFilter').on('change', function() {
        filterAppointments();
    });

    // Handle date filter change
    $('#dateFilter').on('change', function() {
        filterAppointments();
    });

    function filterAppointments() {
        const statusFilter = $('#statusFilter').val();
        const dateFilter = $('#dateFilter').val();

        // Get all rows
        const rows = $('#appointmentTableBody tr');

        // Hide all rows first
        rows.hide();

        // Filter by status
        let filteredRows = rows;
        if (statusFilter !== 'all') {
            filteredRows = filteredRows.filter(function() {
                return $(this).data('status').toLowerCase() === statusFilter;
            });
        }

        // Filter by date
        if (dateFilter !== 'all') {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            filteredRows = filteredRows.filter(function() {
                const rowDate = new Date($(this).data('date'));

                if (dateFilter === 'today') {
                    return rowDate.toDateString() === today.toDateString();
                } else if (dateFilter === 'week') {
                    const weekStart = new Date(today);
                    weekStart.setDate(today.getDate() - today.getDay());
                    const weekEnd = new Date(weekStart);
                    weekEnd.setDate(weekStart.getDate() + 6);
                    return rowDate >= weekStart && rowDate <= weekEnd;
                } else if (dateFilter === 'month') {
                    return rowDate.getMonth() === today.getMonth() &&
                           rowDate.getFullYear() === today.getFullYear();
                }
                return true;
            });
        }

        // Show filtered rows
        filteredRows.show();

        // If no results, show message
        if (filteredRows.length === 0) {
            $('#appointmentTableBody').append(
                '<tr class="no-results"><td colspan="6" class="text-center">No appointments match your filters.</td></tr>'
            );
        } else {
            $('.no-results').remove();
        }
    }

    // Handle cancel appointment
    $('.cancel-appointment').on('click', function() {
        const appointmentId = $(this).data('id');
        $('#cancelAppointmentForm').attr('action', `/patient/appointment/${appointmentId}/cancel`);
        $('#cancelAppointmentModal').modal('show');
    });

    // Submit cancellation form
    $('#confirmCancel').on('click', function() {
        $('#cancelAppointmentForm').submit();
    });

    // Auto-hide success message
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
/* Additional styling for appointment list */
.appointment-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2.5rem;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.appointment-filters {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    min-width: 200px;
}

.filter-group label {
    font-size: 1.4rem;
    margin-bottom: 0.5rem;
    color: var(--black);
}

.appointment-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.summary-card {
    display: flex;
    align-items: center;
    padding: 2rem;
    border-radius: 0.8rem;
    background-color: var(--white);
    box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.summary-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

.summary-card.upcoming {
    border-left: 4px solid #4bd28f;
}

.summary-card.completed {
    border-left: 4px solid #7d7deb;
}

.summary-card.cancelled {
    border-left: 4px solid #ff6b6b;
}

.summary-icon {
    font-size: 2.5rem;
    width: 5rem;
    height: 5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-right: 1.5rem;
}

.summary-card.upcoming .summary-icon {
    color: #4bd28f;
    background-color: rgba(75, 210, 143, 0.1);
}

.summary-card.completed .summary-icon {
    color: #7d7deb;
    background-color: rgba(125, 125, 235, 0.1);
}

.summary-card.cancelled .summary-icon {
    color: #ff6b6b;
    background-color: rgba(255, 107, 107, 0.1);
}

.summary-info h3 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--black);
}

.summary-info p {
    font-size: 1.4rem;
    color: var(--light-color);
    margin: 0;
}

/* Appointment table specific styles */
.appointment-table {
    font-size: 1.5rem;
    border-collapse: separate;
    border-spacing: 0 1rem;
}

.appointment-table thead th {
    background-color: var(--light-bg);
    padding: 1.5rem;
    font-weight: 600;
    color: var(--black);
    border: none;
}

.appointment-table tbody tr {
    box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.05);
    background-color: var(--white);
    transition: transform 0.3s ease;
}

.appointment-table tbody tr:hover {
    transform: scale(1.01);
}

.appointment-table tbody td {
    padding: 1.5rem;
    vertical-align: middle;
    border-top: none;
}

.status-badge {
    padding: 0.6rem 1.2rem;
    border-radius: 50px;
    font-size: 1.3rem;
    font-weight: 500;
    display: inline-block;
    text-align: center;
}

.status-badge.status-pending {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.status-badge.status-confirmed {
    background-color: rgba(75, 210, 143, 0.1);
    color: #4bd28f;
}

.status-badge.status-completed {
    background-color: rgba(125, 125, 235, 0.1);
    color: #7d7deb;
}

.status-badge.status-cancelled {
    background-color: rgba(255, 107, 107, 0.1);
    color: #ff6b6b;
}

@media (max-width: 992px) {
    .appointment-controls {
        flex-direction: column;
        align-items: flex-start;
    }

    .appointment-filters {
        width: 100%;
        margin-bottom: 1.5rem;
    }

    .filter-group {
        flex: 1;
        min-width: 150px;
    }

    .appointment-actions {
        width: 100%;
    }

    .appointment-actions .btn {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .appointment-filters {
        flex-direction: column;
    }

    .filter-group {
        width: 100%;
    }

    .appointment-table thead {
        display: none;
    }

    .appointment-table tbody tr {
        display: block;
        margin-bottom: 1.5rem;
        border-radius: 0.8rem;
        overflow: hidden;
    }

    .appointment-table tbody td {
        display: block;
        text-align: right;
        position: relative;
        padding-left: 50%;
    }

    .appointment-table tbody td:before {
        content: attr(data-label);
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 600;
        text-align: left;
    }

    .action-buttons {
        justify-content: flex-end;
    }
}
</style>

</body>
</html>
