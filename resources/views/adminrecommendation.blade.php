<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Prosthetic Recommendations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Enhanced Prosthetic Recommendations Styling - ProGait Design System */
        :root {
            --blue: #7d7deb;
            --black: #333;
            --white: #fff;
            --light-color: #666;
            --light-bg: #eee;
            --border: .2rem solid rgba(0,0,0,.1);
            --box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
            --success: #4bd28f;
            --warning: #ffab00;
            --danger: #ff6b6b;
            --info: #26c6da;
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
        }

        body {
            background-color: #f7f7fa;
        }

        /* Dashboard Layout */
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
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
            align-items: center;
            margin-bottom: 3rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .page-title {
            font-size: 2.8rem;
            color: var(--black);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0;
        }

        .page-title i {
            color: var(--blue);
        }

        .page-subtitle {
            font-size: 1.6rem;
            color: var(--light-color);
            margin: 0.5rem 0 0;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
        }

        .header-actions .btn {
            padding: 1rem 2rem;
            font-size: 1.4rem;
            border-radius: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 500;
        }

        /* Patient Overview Card */
        .patient-overview-card {
            background: linear-gradient(135deg, var(--white) 0%, #f8f9ff 100%);
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 3rem;
            margin-bottom: 3rem;
            border: 1px solid rgba(125, 125, 235, 0.1);
        }

        .patient-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .patient-avatar-large {
            width: 8rem;
            height: 8rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), #9191ef);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            font-weight: 700;
            box-shadow: 0 8px 25px rgba(125, 125, 235, 0.3);
        }

        .patient-title-info {
            flex: 1;
        }

        .patient-name {
            font-size: 2.4rem;
            color: var(--black);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .patient-subtitle {
            font-size: 1.6rem;
            color: var(--light-color);
            margin-bottom: 1rem;
        }

        .patient-meta {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.4rem;
            color: var(--light-color);
        }

        .meta-item i {
            color: var(--blue);
        }

        .recommendation-badge {
            background: linear-gradient(135deg, var(--success), #45b049);
            color: var(--white);
            padding: 1rem 2rem;
            border-radius: 2rem;
            font-size: 1.4rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            box-shadow: 0 4px 15px rgba(75, 210, 143, 0.3);
        }

        /* Custom Alert */
        .alert-warning-custom {
            background: linear-gradient(135deg, rgba(255, 171, 0, 0.1), rgba(255, 193, 7, 0.05));
            border: 1px solid rgba(255, 171, 0, 0.3);
            border-radius: 1rem;
            padding: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .alert-icon {
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            background-color: var(--warning);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .alert-content h5 {
            font-size: 1.6rem;
            color: var(--black);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .alert-content p {
            font-size: 1.4rem;
            color: var(--light-color);
            margin: 0;
        }

        /* Patient Details Grid */
        .patient-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .detail-card {
            background: var(--white);
            border-radius: 1rem;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .detail-icon {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 1rem;
            background: rgba(125, 125, 235, 0.1);
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .detail-content {
            flex: 1;
        }

        .detail-content label {
            font-size: 1.3rem;
            color: var(--light-color);
            font-weight: 500;
            display: block;
            margin-bottom: 0.3rem;
        }

        .detail-content span {
            font-size: 1.6rem;
            color: var(--black);
            font-weight: 600;
        }

        /* Recommendations Section */
        .recommendations-section {
            background: var(--white);
            border-radius: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 3rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-header h4 {
            font-size: 2.2rem;
            color: var(--black);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0;
        }

        .section-header h4 i {
            color: var(--blue);
        }

        .component-count {
            background: rgba(125, 125, 235, 0.1);
            color: var(--blue);
            padding: 0.8rem 1.5rem;
            border-radius: 2rem;
            font-size: 1.4rem;
            font-weight: 600;
        }

        /* Recommendations Grid */
        .recommendations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .component-card {
            background: var(--white);
            border-radius: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            opacity: 0;
            transform: translateY(20px);
        }

        .component-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .component-header {
            background: linear-gradient(135deg, var(--blue), #9191ef);
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .component-icon {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .component-badge {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            padding: 0.6rem 1.2rem;
            border-radius: 2rem;
            font-size: 1.3rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .component-content {
            padding: 2rem;
        }

        .component-name {
            font-size: 2rem;
            color: var(--black);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .component-specs {
            margin-bottom: 2rem;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 1.4rem;
        }

        .spec-item i {
            width: 2rem;
            color: var(--blue);
            font-size: 1.4rem;
        }

        .spec-item span {
            color: var(--light-color);
        }

        .spec-item strong {
            color: var(--black);
        }

        .component-description {
            background: var(--light-bg);
            padding: 1.5rem;
            border-radius: 0.8rem;
            margin-bottom: 2rem;
        }

        .component-description p {
            font-size: 1.4rem;
            color: var(--light-color);
            margin: 0;
            line-height: 1.6;
            font-style: italic;
        }

        .component-footer {
            padding: 0 2rem 2rem;
            display: flex;
            gap: 1rem;
        }

        .component-footer .btn {
            flex: 1;
            padding: 1rem 1.5rem;
            font-size: 1.3rem;
            border-radius: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--blue);
            color: var(--blue);
        }

        .btn-outline-primary:hover {
            background: var(--blue);
            color: var(--white);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--blue), #9191ef);
            border: none;
            color: var(--white);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #6c6ce9, #8080ed);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(125, 125, 235, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #45b049);
            border: none;
            color: var(--white);
        }

        /* Empty State */
        .no-recommendations {
            grid-column: 1 / -1;
        }

        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: var(--white);
            border-radius: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
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
            font-weight: 600;
        }

        .empty-state p {
            font-size: 1.6rem;
            color: var(--light-color);
            margin-bottom: 2.5rem;
        }

        .empty-state .btn {
            padding: 1.2rem 2.5rem;
            font-size: 1.6rem;
            border-radius: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 600;
        }

        /* Debug Section */
        .debug-section {
            margin-top: 3rem;
        }

        .debug-section .card {
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .debug-section .card-header {
            background: rgba(125, 125, 235, 0.1);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 1rem 1rem 0 0;
            padding: 1.5rem;
        }

        .debug-section .card-header h5 {
            font-size: 1.6rem;
            color: var(--black);
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .debug-section .card-header h5 i {
            color: var(--blue);
        }

        .debug-section .card-body {
            padding: 2rem;
        }

        .debug-section .card-body h6 {
            font-size: 1.4rem;
            color: var(--black);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .debug-section .card-body ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .debug-section .card-body li {
            padding: 0.5rem 0;
            font-size: 1.3rem;
            color: var(--light-color);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .debug-section .card-body li:last-child {
            border-bottom: none;
        }

        .debug-section .card-body strong {
            color: var(--black);
        }

        /* Bootstrap Overrides */
        .btn {
            transition: all 0.3s ease;
            border: none;
            font-weight: 500;
        }

        .btn:focus {
            box-shadow: 0 0 0 3px rgba(125, 125, 235, 0.3);
        }

        .btn i {
            font-size: 1.4rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-main {
                margin-left: 0;
                padding: 1.5rem;
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
                background: var(--white);
                padding: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 2rem;
            }

            .header-actions {
                width: 100%;
                justify-content: space-between;
            }

            .page-title {
                font-size: 2.4rem;
            }

            .patient-header {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .patient-avatar-large {
                width: 6rem;
                height: 6rem;
                font-size: 2rem;
            }

            .patient-details-grid {
                grid-template-columns: 1fr;
            }

            .recommendations-grid {
                grid-template-columns: 1fr;
            }

            .component-footer {
                flex-direction: column;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .patient-meta {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 576px) {
            .patient-overview-card {
                padding: 2rem;
            }

            .component-content {
                padding: 1.5rem;
            }

            .component-header {
                padding: 1.5rem;
            }

            .component-footer {
                padding: 0 1.5rem 1.5rem;
            }

            .alert-warning-custom {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Animation for loading states */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .component-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Print Styles */
        @media print {
            .sidebar-toggle,
            .header-actions,
            .component-footer,
            .debug-section {
                display: none !important;
            }

            .dashboard-main {
                margin-left: 0;
            }

            .dashboard-sidebar {
                display: none;
            }

            .component-card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
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
                    <li class="{{ request()->routeIs('admin.profile.view') ? 'active' : '' }}">
                        <a href="{{ route('admin.profile.view') }}">
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
                            <i class="fas fa-user-injured"></i>
                            <span>Patient List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.doctor.doctorlist') }}">
                            <i class="fas fa-user-md"></i>
                            <span>Doctor List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.medical.list') }}">
                            <i class="fas fa-file-medical-alt"></i>
                            <span>Patient Medical Record</span>
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
                    <li>
                        <a href="{{ route('admin.reminder.list') }}">
                            <i class="fas fa-bell"></i>
                            <span>Appointment Reminders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.component.create') }}">
                            <i class="fas fa-cogs"></i>
                            <span>Component Devices</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{ route('admin.recommendation', ['patientId' => 1]) }}">
                            <i class="fas fa-lightbulb"></i>
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
                    <h2 class="page-title">
                        <i class="fas fa-robot"></i>
                        Prosthetic Recommendations
                    </h2>
                    <p class="page-subtitle">AI-Powered Component Suggestions</p>
                </div>
                <div class="header-right">
                    <div class="header-actions">
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="fas fa-print"></i> Print Report
                        </button>
                        <button class="btn btn-primary" onclick="generateNewRecommendations()">
                            <i class="fas fa-sync-alt"></i> Regenerate
                        </button>
                    </div>
                </div>
            </div>

            <div class="dashboard-content">
                <!-- Patient Info Card -->
                <div class="patient-overview-card">
                    <div class="patient-header">
                        <div class="patient-avatar-large">
                            {{ strtoupper(substr($patient->name ?? $patient->patientName ?? 'P', 0, 2)) }}
                        </div>
                        <div class="patient-title-info">
                            <h3 class="patient-name">{{ $patient->name ?? $patient->patientName ?? 'Unknown Patient' }}</h3>
                            <p class="patient-subtitle">Prosthetic Component Analysis</p>
                            <div class="patient-meta">
                                <span class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    Generated: {{ date('M d, Y') }}
                                </span>
                                <span class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    {{ date('g:i A') }}
                                </span>
                                @if(isset($matching_criteria))
                                <span class="meta-item">
                                    <i class="fas fa-cog"></i>
                                    K-Level: {{ $matching_criteria['k_level'] ?? 'N/A' }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="recommendation-badge">
                            <i class="fas fa-lightbulb"></i>
                            <span>AI Powered</span>
                        </div>
                    </div>

                    <!-- Data Completeness Alert -->
                    @php
                        $missingFields = [];
                        if (empty($patient->gender)) $missingFields[] = 'Gender';
                        if (empty($patient->weight) && empty($patient->bmi)) $missingFields[] = 'Weight/BMI';
                        if (empty($patient->age)) $missingFields[] = 'Age';
                        if (empty($patient->amputation_level)) $missingFields[] = 'Amputation Level';
                        if (empty($patient->k_level)) $missingFields[] = 'K-Level';
                    @endphp
                    @if(count($missingFields) > 0)
                        <div class="alert alert-warning-custom">
                            <div class="alert-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-content">
                                <h5>Incomplete Patient Data</h5>
                                <p>Missing: {{ implode(', ', $missingFields) }}. Recommendations may be less accurate.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Patient Details Grid -->
                    <div class="patient-details-grid">
                        <div class="detail-card">
                            <div class="detail-icon"><i class="fas fa-user"></i></div>
                            <div class="detail-content">
                                <label>Patient Name</label>
                                <span>{{ $patient->name ?? $patient->patientName ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-icon"><i class="fas fa-birthday-cake"></i></div>
                            <div class="detail-content">
                                <label>Age</label>
                                <span>{{ $patient->age ?? '-' }} years</span>
                            </div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-icon"><i class="fas fa-venus-mars"></i></div>
                            <div class="detail-content">
                                <label>Gender</label>
                                <span>{{ $patient->gender ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-icon"><i class="fas fa-weight"></i></div>
                            <div class="detail-content">
                                <label>Weight / BMI</label>
                                <span>
                                    @if($patient->weight ?? false)
                                        {{ $patient->weight }} kg
                                    @elseif($patient->bmi ?? false)
                                        BMI: {{ number_format($patient->bmi, 1) }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-icon"><i class="fas fa-cut"></i></div>
                            <div class="detail-content">
                                <label>Amputation Level</label>
                                <span>{{ $patient->amputation_level ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-icon"><i class="fas fa-running"></i></div>
                            <div class="detail-content">
                                <label>Activity Level (K-Level)</label>
                                <span>{{ $patient->k_level ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-icon"><i class="fas fa-chart-bar"></i></div>
                            <div class="detail-content">
                                <label>BLART Score</label>
                                <span>{{ $patient->blart_score ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="detail-card">
                            <div class="detail-icon"><i class="fas fa-heartbeat"></i></div>
                            <div class="detail-content">
                                <label>Health Condition</label>
                                <span>{{ $patient->health_condition ?? $patient->reasonAmputation ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations Section -->
                <div class="recommendations-section">
                    <div class="section-header">
                        <h4>
                            <i class="fas fa-cogs"></i>
                            Recommended Components
                        </h4>
                        <span class="component-count">
                            {{ isset($recommendations) && is_array($recommendations) ? count($recommendations) : '0' }} Components Found
                        </span>
                    </div>

                    <div class="recommendations-grid">
                        @if(isset($recommendations) && is_array($recommendations) && count($recommendations) > 0)
                            @foreach($recommendations as $componentType => $component)
                                @if($component)
                                <div class="component-card">
                                    <div class="component-header">
                                        <div class="component-icon">
                                            @switch($componentType)
                                                @case('Foot Type')
                                                    <i class="fas fa-shoe-prints"></i>
                                                    @break
                                                @case('Knee Mechanism')
                                                    <i class="fas fa-cogs"></i>
                                                    @break
                                                @case('Socket Type')
                                                    <i class="fas fa-circle"></i>
                                                    @break
                                                @case('Pylon/Tube')
                                                @case('Pylon')
                                                    <i class="fas fa-grip-lines-vertical"></i>
                                                    @break
                                                @case('Adapter')
                                                    <i class="fas fa-plug"></i>
                                                    @break
                                                @case('Suspension System')
                                                    <i class="fas fa-link"></i>
                                                    @break
                                                @case('Terminal Device')
                                                    <i class="fas fa-hand-paper"></i>
                                                    @break
                                                @case('Elbow Unit')
                                                    <i class="fas fa-joint"></i>
                                                    @break
                                                @case('Wrist Unit')
                                                    <i class="fas fa-hand-rock"></i>
                                                    @break
                                                @case('Cable System')
                                                    <i class="fas fa-rope-way"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-puzzle-piece"></i>
                                            @endswitch
                                        </div>
                                        <div class="component-badge">
                                            {{ $componentType }}
                                        </div>
                                    </div>
                                    <div class="component-content">
                                        <h5 class="component-name">
                                            {{ $component->name ?? 'Component Name' }}
                                        </h5>
                                        <div class="component-specs">
                                            @if($component->material ?? false)
                                            <div class="spec-item">
                                                <i class="fas fa-cube"></i>
                                                <span><strong>Material:</strong> {{ $component->material }}</span>
                                            </div>
                                            @endif
                                            @if($component->size ?? false)
                                            <div class="spec-item">
                                                <i class="fas fa-ruler"></i>
                                                <span><strong>Size:</strong> {{ $component->size }}</span>
                                            </div>
                                            @endif
                                            @if($component->type ?? false)
                                            <div class="spec-item">
                                                <i class="fas fa-tag"></i>
                                                <span><strong>Type:</strong> {{ $component->type }}</span>
                                            </div>
                                            @endif
                                            @if($component->compatibility ?? false)
                                            <div class="spec-item">
                                                <i class="fas fa-link"></i>
                                                <span><strong>Compatibility:</strong> {{ $component->compatibility }}</span>
                                            </div>
                                            @endif
                                            
                                            {{-- FIXED: Updated weight display logic to use weight_min and weight_max --}}
                                            @if(($component->weight_min ?? false) || ($component->weight_max ?? false))
                                            <div class="spec-item">
                                                <i class="fas fa-weight-hanging"></i>
                                                <span><strong>Weight Range:</strong> 
                                                    @if($component->weight_min && $component->weight_max)
                                                        {{ $component->weight_min }} - {{ $component->weight_max }} kg
                                                    @elseif($component->weight_min)
                                                        ≥ {{ $component->weight_min }} kg
                                                    @elseif($component->weight_max)
                                                        ≤ {{ $component->weight_max }} kg
                                                    @endif
                                                </span>
                                            </div>
                                            @endif
                                            
                                            @if($component->klevel_range ?? false)
                                            <div class="spec-item">
                                                <i class="fas fa-running"></i>
                                                <span><strong>K-Level:</strong> {{ $component->klevel_range }}</span>
                                            </div>
                                            @endif
                                            
                                            {{-- FIXED: Updated age display logic to use age_min and age_max --}}
                                            @if(($component->age_min ?? false) || ($component->age_max ?? false))
                                            <div class="spec-item">
                                                <i class="fas fa-calendar-alt"></i>
                                                <span><strong>Age Range:</strong> 
                                                    @if($component->age_min && $component->age_max)
                                                        {{ $component->age_min }} - {{ $component->age_max }} years
                                                    @elseif($component->age_min)
                                                        ≥ {{ $component->age_min }} years
                                                    @elseif($component->age_max)
                                                        ≤ {{ $component->age_max }} years
                                                    @endif
                                                </span>
                                            </div>
                                            @endif
                                            
                                            {{-- FIXED: Updated BLART score display logic to use bscore_min and bscore_max --}}
                                            @if(($component->bscore_min ?? false) || ($component->bscore_max ?? false))
                                            <div class="spec-item">
                                                <i class="fas fa-chart-bar"></i>
                                                <span><strong>BLART Score:</strong> 
                                                    @if($component->bscore_min && $component->bscore_max)
                                                        {{ $component->bscore_min }} - {{ $component->bscore_max }}
                                                    @elseif($component->bscore_min)
                                                        ≥ {{ $component->bscore_min }}
                                                    @elseif($component->bscore_max)
                                                        ≤ {{ $component->bscore_max }}
                                                    @endif
                                                </span>
                                            </div>
                                            @endif
                                        </div>
                                        @if($component->description ?? false)
                                        <div class="component-description">
                                            <p>{{ $component->description }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="component-footer">
                                        <button class="btn btn-outline-primary btn-sm" onclick="showComponentDetails('{{ $component->compID ?? '' }}')">
                                            <i class="fas fa-info-circle"></i> Details
                                        </button>
                                        <button class="btn btn-primary btn-sm" onclick="addToPlan('{{ $component->compID ?? '' }}', '{{ $componentType }}')">
                                            <i class="fas fa-plus"></i> Add to Plan
                                        </button>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @else
                            <!-- No Recommendations Found -->
                            <div class="no-recommendations">
                                <div class="empty-state">
                                    <i class="fas fa-search"></i>
                                    <h3>No Suitable Components Found</h3>
                                    <p>
                                        @if(isset($patient->amputation_level) && isset($patient->k_level))
                                            No components match the criteria for {{ $patient->amputation_level }} amputation with K-Level {{ $patient->k_level }}.
                                        @else
                                            Please ensure patient data is complete and try generating recommendations again.
                                        @endif
                                    </p>
                                    <button class="btn btn-primary" onclick="generateNewRecommendations()">
                                        <i class="fas fa-sync-alt"></i> Regenerate Recommendations
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Debug Information -->
                @if(app('app')->environment('local') && isset($matching_criteria))
                <div class="debug-section mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-bug"></i> Debug Information</h5>
                        </div>
                        <div class="card-body">
                            <h6>Matching Criteria Used:</h6>
                            <ul>
                                <li><strong>Amputation Level:</strong> {{ $matching_criteria['amputation_level'] ?? 'N/A' }}</li>
                                <li><strong>Age:</strong> {{ $matching_criteria['age'] ?? 'N/A' }}</li>
                                <li><strong>Weight:</strong> {{ $matching_criteria['weight'] ?? 'N/A' }} kg</li>
                                <li><strong>K-Level:</strong> {{ $matching_criteria['k_level'] ?? 'N/A' }}</li>
                                <li><strong>BLART Score:</strong> {{ $matching_criteria['blart_score'] ?? 'N/A' }}</li>
                                <li><strong>BMI Category:</strong> {{ $matching_criteria['bmi_category'] ?? 'N/A' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- JS files -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const dashboardLayout = document.querySelector('.dashboard-layout');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    dashboardLayout.classList.toggle('sidebar-collapsed');
                });
            }

            // Animate component cards on load
            const componentCards = document.querySelectorAll('.component-card');
            componentCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        function generateNewRecommendations() {
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
            btn.disabled = true;

            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        function showComponentDetails(componentId) {
            console.log('Show details for component:', componentId);
            alert('Component details functionality to be implemented');
        }

        function addToPlan(componentId, componentType) {
            console.log('Add to plan:', componentId, componentType);
            
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Added';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-primary');
                btn.disabled = false;
            }, 2000);
        }
    </script>
</body>
</html>