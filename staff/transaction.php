<?php
include('../layout/nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Transaction List</h4>
                  <p class="card-description">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Create +</button>
                  <?php 
                  
                  if (isset($_GET['transaction'])) {
                    echo ' <a href="transaction_pdf?transaction='.$_GET['transaction'].'&search_sales=Search" class="btn btn-danger">PDF</a>';
                  } else {
                    echo ' <a href="transaction_pdf" class="btn btn-danger">PDF</a>';
                  }
                  ?>
                  <table border="0">
                      <tbody>
                        <tr>
                          <form action="" method="get">
                            <th>Transaction: 
                              <select id="transaction" name="transaction" style="margin-left:10px;margin-right:10px;" value="<?php if(isset($_GET['departments'])){echo $_GET['departments'];} ?>">
                                <option>Transaction List</option>
                                <option value="Financial Transaction">Financial Transaction</option>
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
                          <th>Vat Reg Tin</th>
                          <th>Name</th>
                          <th>Transaction</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Update</th>
                          <th>Delete</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 

                        if (isset($_GET['transaction'])) {
                          $itemsRef = $realtimeDatabase->getReference('transaction');

                          // Get the current items
                          $items = $itemsRef->getValue();
                          
                              // Loop through the items to find the one with the matching name
                              foreach ($items as $itemKey => $item) {
                                if ($item['transaction'] == $_GET['transaction'] && $item['staff_id'] == $_SESSION['id']) {?>
                         <tr>
                          <td><?php echo $item['vat_reg_tin']; ?></td>
                          <td><?php echo $item['title']; ?></td>
                          <td><?php echo $item['transaction']; ?></td>
                          <td><?php echo $item['email']; ?></td>
                          <td><?php echo $item['address']; ?></td>
                          <td>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#supplyModal<?php echo $item['transaction_id']; ?>">Update</button>
                          </td>
                          <td>
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $item['transaction_id']; ?>">Delete</button>
                          </td>
                          <td>
                          <a href="transaction_data?vat_reg_tin=<?php echo $item['vat_reg_tin']; ?>" class="btn btn-info">View</a>
                          </td>
                        </tr>

                        <div class="modal fade" id="supplyModal<?php echo $item['transaction_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Transaction Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="../db/firebaseDB" method="GET" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="title" name="title"  value="<?php echo $item['title']?>" placeholder="Transaction Title">
                                            <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                            <input type="hidden" name="transaction_id" value="<?php echo $item['transaction_id']?>">
                                        </div>
                                      
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $item['email']?>" placeholder="Email Address">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="vat_reg_tin" name="vat_reg_tin" value="<?php echo $fetch['vat_reg_tin']?>" placeholder="VAT Reg TIN">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $item['address']?>" placeholder="Address:">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $item['contact']?>" placeholder="Contact No:">
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="transaction" required>
                                              <option value="<?php echo $item['transaction']?>"><?php echo $item['transaction']?></option>
                                              <option value="Financial Transaction">Financial Transaction</option>
                                              <option value="Company Staff">Company Staff</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                                <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="year" required>
                                                  <option value="<?php echo $item['year'] ?>"><?php echo $item['year'] ?></option>
                                                  <?php 
                                                  $currentYear = date("Y");
                                                  for ($year = 2000; $year <= $currentYear; $year++) {
                                                  ?>
                                                  <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                  <?php }?>
                                                </select>
                                        </div>

                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" name="update_transaction">Update</button>
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                                <div class="modal fade" id="deleteModal<?php echo $item['transaction_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Transaction Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <p>Are you sure you want to delete this transaction ?</p>
                                        <form action="../db/firebaseDB" method="GET" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                            <input type="hidden" name="transaction_id" value="<?php echo $item['transaction_id']?>">
                                            <input type="hidden" name="vat_reg_tin" value="<?php echo $item['vat_reg_tin']?>">
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger" name="delete_transaction">Delete</button>
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                        <?php }}}else{
                          $fetchdata = $realtimeDatabase->getReference("transaction")->getValue();
                          foreach($fetchdata as $fetch) {

                            if ($item['staff_id'] == $_SESSION['id']) {
                              # code...
                        ?>
                        <tr>
                          <td><?php echo $fetch['vat_reg_tin']; ?></td>
                          <td><?php echo $fetch['title']; ?></td>
                          <td><?php echo $fetch['transaction']; ?></td>
                          <td><?php echo $fetch['email']; ?></td>
                          <td><?php echo $fetch['address']; ?></td>
                          <td>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#supplyModal<?php echo $fetch['transaction_id']; ?>">Update</button>
                          </td>
                          <td>
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $fetch['transaction_id']; ?>">Delete</button>
                          </td>
                          <td>
                          <a href="transaction_data?vat_reg_tin=<?php echo $fetch['vat_reg_tin']; ?>" class="btn btn-info">View</a>
                          </td>
                        </tr>

                        <div class="modal fade" id="supplyModal<?php echo $fetch['transaction_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Transaction Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="../db/firebaseDB" method="GET" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="title" name="title"  value="<?php echo $fetch['title']?>" placeholder="Transaction Title">
                                            <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                            <input type="hidden" name="transaction_id" value="<?php echo $fetch['transaction_id']?>">
                                        </div>
                                      
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $fetch['email']?>" placeholder="Email Address">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="vat_reg_tin" name="vat_reg_tin" value="<?php echo $fetch['vat_reg_tin']?>" placeholder="VAT Reg TIN">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $fetch['address']?>" placeholder="Address:">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $fetch['contact']?>" placeholder="Contact No:">
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="transaction" required>
                                              <option value="<?php echo $fetch['transaction']?>"><?php echo $fetch['transaction']?></option>
                                              <option value="Financial Transaction">Financial Transaction</option>
                                              <option value="Company Staff">Company Staff</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                                <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="year" required>
                                                  <option value="<?php echo $fetch['year'] ?>"><?php echo $fetch['year'] ?></option>
                                                  <?php 
                                                  $currentYear = date("Y");
                                                  for ($year = 2000; $year <= $currentYear; $year++) {
                                                  ?>
                                                  <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                  <?php }?>
                                                </select>
                                        </div>

                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" name="update_transaction">Update</button>
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                                <div class="modal fade" id="deleteModal<?php echo $fetch['transaction_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Transaction Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <p>Are you sure you want to delete this transaction ?</p>
                                        <form action="../db/firebaseDB" method="GET" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                            <input type="hidden" name="transaction_id" value="<?php echo $fetch['transaction_id']?>">
                                            <input type="hidden" name="vat_reg_tin" value="<?php echo $fetch['vat_reg_tin']?>">
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger" name="delete_transaction">Delete</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Create Transaction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../db/firebaseDB" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="Transaction Title" required>
            <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
        </div>
        
            <div class="row">

              <div class="form-group col-md-6">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
              </div>

              <div class="form-group col-md-6">
                  <input type="text" class="form-control" id="vat_reg_tin" name="vat_reg_tin" placeholder="VAT Reg TIN" required>
              </div>

            </div>

            <div class="form-group ">
            <input type="text" class="form-control" id="address" name="address" placeholder="Address:" required>
            </div>

            <div class="row">

            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="rq_number" name="rq_number" placeholder="Number of Data:" required>
            </div>

            <div class="form-group col-md-6">
            <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact No:" required>
            </div>

            </div>

            <div class="row">
            <div class="form-group col-md-6">
                <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="year" required>
                  <option>Year List</option>
                  <?php 
                  $currentYear = date("Y");
                  for ($year = 2000; $year <= $currentYear; $year++) {
                  ?>
                  <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                  <?php }?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="transaction" required>
                  <option>Transaction List</option>
                  <option value="Financial Transaction">Financial Transaction</option>
                </select>
            </div>
            </div>

            <div class="form-group">
              <select name="customer_id" id="customer_id" class="form-control" required>
                      <option value="">Customer List</option>
                        <?php 
                                
                          $fetchdata = $realtimeDatabase->getReference("users")->getValue();
                                
                        foreach ($fetchdata as $key) {
                              if ($key['department'] != 'Company Admin' && $key['department'] != 'Company Staff') {
                              
                                ?>
                        <option value="<?php echo $key['id'] ?>"><?php echo $key['name'] ?></option>
                          <?php
                                }   }
                        ?>
                              
            </select>
            </div>

        <!-- <div class="form-group">
              <textarea class="form-control" id="message" name="message" placeholder="Message:" rows="5"></textarea>
          </div> -->
       
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="create_request_number">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>