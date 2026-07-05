document.addEventListener('DOMContentLoaded', function () {
    let menu = document.querySelector('#menu-btn');
    let navbar = document.querySelector('.header .nav');
    let header = document.querySelector('.header');

    if (menu) {
        menu.onclick = () => {
            menu.classList.toggle('fa-times');
            navbar.classList.toggle('active');
        };
    } else {
        console.error('Menu button not found!');
    }

    window.onscroll = () => {
        if (menu) {
            menu.classList.remove('fa-times');
            navbar.classList.remove('active');
        }

        if (window.scrollY > 0) {
            header.classList.add('active');
        } else {
            header.classList.remove('active');
        }
    };

   


    //Home Section - Animation from the Left
    ScrollReveal().reveal('.home .content', {
        origin: 'left',  
        distance: '80px',
        duration: 1500,
        delay: 300,
        easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
        reset: true
    });

    // //Other Sections - Animation from the Top
    ScrollReveal().reveal('.about .content, .about .image, .services .box, .process .box, .reviews .box', {
        origin: 'top',  
        distance: '80px',
        duration: 1500,
        delay: 300,
        easing: 'cubic-bezier(0.25, 0.1, 0.25, 1)',
        reset: true
    });

    const reviewContainer = document.querySelector('.reviews .box-container');
    const leftBtn = document.querySelector('.left-btn');
    const rightBtn = document.querySelector('.right-btn');

    if (leftBtn && rightBtn && reviewContainer) {
        leftBtn.addEventListener('click', () => {
            reviewContainer.scrollBy({ left: -reviewContainer.clientWidth, behavior: 'smooth' });
        });

        rightBtn.addEventListener('click', () => {
            reviewContainer.scrollBy({ left: reviewContainer.clientWidth, behavior: 'smooth' });
        });
    }

    

});
