window.addEventListener('scroll', function() {
    var header = document.querySelector('.header');
    var navBar = document.querySelector('.nav-bar');
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  
    if (scrollTop > 0) {
      navBar.classList.add('scrolled');
    } else {
      navBar.classList.remove('scrolled');
    }
  });