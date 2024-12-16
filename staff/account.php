<?php
include('../layout/nav_header.php');
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Account List</h4>
                  <p class="card-description">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Create +</button>
                  <a href="account_pdf" class="btn btn-danger">PDF</a>
                 
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Account ID</th>
                          <th>Account Name</th>
                          <th>Account Type</th>
                          <th>Action</th>
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
                          <td>
                            <i class="fa fa-edit" style="font-size:30px;" data-toggle="modal" data-target="#supplyModal<?php echo $fetch['account_id']; ?>"></i>
                            <i class="fa fa-trash" style="font-size:30px;" data-toggle="modal" data-target="#deleteModal<?php echo $fetch['account_id']; ?>"></i>
                          </td>
                        </tr>

                        <div class="modal fade" id="supplyModal<?php echo $fetch['account_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Account Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="../db/db" method="GET" enctype="multipart/form-data">
                                
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="account_name" name="account_name" value="<?php echo $fetch['account_name']?>" placeholder="Account Name" required>
                                            <input type="hidden" name="account_id" value="<?php echo $fetch['account_id']?>">
                                        </div>

                                        <div class="form-group">
                                            <select name="account_type" id="account_type" class="form-control" required="required">
                                                <option value="<?php echo $fetch['account_type']?>"><?php echo $fetch['account_type']?></option>
                                                <option value="Assets">Assets</option>
                                                <option value="Liabilities">Liabilities</option>
                                                <option value="Equity">Equity</option>
                                                <option value="Revenues">Revenues</option>
                                                <option value="Expenses">Expenses</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" name="update_account_staff">Update</button>
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                                <div class="modal fade" id="deleteModal<?php echo $fetch['account_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Account Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <p>Are you sure you want to delete this account ?</p>
                                        <form action="../db/db" method="GET" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="hidden" name="account_id" value="<?php echo $fetch['account_id']?>">
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger" name="delete_account_staff">Delete</button>
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
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
        <form action="../db/db" method="POST" enctype="multipart/form-data">

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