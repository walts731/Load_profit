<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .unique-body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
            height: 100vh;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

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

        @keyframes walkAnimation {
            0% {
                left: -20px; /* Adjust the starting position */
            }
            50% {
                left: calc(100% + 20px); /* Adjust the ending position */
                transform: scaleX(-1);
            }
            100% {
                left: -20px; /* Adjust the starting position */
                transform: scaleX(1);
            }
        }
    </style>
    <title>Search Results</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="unique-body">
<?php
include('includes/nav.php');
?>
<?php
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
        // Display search results
        echo "<table class='table'>";
        echo "<tr><th>ID</th><th>Capital</th><th>Profit</th><th>Date</th></tr>";
        while ($row = $searchResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["capital"] . "</td>";
            echo "<td>" . $row["profit"] . "</td>";
            echo "<td>" . $row["transaction_date"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='no-results'>No results found. Please try again.<div class='walking-character'>&#128123;</div></div>";
    }
}
?>
<?php
include('includes/footer.php');
?>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
