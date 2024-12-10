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
                  <?php 
                              $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_SESSION['id']."'");
                              $row_depts = $userRef->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <h4 class="card-title">Name: <?php echo $row_depts['name'] ?></h4>
                    <h4 class="card-title">Trial Balance</h4>
                  <a href="trial_data_pdf?transaction_id=<?php echo $_GET['transaction_id'] ?>&id=<?php echo $_GET['customer_id']  ?>" class="btn btn-danger">PDF</a>
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Account Name</th>
                          <th>Debit</th>
                          <th>Credit</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      <?php
                     $stmt = $dbh->query("SELECT * FROM `trial-data`");
                     $groupedEntries = [];

                     foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $item) {
                            if ($item['transaction_id'] == $_GET['transaction_id']) {
                                $account_name = $item['account_name'];
                                    if (!isset($groupedEntries[$account_name])) {
                                        $groupedEntries[$account_name][] = [];
                                        
                        }
                            $groupedEntries[$account_name][] = $item;
                        }}

                        foreach ($groupedEntries as $account_name => $account) {
                            $filteredArray = array_filter($account);

                      ?>

                      <tr>
                            <td>
                                <?php 
                                echo $account_name; 
                                foreach ($filteredArray as $item) {
                                    
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $amount_debit = 0; $amount_credit = 0;

                                   foreach ($filteredArray as $item) {
                                    if ($item['type'] == 'debit') {
                                        $amount_debit += $item['account_price'];
                                    }
                                    elseif ($item['type'] == 'credit') {
                                        $amount_credit += $item['account_price'];
                                    }
                                  
                                }
                                $balance = 0;
                                $balance = intval($amount_debit - $amount_credit);

                                if ($amount_debit > 0) {
                                    $characters = array(',', ' ', '-');
                                    $cleaned_number_amount_debit = str_replace($characters, '', $balance);
                                    echo htmlspecialchars(number_format($cleaned_number_amount_debit, 2));
                                    $cleaned_number_amount_debittotal += str_replace($characters, '', $balance);
                                } else {
                                    $characters = array(',', ' ', '-');

                                    echo htmlspecialchars(number_format(0, 2));
                                }
                                

                                   
                                ?>
                            </td>
                            <td>
                                <?php

                                 $amount_debit = 0; $amount_credit = 0;

                                   foreach ($filteredArray as $item) {
                                    if ($item['type'] == 'debit') {
                                        $amount_debit += $item['account_price'];
                                    }
                                    elseif ($item['type'] == 'credit') {
                                        $amount_credit += $item['account_price'];
                                    }
                                  
                                }
                                $balance = 0;
                                $balance = intval($amount_debit - $amount_credit);

                                if ($balance < 0) {
                                    $characters = array(',', ' ', '-');
                                    $cleaned_number_amount_credit = str_replace($characters, '', $balance);
                                    echo htmlspecialchars(number_format($cleaned_number_amount_credit, 2));
                                    $cleaned_number_amount_credittotal += str_replace($characters, '', $balance);
                                } else {
                                    $characters = array(',', ' ', '-');

                                    echo htmlspecialchars(number_format(0, 2));
                                }
                               

                                ?>
                            </td>
                      </tr>

                      <?php }?>

                          
                    </tbody>
                    <tfoot>
                        <td></td>
                        <td><?php echo htmlspecialchars(number_format($cleaned_number_amount_debittotal, 2)) ?></td>
                        <td><?php echo htmlspecialchars(number_format($cleaned_number_amount_credittotal, 2)) ?></td>
                    </tfoot>
                    
                    </table>
                    <script>
                        $(document).ready(function() {
                                // Initialize DataTable
                                var table = $('#request').DataTable({
                                    ordering: false,
                                 
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