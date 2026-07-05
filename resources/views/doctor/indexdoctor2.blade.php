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

<!-- header section start -->
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
                <a href="#contact">Collaboration</a>
            </nav>

            <a href="{{ route('doctor.indexdoctor') }}" class="link-btn">Dashboard</a>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>
    </div>
</header>
<!-- header section ends -->

<!-- home section starts -->
<section class="home" id="home">
    <div class="container">
        <div class="row min-vh-100 align-items-center">
            <div class="content text-center text-md-left">
                <h3>Let us make your life better.</h3>
                <p>At ProGait Prosthetics and Orthotics Centre, we understand that every person’s journey is different. That’s why we offer personalized solutions to meet each client’s unique needs. <br><br>
           
            </div>
        </div>
    </div>
</section>
<!-- home section ends -->

<!-- about section start -->
<section class="about" id="about">
    <div class="container">
        <div class="row align-item-center">
            <div class="col-md-6 image">
                <img src="{{ asset('images/founder.jpg') }}" class="w-100 mb-4 mb-md-0" alt="">
            </div>

            <div class="col-md-6 content">
                <span>ProGait P&O Centre Sdn Bhd</span>
                <h3>Kaki Palsu Specialist Malaysia </h3>
                <p> ProGait Prosthetics and Orthotics Centre Sdn. Bhd. is a leading provider of personalized 
                    prosthetic and orthotic care in Malaysia. We create more than just devices, we restore 
                    mobility, confidence, and independence. Using advanced medical technology and 3D 
                    scanning, we design custom prosthetic limbs and orthotic devices focused on comfort, 
                    function, and durability. ProGait works closely with hospitals like Hospital Rehabilitasi
                     Cheras, Hospital Serdang, and Hospital Kajang to provide complete patient care from 
                     consultation to follow-up.<br><br>
             
            </div>
        </div>
    </div>
</section>
<!-- about section ends -->

<!-- service section start -->
<section class="services" id="services">
    <h1 class="heading">Our Service</h1>
    <div class="box-container container">
        <div class="box">
            <img src="{{ asset('images/prosthetic-hand.png') }}" alt="" style="width: 17%; height: auto;"> <br>
            <h3>Prosthetic and Orthotic Repairs</h3>
            <p>Ensures your devices stay in good condition through regular adjustments, repairs, and routine check-ups. This ongoing support helps maintain the performance, comfort, and durability of each device, making sure it continues to meet your needs over time.</p>
        </div>
        <div class="box">
            <img src="{{ asset('images/leg.png') }}" alt="" style="width: 17%; height: auto;"> <br>
            <h3>Custom Prosthetic and Orthotic Design</h3>
            <p>Focuses on creating personalized devices tailored to each patient’s specific needs. From consultation and assessment to measurement, design, fabrication, and fitting, every step ensures the device is comfortable, functional, and effective - helping to improve mobility, reduce discomfort, and enhance overall quality of life.</p>
        </div>
        
        <div class="box">
            <img src="{{ asset('images/physiotherapist.png') }}" alt="" style="width: 17%; height: auto;"> <br>
            <h3>Rehabilitation and Patient Education</h3>
            <p>Helps patients adjust to their new prosthetic or orthotic devices through training and useful resources. This support is essential for building confidence, improving function, and ensuring a smooth, successful transition to daily use.</p>
        </div>
    </div>
</section>
<!-- service section ends -->

<!-- process section starts -->
<section class="process">
    <h1 class="heading">Work Process</h1>
    <div class="box-container container">
        <div class="box">
            <img src="{{ asset('images/bed.png') }}" alt="">
            <h3>Patient Assessment and Evaluation            </h3>
            <p>This involves understanding the patient's medical 
            history, functional needs, and goals </p>
        </div>
        <div class="box">
            <img src="{{ asset('images/ortho.png') }}" alt="">
            <h3>Design and Material Selection  </h3>
            <p>The design must consider the patient’s functional needs, ensuring that the device provides the necessary support or mobility
 </p>
        </div>
        <div class="box">
            <img src="{{ asset('images/try.png') }}" alt="">
            <h3>Fabrication</h3>
            <p>Involved creating a plaster mold and modern methods use 3D scanning and printing to create a digital model that can be modified with precision</p>
        </div>
        <div class="box">
            <img src="{{ asset('images/jalan.png') }}" alt="">
            <h3>Fitting and Adjustment</h3>
            <p>This is a critical step to ensure the device meets the patient’s needs and fits comfortably</p>
        </div>
    </div>
