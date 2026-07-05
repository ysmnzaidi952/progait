<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Assessment List</title>

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
            <li class="active">
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
                <h2>Assessment Records</h2>
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
                <div class="assessment-header">
                    <div class="search-filter">
                        <div class="search-box-container">
                            <input type="text" id="searchInput" class="search-input" placeholder="Search by Patient Name...">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                    </div>

                    <div class="add-new">
                        <a href="{{ route('admin.assessment.create') }}" class="add-assessment-btn">
                            <i class="fas fa-plus"></i> New Assessment
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="assessment-table" id="assessmentTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Patient Name</th>
                                <th>Patient IC</th>
                                <th>Attended By</th>
                                <th>Prescribed By</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($assessments) > 0)
                                @foreach($assessments as $key => $assessment)
                                    <tr>
                                        <td data-label="No.">{{ $key + 1 }}</td>
                                        <td data-label="Patient Name">{{ $assessment->patient->patientName ?? 'N/A' }}</td>
                                        <td data-label="Patient IC">{{ $assessment->patient->patientIC ?? 'N/A' }}</td>
                                        <td data-label="Attended By">{{ $assessment->attendedBy ?? 'N/A' }}</td>
                                        <td data-label="Prescribed By">{{ $assessment->prescribedBy ?? 'N/A' }}</td>
                                        <td data-label="Date">{{ $assessment->created_at->format('d/m/Y') }}</td>
                                        <td data-label="Time">{{ $assessment->created_at->format('h:i A') }}</td>
                                        <td data-label="Action">
                                            <div class="assessment-actions">
                                                <a href="{{ route('admin.assessment.show', $assessment->formID) }}" class="action-btn view-btn" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.assessment.edit', $assessment->formID) }}" class="action-btn edit-btn" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.assessment.destroy', $assessment->formID) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this assessment record for {{ $assessment->patient->patientName ?? 'this patient' }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn delete-btn" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No assessment records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="pagination-container">
                    {{ $assessments->links() }}
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
        const table = document.getElementById('assessmentTable');

        if (searchInput && table) {
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const rows = table.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    if (row.cells.length > 1) {
                        const patientName = row.cells[1].textContent.toLowerCase();
                        const patientIC = row.cells[2].textContent.toLowerCase();
                        const attendedBy = row.cells[3].textContent.toLowerCase();
                        const prescribedBy = row.cells[4].textContent.toLowerCase();

                        if (patientName.includes(searchValue) || 
                            patientIC.includes(searchValue) || 
                            attendedBy.includes(searchValue) || 
                            prescribedBy.includes(searchValue)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            });
        }

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
    /* Additional styling specific to the assessment list */
    .assessment-header {
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

    .add-assessment-btn {
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

    .add-assessment-btn:hover {
        background-color: #6c6ce9;
        transform: translateY(-2px);
        color: var(--white);
        box-shadow: 0 4px 10px rgba(125, 125, 235, 0.3);
        text-decoration: none;
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

    .assessment-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .assessment-table thead th {
        background-color: var(--blue);
        color: var(--white);
        font-size: 1.5rem;
        padding: 1.5rem 1rem;
        font-weight: 500;
        text-align: center;
    }

    .assessment-table tbody td {
        font-size: 1.5rem;
        padding: 1.5rem 1rem;
        color: var(--light-color);
        border-bottom: 1px solid var(--light-bg);
        text-align: center;
        vertical-align: middle;
    }

    .assessment-table tbody tr:last-child td {
        border-bottom: none;
    }

    .assessment-table tbody tr:hover td {
        background-color: #f9f9f9;
    }

    .assessment-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .delete-form {
        margin: 0;
        padding: 0;
        display: inline;
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

    .action-btn.delete-btn {
        background-color: #ff6b6b;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .pagination-container {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
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

    @media (max-width: 991px) {
        .assessment-header {
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
        .assessment-table thead {
            display: none;
        }

        .assessment-table tbody tr {
            display: block;
            margin-bottom: 2rem;
            border: 1px solid var(--light-bg);
            border-radius: 0.5rem;
            padding: 1rem;
        }

        .assessment-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            text-align: right;
            border-bottom: 1px solid #f0f0f0;
        }

        .assessment-table tbody td:last-child {
            border-bottom: none;
        }

        .assessment-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--black);
            text-align: left;
        }

        .assessment-actions {
            justify-content: flex-end;
        }
    }
</style>

</body>
</html>