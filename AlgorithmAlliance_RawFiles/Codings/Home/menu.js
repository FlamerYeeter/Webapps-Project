const listLinks = document.querySelectorAll('#list');

  listLinks.forEach(link => {
    link.addEventListener('click', function(event) {
      event.preventDefault();
      listLinks.forEach(link => link.classList.remove('active'));
      this.classList.add('active');
    });
  });