<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Prosthetic Components</title>

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
                <li>
                    <a href="{{ route('staff.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.profile.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.profile.view') }}">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.patient.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.patient.patientliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.doctor.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.doctor.doctorliststaff') }}">
                        <i class="fas fa-users"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.assessment.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.appointment.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.appointment.list') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Appointments List</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.reminder.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.reminder.list') }}">
                        <i class="fas fa-bell"></i>
                        <span>Appointment Reminders</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('staff.component.*') ? 'active' : '' }}">
                    <a href="{{ route('staff.component.index') }}">
                        <i class="fas fa-cogs"></i>
                        <span>Component Devices</span>
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
                <h2>Prosthetic Components</h2>
                <p class="header-subtitle">View and manage prosthetic components</p>
            </div>
            <div class="header-right">
                <div class="header-actions">
                    <a href="{{ route('staff.component.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Component
                    </a>
                    <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary">
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

                @if(session('info'))
                    <div class="info-message">
                        <i class="fas fa-info-circle"></i> {{ session('info') }}
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
                                    <option value="0">Pending Approval</option>
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
                                                <span class="status-badge badge badge-warning">
                                                    <i class="fas fa-clock"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="created-date">{{ $component->created_at->format('M d, Y') }}</span>
                                            <br><small class="text-muted">{{ $component->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('staff.component.show', $component->compID) }}" 
                                                   class="btn btn-sm btn-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!$component->is_active)
                                                    <a href="{{ route('staff.component.edit', $component->compID) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit Component">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if(!$component->is_active)
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger request-deletion-btn" 
                                                            data-id="{{ $component->compID }}" 
                                                            data-name="{{ $component->name }}" 
                                                            title="Request Deletion">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <span class="btn btn-sm btn-secondary disabled" title="Contact admin to modify active components">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
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
                                                <a href="{{ route('staff.component.create') }}" class="btn btn-primary">
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

<!-- Confirmation Modal for Deletion Request -->
<div class="modal fade" id="requestDeletionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-trash text-warning"></i> Request Component Deletion
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>