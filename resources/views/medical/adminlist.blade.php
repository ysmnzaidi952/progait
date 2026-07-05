<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Medical Records</title>

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
                    <i class="fas fa-file-medical"></i>
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
                    <h2>Medical Records Management</h2>
                </div>
                <div class="header-right">
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Search medical records..." autocomplete="off">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="header-notifications">
                        <div class="notifications-icon">
                            <a href="{{ route('admin.medical.create') }}" class="add-medical-btn">
                                <i class="fas fa-plus"></i> New Medical Record
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-content">
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

                <!-- Medical Records Table Container -->
                <div class="medical-table-container">
                    <div class="table-header">
                        <h3>
                            <i class="fas fa-file-medical"></i> Medical Records
                            <span class="record-count">({{ isset($medicalRecords) ? count($medicalRecords) : '0' }} records)</span>
                        </h3>
                        <div class="table-actions">
                            <div class="filter-dropdown">
                                <select id="statusFilter" class="filter-select">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="In Treatment">In Treatment</option>
                                    <option value="Recovered">Recovered</option>
                                    <option value="Follow-up">Follow-up</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="filter-dropdown">
                                <select id="amputationFilter" class="filter-select">
                                    <option value="">All Amputation Levels</option>
                                    <option value="Below Knee">Below Knee</option>
                                    <option value="Above Knee">Above Knee</option>
                                    <option value="Transradial">Transradial</option>
                                    <option value="Transhumeral">Transhumeral</option>
                                    <option value="Hip Disarticulation">Hip Disarticulation</option>
                                    <option value="Bilateral">Bilateral</option>
                                </select>
                            </div>
                            <div class="filter-dropdown">
                                <select id="kLevelFilter" class="filter-select">
                                    <option value="">All K-Levels</option>
                                    <option value="K0">K0 - No ability</option>
                                    <option value="K1">K1 - Household</option>
                                    <option value="K2">K2 - Limited community</option>
                                    <option value="K3">K3 - Community</option>
                                    <option value="K4">K4 - Active/Athlete</option>
                                </select>
                            </div>
                            <button class="refresh-btn" onclick="refreshTable()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        @if(isset($medicalRecords) && count($medicalRecords) > 0)
                            <table class="medical-table" id="medicalTable">
                                <thead>
                                    <tr>
                                        <th>Record ID</th>
                                        <th>Patient Info</th>
                                        <th>Status</th>
                                        <th>Amputation Details</th>
                                        <th>Health Assessment</th>
                                        <th>K-Level & BLART</th>
                                        <th>Last Updated</th>
                                        <th>Doctor</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicalRecords as $record)
                                    <tr data-status="{{ $record->status }}"
                                        data-amputation="{{ $record->amputation_level }}"
                                        data-klevel="{{ $record->k_level }}">
                                        <td data-label="Record ID">
                                            <span class="record-id">MR{{ str_pad($record->medID, 4, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td data-label="Patient Info">
                                            <div class="patient-info">
                                                <div class="patient-avatar">
                                                    {{ $record->patient ? substr($record->patient->patientName, 0, 1) : 'P' }}
                                                </div>
                                                <div class="patient-details">
                                                    <strong>{{ $record->patient->patientName ?? 'N/A' }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $record->patient->patientIC ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Status">
                                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $record->status)) }}">
                                                {{ $record->status }}
                                            </span>
                                        </td>
                                        <td data-label="Amputation Details">
                                            <div class="amputation-info">
                                                <strong>{{ $record->amputation_level ?? 'N/A' }}</strong>
                                                @if($record->amputation_date)
                                                <br>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($record->amputation_date)->format('M d, Y') }}
                                                </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="Health Assessment">
                                            <div class="health-assessment">
                                                @if($record->weight_kg || $record->height_cm || $record->bmi)
                                                <div class="vitals-info">
                                                    @if($record->weight_kg)
                                                    <small><strong>Weight:</strong> {{ $record->weight_kg }}kg</small><br>
                                                    @endif
                                                    @if($record->height_cm)
                                                    <small><strong>Height:</strong> {{ $record->height_cm }}cm</small><br>
                                                    @endif
                                                    @if($record->bmi)
                                                    <small><strong>BMI:</strong> {{ number_format($record->bmi, 1) }}</small>
                                                    @endif
                                                </div>
                                                @endif
                                                @if($record->health_condition)
                                                <div class="health-condition">
                                                    <span class="health-indicator health-{{ strtolower($record->health_condition) }}">
                                                        <i class="fas fa-heartbeat"></i>
                                                        {{ $record->health_condition }}
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="K-Level & BLART">
                                            <div class="assessment-scores">
                                                @if($record->k_level)
                                                <div class="k-level">
                                                    <span class="k-level-badge k-level-{{ strtolower($record->k_level) }}">
                                                        {{ $record->k_level }}
                                                    </span>
                                                </div>
                                                @endif
                                                @if($record->blart_score)
                                                <div class="blart-score">
                                                    <span class="blart-number">{{ $record->blart_score }}</span>
                                                    <span class="blart-category 
                                                        @if($record->blart_score <= 25) blart-limited
                                                        @elseif($record->blart_score <= 45) blart-functional
                                                        @else blart-advanced
                                                        @endif">
                                                        @if($record->blart_score <= 25) Limited
                                                        @elseif($record->blart_score <= 45) Functional
                                                        @else Advanced
                                                        @endif
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="Last Updated">
                                            <span class="update-date">{{ \Carbon\Carbon::parse($record->updated_at)->format('M d, Y') }}</span>
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($record->updated_at)->format('g:i A') }}</small>
                                        </td>
                                        <td data-label="Doctor">
                                            <span class="doctor-name">{{ $record->assigned_doctor ?? 'Unassigned' }}</span>
                                        </td>
                                        <td data-label="Actions">
                                            <div class="medical-actions">
                                                <a href="{{ route('admin.medical.view', $record->medID) }}" class="action-btn view-btn" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.medical.edit', $record->medID) }}" class="action-btn edit-btn" title="Edit Record">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="action-btn delete-btn" onclick="deleteRecord({{ $record->medID }})" title="Delete Record">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <!-- Empty State -->
                            <div class="empty-state">
                                <i class="fas fa-file-medical-alt"></i>
                                <h3>No Medical Records Found</h3>
                                <p>There are currently no medical records in the system. Create your first medical record to get started.</p>
                                <a href="{{ route('admin.medical.create') }}" class="add-medical-btn">
                                    <i class="fas fa-plus"></i> Create First Medical Record
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
        <!-- Main Content End -->
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this medical record? This action cannot be undone.</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning:</strong> Deleting this medical record will permanently remove all associated medical data.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS files -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

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

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const medicalTable = document.getElementById('medicalTable');

            if (searchInput && medicalTable) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = medicalTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                    Array.from(rows).forEach(row => {
                        const patientName = row.querySelector('.patient-details strong')?.textContent.toLowerCase() || '';
                        const patientIC = row.querySelector('.patient-details small')?.textContent.toLowerCase() || '';
                        const recordId = row.querySelector('.record-id')?.textContent.toLowerCase() || '';
                        const doctor = row.querySelector('.doctor-name')?.textContent.toLowerCase() || '';

                        const matches = patientName.includes(searchTerm) ||
                                      patientIC.includes(searchTerm) ||
                                      recordId.includes(searchTerm) ||
                                      doctor.includes(searchTerm);

                        row.style.display = matches ? '' : 'none';
                    });

                    updateRecordCount();
                });
            }

            // Filter functionality
            const statusFilter = document.getElementById('statusFilter');
            const amputationFilter = document.getElementById('amputationFilter');
            const kLevelFilter = document.getElementById('kLevelFilter');

            [statusFilter, amputationFilter, kLevelFilter].forEach(filter => {
                if (filter) {
                    filter.addEventListener('change', applyFilters);
                }
            });

            function applyFilters() {
                const statusValue = statusFilter?.value || '';
                const amputationValue = amputationFilter?.value || '';
                const kLevelValue = kLevelFilter?.value || '';
                const rows = medicalTable?.getElementsByTagName('tbody')[0].getElementsByTagName('tr') || [];

                Array.from(rows).forEach(row => {
                    const rowStatus = row.getAttribute('data-status') || '';
                    const rowAmputation = row.getAttribute('data-amputation') || '';
                    const rowKLevel = row.getAttribute('data-klevel') || '';

                    const statusMatch = !statusValue || rowStatus === statusValue;
                    const amputationMatch = !amputationValue || rowAmputation === amputationValue;
                    const kLevelMatch = !kLevelValue || rowKLevel === kLevelValue;

                    row.style.display = statusMatch && amputationMatch && kLevelMatch ? '' : 'none';
                });

                updateRecordCount();
            }

            function updateRecordCount() {
                const visibleRows = Array.from(medicalTable?.getElementsByTagName('tbody')[0].getElementsByTagName('tr') || [])
                    .filter(row => row.style.display !== 'none');

                const countElement = document.querySelector('.record-count');
                if (countElement) {
                    countElement.textContent = `(${visibleRows.length} records)`;
                }
            }

            // Auto-hide success/error messages
            const successMessage = document.querySelector('.success-message');
            const errorMessage = document.querySelector('.patient-error-message');

            [successMessage, errorMessage].forEach(message => {
                if (message && message.style.display !== 'none') {
                    setTimeout(() => {
                        message.style.transition = 'opacity 1s ease';
                        message.style.opacity = '0';
                        setTimeout(() => {
                            message.remove();
                        }, 1000);
                    }, 5000);
                }
            });
        });

        // Global functions
        function deleteRecord(recordId) {
            // Set the form action for deletion
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `{{ route('admin.medical.delete', '') }}/${recordId}`;
            $('#deleteModal').modal('show');
        }

        function refreshTable() {
            // Reset all filters
            document.getElementById('statusFilter').value = '';
            document.getElementById('amputationFilter').value = '';
            document.getElementById('kLevelFilter').value = '';
            document.getElementById('searchInput').value = '';

            // Show all rows
            const rows = document.querySelectorAll('#medicalTable tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });

            // Update count
            const countElement = document.querySelector('.record-count');
            if (countElement) {
                countElement.textContent = `(${rows.length} records)`;
            }

            // Refresh icon animation
            const refreshIcon = document.querySelector('.refresh-btn i');
            refreshIcon.style.animation = 'spin 1s linear';
            setTimeout(() => {
                refreshIcon.style.animation = '';
            }, 1000);

            // Show success message
            const successMsg = document.querySelector('.success-message');
            if (successMsg) {
                successMsg.innerHTML = '<i class="fas fa-sync-alt"></i> Table refreshed successfully!';
                successMsg.style.display = 'flex';
                successMsg.style.opacity = '1';
            }
        }
    </script>

    <style>
        /* Medical Records Table Styles */
        :root{
            --blue: #7d7deb;
            --black: #333;
            --white: #fff;
            --light-color: #666;
            --light-bg: #eee;
            --border: .2rem solid rgba(0,0,0,.1);
            --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
        }

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none !important;
        }

        html {
            font-size: 62.5%;
            overflow-x: hidden;
            overflow-y: auto;
            scroll-behavior: smooth;
            scroll-padding-top: 6.5rem;
        }

        /* Dashboard Layout */
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            background-color: #f7f7fa;
        }

        /* Sidebar Styles */
        .dashboard-sidebar {
            width: 280px;
            background: var(--white);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .logo-container {
            margin-bottom: 1.5rem;
        }

        .logo-container img {
            height: 60px;
            width: auto;
        }

        .admin-info {
            width: 100%;
            text-align: center;
            margin-bottom: 1rem;
        }

        .admin-info h3 {
            font-size: 1.8rem;
            color: var(--black);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .admin-info p {
            font-size: 1.4rem;
            color: var(--light-color);
            margin: 0;
        }

        .admin-info span {
            color: var(--blue);
            font-weight: 600;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            color: var(--black);
            font-size: 2.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-menu {
            padding: 2rem 0;
        }

        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 1.2rem 2rem;
            color: var(--light-color);
            font-size: 1.6rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-menu a:hover {
            color: var(--blue);
            background-color: rgba(125, 125, 235, 0.1);
        }

        .sidebar-menu li.active a {
            color: var(--blue);
            background-color: rgba(125, 125, 235, 0.1);
            font-weight: 500;
        }

        .sidebar-menu li.active a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: var(--blue);
        }

        .sidebar-menu a i {
            margin-right: 1.5rem;
            font-size: 1.8rem;
            width: 2rem;
            text-align: center;
        }

        /* Main Content */
        .dashboard-main {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            transition: all 0.3s ease;
            overflow-x: auto;
        }

        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .header-left h2 {
            font-size: 2.4rem;
            color: var(--black);
            font-weight: 600;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        /* Search Box */
        .search-box {
            position: relative;
            width: 25rem;
        }

        .search-box input {
            width: 100%;
            padding: 1rem 1.5rem 1rem 4rem;
            border-radius: 3rem;
            border: none;
            background-color: var(--white);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.03);
            font-size: 1.4rem;
            color: var(--light-color);
        }

        .search-box input:focus {
            outline: none;
            border: 2px solid var(--blue);
        }

        .search-box i {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-color);
            font-size: 1.6rem;
        }

        /* Add Medical Button */
        .add-medical-btn {
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

        .add-medical-btn:hover {
            background-color: #6c6ce9;
            transform: translateY(-2px);
            color: var(--white);
            box-shadow: 0 4px 10px rgba(125, 125, 235, 0.3);
            text-decoration: none;
        }

        /* Medical Table Container */
        .medical-table-container {
            background-color: var(--white);
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background-color: var(--light-bg);
        }

        .table-header h3 {
            font-size: 2rem;
            color: var(--black);
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .record-count {
            color: var(--light-color);
            font-weight: 400;
            font-size: 1.6rem;
        }

        .table-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .filter-select {
            padding: 0.8rem 3rem 0.8rem 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background-color: var(--white);
            color: var(--black);
            font-size: 1.4rem;
            min-width: 150px;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--blue);
        }

        .refresh-btn {
            width: 4rem;
            height: 4rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background-color: var(--white);
            color: var(--light-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            color: var(--blue);
            border-color: var(--blue);
            background-color: rgba(125, 125, 235, 0.05);
        }

        .refresh-btn i {
            font-size: 1.8rem;
        }

        /* Medical Records Table */
        .medical-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            table-layout: fixed;
        }

        .medical-table thead th {
            padding: 1rem 0.8rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--light-color);
            background-color: var(--light-bg);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
        }

        .medical-table tbody td {
            padding: 1rem 0.8rem;
            font-size: 1.3rem;
            color: var(--black);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            vertical-align: middle;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Column widths - Updated for new structure */
        .medical-table th:nth-child(1), .medical-table td:nth-child(1) { width: 8%; }  /* Record ID */
        .medical-table th:nth-child(2), .medical-table td:nth-child(2) { width: 15%; } /* Patient Info */
        .medical-table th:nth-child(3), .medical-table td:nth-child(3) { width: 10%; } /* Status */
        .medical-table th:nth-child(4), .medical-table td:nth-child(4) { width: 12%; } /* Amputation Details */
        .medical-table th:nth-child(5), .medical-table td:nth-child(5) { width: 15%; } /* Health Assessment */
        .medical-table th:nth-child(6), .medical-table td:nth-child(6) { width: 12%; } /* K-Level & BLART */
        .medical-table th:nth-child(7), .medical-table td:nth-child(7) { width: 10%; } /* Last Updated */
        .medical-table th:nth-child(8), .medical-table td:nth-child(8) { width: 10%; } /* Doctor */
        .medical-table th:nth-child(9), .medical-table td:nth-child(9) { width: 8%; }  /* Actions */

        .medical-table tbody tr:last-child td {
            border-bottom: none;
        }

        .medical-table tbody tr:hover td {
            background-color: rgba(125, 125, 235, 0.05);
        }

        /* Record ID Styling */
        .record-id {
            font-family: 'Consolas', monospace;
            background-color: var(--light-bg);
            padding: 0.5rem 1rem;
            border-radius: 0.4rem;
            font-size: 1.3rem;
            color: var(--blue);
            font-weight: 600;
        }

        /* Patient Info Styling */
        .patient-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .patient-avatar {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background-color: var(--blue);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 600;
            flex-shrink: 0;
        }

        .patient-details {
            overflow: hidden;
        }

        .patient-details strong {
            color: var(--black);
            font-size: 1.3rem;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .patient-details small {
            font-size: 1.1rem;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 1.3rem;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }

        .status-active {
            background-color: rgba(75, 210, 143, 0.1);
            color: #4bd28f;
        }

        .status-in-treatment {
            background-color: rgba(255, 171, 0, 0.1);
            color: #ffab00;
        }

        .status-recovered {
            background-color: rgba(75, 210, 143, 0.1);
            color: #4bd28f;
        }

        .status-follow-up {
            background-color: rgba(38, 198, 218, 0.1);
            color: #26c6da;
        }

        .status-inactive {
            background-color: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
        }

        /* Amputation Info */
        .amputation-info {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .amputation-info strong {
            color: var(--black);
            font-size: 1.3rem;
        }

        .amputation-info small {
            color: var(--light-color);
            font-size: 1.1rem;
        }

        /* Health Assessment */
        .health-assessment {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .vitals-info {
            font-size: 1.1rem;
        }

        .vitals-info small {
            display: block;
            margin-bottom: 0.2rem;
        }

        .health-condition {
            margin-top: 0.3rem;
        }

        .health-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.2rem;
            padding: 0.3rem 0.8rem;
            border-radius: 1rem;
        }

        .health-excellent {
            background-color: rgba(125, 125, 235, 0.1);
            color: var(--blue);
        }

        .health-good {
            background-color: rgba(75, 210, 143, 0.1);
            color: #4bd28f;
        }

        .health-fair {
            background-color: rgba(255, 171, 0, 0.1);
            color: #ffab00;
        }

        .health-poor {
            background-color: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
        }

        /* Assessment Scores */
        .assessment-scores {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            align-items: center;
        }

        /* K-Level Badges */
        .k-level-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 2rem;
            font-size: 1.2rem;
            font-weight: 600;
            text-align: center;
            display: inline-block;
        }

        .k-level-k0 {
            background-color: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
        }

        .k-level-k1 {
            background-color: rgba(255, 171, 0, 0.1);
            color: #ffab00;
        }

        .k-level-k2 {
            background-color: rgba(38, 198, 218, 0.1);
            color: #26c6da;
        }

        .k-level-k3 {
            background-color: rgba(75, 210, 143, 0.1);
            color: #4bd28f;
        }

        .k-level-k4 {
            background-color: rgba(125, 125, 235, 0.1);
            color: var(--blue);
        }

        /* BLART Score Styling */
        .blart-score {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.5rem;
        }

        .blart-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--black);
        }

        .blart-category {
            font-size: 1.1rem;
            padding: 0.2rem 0.6rem;
            border-radius: 1rem;
            font-weight: 500;
        }

        .blart-limited {
            background-color: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
        }

        .blart-functional {
            background-color: rgba(75, 210, 143, 0.1);
            color: #4bd28f;
        }

        .blart-advanced {
            background-color: rgba(125, 125, 235, 0.1);
            color: var(--blue);
        }

        /* Action Buttons */
        .medical-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .action-btn {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 1.4rem;
            position: relative;
            overflow: hidden;
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
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            color: var(--white);
            text-decoration: none;
        }

        /* Empty State */
        .empty-state {
            padding: 5rem 2rem;
            text-align: center;
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

        /* Success and Error Messages */
        .success-message {
            background-color: #D4EDDA;
            color: #155724;
            padding: 1.5rem 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .patient-error-message {
            background-color: #FFEBEE;
            color: #B71C1C;
            padding: 1.5rem 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .modal-body {
            padding: 2.5rem;
            font-size: 1.6rem;
            color: var(--black);
        }

        .modal-footer {
            border-top: none;
            padding: 1.5rem 2rem 2rem;
        }

        .btn {
            padding: 1rem 2rem;
            font-size: 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 500;
        }

        .btn-secondary {
            background-color: var(--light-bg);
            color: var(--black);
            border: none;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
            color: var(--black);
        }

        .btn-danger {
            background-color: #ff6b6b;
            color: var(--white);
            border: none;
        }

        .btn-danger:hover {
            background-color: #e05c5c;
            color: var(--white);
        }

        .btn-primary {
            background-color: var(--blue);
            color: var(--white);
            border: none;
        }

        .btn-primary:hover {
            background-color: #6c6ce9;
            color: var(--white);
        }

        .alert-warning {
            background-color: rgba(255, 171, 0, 0.1);
            border: 1px solid #ffab00;
            color: #e08b00;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-top: 1.5rem;
        }

        .alert-warning i {
            margin-right: 0.8rem;
        }

        /* Animation for refresh button */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-main {
                padding: 1.5rem;
                margin-left: 0;
            }

            .dashboard-sidebar {
                transform: translateX(-100%);
            }

            .sidebar-toggle {
                display: block;
                position: fixed;
                top: 1.5rem;
                left: 1.5rem;
                z-index: 110;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
            }

            .search-box {
                width: 100%;
                max-width: 300px;
            }

            /* Mobile Table Styling */
            .medical-table thead {
                display: none;
            }

            .medical-table,
            .medical-table tbody,
            .medical-table tr,
            .medical-table td {
                display: block;
                width: 100%;
            }

            .medical-table tr {
                margin-bottom: 2rem;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 1rem;
                padding: 1.5rem;
                background-color: var(--white);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .medical-table td {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                padding: 1rem 0;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .medical-table td:last-child {
                border-bottom: none;
                justify-content: center;
            }

            .medical-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--light-color);
                flex: 1;
                text-transform: uppercase;
                font-size: 1.2rem;
                letter-spacing: 0.5px;
                margin-right: 1rem;
            }

            .medical-actions {
                justify-content: center;
                width: 100%;
            }

            .table-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .filter-select {
                width: 100%;
            }
        }
    </style>

</body>
</html>