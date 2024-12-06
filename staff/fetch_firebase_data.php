<?php 
include("../db/db.php");

$stmt = $dbh->query("SELECT * FROM `time_series_forecasts` WHERE transaction_id = '".$_GET['transaction_id']."'");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return data as JSON for the front-end
header('Content-Type: application/json');
echo json_encode($data);

?> 