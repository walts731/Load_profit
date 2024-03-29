<?php
include('includes/connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yearly Profit Chart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        .label{
            margin-top: 150px;
        }
    </style>
</head>
<body>
<?php
include('includes/nav.php');
?>
<div class="container">
    <h2 class="label text-center ">Yearly Profit Chart</h2>
    <?php
    include('includes/clock.php');
    ?>

    <?php
    // Fetch yearly profit data
    $yearlyProfitResult = $conn->query("SELECT YEAR(`transaction_date`) AS year FROM `profit` GROUP BY year");

    while ($yearRow = $yearlyProfitResult->fetch_assoc()) {
        $year = $yearRow['year'];

        // Fetch monthly profit data for the current year
        $monthlyProfitData = array();
        $monthlyProfitResult = $conn->query("SELECT MONTH(`transaction_date`) AS month, SUM(`amount`) AS totalProfit FROM `profit` WHERE YEAR(`transaction_date`) = $year GROUP BY month");

        while ($row = $monthlyProfitResult->fetch_assoc()) {
            $monthlyProfitData[$row['month']] = $row['totalProfit'];
        }

        // Calculate total monthly profit for the current year
        $totalMonthlyProfit = array_sum($monthlyProfitData);
        ?>
        <!-- Chart container for the current year -->
        <h3 class="text-center mt-3"><?php echo $year; ?> - Total Monthly Profit: ₱<?php echo number_format($totalMonthlyProfit, 2); ?></h3>
        <canvas id="profitChart<?php echo $year; ?>" width="400" height="200"></canvas>

        <script>
            // JavaScript to render the Chart for the current year
            var ctx<?php echo $year; ?> = document.getElementById('profitChart<?php echo $year; ?>').getContext('2d');
            var profitChart<?php echo $year; ?> = new Chart(ctx<?php echo $year; ?>, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                        label: 'Total Profit (₱)',
                        data: <?php echo json_encode(array_values($monthlyProfitData)); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        <?php
    }
    // Close connection
    $conn->close();
    ?>
</div>
<?php
include('includes/footer.php');
?>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
