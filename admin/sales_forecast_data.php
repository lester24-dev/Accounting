<?php
include('../layout/admin_nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-16 grid-margin stretch-card">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-description">
                    <?php 

                              $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['customer_id']."'");
                              $row_depts = $userRef->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <h4 class="card-title">Name: <?php echo $row_depts['name'] ?></h4>
                    <h4 class="card-title"><?php echo $_GET['title'] ?> Time Series Sale Forecast</h4>
                    </div>
                    <div>
                        <canvas id="forecastChart" width="800" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        // Fetch data from the PHP script
        fetch('fetch_firebase_data?transaction_id=<?php echo $_GET['transaction_id'] ?>')
            .then(response => response.json())
            .then(data => {
                const datasets = [];
                let labels = [];

                // Process each time series
                Object.keys(data).forEach(seriesName => {
                    const seriesData = data.map(item => item.seriesName);
                    const originalValues = data.map(item => item.original_value);
                    const forecastValues = data.map(item => item.forecast_value);

                    labels = data.map(item => item.seriesName); // Use one set of labels for all

                    // Add datasets for original and forecasted data
                    datasets.push({
                        label: `${seriesName} - Original`,
                        data: originalValues,
                        borderColor: getRandomColor(),
                        backgroundColor: 'rgba(0, 0, 255, 0.1)',
                        fill: true,
                        tension: 0.3,
                    });

                    datasets.push({
                        label: `${seriesName} - Forecast`,
                        data: forecastValues,
                        borderColor: getRandomColor(),
                        backgroundColor: 'rgba(255, 0, 0, 0.1)',
                        fill: true,
                        tension: 0.3,
                    });
                });

                const ctx = document.getElementById('forecastChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Multiple Time Series Forecasting with Firebase'
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });

        // Helper to generate random colors
        function getRandomColor() {
            return `rgb(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)})`;
        }
    </script>