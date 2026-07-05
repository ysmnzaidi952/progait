<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProGait</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- bootstrap cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

    <!-- custom css file link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>



<body>

    <!-- Back to Home Button -->
    <a href="{{ url('/') }}" class="back-to-home-btn">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Home</span>
    </a>

    <div class="login">
        <div class="container">
            <h1 class="form-title">Login</h1>

            @if(session('error'))
            <p style="color: red">{{ session('error') }}</p>
            @endif

            <form id="loginForm" action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="user-selection">
                    <label><input type="radio" name="role" value="admin" id="adminRadio"> Admin</label>
                    <label><input type="radio" name="role" value="patient" id="patientRadio" checked> Patient</label>
                    <label><input type="radio" name="role" value="staff" id="staffRadio"> Staff</label>
                    <label><input type="radio" name="role" value="doctor" id="doctorRadio"> Doctor</label>
                </div>

                <!-- Patient Login -->
                <div class="input-group">
                    <input type="text" name="ic" placeholder="IC Number (12-digit)">
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password">
                </div>

                <input type="submit" class="btn" value="Login">
            </form>
            <div class="links">
                <p>Don't have an account?
                    <a href="{{ route('patient.register') }}">Register Patient</a> |
                    <a href="{{ route('staff.register') }}">Register Staff</a> |
                    <a href="{{ route('doctor.register.show') }}">Register Doctor</a>
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Back to Home Button Styling */
        .back-to-home-btn {
            position: fixed;
            top: 2rem;
            left: 2rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            background-color: var(--blue);
            color: var(--white);
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 1.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(125, 125, 235, 0.3);
        }

        .back-to-home-btn:hover {
            background-color: var(--black);
            color: var(--white);
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(125, 125, 235, 0.4);
        }

        .back-to-home-btn i {
            font-size: 1.6rem;
        }

        /* Responsive styling for back button */
        @media (max-width: 768px) {
            .back-to-home-btn {
                top: 1.5rem;
                left: 1.5rem;
                padding: 0.8rem 1.2rem;
                font-size: 1.4rem;
            }
            
            .back-to-home-btn i {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 480px) {
            .back-to-home-btn span {
                display: none;
            }
            
            .back-to-home-btn {
                width: 4rem;
                height: 4rem;
                justify-content: center;
                padding: 0;
                border-radius: 50%;
            }
        }
    </style>

</body>

</html>