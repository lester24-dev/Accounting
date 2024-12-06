<?php
include('../layout/admin_nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                    <?php 
                            $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['customer_id']."'");
                            $row_depts = $userRef->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <h4 class="card-title">Name: <?php echo $row_depts['name'] ?></h4>
                    <h4 class="card-title">General Ledger</h4>
                  <p class="card-description">
                  <a href="ledger_data_pdf?transaction_id=<?php echo $_GET['transaction_id'] ?>" class="btn btn-danger">PDF</a>
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Account Title</th>
                          <th>Debit</th>
                          <th>Credit</th>
                          <th>Balance</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                            $stmt = $dbh->query("SELECT * FROM `journal-data`");
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
                                <?php echo $item['account_debit']; ?><hr><?php echo $item['account_credit']; ?> <br> <hr>
                                <?php }
                                ?>

                        </td>
                        <td>
                                    <?php
                                        foreach ($filteredArray as $item) {
                                            ?>
                                        <?php echo'&#8369;'.htmlspecialchars(number_format($item['amount_debit'], 2)); ?> <hr>
                                        <?php echo'&#8369;'.htmlspecialchars(number_format(0, 2)); ?><br> <hr>
                                        <?php }
                                        ?>

                        </td>
                        <td>
                                    <?php
                                        foreach ($filteredArray as $item) {
                                            ?>
                                        <?php echo'&#8369;'.htmlspecialchars(number_format(0, 2)); ?><hr>
                                        <?php echo'&#8369;'.htmlspecialchars(number_format($item['amount_credit'], 2)); ?> <br> <hr>
                                        <?php }
                                        ?>

                        </td>
                        <td>
                                    <?php
                                        foreach ($filteredArray as $item) {
                                            $characters = array(',', '.', ' ', '-');
                                            $amount_debit = $item['amount_debit'];
                                            $amount_credit = $item['amount_credit'];
                                            $balance += $amount_debit - $amount_credit;
                                            ?>
                                        <?php echo '&#8369;'.htmlspecialchars(number_format(str_replace($characters, '', $balance), 2)); ?> <br> <hr>
                                        <?php }
                                        ?>

                        </td>     
                    </tr>

                        <?php 
                         $characters = array(',', '.', ' ', '-');
                         $cleaned_number_debit = str_replace($characters, '', $item['amount_debit']);
                         $cleaned_number_credit = str_replace($characters, '', $item['amount_credit']);
                         $debit += $item['amount_debit'];
                         $credit += $item['amount_credit'];
                         $balances += str_replace($characters, '', $balance);

                        ?>

                    <?php }?>
                        
                          
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Final Balance</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo '&#8369;'.htmlspecialchars(number_format($balances, 2)); ?></td>
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