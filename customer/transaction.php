<?php
include('../layout/customer_nav_header.php')
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Transaction List</h4>
                  <p class="card-description">
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
                          <th>Approval</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 

                        if (isset($_GET['transaction'])) {
                          $itemsRef = $realtimeDatabase->getReference('transaction')->orderByChild("customer_id")->equalTo($_GET['id'])->getSnapshot();
                          
                              // Loop through the items to find the one with the matching name
                              foreach ($itemsRef->getValue() as $key => $item) {
                                if ($item['transaction'] == $_GET['transaction']) {?>
                         <tr>
                          <td><?php echo $item['vat_reg_tin']; ?></td>
                          <td><?php echo $item['title']; ?></td>
                          <td><?php echo $item['transaction']; ?></td>
                          <td><?php echo $item['email']; ?></td>
                          <td><?php echo $item['address']; ?></td>
                          <td>
                          <?php 
                            
                            if ($fetch['status'] == 'Approved') {
                                echo '<label class="text-success">Approved</label>';
                            }else{
                              ?>
                              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#approvedModal<?php echo $fetch['transaction_id']; ?>">Approved</button>
                              <?php
                            }

                            ?>
                          </td>
                          <td>
                          <a href="transaction_data?vat_reg_tin=<?php echo $item['vat_reg_tin']; ?>" class="btn btn-info">View</a>
                          </td>
                        </tr>

                     

                                <div class="modal fade" id="approvedModal<?php echo $item['transaction_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Transaction Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <p>Are you sure you want to approved this transaction ?</p>
                                        <form action="../db/firebaseDB" method="GET" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="hidden" name="transaction_id" value="<?php echo $item['transaction_id']?>">
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" name="update_transaction_data_customer">Approved</button>
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>

                        <?php }}}else{
                         $itemsRef = $realtimeDatabase->getReference('transaction')->orderByChild("customer_id")->equalTo($_SESSION['id'])->getSnapshot();
                          foreach($itemsRef->getValue() as $key => $fetch) {
                        ?>
                        <tr>
                          <td><?php echo $fetch['vat_reg_tin']; ?></td>
                          <td><?php echo $fetch['title']; ?></td>
                          <td><?php echo $fetch['transaction']; ?></td>
                          <td><?php echo $fetch['email']; ?></td>
                          <td><?php echo $fetch['address']; ?></td>
                          <td>
                            <?php 
                            
                            if ($fetch['status'] == 'Approved') {
                                echo '<label class="text-success">Approved</label>';
                            }else{
                              ?>
                              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#approvedModal<?php echo $fetch['transaction_id']; ?>">Approved</button>
                              <?php
                            }

                            ?>
                          </td>
                          <td>
                          <a href="transaction_data?vat_reg_tin=<?php echo $fetch['vat_reg_tin']; ?>" class="btn btn-info">View</a>
                          </td>
                        </tr>


                                <div class="modal fade" id="approvedModal<?php echo $fetch['transaction_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Transaction Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <p>Are you sure you want to approved this transaction ?</p>
                                        <form action="../db/firebaseDB" method="GET" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="hidden" name="transaction_id" value="<?php echo $fetch['transaction_id']?>">
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" name="update_transaction_data_customer">Approved</button>
                                      </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                     <?php   }}?>
                        
                          
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