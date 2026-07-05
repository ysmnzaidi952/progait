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

<div class="register">
<div class="container">
    <h1 class="form-title">Register New Staff</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('staff.register.post') }}" method="POST">
        @csrf

        <div class="input-group">
            <input type="text" name="staffName" required  placeholder="Full Name">
        </div>

        <div class="input-group">
            <input type="text" name="staffIC" required placeholder="IC Number">
        </div>

        <div class="input-group">
            <input type="email" name="staffEmail" required placeholder="Email">
        </div>

        <div class="input-group">
            <input type="password" name="staffPass" required placeholder="Password">
        </div>

        <div class="input-group">
            <input type="text" name="staffTel" required placeholder="Phone Number">
        </div>

        <div class="input-group">
            <select name="staffRole" id="staffRole" required>
                <option value="" disabled selected hidden>Select Role</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <input type="submit" class="btn" value="Register Staff">

        <div class="links">
            <p>Already registered? <a href="{{ route('login') }}">Login here</a></p>
        </div>

    </form>
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