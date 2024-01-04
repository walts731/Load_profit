<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit Tracker</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row mt-4">
            <?php
                include('includes/nav.php');
            ?>
            <!-- Column for transactions -->
            <div class="col-md-3 mt-5">
                <!-- Add Bootstrap styling to the table -->
                <div class="table-responsive">
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "12345";
                    $database = "load_profit";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Handle form submission
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $capital = $_POST["capital"];
                        $profit = $_POST["profit"];
                        $transactionDate = date("Y-m-d H:i:s"); // Current date and time

                        // Insert data into the database
                        $insertQuery = "INSERT INTO transactions (capital, profit, transaction_date) VALUES ('$capital', '$profit', NOW())";

                        if ($conn->query($insertQuery) === TRUE) {
                            echo "<script>alert('New record added successfully');</script>"; 

                            // Check if total capital has reached 1000
                            $totalCapitalResult = $conn->query("SELECT SUM(`capital`) AS totalCapital FROM `transactions`");
                            $totalCapital = $totalCapitalResult->fetch_assoc()["totalCapital"];

                            if ($totalCapital >= 1000) {
                                // Fetch total profit from the transactions table
                                $totalProfitResult = $conn->query("SELECT SUM(`profit`) AS totalProfit FROM `transactions`");
                                $totalProfit = $totalProfitResult->fetch_assoc()["totalProfit"];

                                // Insert data into archive_transactions table
                                $insertArchiveQuery = "INSERT INTO archive_transactions (capital, profit, transaction_date) SELECT capital, profit, transaction_date FROM transactions";

                                if ($conn->query($insertArchiveQuery) === TRUE) {
                                    // Insert total profit into profit table
                                    $insertProfitQuery = "INSERT INTO profit (amount, transaction_date) VALUES ('$totalProfit', NOW())";

                                    if ($conn->query($insertProfitQuery) === TRUE) {
                                        // Delete transaction data
                                        $deleteQuery = "DELETE FROM transactions";
                                        if ($conn->query($deleteQuery) === TRUE) {
                                            echo "<script>alert('Data archived, profit inserted, and transactions data deleted.');</script>";
                                        } else {
                                            echo "Error deleting transactions data: " . $conn->error;
                                        }
                                    } else {
                                        echo "Error inserting profit: " . $conn->error;
                                    }
                                } else {
                                    echo "Error archiving data: " . $conn->error;
                                }
                            }

                        } else {
                            echo "Error adding record: " . $conn->error;
                        }
                    }

                    // Fetch and display data from the database in ascending order based on transaction_date
                    $result = $conn->query("SELECT `id`, `capital`, `profit`, (`capital` + `profit`) AS `total`, `transaction_date` FROM `transactions` ORDER BY `transaction_date` ASC");

                    if ($result->num_rows > 0) {
                        echo "<table class='table'>";
                        echo "<tr><th>Capital</th><th>Profit</th><th>Total</th><th>Date</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style='font-size: small;'>₱" . $row["capital"] . "</td>"; // Displayed currency changed to peso
                            echo "<td style='font-size: small;'>₱" . $row["profit"] . "</td>"; // Displayed currency changed to peso
                            echo "<td style='font-size: small;'>₱" . $row["total"] . "</td>"; // Displayed currency changed to peso
                            echo "<td style='font-size: small;'>" . date("m-d-y", strtotime($row["transaction_date"])) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<div class='col-md-7 mt-5 position-relative'>";
                        echo "<div class='alert alert-primary text-center w-100 position-sticky top-0' role='alert' style='z-index: 100;'>";
                        echo "No transactions found.";
                        echo "</div>";
                        echo "</div>";
                    }
                    

                    // Close connection
                    $conn->close();
                    ?>

                </div>
            </div>

            <!-- Column for totals -->
            <div class="col-md-3 d-flex align-items-center">
                <div class="totals p-3 rounded">
                    <?php
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch and display total data
                    $totalCapitalResult = $conn->query("SELECT SUM(`capital`) AS totalCapital FROM `transactions`");
                    $totalProfitResult = $conn->query("SELECT SUM(`profit`) AS totalProfit FROM `transactions`");
                    $totalResult = $conn->query("SELECT SUM(`capital` + `profit`) AS overallTotal FROM `transactions`"); // Added line for overall total
                    $totalCapital = $totalCapitalResult->fetch_assoc()["totalCapital"];
                    $totalProfit = $totalProfitResult->fetch_assoc()["totalProfit"];
                    $overallTotal = $totalResult->fetch_assoc()["overallTotal"]; // Added line for overall total

                    echo "<div class='mb-3 mt-2 text-center'><h3>TOTALS</h3></div>";
                    echo '<div class="transparent-div">Total Capital: ₱' . $totalCapital . '</div>';
                    echo '<div class="transparent-div">Total Profit: ₱' . $totalProfit . '</div>';
                    echo '<div class="transparent-div">Overall Total: ₱' . $overallTotal . '</div>';

                    // Close connection
                    $conn->close();
                    ?>
                </div>
            </div>

            <!-- Column for profit table -->
            <div class="col-md-3">
                <!-- Add Bootstrap styling to the table -->
                <div class="table-responsive">
                <?php
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch and display data from profit table
                    $profitResult = $conn->query("SELECT `id`, `amount`, `transaction_date` FROM `profit`");

                    if ($profitResult->num_rows > 0) {
                        // Fetch and display data from the database in ascending order based on transaction_date
                        $profitResult = $conn->query("SELECT `amount`, `transaction_date` FROM `profit` ORDER BY `transaction_date` ASC");
                    
                        echo "<div class='mb-3 mt-5 text-center'><h3>PROFIT</h3></div>"; 
                        echo "<div style='overflow-x: auto; margin-top: 20px;'>";
                        echo "<table class='table'>";
                        echo "<thead style='position: sticky; top: 0; background-color: white;'>";
                        echo "<tr><th>Amount</th><th>Date</th></tr>";
                        echo "</thead>";
                        echo "<tbody>";
                    
                        while ($row = $profitResult->fetch_assoc()) {
                            $formattedDate = date("D, M j, Y", strtotime($row["transaction_date"])); // Format the date
                            echo "<tr>";
                            echo "<td>₱" . $row["amount"] . "</td>"; // Displayed currency changed to peso
                            echo "<td>" . $formattedDate . "</td>";
                            echo "</tr>";
                        }
                    
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "<div class='col-md-7 mt-5 position-relative'>";
                        echo "<div class='alert alert-primary text-center w-100 position-sticky top-0' role='alert' style='z-index: 100;'>";
                        echo "No profit records found.";
                        echo "</div>";
                        echo "</div>";
                    }
                    
                    
                    
                    // Close connection
                    $conn->close();
                ?>
                </div>
            </div>

            <!-- Column for form -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <!-- Form content -->
                            <div class="form-group">
                                <label for="capital">Enter Capital (₱):</label>
                                <input type="number" class="form-control" name="capital" required>
                            </div>
                            <div class="form-group">
                                <label for="profit">Enter Profit (₱):</label>
                                <input type="number" class="form-control" name="profit" required>
                            </div>
                            <button type="submit" class="styled-btn btn btn-success btn-block">Add Capital and Profit</button>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php
        include('includes/footer.php');
    ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Your existing JavaScript links -->
    <script src="js/bootstrap.js"></script>
    <script src="chart.js"></script>
</body>
</html>
