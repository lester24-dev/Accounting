<?php
include('../layout/nav_header.php');
$currentDate = new DateTime();
// Calculate the start date of the current week (assuming weeks start on Monday)
$currentDate->modify('this week');
$startDate = $currentDate->format('Y-m-d');

// Calculate the end date of the current week (assuming weeks end on Sunday)
$currentDate->modify('this week +5 days');
$endDate = $currentDate->format('Y-m-d');

$ref_journal = $dbh->query("SELECT * FROM journal WHERE staff_id = '".$_SESSION['id']."'");
$ref_journal_row = $ref_journal->rowCount();

$ref_ledger = $dbh->query("SELECT * FROM ledger WHERE staff_id = '".$_SESSION['id']."'");
$ref_ledger_row = $ref_ledger->rowCount();

$ref_trial = $dbh->query("SELECT * FROM trial WHERE staff_id = '".$_SESSION['id']."'");
$ref_trial_row = $ref_trial->rowCount();

$pending_ref_journal = $dbh->query("SELECT * FROM journal WHERE staff_id = '".$_SESSION['id']."' AND status = 'Pending'");
$pending_journal = $pending_ref_journal->rowCount();

$pending_ref_cash = $dbh->query("SELECT * FROM `cash-flow-statement` WHERE staff_id = '".$_SESSION['id']."' AND status = 'Pending'");
$pending_cash = $pending_ref_cash->rowCount();
?>

