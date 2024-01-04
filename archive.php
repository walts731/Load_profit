<?php
    include('includes/connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive Transactions</title>

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="archive.css">
</head>
<body>
    <?php
        include('includes/nav.php');
    ?>
    <div class="container" style="margin-top: 80px;">
        <h2 class="mt-3">Archive Transactions</h2>

        <?php
        // Query to fetch data from archive_transactions table, ordered by year
        $sql = "SELECT `id`, `capital`, `profit`, `transaction_date` FROM `archive_transactions` ORDER BY YEAR(`transaction_date`) DESC";

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are rows returned
        if ($result->num_rows > 0) {
            $currentYear = null;

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Get the year from the transaction date
                $year = date("Y", strtotime($row["transaction_date"]));

                // If the year changes, create a new section or folder
                if ($year != $currentYear) {
                    // Close the previous section if it exists
                    if ($currentYear !== null) {
                        echo "</tbody>";
                        echo "</table>";
                    }

                    // Start a new section or folder for the current year
                    echo "<h3 class='mt-3'>$year</h3>";
                    echo "<table class='table'>";
                    echo "<thead class='thead-light'>";
                    echo "<tr><th>ID</th><th>Capital</th><th>Profit</th><th>Transaction Date</th></tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    // Update the current year
                    $currentYear = $year;
                }

                // Output the transaction data within the current section or folder
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["capital"] . "</td>";
                echo "<td>" . $row["profit"] . "</td>";

                // Format the transaction date
                $formattedDate = date("M-d-Y g:i A", strtotime($row["transaction_date"]));
                echo "<td>" . $formattedDate . "</td>";

                echo "</tr>";
            }

            // Close the last section or folder
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No records found";
        }

        // Close the database connection
        $conn->close();
        ?>

    </div>

    <?php
        include('includes/footer.php');
    ?>

    <!-- Add Bootstrap JS and Popper.js if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
