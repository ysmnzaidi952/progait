<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - ProGait</title>

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
                <li>
                    <a href="">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.stafflist') }}">
                        <i class="fas fa-users"></i>
                        <span>Staff List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.patient.patientlist') }}">
                        <i class="fas fa-users"></i>
                        <span>Patient List</span> 
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.doctor.doctorlist') }}">
                        <i class="fas fa-users"></i>
                        <span>Doctor List</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('admin.medical.list') }}">
                        <i class="fas fa-file-medical"></i>
                        <span>Patient Medical Records</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.assessment.list') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Assessment Form List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.appointment.list') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Appointment List</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{ route('admin.reminder.list') }}">
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
                <h2>My Profile</h2>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-notifications">
                    <div class="notifications-icon">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="messages-icon">
                        <i class="fas fa-envelope"></i>
                        <span class="badge">5</span>
                    </div>
                </div>
                <div class="admin-profile">
                    <img src="{{ asset('images/admin-avatar.png') }}" alt="Admin">
                    <span>{{ $admin->name }}</span>
                </div>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-cover">
                        <div class="edit-cover-btn">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <div class="profile-avatar">
                        <img src="{{ asset('images/admin-avatar.png') }}" alt="{{ $admin->name }}">
                        <div class="edit-avatar-btn">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <div class="profile-info">
                        <h2>{{ $admin->name }}</h2>
                        <p>Administrator</p>
                    </div>
                    <div class="profile-stats">
                        <div class="stat">
                            <h3>{{ $adminStats->yearsOfService ?? '5' }}</h3>
                            <p>Years of Service</p>
                        </div>
                        <div class="stat">
                            <h3>{{ $adminStats->managedStaff ?? '12' }}</h3>
                            <p>Staff Managed</p>
                        </div>
                        <div class="stat">
                            <h3>{{ $adminStats->tasks ?? '24' }}</h3>
                            <p>Tasks</p>
                        </div>
                    </div>
                </div>

                <div class="profile-content">
                    <div class="profile-nav">
                        <ul>
                            <li class="active" data-tab="personal-info">
                                <i class="fas fa-user"></i> Personal Information
                            </li>
                            <li data-tab="security">
                                <i class="fas fa-lock"></i> Security
                            </li>
                            <li data-tab="activity">
                                <i class="fas fa-chart-line"></i> Activity
                            </li>
                            <li data-tab="settings">
                                <i class="fas fa-cog"></i> Settings
                            </li>
                        </ul>
                    </div>

                    <div class="profile-tabs">
                        <!-- Personal Information Tab -->
                        <div class="profile-tab active" id="personal-info">
                            <div class="profile-section">
                                <div class="section-header">
                                    <h3>Personal Information</h3>
                                    <button class="edit-btn" id="edit-personal-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                                <div class="section-content">
                                    <div class="info-container">
                                        <div class="info-group">
                                            <div class="info-row">
                                                <div class="info-label">Full Name</div>
                                                <div class="info-value">{{ $admin->name ?? 'Admin User' }}</div>
                                            </div>
                                            <div class="info-row">
                                                <div class="info-label">Email</div>
                                                <div class="info-value">{{ $admin->email ?? 'admin@progait.com' }}</div>
                                            </div>
                                            <div class="info-row">
                                                <div class="info-label">Phone</div>
                                                <div class="info-value">{{ $admin->phone ?? '+60 1xx xxxx xxx' }}</div>
                                            </div>
                                            <div class="info-row">
                                                <div class="info-label">Date of Birth</div>
                                                <div class="info-value">{{ $admin->dob ?? '15 January 1990' }}</div>
                                            </div>
                                        </div>
                                        <div class="info-group">
                                            <div class="info-row">
                                                <div class="info-label">Role</div>
                                                <div class="info-value">{{ $admin->role ?? 'System Administrator' }}</div>
                                            </div>
                                            <div class="info-row">
                                                <div class="info-label">Department</div>
                                                <div class="info-value">{{ $admin->department ?? 'IT Management' }}</div>
                                            </div>
                                            <div class="info-row">
                                                <div class="info-label">Join Date</div>
                                                <div class="info-value">{{ $admin->joinDate ?? '5 March 2020' }}</div>
                                            </div>
                                            <div class="info-row">
                                                <div class="info-label">Employee ID</div>
                                                <div class="info-value">{{ $admin->employeeId ?? 'ADM-2020-001' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-section">
                                <div class="section-header">
                                    <h3>Contact Information</h3>
                                    <button class="edit-btn" id="edit-contact-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                                <div class="section-content">
                                    <div class="info-group full-width">
                                        <div class="info-row">
                                            <div class="info-label">Address</div>
                                            <div class="info-value">{{ $admin->address ?? '123 Jalan Ampang, Kuala Lumpur' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">City</div>
                                            <div class="info-value">{{ $admin->city ?? 'Kuala Lumpur' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">State</div>
                                            <div class="info-value">{{ $admin->state ?? 'Wilayah Persekutuan' }}</div>
                                        </div>
                                        <div class="info-row">
                                            <div class="info-label">Postal Code</div>
                                            <div class="info-value">{{ $admin->postalCode ?? '50450' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-section">
                                <div class="section-header">
                                    <h3>Professional Skills</h3>
                                    <button class="edit-btn" id="edit-skills">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                                <div class="section-content">
                                    <div class="skills-container">
                                        <div class="skill">
                                            <span>System Administration</span>
                                            <div class="skill-bar">
                                                <div class="skill-progress" style="width: 95%;"></div>
                                            </div>
                                        </div>
                                        <div class="skill">
                                            <span>Healthcare Management</span>
                                            <div class="skill-bar">
                                                <div class="skill-progress" style="width: 85%;"></div>
                                            </div>
                                        </div>
                                        <div class="skill">
                                            <span>Team Leadership</span>
                                            <div class="skill-bar">
                                                <div class="skill-progress" style="width: 90%;"></div>
                                            </div>
                                        </div>
                                        <div class="skill">
                                            <span>Patient Care</span>
                                            <div class="skill-bar">
                                                <div class="skill-progress" style="width: 80%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Tab -->
                        <div class="profile-tab" id="security">
                            <div class="profile-section">
                                <div class="section-header">
                                    <h3>Change Password</h3>
                                </div>
                                <div class="section-content">
                                    <form class="form-container">
                                        <div class="form-group">
                                            <label>Current Password</label>
                                            <input type="password" class="form-control" placeholder="Enter current password">
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" placeholder="Enter new password">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm New Password</label>
                                            <input type="password" class="form-control" placeholder="Confirm new password">
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn-primary">Update Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="profile-section">
                                <div class="section-header">
                                    <h3>Two-Factor Authentication</h3>
                                </div>
                                <div class="section-content">
                                    <div class="tfa-status">
                                        <div class="status-icon">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <div class="status-info">
                                            <h4>Two-Factor Authentication is Disabled</h4>
                                            <p>Add an extra layer of security to your account by enabling two-factor authentication.</p>
                                        </div>
                                        <div class="status-action">
                                            <button class="btn-secondary">Enable</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-section">
                                <div class="section-header">
                                    <h3>Login Sessions</h3>
                                </div>
                                <div class="section-content">
                                    <div class="session-list">
                                        <div class="session-item current">
                                            <div class="session-info">
                                                <div class="device-icon"><i class="fas fa-laptop"></i></div>
                                                <div class="device-details">
                                                    <h4>Windows PC - Chrome</h4>
                                                    <p>Kuala Lumpur, Malaysia - Current Session</p>
                                                </div>
                                            </div>
                                            <div class="session-action">
                                                <span class="active-session">Active Now</span>
                                            </div>
                                        </div>
                                        <div class="session-item">
                                            <div class="session-info">
                                                <div class="device-icon"><i class="fas fa-mobile-alt"></i></div>
                                                <div class="device-details">
                                                    <h4>iPhone - Safari</h4>
                                                    <p>Kuala Lumpur, Malaysia - Last active: 2 days ago</p>
                                                </div>
                                            </div>
                                            <div class="session-action">
                                                <button class="btn-danger-outline">Logout</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Tab -->
                        <div class="profile-tab" id="activity">
                            <div class="profile-section">
                                <div class="section-header">
                                    <h3>Recent Activity</h3>
                                </div>
                                <div class="section-content">
                                    <div class="activity-timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="fas fa-user-check"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h4>Approved Staff Registration</h4>
                                                <p>You approved Dr. Ahmad Nasir's staff registration request.</p>
                                                <span class="timeline-date">Today, 10:30 AM</span>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h4>Updated System Settings</h4>
                                                <p>You updated the system email notification settings.</p>
                                                <span class="timeline-date">Yesterday, 3:45 PM</span>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="fas fa-calendar-plus"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h4>Created New Appointment</h4>
                                                <p>You created a new appointment for patient Nur Hidayah.</p>
                                                <span class="timeline-date">May 10, 2025, 11:20 AM</span>
                                            </div>
                                        </div>
                                        <div class="timeline-item">
                                            <div class="timeline-icon">
                                                <i class="fas fa-sign-in-alt"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h4>Logged In</h4>
                                                <p>You logged in from Chrome on Windows PC.</p>
                                                <span class="timeline-date">May 10, 2025, 9:00 AM</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div class="profile-tab" id="settings">
                            <div class="profile-section">
                                <div class="section-header">
                                    <h3>Notification Settings</h3>
                                </div>
                                <div class="section-content">
                                    <div class="settings-list">
                                        <div class="setting-item">
                                            <div class="setting-info">
                                                <h4>Email Notifications</h4>
                                                <p>Receive email notifications for new staff registrations, patient appointments, and system updates.</p>
                                            </div>
                                            <div class="setting-toggle">
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="setting-item">
                                            <div class="setting-info">
                                                <h4>Browser Notifications</h4>
                                                <p>Receive browser push notifications while you're using the system.</p>
                                            </div>
                                            <div class="setting-toggle">
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="setting-item">
                                            <div class="setting-info">
                                                <h4>SMS Notifications</h4>
                                                <p>Receive SMS alerts for critical system events and urgent requests.</p>
                                            </div>
                                            <div class="setting-toggle">
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-section">
                                <div class="section-header">
                                    <h3>Account Settings</h3>
                                </div>
                                <div class="section-content">
                                    <div class="settings-list">
                                        <div class="setting-item">
                                            <div class="setting-info">
                                                <h4>Language</h4>
                                                <p>Change your default language for the dashboard interface.</p>
                                            </div>
                                            <div class="setting-action">
                                                <select class="form-control">
                                                    <option selected>English</option>
                                                    <option>Bahasa Malaysia</option>
                                                    <option>中文</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="setting-item">
                                            <div class="setting-info">
                                                <h4>Timezone</h4>
                                                <p>Set your local timezone for accurate scheduling.</p>
                                            </div>
                                            <div class="setting-action">
                                                <select class="form-control">
                                                    <option selected>(GMT+8:00) Kuala Lumpur</option>
                                                    <option>(GMT+8:00) Singapore</option>
                                                    <option>(GMT+7:00) Bangkok</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-section danger-zone">
                                <div class="section-header">
                                    <h3>Danger Zone</h3>
                                </div>
                                <div class="section-content">
                                    <div class="danger-actions">
                                        <div class="danger-item">
                                            <div class="danger-info">
                                                <h4>Delete Account</h4>
                                                <p>Permanently delete your account and all associated data. This action cannot be undone.</p>
                                            </div>
                                            <div class="danger-action">
                                                <button class="btn-danger">Delete Account</button>
                                            </div>
                                        </div>
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

<!-- JS files -->
<script src="{{ asset('js/script.js') }}"></script>
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
        
        // Profile tabs
        const tabButtons = document.querySelectorAll('.profile-nav li');
        const tabContents = document.querySelectorAll('.profile-tab');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Remove active class from all buttons and tabs
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(tab => tab.classList.remove('active'));
                
                // Add active class to current button and tab
                this.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });
        
        // Initialize ScrollReveal
        ScrollReveal().reveal('.profile-header', {
            origin: 'top',
            distance: '20px',
            duration: 1000,
            delay: 200,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });
        
        ScrollReveal().reveal('.profile-section', {
            origin: 'bottom',
            distance: '30px',
            duration: 1000,
            interval: 200,
            delay: 300,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
        });
    });
</script>

</body>
</html>