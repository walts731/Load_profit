<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nav</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add your custom font design CSS here */
        .lts-label {
            font-family: 'YourFont', sans-serif; /* Replace 'YourFont' with your desired font */
            font-size: 16px; /* Adjust the font size as needed */
            font-weight: bold; /* You can adjust the font weight */
            color: #ffffff; /* Set the desired text color */
            margin-right: 20px; /* Adjust the spacing from the other links */
        }

        /* Additional styles for the navbar */
        .navbar {
            background: linear-gradient(135deg, #3498db, #9b59b6); /* Gradient background */
            padding: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: left;
            align-items: center;
        }

        /* Style for the logo */
        .navbar-logo {
            width: 40px; /* Adjust the width of the logo */
            height: 40px; /* Adjust the height of the logo */
            margin-right: 10px; /* Adjust the spacing between the logo and the links */
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar fixed-top navbar-light bg-gradient">
        <img class="navbar-logo" src="img/LTS.png" alt="Logo">
        <a class="nav-link lts-label" href="#">LTS</a>
        <a class="nav-link" href="index.php">Load Profit Tracker</a>
        <a class="nav-link" href="archive.php">Archive</a>
        <a class="nav-link" href="profit.php">Profit</a>
        <a class="nav-link" href="about.php">About</a>
    </nav>
</body>
</html>
