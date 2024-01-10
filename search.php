<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Existing styles for the search page */
        .unique-body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background: linear-gradient(to bottom, #a29bfe, #c7a3f0); /* Soft pastel blue-violet gradient */
}
 /* Linear gradient from blue to violet */


.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    color: #fff; /* Text color set to white */
}

.table th {
    background: linear-gradient(to bottom, #add8e6, #6bb2f0); /* Soft blue gradient */
}




/* Darker blue for the header background */


        .no-results {
            color: rgba(77, 77, 77, 0.8);
            text-align: center;
            margin-top: 100px;
            font-size: 1.5em;
            padding: 20px;
            border: 1px solid rgba(221, 221, 221, 0.8);
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, border-color 0.3s, color 0.3s;
            position: relative;
        }

        .walking-character {
            position: absolute;
            top: 50%;
            left: -20px; /* Adjust the starting position */
            transform: translateY(-50%);
            animation: walkAnimation 12s linear infinite; /* Adjust the duration */
        }

        .walking-character:nth-child(2) {
            animation-delay: 2s; /* Delay the start of the second character */
        }

        .walking-character:nth-child(3) {
            animation-delay: 4s; /* Delay the start of the third character */
        }

        @keyframes walkAnimation {
            0% {
                left: -20px; /* Adjust the starting position */
            }
            50% {
                left: calc(100% - 40px); /* Adjust the ending position */
                transform: scaleX(-1);
            }
            100% {
                left: -20px; /* Adjust the starting position */
                transform: scaleX(1);
            }
        }
        /* New style for the search message */
        .result-message {
    margin-top: 20px;
    padding: 10px;
    background-color: #cfe2f3; /* Soft blue background color */
    border: 1px solid #a4c9e5; /* Soft blue border color */
    border-radius: 5px;
    color: #31708f; /* Soft blue text color */
}


    .label-row {
        background-color: #9b59b6; /* Unique color for the label row */
        color: #fff; /* Text color set to white */
        font-weight: bold; /* Optional: Make the text bold */
    }";
    </style>
    <title>Search Results</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="unique-body">
    <?php
    // Include the navigation bar
    include('includes/nav.php');
    ?>

    <?php
    // Include the database connection
    include('includes/connect.php');

    // Include necessary files and connect to the database
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["searchKeyword"])) {
        $searchKeyword = $_GET["searchKeyword"];

        // Construct the SQL query with a WHERE clause for searching
        $searchQuery = "SELECT `id`, `capital`, `profit`, `transaction_date` FROM `archive_transactions` WHERE 
                        `capital` LIKE '%$searchKeyword%' OR
                        `profit` LIKE '%$searchKeyword%' OR
                        `transaction_date` LIKE '%$searchKeyword%'";

        // Execute the search query
        $searchResult = $conn->query($searchQuery);

        if ($searchResult->num_rows > 0) {
            // Display search results with result message
            echo "<div class='result-message mt-5'>Results for searched word: <strong style='color: #155724;'>$searchKeyword</strong></div>";
            echo "<table class='table mt-5'>";
            echo "<tr class='label-row'><th colspan='4'>Archive Transaction Details</th></tr>"; // Label row
            echo "<tr><th>Capital</th><th>Profit</th><th>Date</th></tr>"; // Header row

            while ($row = $searchResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["capital"] . "</td>";
                echo "<td>" . $row["profit"] . "</td>";
                echo "<td>" . $row["transaction_date"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";

        } else {
            echo "<div class='no-results'>No results found for: <strong>$searchKeyword</strong>. Please try again.";
            echo "<div class='walking-character'>&#128123;</div>";
            echo "<div class='walking-character'>&#128123;</div>";
            echo "<div class='walking-character'>&#128123;</div>";
            echo "</div>";
        }
    }
    ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include the additional JavaScript for interactions -->
   
</body>



</html>


<!-- Additional JavaScript for interactions -->
