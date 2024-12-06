<?php
include('../layout/admin_nav_header.php')
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Department List</h4>
                  <p class="card-description">
                  <a href="register" class="btn btn-success">Create Account</a>
                  <?php 
                  
                  if (isset($_GET['departments'])) {
                    echo ' <a href="department_pdf?departments='.$_GET['departments'].'&search_sales=Search" class="btn btn-danger">PDF</a>';
                  } else {
                    echo ' <a href="department_pdf" class="btn btn-danger">PDF</a>';
                  }
                  ?>
                  <table border="0">
                      <tbody>
                        <tr>
                          <form action="" method="get">
                            <th>Department: 
                              <select id="departments" name="departments" style="margin-left:10px;margin-right:10px;" value="<?php if(isset($_GET['departments'])){echo $_GET['departments'];} ?>">
                                <option>Department</option>
                                <option value="Company Customer">Company Customer</option>
                                <option value="Company Staff">Company Staff</option>
                              </select></th>
                            <th><input type="submit" name="department" id="search_sales" value="Search" style="margin-left:10px;margin-top:-4px;" class="btn btn-info" /></th>
                          </form>
                        </tr>
                      </tbody>
                  </table>
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Department</th>
                          <th>Email</th>
                          <th>Documents</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 

                        if (isset($_GET['departments'])) {
                              $stmt = $dbh->query("SELECT * FROM users");
                          
                              // Loop through the items to find the one with the matching name
                              foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $itemKey => $item) {
                                if ($item['department'] == $_GET['departments']) {?>
                         <tr>
                          <td class="py-1"><img src="<?php echo $item['profile_img']; ?>" alt="image"/></td>
                          <td><?php echo $item['name']; ?></td>
                          <td><?php echo $item['department']; ?></td>
                          <td><?php echo $item['email']; ?></td>
                          <td>
                          <?php 
                            if ($item['customer_dept'] == 'Single Proprietor') {
                              ?>
                              <a href="<?php echo $item['bir']; ?>" target="_blank" class="btn btn-danger">View BIR</a>
                              <a href="<?php echo $item['mayors_permit']; ?>" target="_blank" class="btn btn-success">View Mayors Permit</a>
                              <a href="<?php echo $item['dti']; ?>" target="_blank" class="btn btn-info">View DTI</a>
                              <?php
                            }else if ($item['customer_dept'] == 'Corporation') {
                              ?>
                              <a href="<?php echo $item['bir']; ?>" target="_blank" class="btn btn-danger">View BIR</a>
                              <a href="<?php echo $item['mayors_permit']; ?>" target="_blank" class="btn btn-success">View Mayors Permit</a>
                              <a href="<?php echo $item['sec']; ?>" target="_blank" class="btn btn-info">View SEC Certificate</a>
                            <?php } 
                             else if ($item['customer_dept'] == 'Partnership') {
                              ?>
                              <a href="<?php echo $item['bir']; ?>" target="_blank" class="btn btn-danger">View BIR</a>
                              <a href="<?php echo $item['mayors_permit']; ?>" target="_blank" class="btn btn-success">View Mayors Permit</a>
                              <a href="<?php echo $item['sec']; ?>" target="_blank" class="btn btn-info">View SEC Certificate</a>
                            <?php } 
                            else {
                             
                            }?>
                          </td>
                          <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#supplyModal<?php echo $item['id']; ?>">Info</button>
                        </tr>

                        <div class="modal fade" id="supplyModal<?php echo $item['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Department Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="../db/function.php" method="POST" enctype="multipart/form-data">
                                          <div class="form-group">
                                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                            <input type="text" class="form-control" name="name" value="<?php echo $item['name']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="text" class="form-control" name="username" value="<?php echo $item['username']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="text" class="form-control" name="email" value="<?php echo $item['email']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="password" class="form-control" name="password" value="<?php echo $item['password']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="department" class="form-control" name="department" value="<?php echo $item['department']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="file" class="form-control" profile_img="profile_img" value="<?php echo $item['profile_img']; ?>" placeholder="Image">
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <!-- <button type="submit" class="btn btn-primary" name="update_supply">Create</button> -->
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                        <?php }}}else{
                           $stmt = $dbh->query("SELECT * FROM users");
                          
                           // Loop through the items to find the one with the matching name
                           foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $itemKey => $fetch) 
                          if ($fetch['department'] != 'Company Admin' ) {
                            # code...
                          
                        {?>
                        <tr>
                          <td class="py-1"><img src="../uploads/<?php echo $fetch['profile_img']; ?>" alt="image"/></td>
                          <td><?php echo $fetch['name']; ?></td>
                          <td><?php echo $fetch['department']; ?></td>
                          <td><?php echo $fetch['email']; ?></td>
                          <td>
                            <?php 
                            if ($fetch['customer_dept'] == 'Single Proprietor') {
                              ?>
                              <a href="../uploads/<?php echo $fetch['bir']; ?>" target="_blank" class="btn btn-danger">View BIR</a>
                              <a href="../uploads/<?php echo $fetch['mayors_permit']; ?>" target="_blank" class="btn btn-success">View Mayors Permit</a>
                              <a href="../uploads/<?php echo $fetch['dti']; ?>" target="_blank" class="btn btn-info">View DTI</a>
                            <?php
                            }else if ($fetch['customer_dept'] == 'Corporation') {
                              ?>
                              <a href="../uploads/<?php echo $fetch['bir']; ?>" target="_blank" class="btn btn-danger">View BIR</a>
                              <a href="../uploads/<?php echo $fetch['mayors_permit']; ?>" target="_blank" class="btn btn-success">View Mayors Permit</a>
                              <a href="../uploads/<?php echo $fetch['sec']; ?>" target="_blank" class="btn btn-info">View SEC Certificate</a>
                            <?php } 
                             else if ($fetch['customer_dept'] == 'Partnership') {
                              ?>
                              <a href="../uploads/<?php echo $fetch['bir']; ?>" target="_blank" class="btn btn-danger">View BIR</a>
                              <a href="../uploads/<?php echo $fetch['mayors_permit']; ?>" target="_blank" class="btn btn-success">View Mayors Permit</a>
                              <a href="../uploads/<?php echo $fetch['sec']; ?>" target="_blank" class="btn btn-info">View SEC Certificate</a>
                            <?php } 
                            else {
                             
                            }?>
                          </td>
                          <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#supplyModal<?php echo $fetch['id']; ?>">Info</button>
                        </tr>

                        <div class="modal fade" id="supplyModal<?php echo $fetch['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Department Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="../db/function.php" method="POST" enctype="multipart/form-data">
                                          <div class="form-group">
                                            <input type="hidden" name="id" value="<?php echo $fetch['id']; ?>">
                                            <input type="text" class="form-control" name="name" value="<?php echo $fetch['name']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="text" class="form-control" name="username" value="<?php echo $fetch['username']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="text" class="form-control" name="email" value="<?php echo $fetch['email']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="password" class="form-control" name="password" value="<?php echo $fetch['password']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="department" class="form-control" name="department" value="<?php echo $fetch['department']; ?>" readonly>
                                          </div>
                                          <div class="form-group">
                                          <input type="file" class="form-control" profile_img="profile_img" value="<?php echo $fetch['profile_img']; ?>" placeholder="Image" readonly>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <!-- <button type="submit" class="btn btn-primary" name="update_supply">Create</button> -->
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                     <?php   }}}?>
                        
                          
                    </tbody>
                    </table>

                        <script>
                            $(document).ready(function() {
                                $('#request').DataTable({ });
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