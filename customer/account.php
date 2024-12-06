<?php
include('../layout/customer_nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Account List</h4>
                  <p class="card-description">
                  <a href="account_pdf" class="btn btn-danger">PDF</a>
                 
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Account ID</th>
                          <th>Account Name</th>
                          <th>Account Type</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                          $stmt = $dbh->query("SELECT * FROM account");
                          
                          // Loop through the items to find the one with the matching name
                          foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $fetch) {
                        ?>
                        <tr>
                          <td><?php echo $fetch['account_id']; ?></td>
                          <td><?php echo $fetch['account_name']; ?></td>
                          <td><?php echo $fetch['account_type']; ?></td>
                          
                        </tr>
                     <?php  }?>
                        
                          
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