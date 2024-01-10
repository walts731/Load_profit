<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
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

            <!-- Column for balance -->
            <div class="col-md-6 mx-auto text-center mt-5">
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

                    // Fetch total capital
                    $totalCapitalResult = $conn->query("SELECT SUM(`capital`) AS totalCapital FROM `transactions`");
                    $totalCapital = $totalCapitalResult->fetch_assoc()["totalCapital"];

                    // Calculate remaining balance
                    $remainingBalance = $totalCapital - 1000;

                    echo "<div class='mb-3 mt-2'><h3>BALANCE</h3></div>";
                    echo '<div class="transparent-div">Total Capital: ₱' . $totalCapital . '</div>';
                    echo '<div class="transparent-div">Remaining Balance: ₱' . $remainingBalance . '</div>';

                    // Close connection
                    $conn->close();
                ?>
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
