<?php
include('../db/db.php');

$stmt = $dbh->query("SELECT * FROM department_notification WHERE status = 'unseen' AND department_id = '".$_SESSION['id']."'");
$rowCount = $stmt->rowCount();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCM Accounting Firm</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../vendors/feather/feather.css">
    <link rel="stylesheet" href="../vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css"/>
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/jquery-bar-rating/fontawesome-stars-o.css">
    <link rel="stylesheet" href="../vendors/jquery-bar-rating/fontawesome-stars.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- endinject -->
</head>
<body>

<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="background:#008000">
      <a class="navbar-brand brand-logo" href="../customer/dashboard" style="color:white;">GCM Accounting</a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend">
                <!-- <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span> -->
              </div>
              <!-- <input type="text" class="form-control" placeholder="Search Projects.." aria-label="search" aria-describedby="search"> -->
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">

          <li class="nav-item dropdown d-flex">
            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown" >
              <i class="icon-air-play mx-0"></i><span class="badge badge-danger" style="margin-bottom: 1vmax;">
              <?php 
              
              echo $rowCount;
              
              ?></span>
            </a>

            <?php 

if ($rowCount == 0) {
  echo '
  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
      <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
      <a class="dropdown-item preview-item">
      <div class="preview-thumbnail">
    
      </div>
      <div class="preview-item-content flex-grow">
        <h7 class="preview-subject ellipsis font-weight-normal">
        </h7>
        <p class="font-weight-light small-text text-muted mb-0">
      
        </p>
        <p class="font-weight-light small-text text-muted mb-0">
      
      </p>
      </div>
    </a>
  </div>
  </li>
  ';
} else if($rowCount <= 8){
    ?>
  <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
  <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
    <?php 

            $stmts = $dbh->query("SELECT * FROM department_notification WHERE status = 'unseen' AND department_id = '".$_SESSION['id']."'");

                          
            // Loop through the items to find the one with the matching name
            foreach ($stmts->fetchAll(PDO::FETCH_ASSOC) as $itemKey => $value) {

            if ($value['status'] == 'unseen') {
              if ($value['type'] == 'journal') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/journal-data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'ledger') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/ledger_data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'trial') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/trial_data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'cash') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/cash-flow-statement-data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }
              else {
                echo '
                <a class="dropdown-item preview-item" href="../db/db?rq_number='.$value['request_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }
           
            } else {
              if ($value['type'] == 'journal') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/journal-data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'ledger') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/ledger_data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'trial') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/trial_data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              } else if ($value['type'] == 'cash') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/cash-flow-statement-data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              } 
              else {
                echo '
                <a class="dropdown-item preview-item" href="../customer/journal-data?transaction_id='.$value['request_id'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }
            }
            
          }
          ?>
        </div>
      </li>
    <?php
}else {
  ?>

<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown" style="height:42vmax;overflow-y: auto;">
  <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
    <?php 

          $stmt = $dbh->query("SELECT * FROM department_notification WHERE status = 'unseen' AND department_id = '".$_SESSION['id']."'");

                                                        
          // Loop through the items to find the one with the matching name
          foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $itemKey => $value) {

            if ($value['status'] == 'unseen') {
              if ($value['type'] == 'journal') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/journal-data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'ledger') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/ledger_data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'trial') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/trial_data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'cash') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/cash-flow-statement-data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }
              else {
                echo '
                <a class="dropdown-item preview-item" href="../db/db?rq_number='.$value['request_id'].'&cmd=notif_admin&type='.$value['type'].'" style="background-color:green;color:white;">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }
           
            } else {
              if ($value['type'] == 'journal') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/journal-data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'ledger') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/ledger_data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }else if ($value['type'] == 'trial') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/trial_data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              } else if ($value['type'] == 'cash') {
                echo '
                <a class="dropdown-item preview-item" href="../customer/cash-flow-statement-data?transaction_id='.$value['request_id'].'&customer_id='.$value['department_id'].'&cmd=notif_admin&type='.$value['type'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              } 
              else {
                echo '
                <a class="dropdown-item preview-item" href="../customer/journal-data?transaction_id='.$value['request_id'].'">
                <div class="preview-thumbnail">
                <img src="../uploads/'.$value['profile_img'].'" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h7 class="preview-subject ellipsis font-weight-normal">'.$value['title'].'
                  </h7>
                 
                  <p class="small-text font-weight-light">
                  '.$value['timestamp'].'
                </p>
                </div>
                </a>
                ';
              }
            }
            
          }
          ?>
        </div>
      </li>
  <?php
}
            
           
            ?>

                   
          </li>
      
          <li class="nav-item dropdown d-flex mr-4 ">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Settings</p>
              <a class="dropdown-item preview-item" href="../customer/profile">               
                  <i class="icon-head"></i> Profile
              </a>
              <a class="dropdown-item preview-item" href="../login">
                  <i class="icon-inbox"></i> Logout
              </a>
            </div>
          </li>
         
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <div class="container-fluid page-body-wrapper">

    <nav class="sidebar sidebar-offcanvas" id="sidebar" style="background:#008000;">
        <div class="user-profile">
          <div class="user-image">
            <img src="../uploads/<?php echo $_SESSION["profile_img"]; ?>">
          </div>
          <div class="user-name">
              <?php echo $_SESSION['name']; ?>
          </div>
          <div class="user-designation">
          <?php echo $_SESSION["department"]; ?>
          </div>
        </div>
        <ul class="nav">

          <li class="nav-item">
            <a class="nav-link" href="../customer/dashboard">
              <i class="fa fa-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="../customer/profile">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Profile</span>
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="../customer/account">
              <i class="fa fa-table menu-icon"></i>
              <span class="menu-title">Account Table</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="../customer/journal-entry">
              <i class="fa fa-j menu-icon"></i>
              <span class="menu-title">Journal Entries</span>
            </a>
          </li>

          <li class="nav-item">
           <a class="nav-link" href="../customer/ledger">
             <i class="fa fa-l menu-icon"></i>
             <span class="menu-title">General Ledger</span>
           </a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="../customer/trial">
             <i class="fa fa-t"></i><i class="fa fa-b menu-icon"></i>
             <span class="menu-title">Trial Balance</span>
           </a>
         </li>

         <li class="nav-item">
           <a class="nav-link" href="../customer/cash-flow-statement">
             <i class="fa fa-c menu-icon"></i>
             <span class="menu-title">Cash Flow Statement</span>
           </a>
         </li>

         <li class="nav-item">
           <a class="nav-link" href="../customer/financial">
             <i class="fa fa-f menu-icon"></i>
             <span class="menu-title">Financial Statement</span>
           </a>
         </li>

         <li class="nav-item">
           <a class="nav-link" href="../customer/sales_forecast">
             <i class="fa fa-chart-line menu-icon"></i>
             <span class="menu-title">Sales Forecast</span>
           </a>
         </li>

         <li class="nav-item">
           <a class="nav-link" href="../customer/bir">
             <i class="fa fa-b menu-icon"></i>
             <span class="menu-title">BIR Form</span>
           </a>
         </li>

         <li class="nav-item">
           <a class="nav-link" href="../customer/tax?id=<?php echo $_SESSION['id'] ?>">
             <i class="fa fa-t menu-icon"></i>
             <span class="menu-title">Tax</span>
           </a>
         </li>

         <li class="nav-item">
           <a class="nav-link" href="../customer/ewt">
             <i class="fa fa-e menu-icon"></i>
             <span class="menu-title">EWT</span>
           </a>
         </li>
         
          <!-- <li class="nav-item">
            <a class="nav-link" href="../customer/transaction">
              <i class="icon-command menu-icon"></i>
              <span class="menu-title">Transaction List</span>
            </a>
          </li> -->
        
        
        </ul>
      </nav>





<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>
<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-analytics.js"></script>
<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-firestore.js"></script>  

<script src="../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../vendors/chart.js/Chart.min.js"></script>
  <script src="../vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>


