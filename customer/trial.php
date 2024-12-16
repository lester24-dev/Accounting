<?php
include('../layout/customer_nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Trial Balance List</h4>
                  <p class="card-description">
                  <a href="trial_pdf" class="btn btn-danger">PDF</a>
                 
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Year</th>
                          <th>Created At</th>
                          <th>Client</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                          $stmt = $dbh->query("SELECT * FROM `trial`");

                          foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $fetch) {

                            if ($fetch['customer_id'] == $_SESSION['id']) {
                              $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$fetch['customer_id']."'");
                              $row_depts = $userRef->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <tr>
                          <td><?php echo $fetch['title']; ?></td>
                          <td><?php echo $fetch['year']; ?></td>
                          <td><?php echo $fetch['timestamp']; ?></td>
                          <td><?php echo $row_depts['name']; ?></td>
                          <td>
                          <a href="trial_data?transaction_id=<?php echo $fetch['transaction_id']; ?>&customer_id=<?php echo $row_depts['id'] ?>"><i class="fa-solid fa-link" style="font-size:30px;"></i> </a>    
                        </td>
                        </tr>

                      
                     <?php  } }?>
                        
                          
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>