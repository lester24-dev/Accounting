<?php
include('../layout/admin_nav_header.php');
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
                          <th>Account Name</th>
                          <th>Account Type</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                         $stmt = $dbh->query("SELECT * FROM account");
                          
                         // Loop through the items to find the one with the matching name
                         foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $itemKey => $fetch) {
                        ?>
                        <tr>
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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../db/firebaseDB" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name" required>
        </div>

        <div class="form-group">
             <select name="account_type" id="account_type" class="form-control" required="required">
                <option value="">Account Type</option>
                <option value="Assets">Assets</option>
                <option value="Liabilities">Liabilities</option>
                <option value="Equity">Equity</option>
                <option value="Revenues">Revenues</option>
                <option value="Expenses">Expenses</option>
             </select>
             
        </div>
           

        <!-- <div class="form-group">
              <textarea class="form-control" id="message" name="message" placeholder="Message:" rows="5"></textarea>
          </div> -->
       
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="create_account_staff">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>