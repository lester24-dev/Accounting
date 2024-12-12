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
                            <a href="../uploads/<?php echo $item['bir']; ?>" target="_blank"><img src="../bir/bir.png" alt="" srcset="">View BIR</a>
                            <a href="../uploads/<?php echo $item['mayors_permit']; ?>" target="_blank"><img src="../bir/mayor.png" style="width:100px;margin-right:-22px;" alt="" srcset="">View Mayors Permit</a>
                            <a href="../uploads/<?php echo $item['dti']; ?>" target="_blank"><img src="../bir/dti.jpg" style="width:50px;" alt="" srcset=""> View DTI</a>
                            <?php 
                          }else if ($item['customer_dept'] == 'Corporation') {
                            ?>
                            <a href="../uploads/<?php echo $item['bir']; ?>" target="_blank"><img src="../bir/bir.png" alt="" srcset="">View BIR</a>
                            <a href="../uploads/<?php echo $item['mayors_permit']; ?>" target="_blank"><img src="../bir/mayor.png" style="width:100px;margin-right:-22px;" alt="" srcset=""> View Mayors Permit</a>
                            <a href="../uploads/<?php echo $item['sec']; ?>" target="_blank"><img src="../bir/sec.png" alt="" srcset=""> View SEC Certificate</a>
                          <?php } 
                           else if ($item['customer_dept'] == 'Partnership') {
                            ?>
                            <a href="../uploads/<?php echo $item['bir']; ?>" target="_blank"><img src="../bir/bir.png" alt="" srcset=""> View BIR</a>
                            <a href="../uploads/<?php echo $item['mayors_permit']; ?>" target="_blank"><img src="../bir/mayor.png" style="width:100px;margin-right:-22px;" alt="" srcset="">View Mayors Permit</a>
                            <a href="../uploads/<?php echo $item['sec']; ?>" target="_blank"><img src="../bir/sec.png" alt="" srcset=""> View SEC Certificate</a>
                            <?php } 
                            else {
                             
                            }?>
                          </td>
                          <td>
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1212 1212" data-toggle="modal" data-target="#supplyModal<?php echo $item['id']; ?>"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>  
                          </td>
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
                              <a href="../uploads/<?php echo $fetch['bir']; ?>" target="_blank"><img src="../bir/bir.png" alt="" srcset="">View BIR</a>
                              <a href="../uploads/<?php echo $fetch['mayors_permit']; ?>" target="_blank"><img src="../bir/mayor.png" style="width:100px;margin-right:-22px;" alt="" srcset="">View Mayors Permit</a>
                              <a href="../uploads/<?php echo $fetch['dti']; ?>" target="_blank"><img src="../bir/dti.jpg" style="width:50px;" alt="" srcset=""> View DTI</a>
                              <?php 
                            }else if ($fetch['customer_dept'] == 'Corporation') {
                              ?>
                              <a href="../uploads/<?php echo $fetch['bir']; ?>" target="_blank"><img src="../bir/bir.png" alt="" srcset="">View BIR</a>
                              <a href="../uploads/<?php echo $fetch['mayors_permit']; ?>" target="_blank"><img src="../bir/mayor.png" style="width:100px;margin-right:-22px;" alt="" srcset=""> View Mayors Permit</a>
                              <a href="../uploads/<?php echo $fetch['sec']; ?>" target="_blank"><img src="../bir/sec.png" alt="" srcset=""> View SEC Certificate</a>
                            <?php } 
                             else if ($fetch['customer_dept'] == 'Partnership') {
                              ?>
                              <a href="../uploads/<?php echo $fetch['bir']; ?>" target="_blank"><img src="../bir/bir.png" alt="" srcset=""> View BIR</a>
                              <a href="../uploads/<?php echo $fetch['mayors_permit']; ?>" target="_blank"><img src="../bir/mayor.png" style="width:100px;margin-right:-22px;" alt="" srcset="">View Mayors Permit</a>
                              <a href="../uploads/<?php echo $fetch['sec']; ?>" target="_blank"><img src="../bir/sec.png" alt="" srcset=""> View SEC Certificate</a>
                            <?php } 
                            else {
                             
                            }?>
                          </td>
                          <td>
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1212 1212" data-toggle="modal" data-target="#supplyModal<?php echo $fetch['id']; ?>"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>  
                        </td>
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