</section>
<!-- process section end -->

<!-- reviews section start -->
<section class="reviews" id="reviews">
    <h1 class="heading">Satiesfied Clients</h1>

    <div class="reviews-wrapper">
        <button class="scroll-btn left-btn"><i class="fas fa-chevron-left"></i></button>

    <div class="box-container container">
    <div class="box">
    <p>ProGait provided me with the perfect orthotic fit. The comfort and mobility it offers is beyond expectations!</p>
    <div class="stars">
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
    </div>
    <h2>Nadiah Harun</h2>

</div>

<div class="box">
    <p>From consultation to fitting, the staff were kind and professional. Highly recommend their personalized service.</p>
    <div class="stars">
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
    </div>
    <h2>Ammar Zulkifli</h2>
   
</div>

<div class="box">
    <p>Excellent rehab support! They helped me regain confidence after my surgery. Friendly and knowledgeable team.</p>
    <div class="stars">
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
    </div>
    <h2>Suhaila Yusof</h2>
   
</div>

<div class="box">
    <p>My son’s prosthetic leg was custom-fitted here. It fits perfectly and he’s back to school with full confidence!</p>
    <div class="stars">
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
    </div>
    <h2>Hafiz Ramlee</h2>
  
</div>

<div class="box">
    <p>I had doubts at first, but ProGait really delivers. The team knows what they’re doing — thank you for everything!</p>
    <div class="stars">
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="fas fa-star"></i>
    </div>
    <h2>Rabiatul Adawiyah</h2>
 
</div>

<div class="box">
    <p>The best prosthetic care I’ve experienced. The clinic is well-equipped and follow-ups are consistent and helpful.</p>
    <div class="stars">
        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
    </div>
    <h2>Akmal Firdaus</h2>
  
</div>

    <button class="scroll-btn right-btn"><i class="fas fa-chevron-right"></i></button>
    </div>

    

</section>
<!-- reviews section ends -->

<!-- contact section starts -->
<section class="contact" id="contact">
    <h1 class="heading">Collaboration With Maybank</h1>
    
    <div class="video-container">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/YwwRH5U2w38?si=yXnoYbzhruFHxT-Z" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
        
</section>
<!-- contact section ends -->

<!-- footer section start -->
<section class="footer">

    <div class="box-container container">

        <div class="box">
            <img src="{{ asset('images/progait.png') }}" alt="ProGait Logo" class="footer-logo">
            <div class="footer-socials">
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com/share/161ah6VqVy/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div class="box">
            <i class="fas fa-phone"></i>
            <h3>Phone Number</h3>
            <p>+601133177268</p>
            <p>+601234573454</p>
        </div>
        <div class="box">
            <i class="fas fa-map-marker-alt"></i>
            <h3>Our Address</h3>
            <p>Kuala Lumpur</p>
        </div>
        <div class="box">
            <i class="fas fa-clock"></i>
            <h3>Opening Hours</h3>
            <p>07:00am to 17:00pm</p>
        </div>
        <div class="box">
            <i class="fas fa-envelope"></i>
            <h3>Email Address</h3>
            <p>progait@gmail.com</p>
            <p>zulfadzli@gmail.com</p>
        </div>
    </div><br><br>
</section>

<!-- copyright section -->
<div class="copyright">
    &copy; copyright @ {{ date('Y') }} by <a href="#">ProGait Prosthetics & Orthotics Sdn Bhd</a>
</div>

<!-- footer section ends -->


<!-- JS files -->
<script src="{{ asset('js/script.js') }}"></script>
<script src="https://unpkg.com/scrollreveal"></script>

</body>
</html>
