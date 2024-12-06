<?php
include('../layout/admin_nav_header.php');
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
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Create +</button>
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Tax Name</th>
                          <th>Tax Percentage</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                          $stmt = $dbh->query("SELECT * FROM tax WHERE customer_id = '".$_GET['id']."'");
                          
                          // Loop through the items to find the one with the matching name
                          foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key => $fetch) {
                        ?>
                        <tr>
                          <td><?php echo $fetch['tax_name']; ?></td>
                          <td><?php echo $fetch['tax_percentage']. "%" ;?></td>
                          <td>
                          <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateeModal<?php echo $fetch['id']; ?>">View</a>
                          </td>
                        </tr>

                        <div class="modal fade" id="updateeModal<?php echo $fetch['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Update Tax</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="../db/db" method="POST" enctype="multipart/form-data">
                              <div class="form-group">
                                  <input type="text" class="form-control" id="tax_name" value="<?php echo $fetch['tax_name']; ?>" name="tax_name" placeholder="Tax Name" required>
                                  <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $_GET['id']; ?>">
                                  <input type="hidden" name="tax_id" id="tax_id" value="<?php echo $fetch['id']; ?>">
                              </div>

                              <div class="form-group">
                                    <input type="text" class="form-control" id="tax_percentage" name="tax_percentage" value="<?php echo $fetch['tax_percentage'];?>" placeholder="Tax Percentage" required>
                              </div>

                              </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-success" name="update_tax">Create</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Create Tax</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../db/db" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <select class="form-control" id="tax_name" name="tax_name" placeholder="Tax Name" required>
              <option value="">Tax Name</option>
              <option value="Percentage Tax">Percentage Tax</option>
              <option value="Expanded Withholding Tax">Expanded Withholding Tax</option>
              <option value="Income Tax">Income Tax</option>
              <option value="Withholding Tax on Compensation">Withholding Tax on Compensation</option>
              <option value="Corporate Income Tax">Corporate Income Tax</option>
            </select>
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