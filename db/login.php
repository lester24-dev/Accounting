<?php
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
session_start();
error_reporting(0);

try {
	$dbh = new PDO('mysql:host=localhost;dbname=gcm;charset=utf8mb4','root','');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	die($e->getMessage());
}

try {
    // $email = $_POST['email'];
    // $password = $_POST['password'];

    $input = json_decode(file_get_contents('php://input'), true);

    $email = $input['email'];
    $password = $input['password'];

$select = $dbh->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
$userData = $select->fetch(PDO::FETCH_ASSOC);
if ($userData['department'] == 'Company Staff' ) {
    $_SESSION['id'] = $userData['id'];
    $_SESSION['name'] = $userData['name'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['password'] = $userData['password'];
    $_SESSION['department'] = $userData['department'];
    $_SESSION['customer_dept'] = $userData['customer_dept'];
    $_SESSION['profile_img'] = $userData['profile_img'];
    $_SESSION['bir'] = $userData['bir'];
    $_SESSION['dti'] = $userData['dti'];
    $_SESSION['mayors_permit'] = $userData['mayors_permit'];
    $_SESSION['sec'] = $userData['sec'];
    // echo '<script>window.location.href="../staff/dashboard"</script>';
    echo json_encode(['success' => true, 'url' => 'staff/dashboard']);
}elseif ($userData['department'] == 'Company Customer') {
    $_SESSION['id'] = $userData['id'];
    $_SESSION['name'] = $userData['name'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['password'] = $userData['password'];
    $_SESSION['customer_dept'] = $userData['customer_dept'];
    $_SESSION['department'] = $userData['department'];
    $_SESSION['profile_img'] = $userData['profile_img'];
    $_SESSION['bir'] = $userData['bir'];
    $_SESSION['dti'] = $userData['dti'];
    $_SESSION['mayors_permit'] = $userData['mayors_permit'];
    $_SESSION['sec'] = $userData['sec'];
    // echo '<script>window.location.href="../customer/dashboard"</script>';
    echo json_encode(['success' => true, 'url' => 'customer/dashboard']);

}elseif ($userData['department'] == 'Company Admin'){
    $_SESSION['id'] = $userData['id'];
    $_SESSION['name'] = $userData['name'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['password'] = $userData['password'];
    $_SESSION['customer_dept'] = $userData['customer_dept'];
    $_SESSION['department'] = $userData['department'];
    $_SESSION['profile_img'] = $userData['profile_img'];
    $_SESSION['bir'] = $userData['bir'];
    $_SESSION['dti'] = $userData['dti'];
    $_SESSION['mayors_permit'] = $userData['mayors_permit'];
    $_SESSION['sec'] = $userData['sec'];
    echo json_encode(['success' => true, 'url' => 'admin/dashboard']);
}else {
    echo json_encode(['success' => false, 'url' => '/admin/dashboard']);
}
} catch (\Throwable $th) {
  throw $th;
}
?>