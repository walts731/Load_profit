// clock.js

function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var day = now.getDate();
    var month = now.getMonth() + 1; // Months are zero-based
    var year = now.getFullYear();

    // Format the time
    var timeString = addZeroPadding(hours) + ":" + addZeroPadding(minutes) + ":" + addZeroPadding(seconds);

    // Format the date
    var dateString = addZeroPadding(month) + "/" + addZeroPadding(day) + "/" + year;

    // Display the time and date in the clock container
    document.getElementById("clock").innerHTML = "<h2>" + timeString + "</h2><p>" + dateString + "</p>";

    // Update the clock every second
    setTimeout(updateClock, 1000);
}

function addZeroPadding(value) {
    return value < 10 ? "0" + value : value;
}

// Initial call to start the clock
updateClock();