<!-- partial -->
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              <h4 class="font-weight-bold text-dark">Welcome back!</h4>
              <p class="font-weight-normal mb-2 text-muted"><?php echo date("Y-m-d"); ?></p>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
              <div class="row flex-grow">
                <div class="col-sm-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                      <center>
                          <h4 class="card-title">Pending Request</h4>
                          <h1 class="text-dark font-weight-bold mb-1" style="font-size:10vmax;">
                          <?php 
                          
                          if ($pending_journal != 0) {
                            echo $pending_journal;
                          }else{
                            echo 0;
                          }
                          
                          ?></h4>
                       </center>
                      </div>
                    </div>
                </div>

                <div class="col-sm-12 stretch-card">
                    <div class="card">
                      <div class="card-body">
                         <center>
                            <h4 class="card-title">Finished Request</h4>
                            <h1 class="text-dark font-weight-bold mb-1" style="font-size:5vmax;">
                            <?php  
                            if ($ref_journal_row != 0) {
                              echo $ref_journal_row;
                            }else{
                              echo 0;
                            }
                            
                            ?></h4>
                          </center>
                      </div>
                    </div>
               </div>
              </div>
            </div>

            <div class="col-xl-9 d-flex grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                      <h4 class="card-title"></h4>

                      <div id="piechart_3d" style="width: 900px; height: 400px"></div>
                        
                    </div>
                  </div>
            </div>
          </div>

          <div class="row">

              <div class="col-xl-4 grid-margin stretch-card">
                  <div class="card" style="height:22vmax;overflow-y: auto;">
                    <div class="card-body">
                    <h4 class="card-title">Current Journal Entries Today (<?php echo date("Y-m-d") ?>)</h4>
                    <div class="row">
                      <div class="col-sm-12">

                      <div class="text-dark">
                          <?php 

                          $approved_ref_journal = $dbh->query("SELECT * FROM journal WHERE staff_id = '".$_SESSION['id']."' AND dates = '".date("Y-m-d")."'");
                          $journal = $approved_ref_journal->rowCount();
                          

                            if ($journal === 0) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                              <div>No data found</div>
                            </div>
                          </div>
                          <?php }else{

                            foreach($approved_ref_journal->fetchAll(PDO::FETCH_ASSOC) as $fetch){
                              if ($fetch['staff_id'] == $_SESSION['id']) {              
                          
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                                <div>Name: <?php echo $fetch['title'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $_SESSION['name'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $fetch['timestamp'] ?></div>
                            </div>
                          </div>


                          <?php }}}?>
                        </div>

                      </div>
                      
                    </div> 
                    </div>
                  </div>
              </div>

              <div class="col-xl-4 grid-margin stretch-card">
                <div class="card" style="height:22vmax;overflow-y: auto;">
                  <div class="card-body">
                    <h4 class="card-title">All Journal Entries</h4>
                    <div class="row">
                      <div class="col-sm-12">

                      <div class="text-dark">
                          <?php 
                          
                          
                          $approved_ref_journal = $dbh->query("SELECT * FROM journal WHERE staff_id = '".$_SESSION['id']."'");
                          $journal = $approved_ref_journal->rowCount();
                          

                            if ($journal === 0) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                              <div>No data found</div>
                            </div>
                          </div>
                          <?php }else{

                            foreach($approved_ref_journal->fetchAll(PDO::FETCH_ASSOC) as $fetch){
                              if ($fetch['staff_id'] == $_SESSION['id']) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                                <div>Name: <?php echo $fetch['title'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $_SESSION['name'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $fetch['timestamp'] ?></div>
                            </div>
                          </div>


                          <?php }}}?>
                        </div>

                      </div>
                      
                    </div>  
                  </div>
                </div>
              </div>

              <div class="col-xl-4 grid-margin stretch-card">
                <div class="card" style="height:22vmax;overflow-y: auto;">
                  <div class="card-body">
                    <h4 class="card-title mb-3">Current Journal Entries Week (<?php echo $startDate .' to '. $endDate ?>)</h4>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="text-dark">
                          <?php 
                          
                          $journal = $dbh->query("SELECT * FROM journal WHERE staff_id = '".$_SESSION['id']."' AND  dates BETWEEN '$startDate' AND '$endDate'");
                          $request = $journal->rowCount();

                            if ($request === 0) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                              <div>No data found</div>
                            </div>
                          </div>
                          <?php }else{

                            foreach($journal->fetchAll(PDO::FETCH_ASSOC) as $fetch){
                              if ($fetch['staff_id'] == $_SESSION['id']) {
                                # code...
                              
                   
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                                <div>Name: <?php echo $fetch['title'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $_SESSION['name'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $fetch['timestamp'] ?></div>
                            </div>
                          </div>


                          <?php }}}?>
                        </div>
                      </div>
                    </div>  
                  </div>
                </div>
              </div>

              <div class="col-xl-4 grid-margin stretch-card">
                  <div class="card" style="height:22vmax;overflow-y: auto;">
                    <div class="card-body">
                    <h4 class="card-title">Current General Ledger Today (<?php echo date("Y-m-d") ?>)</h4>
                    <div class="row">
                      <div class="col-sm-12">

                      <div class="text-dark">
                          <?php 
                          

                          $ledger = $dbh->query("SELECT * FROM ledger WHERE staff_id = '".$_SESSION['id']."' AND dates = '".date('Y-m-d')."'");
                          $request = $ledger->rowCount();

                            if ($request === 0) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                              <div>No data found</div>
                            </div>
                          </div>
                          <?php }else{

                            foreach($ledger->fetchAll(PDO::FETCH_ASSOC) as $fetch){
                              if ($fetch['staff_id'] == $_SESSION['id']) {              
                          
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                                <div>Name: <?php echo $fetch['title'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $_SESSION['name'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $fetch['timestamp'] ?></div>
                            </div>
                          </div>


                          <?php }}}?>
                        </div>

                      </div>
                      
                    </div> 
                    </div>
                  </div>
              </div>

              <div class="col-xl-4 grid-margin stretch-card">
                <div class="card" style="height:22vmax;overflow-y: auto;">
                  <div class="card-body">
                    <h4 class="card-title">All General Ledger</h4>
                    <div class="row">
                      <div class="col-sm-12">

                      <div class="text-dark">
                          <?php 
                          
                          
                          $ledger = $dbh->query("SELECT * FROM ledger WHERE staff_id = '".$_SESSION['id']."'");
                          $request = $ledger->rowCount();

                            if ($request === 0) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                              <div>No data found</div>
                            </div>
                          </div>
                          <?php }else{

                            foreach($ledger->fetchAll(PDO::FETCH_ASSOC) as $fetch){
                              if ($fetch['staff_id'] == $_SESSION['id']) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                                <div>Name: <?php echo $fetch['title'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $_SESSION['name'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $fetch['timestamp'] ?></div>
                            </div>
                          </div>


                          <?php }}}?>
                        </div>

                      </div>
                      
                    </div>  
                  </div>
                </div>
              </div>

              <div class="col-xl-4 grid-margin stretch-card">
                <div class="card" style="height:22vmax;overflow-y: auto;">
                  <div class="card-body">
                    <h4 class="card-title mb-3">Current General Ledger Week (<?php echo $startDate .' to '. $endDate ?>)</h4>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="text-dark">
                          <?php 
                         $journal = $dbh->query("SELECT * FROM ledger WHERE staff_id = '".$_SESSION['id']."' AND  dates BETWEEN '$startDate' AND '$endDate'");
                         $request = $journal->rowCount();

                            if ($request === 0) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                              <div>No data found</div>
                            </div>
                          </div>
                          <?php }else{

                            foreach($ledger->fetchAll(PDO::FETCH_ASSOC) as $fetch){
                              if ($fetch['staff_id'] == $_SESSION['id']) {
                                # code...
                              
                   
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                                <div>Name: <?php echo $fetch['title'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $_SESSION['name'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $fetch['timestamp'] ?></div>
                            </div>
                          </div>


                          <?php }}}?>
                        </div>
                      </div>
                    </div>  
                  </div>
                </div>
              </div>


              <div class="col-xl-4 grid-margin stretch-card">
                  <div class="card" style="height:22vmax;overflow-y: auto;">
                    <div class="card-body">
                    <h4 class="card-title">Current Trial Balance Today (<?php echo date("Y-m-d") ?>)</h4>
                    <div class="row">
                      <div class="col-sm-12">

                      <div class="text-dark">
                          <?php 
                          
                          $trial = $dbh->query("SELECT * FROM trial WHERE staff_id = '".$_SESSION['id']."' AND dates = '".date("Y-m-d")."'");
                          $request = $trial->rowCount();


                            if ($request === 0) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                              <div>No data found</div>
                            </div>
                          </div>
                          <?php }else{

                            foreach($trial->fetchAll(PDO::FETCH_ASSOC) as $fetch){
                              if ($fetch['staff_id'] == $_SESSION['id']) {              
                          
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                                <div>Name: <?php echo $fetch['title'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $_SESSION['name'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $fetch['timestamp'] ?></div>
                            </div>
                          </div>


                          <?php }}}?>
                        </div>

                      </div>
                      
                    </div> 
                    </div>
                  </div>
              </div>

              <div class="col-xl-4 grid-margin stretch-card">
                <div class="card" style="height:22vmax;overflow-y: auto;">
                  <div class="card-body">
                    <h4 class="card-title">All Trial Balance</h4>
                    <div class="row">
                      <div class="col-sm-12">

                      <div class="text-dark">
                          <?php 
                          
                          
                          $trial = $dbh->query("SELECT * FROM trial WHERE staff_id = '".$_SESSION['id']."'");
                          $request = $trial->rowCount();
                            if ($request === 0) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                              <div>No data found</div>
                            </div>
                          </div>
                          <?php }else{

                            foreach($trial->fetchAll(PDO::FETCH_ASSOC) as $fetch){
                              if ($fetch['staff_id'] == $_SESSION['id']) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                                <div>Name: <?php echo $fetch['title'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $_SESSION['name'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $fetch['timestamp'] ?></div>
                            </div>
                          </div>


                          <?php }}}?>
                        </div>

                      </div>
                      
                    </div>  
                  </div>
                </div>
              </div>

              <div class="col-xl-4 grid-margin stretch-card">
                <div class="card" style="height:22vmax;overflow-y: auto;">
                  <div class="card-body">
                    <h4 class="card-title mb-3">Current Trial Balance Week (<?php echo $startDate .' to '. $endDate ?>)</h4>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="text-dark">
                          <?php 
                          
                          $trial = $dbh->query("SELECT * FROM trial WHERE staff_id = '".$_SESSION['id']."' AND dates = '".date("Y-m-d")."'");
                          $request = $trial->rowCount();
  

                            if ($request === 0) {
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                              <div>No data found</div>
                            </div>
                          </div>
                          <?php }else{

                            foreach($trial->fetchAll(PDO::FETCH_ASSOC) as $fetch){
                              if ($fetch['staff_id'] == $_SESSION['id']) {
                                # code...
                              
                   
                          ?>
                          <div class="d-flex pb-3 border-bottom justify-content-between">
                            <div class="mr-3"><i class="mdi mdi-signal-cellular-outline icon-md"></i></div>
                            <div class="font-weight-bold mr-sm-4">
                                <div>Name: <?php echo $fetch['title'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $_SESSION['name'] ?></div>
                                <div class="text-muted font-weight-normal mt-1"><?php echo $fetch['timestamp'] ?></div>
                            </div>
                          </div>


                          <?php }}}?>
                        </div>
                      </div>
                    </div>  
                  </div>
                </div>
              </div>


          </div>

          </div>
        </div>
        
        <!-- content-wrapper ends -->        
        <!-- partial -->
      </div>


<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Journal Entries',     <?php echo $ref_journal_row ?>],
          ['General Ledger',     <?php echo $ref_ledger_row ?>],
          ['Trial Balance', <?php echo $ref_trial_row ?>]
        ]);

        var options = {
          title: 'Transaction',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));

        chart.draw(data, options);
      }
    </script>