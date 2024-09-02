$(document).ready(function() {
  const checkInInput = document.getElementById('check-in');
  const checkOutInput = document.getElementById('check-out');
  const numStaysSpan = document.getElementById('num-stays');
  const selectedDatesSpan = document.getElementById('selected-dates');
  let checkInDate;

  checkInInput.addEventListener('change', updateNumStays);
  checkOutInput.addEventListener('change', updateNumStays);

  // Initialize FullCalendar after defining the event handlers
  initializeCalendar();

  window.addEventListener('scroll', function() {
    var navBar = document.querySelector('.nav-bar');
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > 0) {
      navBar.classList.add('scrolled');
    } else {
      navBar.classList.remove('scrolled');
    }
  });
  
  function formatDate(date) {
    var year = date.getFullYear();
    var month = ("0" + (date.getMonth() + 1)).slice(-2);
    var day = ("0" + date.getDate()).slice(-2);
    return year + "-" + month + "-" + day;
  }
  
  function updateNumStays() {
    const checkInDate = new Date(checkInInput.value);
    const checkOutDate = new Date(checkOutInput.value);
  
    if (isNaN(checkInDate) || isNaN(checkOutDate)) {
      numStaysSpan.textContent = '0';
      selectedDatesSpan.textContent = '';
    } else {
      const timeDiff = Math.abs(checkOutDate.getTime() - checkInDate.getTime());
      const numStays = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
      numStaysSpan.textContent = numStays.toString();
  
      const selectedDates = getSelectedDates(checkInDate, checkOutDate);
      selectedDatesSpan.textContent = selectedDates.join(', ');
    }
  }
  
  function getSelectedDates(checkInDate, checkOutDate) {
    const selectedDates = [];
    const currentDate = new Date(checkInDate);
  
    while (currentDate <= checkOutDate) {
      selectedDates.push(currentDate.toDateString());
      currentDate.setDate(currentDate.getDate() + 1);
    }
  
    return selectedDates;
  }
  
  function initializeCalendar() {
    $('#calendar').fullCalendar({
      header: {
        left: 'prev',
        center: 'title',
        right: 'next'
      },
      defaultDate: new Date(),
      editable: false,
      eventLimit: true,
      selectable: true,
      selectHelper: true,
      dayRender: function (date, cell) {
        var fullyBookedDate = moment('2023-05-27');
  
        if (date.isSame(fullyBookedDate, 'day')) {
          cell.css('background-color', '#FF0000');
          cell.css('color', '#FFFFFF');
        }
      },
      dayClick: function (date) {
        if (!checkInInput.value) {
          checkInInput.value = moment(date).format('YYYY-MM-DD');
        } else if (!checkOutInput.value) {
          checkOutInput.value = moment(date).format('YYYY-MM-DD');
        } else {
          checkInInput.value = moment(date).format('YYYY-MM-DD');
          checkOutInput.value = '';
        }
  
        updateNumStays();
  
        updateReservation();
      },
    });
  }
  
  initializeCalendar();
  
  // Reserve button functionality
  $("#reserve-btn").click(function () {
    // Get selected values from the form
    var selectedRoom = $("#room").val();
    var selectedAdults = $("#adults").val();
    var selectedChildren = $("#children").val();
    var enteredPromo = $("#promo").val();
  }); 

  // Clear button functionality
  $("#clear-btn").click(function () {
    $("#check-in").val("");
    $("#check-out").val("");
    $("#room").prop("selectedIndex", 0);
    $("#adults").prop("selectedIndex", 0);
    $("#children").prop("selectedIndex", 0);
    $("#promo").val("");
  });
});
