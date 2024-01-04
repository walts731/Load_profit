<?php
include('includes/connect.php');

if (isset($_GET['year']) && is_numeric($_GET['year'])) {
    $selectedYear = intval($_GET['year']);

    // Query to fetch data from archive_transactions table for the selected year
    $sql = "SELECT `id`, `capital`, `profit`, `transaction_date` FROM `archive_transactions` WHERE YEAR(`transaction_date`) = $selectedYear ORDER BY `transaction_date` DESC";

    // Execute the query
    $result = $conn->query($sql);

    // Display the transactions for the selected year
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Archive Transactions for $selectedYear</title>";
    echo "<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>";
    echo "</head>";
    echo "<body>";

    echo "<div class='container mt-5'>";
    
    // Include navigation or header if needed
    // include('includes/nav.php');
    
    echo "<h2>Archive Transactions for $selectedYear</h2>";

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table class='table'>";
            echo "<thead class='thead-light'>";
            echo "<tr><th>ID</th><th>Capital</th><th>Profit</th><th>Transaction Date</th></tr>";
            echo "</thead>";
            echo "<tbody>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["capital"] . "</td>";
                echo "<td>" . $row["profit"] . "</td>";

                // Format the transaction date
                $formattedDate = date("M-d-Y g:i A", strtotime($row["transaction_date"]));
                echo "<td>" . $formattedDate . "</td>";

                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No records found for $selectedYear";
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    // Free the result set
    $result->free_result();

    echo "</div>";

    // Add Bootstrap JS and Popper.js if needed
    echo "<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>";
    echo "<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js'></script>";
    echo "<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>";

    echo "</body>";
    echo "</html>";

} else {
    echo "Invalid year parameter";
}

// Close the database connection
$conn->close();
?>
