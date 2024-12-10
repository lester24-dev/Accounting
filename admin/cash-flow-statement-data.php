<?php
include('../layout/admin_nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <p class="card-description">
                  <?php 
                             $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['customer_id']."'");
                             $row_depts = $userRef->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <h4 class="card-title">Name: <?php echo $row_depts['name'] ?></h4>
                    <h4 class="card-title">Cash Flow Statement</h4>
                  <a href="cash_flow_statement_data_pdf?transaction_id=<?php echo $_GET['transaction_id'] ?>&id=<?php echo $_GET['customer_id'] ?>" class="btn btn-danger">PDF</a>
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Operating Activities</th>
                          <th><?php echo'&#8369;' ?></th>
                          <th>Investing Activities</th>
                          <th><?php echo'&#8369;' ?></th>
                          <th>Financing Activities</th>
                          <th><?php echo'&#8369;' ?></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                            $stmt = $dbh->query("SELECT * FROM `cash-flow-statement-data`");
                            // Get the current items
                            $groupedEntries = [];
                            
                            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
                                if ($item['transaction_id'] === $_GET['transaction_id']) {
                                    $date = $item['date'];
                                        if (!isset($groupedEntries[$date])) {
                                            $groupedEntries[$date][] = [];
                                            
                            }
                                $groupedEntries[$date][] = $item;
                            }}

                        // Loop through the items to find the one with the matching name
                        foreach ($groupedEntries as $date => $items) {
                            $filteredArray = array_filter($items);
                            ?>

                        <tr>

                        <td><?php echo $date; ?></td>
                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                            <?php echo $item['operating_activities_name']; ?>
                            <?php }
                            ?>
                        </td>

                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                            <?php echo'&#8369;'.htmlspecialchars(number_format($item['operating_activities_amount'], 2)); ?>
                            <?php }
                            ?>
                        </td>

                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                           <?php echo $item['investing_activities_name']; ?>
                            <?php }
                            ?>
                        </td>

                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                            <?php echo '&#8369;'.htmlspecialchars(number_format($item['investing_activities_amount'], 2)); ?>
                            <?php }
                            ?>
                        </td>

                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                            <?php echo $item['financing_activities_name']; ?>
                            <?php }
                            ?>
                        </td>

                        <td> 
                           
                            <?php echo '&#8369;'.htmlspecialchars(number_format($item['financing_activities_amount'], 2)); ?>
                        </td>
                   
                        

                    <?php 
                    ?>
                   
                    </tr>

                    <?php 
                             $characters = array(',', '.', ' ', '-');
                             $operating_activities_amount += $item['operating_activities_amount'];
                             $investing_activities_amount += $item['investing_activities_amount'];
                             $financing_activities_amount += $item['financing_activities_amount'];
                            $cash_flow_final_balance = $operating_activities_amount + $investing_activities_amount + $financing_activities_amount;
                    ?>

                       
                    <?php }?>
                        
                          
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total Cash Flow: <?php echo '&#8369;'.htmlspecialchars(number_format($cash_flow_final_balance, 2)); ?></td>
                            <td>Total</td>
                            <td><?php echo '&#8369;'.htmlspecialchars(number_format($operating_activities_amount, 2)); ?></td>
                            <td>Total</td>
                            <td><?php echo '&#8369;'.htmlspecialchars(number_format($investing_activities_amount, 2)); ?></td>
                            <td>Total</td>
                            <td><?php echo '&#8369;'.htmlspecialchars(number_format($financing_acitivities_amount, 2)); ?></td>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>