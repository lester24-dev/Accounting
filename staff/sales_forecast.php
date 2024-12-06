<?php
include('../layout/nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Sale Forcast List</h4>
                  <p class="card-description">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Create +</button>
                  <a href="sale_forecast_pdf" class="btn btn-danger">PDF</a>               
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Year</th>
                          <th>Created At</th>
                          <th>Client</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                          $stmt = $dbh->query("SELECT * FROM `sale-forecast` WHERE staff_id = '".$_SESSION['id']."'");
                          
                          // Loop through the items to find the one with the matching name
                          foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $fetch) {

                              $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$fetch['customer_id']."'");
                              $row_depts = $userRef->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <tr>
                          <td><?php echo $fetch['title']; ?></td>
                          <td><?php echo $fetch['year']; ?></td>
                          <td><?php echo $fetch['timestamp']; ?></td>
                          <td><?php echo $row_depts['name']; ?></td>
                          <td>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#supplyModal<?php echo $fetch['transaction_id']; ?>">Update</button>
                            <a href="sales_forecast_data?transaction_id=<?php echo $fetch['transaction_id']; ?>&customer_id=<?php echo $row_depts['id'] ?>&title=<?php echo $fetch['title']; ?>" class="btn btn-info">View</a>
                          </td>
                        </tr>

                        <div class="modal fade" id="supplyModal<?php echo $fetch['transaction_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Sale Forecast Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="../db/db" method="GET" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="title" name="title"  value="<?php echo $fetch['title'];?>" placeholder="Journal Title">
                                            <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                            <input type="hidden" name="transaction_id" value="<?php echo $fetch['transaction_id']?>">
                                        </div>
                                      
                                
                                        <div class="form-group">
                                                <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="year" required>
                                                  <option value="<?php echo $fetch['year'] ?>"><?php echo $fetch['year'] ?></option>
                                                  <?php 
                                                  $currentYear = date("Y");
                                                  for ($year = 2000; $year <= $currentYear; $year++) {
                                                  ?>
                                                  <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                  <?php }?>
                                                </select>
                                         </div>

                                         <div class="form-group">
                                            <select name="customer_id" id="customer_id" class="form-control" required>
                                                   <option value="<?php echo $fetch['customer_id'] ?>"><?php echo $fetch['department'] ?></option>
                                                        <?php 
                                                                
                                                                $stmt = $dbh->query("SELECT * FROM users");
                          
                                                                // Loop through the items to find the one with the matching name
                                                                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
                                                            if ($key['department'] != 'Company Admin' && $key['department'] != 'Company Staff') {
                                                            
                                                                ?>
                                                        <option value="<?php echo $key['id'] ?>"><?php echo $key['name'] ?></option>
                                                        <?php
                                                                }   }
                                                        ?>
                                                            
                                            </select>
                                      </div>
                                    </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" name="update_sale_forecast_staff">Update</button>
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                               
                     <?php   }?>
                        
                          
                    </tbody>
                    </table>

                        <script>
                            $(document).ready(function() {
                                $('#request').DataTable({
                                  ordering: false
                                 });
                            });
                        </script>
                </div>
              </div>
            </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Sale Forecast</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../db/db" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="Sale Forecast Title" required>
            <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
        </div>

        <div class="form-group">
              <input type="text" class="form-control" id="rq_number" name="rq_number" placeholder="Number of Data:" required>
        </div>


        <div class="form-group">
                <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="year" required>
                  <option>Year List</option>
                  <?php 
                  $currentYear = date("Y");
                  for ($year = 2000; $year <= $currentYear; $year++) {
                  ?>
                  <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                  <?php }?>
                </select>
        </div>

        <div class="form-group">
              <select name="customer_id" id="customer_id" class="form-control" required>
                       <option value="">Customer List</option>
                         <?php 
                                
                                $stmt = $dbh->query("SELECT * FROM users");
                          
                                // Loop through the items to find the one with the matching name
                                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
                              if ($key['department'] != 'Company Admin' && $key['department'] != 'Company Staff') {
                              
                                ?>
                         <option value="<?php echo $key['id'] ?>"><?php echo $key['name'] ?></option>
                          <?php
                                 }   }
                         ?>
                               
            </select>
        </div>
           
        
   

        <!-- <div class="form-group">
              <textarea class="form-control" id="message" name="message" placeholder="Message:" rows="5"></textarea>
          </div> -->
       
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="create_sales_forecast_staff">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>