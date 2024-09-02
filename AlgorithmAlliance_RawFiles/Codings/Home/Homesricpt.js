
//code for  rooms carousel
window.addEventListener('DOMContentLoaded', function() {
    let images = Array.from(document.getElementsByClassName('imgcarousel'));
    let mainPhoto = document.getElementById('Mainphoto');
    let caption = document.getElementById('caption');
    
    // Set the initial caption
    caption.innerHTML = images[0].getAttribute('name');
    
    // Add click event listeners to the images
    images.forEach(function(image) {
      image.addEventListener('mouseover', function() {
        let name = image.getAttribute('name');
        mainPhoto.src = image.src;
        caption.innerHTML = name;
      });
    });
  });


  // code for customeer gallery
document.addEventListener("DOMContentLoaded", function() {
  var mySwiper = new Swiper('.Ccarousel .customerCarousel', {
    slidesPerView: 3,
    spaceBetween: 10,
    navigation: {
      prevEl: '.Ccarousel .ArrowLeft',
      nextEl: '.Ccarousel .ArrowRight'
    }
  });
});


// function toggleMenu() {
//   var menu = document.querySelector('.menu');
//   menu.classList.toggle('show');
// }


window.addEventListener('scroll', function() {
    var navBar = document.querySelector('.nav-bar');
    var logoIcon = document.querySelector('.logo-item img');
    
    if (window.scrollY > 0) {
        navBar.classList.add('scrolled');
        logoIcon.src = '/path/to/scrolled-logo.png';
    } else {
        navBar.classList.remove('scrolled');
        logoIcon.src = '/Company Logo.png';
    }
});


document.addEventListener('DOMContentLoaded', function() {
  const tglBtn = document.querySelector('.tglBtn');

  window.addEventListener('scroll', function() {
    if (window.scrollY > 0) {
      tglBtn.style.color = '#000000'; // Change the color to black
    } else {
      tglBtn.style.color = ''; // Revert to the default color
    }
  });
});


// document.addEventListener('DOMContentLoaded', function() {
//   const tglBtn = document.querySelector('.tglBtn');
//   const btnIcon = tglBtn.querySelector('i');
//   const ddm = document.querySelector('.dropdown_menu');

//   tglBtn.addEventListener('click', function() {
//     ddm.classList.toggle('open');
//     const isOpen = ddm.classList.contains('open');

//     if (isOpen) {
//       btnIcon.className = 'fa-solid fa-times';
//     } else {
//       btnIcon.className = 'fa-solid fa-bars';
//     }
//   });

//   window.addEventListener('scroll', function() {
//     if (window.scrollY > 0) {
//       ddm.style.top = window.scrollY + 'px';
//     } else {
//       ddm.style.top = '';
//     }
//   });
// });
