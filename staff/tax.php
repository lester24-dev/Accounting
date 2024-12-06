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
                  <a href="tax_pdf?id=<?php echo $_GET['id']; ?>" class="btn btn-danger">PDF</a>
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
                         $dbh->query("SELECT * FROM tax WHERE customer_id = '".$_GET['id']."'");
                          
                         // Loop through the items to find the one with the matching name
                         foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key => $fetch) {
                        ?>
                        <tr>
                          <td><?php echo $fetch['tax_name']; ?></td>
                          <td><?php echo $fetch['tax_percentage']. "%" ;?></td>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Tax</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../db/firebaseDB" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="text" class="form-control" id="tax_name" name="tax_name" placeholder="Tax Name" required>
            <input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>">
        </div>

        <div class="form-group">
              <input type="text" class="form-control" id="tax_percentage" name="tax_percentage" placeholder="Tax Percentage" required>
        </div>

        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="create_tax">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>