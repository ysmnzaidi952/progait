<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait - Staff Approval</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Bootstrap CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<!-- Header Section -->
<header class="header fixed-top">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <a href="#home" class="logo">
                <img src="{{ asset('images/progait.png') }}" alt="ProGait Logo">
            </a>

            <nav class="nav">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#services">Service</a>
                <a href="#reviews">Reviews</a>
                <a href="#contact">Contact</a>
            </nav>

            <a href="{{ route('login') }}" class="link-btn">Log Out</a>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>
    </div>
</header>

<!-- Content Section -->
<section class="content-section">
    <div class="container">
        <div class="content-container">
            <h1 class="page-title">Pending Staff Registrations</h1>

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="approval-table">
                    <thead>
                        <tr>
                            <th>Staff ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingStaff as $staffMember)
                            <tr>
                                <td>{{ $staffMember->staffID }}</td>
                                <td>{{ $staffMember->staffName }}</td>
                                <td>{{ $staffMember->staffEmail }}</td>
                                <td>{{ $staffMember->staffRole }}</td>
                                <td><span class="status-pending">{{ $staffMember->status }}</span></td>
                                <td>
                                    <!-- Admin can approve -->
                                    <form action="{{ route('admin.approve-staff', ['staffID' => $staffMember->staffID]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="approve-btn">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(count($pendingStaff) == 0)
                <div class="text-center py-4">
                    <i class="fas fa-clipboard-check" style="font-size: 5rem; color: var(--light-color);"></i>
                    <p style="font-size: 1.8rem; color: var(--light-color); margin-top: 2rem;">
                        No pending staff registrations at the moment.
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- JS files -->
<script src="{{ asset('js/script.js') }}"></script>
<script src="https://unpkg.com/scrollreveal"></script>

<script>
    // Additional JavaScript for this page
    document.addEventListener('DOMContentLoaded', function() {
        // Animation for content container
        ScrollReveal().reveal('.content-container', {
            origin: 'top',
            distance: '50px',
            duration: 1000,
            delay: 200,
            easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
            reset: false
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

</body>
</html>