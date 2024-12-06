<?php
include('../layout/admin_nav_header.php');
?>


<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Tax Setting</h4>
                  <p class="card-description">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target=".exampleModal">Create +</button>
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

<div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Tax</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../db/db" method="POST" enctype="multipart/form-data">
        <div class="form-group">
        <input type="text" class="form-control" id="title" name="title" placeholder="Tax Title" required>
        </div>

        <div class="form-group">
        <input type="number" class="form-control" id="tax_rate" name="tax_rate" placeholder="Tax Rate" required>
        </div>

        <div class="form-group">
        <input type="number" class="form-control" id="ind" name="ind" placeholder="Tax Ind" required>
        </div>

        <div class="form-group">
        <input type="number" class="form-control" id="corp" name="corp" placeholder="Tax Corp" required>
        </div>

        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="create_ewt">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>