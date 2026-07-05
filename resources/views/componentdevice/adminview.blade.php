<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - View Prosthetic Component</title>

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
                <div class="component-title">
                    <h2>{{ $component->name }}</h2>
                    <div class="component-meta">
                        <span class="component-id">#{{ $component->compID }}</span>
                        <span class="component-type">{{ $component->type }}</span>
                        @if($component->is_active)
                            <span class="status-badge badge badge-success">
                                <i class="fas fa-check-circle"></i> Active
                            </span>
                        @else
                            <span class="status-badge badge badge-danger">
                                <i class="fas fa-times-circle"></i> Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-right">
                <div class="header-actions">
                    <a href="{{ route('admin.component.edit', $component->compID) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Component
                    </a>
                    @if($component->is_active)
                        <button type="button" class="btn btn-danger" id="deactivateBtn">
                            <i class="fas fa-ban"></i> Deactivate
                        </button>
                    @else
                        <button type="button" class="btn btn-success" id="activateBtn">
                            <i class="fas fa-check"></i> Activate
                        </button>
                    @endif
                    <a href="{{ route('admin.component.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list"></i> Back to List
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

                <div class="component-details">
                    <!-- Basic Information Card -->
                    <div class="details-card">
                        <div class="card-header">
                            <h4><i class="fas fa-info-circle"></i> Basic Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="status-grid">
                                <div class="status-item">
                                    <label>Current Status</label>
                                    <div class="status-display">
                                        @if($component->is_active)
                                            <span class="status-badge badge badge-success">
                                                <i class="fas fa-check-circle"></i> Active
                                            </span>
                                            <small class="status-description">This component is available for selection and use.</small>
                                        @else
                                            <span class="status-badge badge badge-danger">
                                                <i class="fas fa-times-circle"></i> Inactive
                                            </span>
                                            <small class="status-description">This component is not available for selection.</small>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="status-item">
                                    <label>Component ID</label>
                                    <div class="component-id-display">
                                        <span class="id-value">#{{ $component->compID }}</span>
                                        <small class="id-description">Unique identifier in system</small>
                                    </div>
                                </div>

                                <div class="status-item">
                                    <label>Created Date</label>
                                    <div class="date-display">
                                        <span class="date-value">{{ $component->created_at->format('F j, Y') }}</span>
                                        <small class="time-value">{{ $component->created_at->format('g:i A') }}</small>
                                        <small class="date-description">{{ $component->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>

                                <div class="status-item">
                                    <label>Last Updated</label>
                                    <div class="date-display">
                                        <span class="date-value">{{ $component->updated_at->format('F j, Y') }}</span>
                                        <small class="time-value">{{ $component->updated_at->format('g:i A') }}</small>
                                        <small class="date-description">{{ $component->updated_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Component Summary Card -->
                    <div class="details-card summary-card">
                        <div class="card-header">
                            <h4><i class="fas fa-clipboard-list"></i> Component Summary</h4>
                        </div>
                        <div class="card-body">
                            <div class="summary-content">
                                <div class="summary-section">
                                    <h5>Suitable For:</h5>
                                    <ul class="summary-list">
                                        @if($component->compatibility)
                                            <li><i class="fas fa-check"></i> {{ $component->compatibility }} amputations</li>
                                        @endif
                                        @if($component->age_min || $component->age_max)
                                            <li><i class="fas fa-check"></i> 
                                                Ages 
                                                {{ $component->age_min ? $component->age_min : '0' }} - 
                                                {{ $component->age_max ? $component->age_max : '120+' }} years
                                            </li>
                                        @endif
                                        @if($component->klevel_range)
                                            <li><i class="fas fa-check"></i> K-Level: {{ $component->klevel_range }}</li>
                                        @endif
                                        @if($component->bscore_min || $component->bscore_max)
                                            <li><i class="fas fa-check"></i> 
                                                BLARt Score: 
                                                {{ $component->bscore_min ? $component->bscore_min : '0' }} - 
                                                {{ $component->bscore_max ? $component->bscore_max : '30+' }} points
                                            </li>
                                        @endif
                                        @if($component->weight_min || $component->weight_max)
                                            <li><i class="fas fa-check"></i> 
                                                Weight capacity: 
                                                {{ $component->weight_min ? $component->weight_min : '0' }}g - 
                                                {{ $component->weight_max ? $component->weight_max : 'unlimited' }}g
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="summary-section">
                                    <h5>Key Features:</h5>
                                    <div class="feature-tags">
                                        <span class="feature-tag">{{ $component->type }}</span>
                                        @if($component->material)
                                            <span class="feature-tag">{{ $component->material }}</span>
                                        @endif
                                        @if($component->size)
                                            <span class="feature-tag">Size: {{ $component->size }}</span>
                                        @endif
                                        @if($component->is_active)
                                            <span class="feature-tag active">Available</span>
                                        @else
                                            <span class="feature-tag inactive">Unavailable</span>
                                        @endif
                                    </div>
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
                <p>Are you sure you want to deactivate "<strong>{{ $component->name }}</strong>"?</p>
                <p class="text-warning"><i class="fas fa-exclamation-triangle"></i> This component will no longer be available for selection in the recommendation system.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.component.destroy', $component->compID) }}" method="POST" style="display: inline;">
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
                <p>Are you sure you want to activate "<strong>{{ $component->name }}</strong>"?</p>
                <p class="text-success"><i class="fas fa-check-circle"></i> This component will be available for selection in the recommendation system.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.component.restore', $component->compID) }}" method="POST" style="display: inline;">
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

    // Modal functionality
    const deactivateBtn = document.getElementById('deactivateBtn');
    const activateBtn = document.getElementById('activateBtn');
    
    if (deactivateBtn) {
        deactivateBtn.addEventListener('click', function() {
            $('#deactivateModal').modal('show');
        });
    }
    
    if (activateBtn) {
        activateBtn.addEventListener('click', function() {
            $('#activateModal').modal('show');
        });
    }

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

    // Print functionality
    const printBtn = document.createElement('button');
    printBtn.className = 'btn btn-outline-primary';
    printBtn.innerHTML = '<i class="fas fa-print"></i> Print Details';
    printBtn.addEventListener('click', function() {
        window.print();
    });
    
    // Add print button to header actions if not on mobile
    if (window.innerWidth > 768) {
        const headerActions = document.querySelector('.header-actions');
        if (headerActions) {
            headerActions.appendChild(printBtn);
        }
    }

    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

<style>
/* View Component Specific Styles */
:root{
    --blue: #7d7deb;
    --black: #333;
    --white: #fff;
    --light-color: #666;
    --light-bg: #eee;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #17a2b8;
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
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--light-bg);
}

.component-title h2 {
    font-size: 2.8rem;
    color: var(--black);
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.component-meta {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.component-id {
    font-size: 1.6rem;
    color: var(--blue);
    font-weight: 600;
    background-color: rgba(125, 125, 235, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
}

.component-type {
    font-size: 1.4rem;
    color: var(--light-color);
    font-weight: 500;
}

.status-badge {
    font-size: 1.3rem;
    padding: 0.6rem 1.2rem;
    font-weight: 600;
}

.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
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

.btn-warning {
    background-color: var(--warning-color);
    color: var(--black);
}

.btn-warning:hover {
    background-color: #e0a800;
    color: var(--black);
    text-decoration: none;
}

.btn-danger {
    background-color: var(--danger-color);
    color: var(--white);
}

.btn-danger:hover {
    background-color: #c82333;
    color: var(--white);
    text-decoration: none;
}

.btn-success {
    background-color: var(--success-color);
    color: var(--white);
}

.btn-success:hover {
    background-color: #218838;
    color: var(--white);
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

.btn-outline-primary {
    background-color: transparent;
    color: var(--blue);
    border: 2px solid var(--blue);
}

.btn-outline-primary:hover {
    background-color: var(--blue);
    color: var(--white);
    text-decoration: none;
}

/* Component Details Cards */
.component-details {
    display: grid;
    gap: 2rem;
}

.details-card {
    background-color: var(--white);
    border-radius: 1rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    border-left: 4px solid var(--blue);
}

.card-header {
    background-color: var(--light-bg);
    padding: 2rem;
    border-bottom: 1px solid #e0e0e0;
}

.card-header h4 {
    font-size: 2rem;
    color: var(--blue);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-weight: 600;
}

.card-body {
    padding: 2.5rem;
}

/* Detail Grid */
.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-item.full-width {
    grid-column: span 2;
}

.detail-item label {
    font-size: 1.3rem;
    color: var(--light-color);
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-item p {
    font-size: 1.5rem;
    color: var(--black);
    margin: 0;
    font-weight: 500;
}

.detail-item .description {
    line-height: 1.6;
    text-align: justify;
}

.type-badge {
    background-color: var(--info-color);
    color: var(--white);
    padding: 0.4rem 1rem;
    border-radius: 0.5rem;
    font-size: 1.3rem;
    font-weight: 600;
}

/* Specifications */
.specification-grid {
    display: grid;
    gap: 2rem;
}

.spec-group h5 {
    font-size: 1.6rem;
    color: var(--black);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    font-weight: 600;
}

.spec-values {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.spec-item {
    background-color: var(--light-bg);
    padding: 1.5rem;
    border-radius: 0.8rem;
    text-align: center;
}

.spec-item label {
    font-size: 1.2rem;
    color: var(--light-color);
    font-weight: 600;
    display: block;
    margin-bottom: 0.5rem;
}

.spec-value {
    font-size: 1.6rem;
    color: var(--black);
    font-weight: 700;
}

.range-highlight {
    color: var(--blue);
    background-color: rgba(125, 125, 235, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
}

/* Criteria Styles */
.criteria-grid {
    display: grid;
    gap: 2.5rem;
}

.criteria-group h5 {
    font-size: 1.6rem;
    color: var(--black);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    font-weight: 600;
}

.criteria-values {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1.5rem;
}

.criteria-item {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.8rem;
    border: 1px solid #e9ecef;
}

.criteria-item label {
    font-size: 1.2rem;
    color: var(--light-color);
    font-weight: 600;
    display: block;
    margin-bottom: 0.8rem;
}

.criteria-value {
    font-size: 1.4rem;
    color: var(--black);
    font-weight: 600;
}

.klevel-badge {
    background-color: var(--success-color);
    color: var(--white);
    padding: 0.3rem 0.8rem;
    border-radius: 0.4rem;
    font-size: 1.2rem;
    font-weight: 600;
}

/* Status Styles */
.status-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.status-item {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 0.8rem;
    border: 1px solid #e9ecef;
}

.status-item label {
    font-size: 1.3rem;
    color: var(--light-color);
    font-weight: 600;
    display: block;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-display, .component-id-display, .date-display {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.status-description, .id-description, .date-description {
    font-size: 1.1rem;
    color: var(--light-color);
    margin: 0;
}

.id-value {
    font-size: 1.6rem;
    color: var(--blue);
    font-weight: 700;
}

.date-value {
    font-size: 1.5rem;
    color: var(--black);
    font-weight: 600;
}

.time-value {
    font-size: 1.3rem;
    color: var(--light-color);
    font-weight: 500;
}

/* Summary Card */
.summary-card {
    border-left-color: var(--success-color);
}

.summary-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
}

.summary-section h5 {
    font-size: 1.6rem;
    color: var(--black);
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.summary-list {
    list-style: none;
    padding: 0;
}

.summary-list li {
    font-size: 1.4rem;
    color: var(--light-color);
    margin-bottom: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.summary-list li i {
    color: var(--success-color);
    margin-top: 0.2rem;
}

.feature-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8rem;
}

.feature-tag {
    background-color: var(--light-bg);
    color: var(--black);
    padding: 0.6rem 1.2rem;
    border-radius: 2rem;
    font-size: 1.2rem;
    font-weight: 500;
    border: 1px solid #e0e0e0;
}

.feature-tag.active {
    background-color: var(--success-color);
    color: var(--white);
    border-color: var(--success-color);
}

.feature-tag.inactive {
    background-color: var(--danger-color);
    color: var(--white);
    border-color: var(--danger-color);
}

/* Messages */
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

/* Print Styles */
@media print {
    .dashboard-sidebar,
    .header-actions,
    .modal {
        display: none !important;
    }
    
    .dashboard-main {
        margin-left: 0;
        padding: 1rem;
    }
    
    .details-card {
        break-inside: avoid;
        box-shadow: none;
        border: 1px solid #ddd;
        margin-bottom: 1rem;
    }
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
        gap: 2rem;
    }

    .component-title h2 {
        font-size: 2.2rem;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .header-actions .btn {
        width: 100%;
        justify-content: center;
    }

    .detail-grid {
        grid-template-columns: 1fr;
    }

    .detail-item.full-width {
        grid-column: span 1;
    }

    .spec-values {
        grid-template-columns: 1fr;
    }

    .criteria-values {
        grid-template-columns: 1fr;
    }

    .status-grid {
        grid-template-columns: 1fr;
    }

    .summary-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media (max-width: 576px) {
    .component-title h2 {
        font-size: 2rem;
    }

    .component-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .card-header,
    .card-body {
        padding: 1.5rem;
    }

    .spec-item,
    .criteria-item,
    .status-item {
        padding: 1.2rem;
    }
}
</style>

</body>
</html>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <label>Component Name</label>
                                    <p>{{ $component->name }}</p>
                                </div>
                                <div class="detail-item">
                                    <label>Component Type</label>
                                    <p><span class="type-badge">{{ $component->type }}</span></p>
                                </div>
                                <div class="detail-item">
                                    <label>Size</label>
                                    <p>{{ $component->size ?? 'Not specified' }}</p>
                                </div>
                                <div class="detail-item">
                                    <label>Material</label>
                                    <p>{{ $component->material ?? 'Not specified' }}</p>
                                </div>
                                <div class="detail-item full-width">
                                    <label>Compatibility</label>
                                    <p>{{ $component->compatibility ?? 'Not specified' }}</p>
                                </div>
                                <div class="detail-item full-width">
                                    <label>Description</label>
                                    <p class="description">{{ $component->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Specifications Card -->
                    <div class="details-card">
                        <div class="card-header">
                            <h4><i class="fas fa-cogs"></i> Technical Specifications</h4>
                        </div>
                        <div class="card-body">
                            <div class="specification-grid">
                                <div class="spec-group">
                                    <h5><i class="fas fa-weight-hanging"></i> Weight Range</h5>
                                    <div class="spec-values">
                                        <div class="spec-item">
                                            <label>Minimum Weight</label>
                                            <span class="spec-value">{{ $component->weight_min ? $component->weight_min . 'g' : 'Not specified' }}</span>
                                        </div>
                                        <div class="spec-item">
                                            <label>Maximum Weight</label>
                                            <span class="spec-value">{{ $component->weight_max ? $component->weight_max . 'g' : 'Not specified' }}</span>
                                        </div>
                                        @if($component->weight_min && $component->weight_max)
                                            <div class="spec-item">
                                                <label>Weight Range</label>
                                                <span class="spec-value range-highlight">{{ $component->weight_min }}g - {{ $component->weight_max }}g</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Criteria Card -->
                    <div class="details-card">
                        <div class="card-header">
                            <h4><i class="fas fa-user-check"></i> Patient Matching Criteria</h4>
                        </div>
                        <div class="card-body">
                            <div class="criteria-grid">
                                <div class="criteria-group">
                                    <h5><i class="fas fa-birthday-cake"></i> Age Requirements</h5>
                                    <div class="criteria-values">
                                        <div class="criteria-item">
                                            <label>Minimum Age</label>
                                            <span class="criteria-value">{{ $component->age_min ? $component->age_min . ' years' : 'No minimum' }}</span>
                                        </div>
                                        <div class="criteria-item">
                                            <label>Maximum Age</label>
                                            <span class="criteria-value">{{ $component->age_max ? $component->age_max . ' years' : 'No maximum' }}</span>
                                        </div>
                                        @if($component->age_min && $component->age_max)
                                            <div class="criteria-item">
                                                <label>Age Range</label>
                                                <span class="criteria-value range-highlight">{{ $component->age_min }} - {{ $component->age_max }} years</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="criteria-group">
                                    <h5><i class="fas fa-walking"></i> Mobility & Activity Level</h5>
                                    <div class="criteria-values">
                                        <div class="criteria-item">
                                            <label>K-Level Range</label>
                                            <span class="criteria-value">
                                                @if($component->klevel_range)
                                                    <span class="klevel-badge">{{ $component->klevel_range }}</span>
                                                @else
                                                    Not specified
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="criteria-group">
                                    <h5><i class="fas fa-chart-line"></i> BLARt Score Range</h5>
                                    <div class="criteria-values">
                                        <div class="criteria-item">
                                            <label>Minimum Score</label>
                                            <span class="criteria-value">{{ $component->bscore_min ?? 'No minimum' }}</span>
                                        </div>
                                        <div class="criteria-item">
                                            <label>Maximum Score</label>
                                            <span class="criteria-value">{{ $component->bscore_max ?? 'No maximum' }}</span>
                                        </div>
                                        @if($component->bscore_min && $component->bscore_max)
                                            <div class="criteria-item">
                                                <label>Score Range</label>
                                                <span class="criteria-value range-highlight">{{ $component->bscore_min }} - {{ $component->bscore_max }} points</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status & History Card -->
                    <div class="details-card">
                        <div class="card-header">
                            <h4><i class="fas fa-history"></i> Status & History</h4>
                        </div>
                        <div class="card-body">