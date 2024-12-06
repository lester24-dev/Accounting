<?php
include('../layout/nav_header.php');
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
                          <th>Tax Name</th>
                          <th>Tax Percentage</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                          $etw = $dbh->query("SELECT * FROM etw");
                          foreach($etw->fetchAll(PDO::FETCH_ASSOC) as $key => $fetch) {
                        ?>
                        <tr>
                          <td><?php echo $fetch['title']; ?></td>
                          <td><?php echo $fetch['tax_rate']. "%" ;?></td>
                          
                        </tr>

                        

                      
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>