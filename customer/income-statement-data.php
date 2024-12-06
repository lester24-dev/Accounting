<?php
include('../layout/customer_nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <p class="card-description">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AddModal">Add +</button>
                  <a href="transaction_data_pdf" class="btn btn-danger">PDF</a>
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Total Revenue</th>
                          <th>Total Expenses</th>
                          <th>Net Income</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 

                    $itemsRef = $realtimeDatabase->getReference('income-statement-data');

                    // Get the current items
                    $items = $itemsRef->getValue();

                        // Loop through the items to find the one with the matching name
                        foreach ($items as $itemKey => $item) {
                        if ($item['transaction_id'] === $_GET['transaction_id']) {?>
                    <tr>
                    <td><p class="text-success"><?php echo '&#8369;'.htmlspecialchars(number_format($item['total_revenue'], 2)); ?></p></td>
                    <td><p class="text-danger"><?php echo '&#8369;'.htmlspecialchars(number_format($item['total_expenses'], 2));?></p></td>
                    <td><p class="text-success"><?php echo '&#8369;'.htmlspecialchars(number_format($item['net_income'], 2)); ?></p></td>
                    </tr>

                   

                        <?php 
                         $characters = array(',', '.', ' ');
                         $cleaned_number_debit = str_replace($characters, '', $item['debit']);
                         $cleaned_number_credit = str_replace($characters, '', $item['credit']);
                         $debit += $item['debit'];
                         $credit += $item['credit'];
                         

                        ?>

                    <?php }}?>
                        
                          
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                            <td>
                                <p class="text-danger"><?php echo '&#8369;'.htmlspecialchars(number_format($debit, 2)); ?></p>
                            </td>
                            <td><p class="text-success"><?php echo '&#8369;'.htmlspecialchars(number_format($credit, 2)); ?></p></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
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