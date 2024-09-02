
//For the DashBoard Guys
window.addEventListener('DOMContentLoaded', (event) => {
    const listItems = document.querySelectorAll('.board ul li');
    listItems.forEach(item => {
        item.addEventListener('click', () => {
            listItems.forEach(item => {
                item.classList.remove('clicked');
            });
            item.classList.add('clicked');
        });
    });
});

 // Function to fetch data from the server or database
 function fetchData(url) {
    // Perform an AJAX request or fetch API to get the data
    return fetch(url)
        .then(response => response.json())
        .catch(error => {
            console.error('Error:', error);
        });
}

// Function to update the monthly earnings box content
function updateMonthlyEarnings() {
    const monthlyEarningsValue = document.getElementById('monthly-earnings-value');
    fetchData('/getMonthlyEarnings')
        .then(data => {
            monthlyEarningsValue.textContent = data.monthlyEarnings;
        });
}

// Function to update the annual earnings box content
function updateAnnualEarnings() {
    const annualEarningsValue = document.getElementById('annual-earnings-value');
    fetchData('/getAnnualEarnings')
        .then(data => {
            annualEarningsValue.textContent = data.annualEarnings;
        });
}

// Function to update the bookings box content
function updateBookings() {
    const bookingsValue = document.getElementById('bookings-value');
    fetchData('/getBookings')
        .then(data => {
            bookingsValue.textContent = data.bookings + ' Bookings';
        });
}

// Function to update the visitors box content
function updateVisitors() {
    const visitorsValue = document.getElementById('visitors-value');
    fetchData('/getVisitors')
    .then(data => {
    visitorsValue.textContent = data.visitors + ' Visitors';
    });
    }

     // Call the update functions initially
     updateMonthlyEarnings();
     updateAnnualEarnings();
     updateBookings();
     updateVisitors();
 
     // Set interval to update the content every 1 minute (adjust the interval as needed)
     setInterval(() => {
         updateMonthlyEarnings();
         updateAnnualEarnings();
         updateBookings();
         updateVisitors();
     }, 60000);

     
     
        // JavaScript code for adding the 'clicked' class to the clicked link
        const links = document.querySelectorAll('.board ul li a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                links.forEach(link => link.classList.remove('clicked'));
                this.classList.add('clicked');
            });
        });
   


        // JavaScript code for navigating to the respective pages when clicked
const links = document.querySelectorAll('.board ul li a');
links.forEach(link => {
  link.addEventListener('click', function(event) {
    event.preventDefault();
    const href = this.getAttribute('href');
    if (href) {
      window.location.href = href;
    }
  });
});
