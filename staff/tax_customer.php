<?php
include('../layout/nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Tax Setting</h4>
                  <p class="card-description">
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Customer Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                           $stmt = $dbh->query("SELECT * FROM `users`");
                          
                           // Loop through the items to find the one with the matching name
                             foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key => $fetch) {
                               if ($fetch['department'] != 'Company Admin' && $fetch['department'] != 'Company Staff') {
                        ?>
                        <tr>
                          <td><?php echo $fetch['name']; ?></td>
                          <td>
                          <a href="tax?id=<?php echo $key; ?>"><i class="fa-solid fa-link" style="font-size:30px;"></i> </a>
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