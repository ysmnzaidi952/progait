<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Prosthetic Components List</title>

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
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.profile.view') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.stafflist') || request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.stafflist') }}">
                        <i class="fas fa-users"></i>
                        <span>Staff List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.patient.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.patient.patientlist') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span> 
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.doctor.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.doctor.doctorlist') }}">
                        <i class="fas fa-users"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.medical.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.medical.list') }}">
                        <i class="fas fa-file-medical"></i>
                        <span>Patient Medical Records</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.assessment.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.appointment.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.appointment.list') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Appointment List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.reminder.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reminder.list') }}">
                        <i class="fas fa-bell"></i>
                        <span>Appointment Reminders</span>
                    </a>
                </li>
                    <li class="{{ request()->routeIs('admin.component.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.component.index') }}">
                            <i class="fas fa-cogs"></i>
                            <span>Component Devices</span>
                        </a>
                    </li>

 
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </aside>
    <!-- Sidebar End -->

    <!-- Main Content Start --> 
    <main class="dashboard-main">
        <div class="dashboard-header">
            <div class="header-left">
                <h2>Prosthetic Components Management</h2>
                <p class="header-subtitle">Manage all prosthetic components and devices</p>
            </div>
            <div class="header-right">
                <div class="header-actions">
                    <a href="{{ route('admin.component.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Component
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
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

                <!-- Filters Section -->
                <div class="filters-section">
                    <div class="filters-container">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="typeFilter">Filter by Type:</label>
                                <select id="typeFilter" class="form-control">
                                    <option value="">All Types</option>
                                    <option value="Foot">Foot</option>
                                    <option value="Knee Joint">Knee Joint</option>
                                    <option value="Tube">Tube</option>
                                    <option value="Socket Adapter">Socket Adapter</option>
                                    <option value="Elbow Unit">Elbow Unit</option>
                                    <option value="Terminal Device">Terminal Device</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="statusFilter">Filter by Status:</label>
                                <select id="statusFilter" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="searchInput">Search Components:</label>
                                <input type="text" id="searchInput" class="form-control" placeholder="Search by name, material, or compatibility...">
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="button" id="clearFilters" class="btn btn-outline-secondary btn-block">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Components Table -->
                <div class="table-section">
                    <div class="table-header">
                        <h4><i class="fas fa-list"></i> Components List</h4>
                        <div class="table-info">
                            <span class="total-count">Total: {{ $components->total() }} components</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="componentsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Size</th>
                                    <th>Material</th>
                                    <th>Weight Range</th>
                                    <th>Age Range</th>
                                    <th>K-Level</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($components as $component)
                                    <tr data-type="{{ $component->type }}" data-status="{{ $component->is_active }}">
                                        <td><span class="component-id">#{{ $component->compID }}</span></td>
                                        <td>
                                            <div class="component-name">
                                                <strong>{{ $component->name }}</strong>
                                                @if($component->compatibility)
                                                    <br><small class="text-muted">{{ Str::limit($component->compatibility, 30) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="component-type badge badge-info">{{ $component->type }}</span>
                                        </td>
                                        <td>{{ $component->size ?? 'N/A' }}</td>
                                        <td>{{ $component->material ?? 'N/A' }}</td>
                                        <td>
                                            @if($component->weight_min || $component->weight_max)
                                                <span class="weight-range">
                                                    {{ $component->weight_min ?? 'Min' }} - {{ $component->weight_max ?? 'Max' }}g
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($component->age_min || $component->age_max)
                                                <span class="age-range">
                                                    {{ $component->age_min ?? 'Min' }} - {{ $component->age_max ?? 'Max' }} years
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $component->klevel_range ?? 'N/A' }}</td>
                                        <td>
                                            @if($component->is_active)
                                                <span class="status-badge badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="status-badge badge badge-danger">
                                                    <i class="fas fa-times-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="created-date">{{ $component->created_at->format('M d, Y') }}</span>
                                            <br><small class="text-muted">{{ $component->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.component.show', $component->compID) }}" 
                                                   class="btn btn-sm btn-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.component.edit', $component->compID) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit Component">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($component->is_active)
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger deactivate-btn" 
                                                            data-id="{{ $component->compID }}" 
                                                            data-name="{{ $component->name }}" 
                                                            title="Deactivate Component">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                @else
                                                    <button type="button" 
                                                            class="btn btn-sm btn-success activate-btn" 
                                                            data-id="{{ $component->compID }}" 
                                                            data-name="{{ $component->name }}" 
                                                            title="Activate Component">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">
                                            <div class="empty-state">
                                                <i class="fas fa-cogs fa-3x text-muted"></i>
                                                <h5 class="mt-3">No Components Found</h5>
                                                <p class="text-muted">No prosthetic components have been created yet.</p>
                                                <a href="{{ route('admin.component.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create First Component
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($components->hasPages())
                        <div class="pagination-wrapper">
                            {{ $components->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    <!-- Main Content End -->
</div>

<!-- Confirmation Modals -->
<!-- Deactivate Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-ban text-danger"></i> Deactivate Component
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to deactivate the component "<strong id="deactivateComponentName"></strong>"?</p>
                <p class="text-warning"><i class="fas fa-exclamation-triangle"></i> This component will no longer be available for selection.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deactivateForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Deactivate Component</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Activate Modal -->
<div class="modal fade" id="activateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-check text-success"></i> Activate Component
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to activate the component "<strong id="activateComponentName"></strong>"?</p>
                <p class="text-success"><i class="fas fa-check-circle"></i> This component will be available for selection again.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="activateForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Activate Component</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS files -->
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

    // Filter functionality
    const typeFilter = document.getElementById('typeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('searchInput');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const tableRows = document.querySelectorAll('#componentsTable tbody tr:not(.empty-row)');

    function filterTable() {
        const typeValue = typeFilter.value.toLowerCase();
        const statusValue = statusFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        tableRows.forEach(row => {
            const type = row.dataset.type?.toLowerCase() || '';
            const status = row.dataset.status || '';
            const text = row.textContent.toLowerCase();

            const typeMatch = !typeValue || type.includes(typeValue);
            const statusMatch = !statusValue || status === statusValue;
            const searchMatch = !searchValue || text.includes(searchValue);

            if (typeMatch && statusMatch && searchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Update visible count
        const visibleRows = Array.from(tableRows).filter(row => row.style.display !== 'none');
        const totalCountElement = document.querySelector('.total-count');
        if (totalCountElement) {
            totalCountElement.textContent = `Showing: ${visibleRows.length} of {{ $components->total() }} components`;
        }
    }

    // Event listeners for filters
    typeFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
    searchInput.addEventListener('input', filterTable);

    // Clear filters
    clearFiltersBtn.addEventListener('click', function() {
        typeFilter.value = '';
        statusFilter.value = '';
        searchInput.value = '';
        filterTable();
        
        const totalCountElement = document.querySelector('.total-count');
        if (totalCountElement) {
            totalCountElement.textContent = `Total: {{ $components->total() }} components`;
        }
    });

    // Deactivate component modal
    const deactivateBtns = document.querySelectorAll('.deactivate-btn');
    const deactivateModal = document.getElementById('deactivateModal');
    const deactivateForm = document.getElementById('deactivateForm');
    const deactivateComponentName = document.getElementById('deactivateComponentName');

    deactivateBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const componentId = this.dataset.id;
            const componentName = this.dataset.name;
            
            deactivateComponentName.textContent = componentName;
            deactivateForm.action = `/admin/component/${componentId}`;
            
            $(deactivateModal).modal('show');
        });
    });

    // Activate component modal
    const activateBtns = document.querySelectorAll('.activate-btn');
    const activateModal = document.getElementById('activateModal');
    const activateForm = document.getElementById('activateForm');
    const activateComponentName = document.getElementById('activateComponentName');

    activateBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const componentId = this.dataset.id;
            const componentName = this.dataset.name;
            
            activateComponentName.textContent = componentName;
            activateForm.action = `/admin/component/${componentId}/restore`;
            
            $(activateModal).modal('show');
        });
    });

    // Auto-hide success/error messages
    const messages = document.querySelectorAll('.success-message, .error-message');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 1s ease';
            message.style.opacity = '0';
            setTimeout(() => {
                message.remove();
            }, 1000);
        }, 5000);
    });
});
</script>

<style>
/* List Page Specific Styles */
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
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 3rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.header-left h2 {
    font-size: 2.4rem;
    color: var(--black);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.header-subtitle {
    font-size: 1.4rem;
    color: var(--light-color);
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

/* Buttons */
.btn {
    padding: 1rem 2rem;
    font-size: 1.4rem;
    font-weight: 500;
    border-radius: 0.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background-color: var(--blue);
    color: var(--white);
}

.btn-primary:hover {
    background-color: #6c6ce9;
    color: var(--white);
    transform: translateY(-2px);
    text-decoration: none;
}

.btn-outline-secondary {
    background-color: transparent;
    color: var(--light-color);
    border: 2px solid var(--light-color);
}

.btn-outline-secondary:hover {
    background-color: var(--light-color);
    color: var(--white);
    text-decoration: none;
}

/* Filters Section */
.filters-section {
    background-color: var(--white);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

.filters-container label {
    font-size: 1.3rem;
    color: var(--black);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control {
    font-size: 1.3rem;
    padding: 0.8rem 1.2rem;
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

/* Table Section */
.table-section {
    background-color: var(--white);
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--light-bg);
}

.table-header h4 {
    font-size: 2rem;
    color: var(--blue);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.total-count {
    font-size: 1.3rem;
    color: var(--light-color);
    font-weight: 500;
}

/* Table Styles */
.table {
    font-size: 1.3rem;
    margin-bottom: 0;
}

.table th {
    background-color: var(--light-bg);
    color: var(--black);
    font-weight: 600;
    border: none;
    padding: 1.5rem 1rem;
    font-size: 1.2rem;
}

.table td {
    padding: 1.5rem 1rem;
    vertical-align: middle;
    border-top: 1px solid #e0e0e0;
}

.table-hover tbody tr:hover {
    background-color: rgba(125, 125, 235, 0.05);
}

/* Component specific styles */
.component-id {
    font-weight: 600;
    color: var(--blue);
}

.component-name strong {
    color: var(--black);
    font-size: 1.4rem;
}

.component-type {
    font-size: 1.1rem;
}

.weight-range, .age-range {
    font-size: 1.2rem;
    color: var(--light-color);
}

.status-badge {
    font-size: 1.1rem;
    padding: 0.4rem 0.8rem;
}

.created-date {
    font-weight: 500;
    color: var(--black);
}

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem 0.8rem;
    font-size: 1.2rem;
}

.btn-info {
    background-color: #17a2b8;
    color: var(--white);
}

.btn-warning {
    background-color: #ffc107;
    color: var(--black);
}

.btn-danger {
    background-color: #dc3545;
    color: var(--white);
}

.btn-success {
    background-color: #28a745;
    color: var(--white);
}

/* Empty state */
.empty-state {
    padding: 4rem 2rem;
}

.empty-state i {
    opacity: 0.5;
}

/* Success and Error Messages */
.success-message, .error-message {
    background-color: #D4EDDA;
    color: #155724;
    padding: 1.5rem 2rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    font-size: 1.4rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.error-message {
    background-color: #FFEBEE;
    color: #B71C1C;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

/* Modal styles */
.modal-content {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.modal-header {
    background-color: var(--light-bg);
    border-bottom: 1px solid #e0e0e0;
    border-radius: 1rem 1rem 0 0;
}

.modal-title {
    font-size: 1.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.modal-body {
    padding: 2rem;
    font-size: 1.4rem;
    line-height: 1.6;
}

.modal-footer {
    border-top: 1px solid #e0e0e0;
    padding: 1.5rem 2rem;
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

    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .filters-container .col-md-3,
    .filters-container .col-md-4,
    .filters-container .col-md-2 {
        margin-bottom: 1rem;
    }

    .table-responsive {
        font-size: 1.2rem;
    }

    .action-buttons {
        flex-direction: column;
    }
}

@media (max-width: 576px) {
    .table th,
    .table td {
        padding: 0.8rem 0.5rem;
    }

    .component-name strong {
        font-size: 1.3rem;
    }

    .btn-sm {
        padding: 0.4rem 0.6rem;
        font-size: 1.1rem;
    }
}
</style>

</body>
</html>