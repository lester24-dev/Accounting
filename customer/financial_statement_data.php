<?php
include('../layout/customer_nav_header.php');
error_reporting(0);
$total_net_income = 0;
$cleaned_number_total_revenue  = 0;
$cleaned_number_total_balance_expense  = 0;
$total_balance_assets  = 0;
$total_balance_liabilities = 0;
$total_balance_equity = 0;
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-md-6 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <p class="card-description">
                  <?php 
                              $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['customer_id']."'");
                              $row_depts = $userRef->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <h4 class="card-title">Name: <?php echo $row_depts['name'] ?></h4>
                    <h4 class="card-title">Income Statement</h4>
                  <a href="financial_statement_data_pdf?transaction_id=<?php echo $_GET['transaction_id'] ?>&id=<?php echo $_GET['customer_id']  ?>" class="btn btn-danger">PDF</a>
                  </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      
                      <?php 

                      $array_revenue = [];
                      $array_expense = [];
                      $groupedEntries = [];
                      $balance_revenue = 0;
                      $balance_expenses = 0;

                      $itemsRef_revenue = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Revenues'");
                      foreach ($itemsRef_revenue->fetchAll(PDO::FETCH_ASSOC) as $value) {
                        
                        $array_revenue[] = $value['account_name'];
                        
                      }

                      $itemsRef_expenses = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Expenses'");
                      foreach ($itemsRef_expenses->fetchAll(PDO::FETCH_ASSOC) as $value) {
                        
                        $array_expense[] = $value['account_name'];
                        
                      }

                    

                    
                      ?>

                      <thead>
                        <tr>
                          <th>Revenues</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                            $trailgroupedEntries = [];
                             $trial_itemsRef = $dbh->query("SELECT * FROM `trial-data`");
                             // Array to track unique entries
         
                             foreach ($trial_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
                                 if ($item['transaction_id'] == $_GET['transaction_id']) {
                                     $account_name = $item['account_name'];
                                         if (!isset($trailgroupedEntries[$account_name])) {
                                             $trailgroupedEntries[$account_name][] = [];
                                             
                             }
                                 $trailgroupedEntries[$account_name][] = $item;
                             }}
     
                             foreach ($trailgroupedEntries as $account_name => $account) {
                               $filteredArray = array_filter($account);
                               if (in_array($account_name, $array_revenue)) {
                          ?>
                        <tr>
                          
                          <td><?php echo $account_name; ?></td>
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
                                
                                $balance_revenue = intval($amount_debit - $amount_credit);
                                $characters = array(',', ' ', '-');
                                $cleaned_number_revenue = str_replace($characters, '', $balance_revenue); 
                                echo htmlspecialchars(number_format($cleaned_number_revenue, 2));

                                ?>

                             
                          </td>
                        </tr>

                        <?php 
                                $total_balance_revenue += $balance_revenue;
                                $characters = array(',', ' ', '-');
                                $cleaned_number_total_revenue = str_replace($characters, '', $total_balance_revenue); 
                                ?>
                        <?php } }?>

                        <tr>
                            <td>Total Revenues</td>
                            <td> 
                                    <?php 
                                      
                                      echo htmlspecialchars(number_format($cleaned_number_total_revenue, 2));
                                    ?>

                            </td>
                        </tr>


                    </tbody>

                    <thead>
                        <tr>
                          <th>Expenses</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php 

                             $trailgroupedEntries = [];
                             $trial_itemsRef = $trial_itemsRef = $dbh->query("SELECT * FROM `trial-data`");;
         
                             foreach ($trial_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
                                 if ($item['transaction_id'] == $_GET['transaction_id']) {
                                     $account_name = $item['account_name'];
                                         if (!isset($trailgroupedEntries[$account_name])) {
                                             $trailgroupedEntries[$account_name][] = [];
                                             
                             }
                                 $trailgroupedEntries[$account_name][] = $item;
                             }}
     
                             foreach ($trailgroupedEntries as $account_name => $account) {
                              $filteredArray = array_filter($account);
                               if (in_array($account_name, $array_expense)) {                             
                          ?>
                        <tr>
                       
                          <td><?php echo $account_name; ?></td>
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
                                      $balance_expenses = intval($amount_debit - $amount_credit);
                                      $characters = array(',', ' ', '-');
                                      $cleaned_number_expense = str_replace($characters, '', $balance_expenses); 
                                      echo htmlspecialchars(number_format($cleaned_number_expense, 2));
                                
                                ?>
                          </td>
                        </tr>

                                      <?php 
                                       $total_balance_expense += $balance_expenses;
                                       $characters = array(',', ' ', '-');
                                       $cleaned_number_total_balance_expense = str_replace($characters, '', $total_balance_expense);
                                      ?>
                        <?php } }?>


                        <tr>
                            <td>Total Expenses</td>
                            <td> 
                                    <?php  
                                      echo htmlspecialchars(number_format($cleaned_number_total_balance_expense, 2));
                                    ?>

                            </td>
                           </tr>

                    </tbody>

                    <thead>
                        <tr>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        
                       

                          <tr>
                            <td>Net Income</td>
                            <td>
                              <?php 
                                $total_net_income = intval($cleaned_number_total_revenue - $cleaned_number_total_balance_expense);
                                 echo  htmlspecialchars(number_format($total_net_income, 2));

                              ?>
                            </td>
                          </tr>
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

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <p class="card-description">
                  <?php 
                               $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['customer_id']."'");
                               $row_dept = $userRef->fetch(PDO::FETCH_ASSOC);
                    ?>
                  <h4 class="card-title">Name: <?php echo $row_depts['name'] ?></h4>
                  <h4 class="card-title">Balance Sheet</h4>
                  <a href="balance_sheet_data_pdf?transaction_id=<?php echo $_GET['transaction_id'] ?>&id=<?php echo $_GET['customer_id'] ?>" class="btn btn-danger">PDF</a>
                  </p>
                  <div class="table-responsive">

                    <?php 
                    $array_assets = [];
                    $array_liabilities = [];
                    $array_equity = [];
                    $groupedEntries = [];
                    $balance_assets = 0;
                    $balance_liabilities = 0;

                    $itemsRef_assets = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Assets'");
                    foreach ($itemsRef_assets->fetchAll(PDO::FETCH_ASSOC) as $value) {
                      
                      $array_assets[] = $value['account_name'];
                      
                    }

                    $itemsRef_liabilities = $dbh->query("SELECT * FROM `account` WHERE account_type = 'Liabilities'");
                    foreach ($itemsRef_liabilities->fetchAll(PDO::FETCH_ASSOC) as $value) {
                      
                      $array_liabilities[] = $value['account_name'];
                      
                    }

                    $itemsRef_equity =  $dbh->query("SELECT * FROM `account` WHERE account_type = 'Equity'");
                    foreach ($itemsRef_equity->fetchAll(PDO::FETCH_ASSOC) as $value) {
                      
                      $array_equity[] = $value['account_name'];
                      
                    }
                    
                    ?>
                    <table class="table" id="requests" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Assets</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php 
                         $trailgroupedEntries = [];
                         $trial_itemsRef = $dbh->query("SELECT * FROM `trial-data`");
     
                         foreach ($trial_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
                             if ($item['transaction_id'] == $_GET['transaction_id']) {
                                 $account_name = $item['account_name'];
                                     if (!isset($trailgroupedEntries[$account_name])) {
                                         $trailgroupedEntries[$account_name][] = [];
                                         
                         }
                             $trailgroupedEntries[$account_name][] = $item;
                         }}
 
                         foreach ($trailgroupedEntries as $account_name => $account) {
                              $filteredArray = array_filter($account);
                              if (in_array($account_name, $array_assets)) { 
                        ?>

                                  <tr>
                                    <td><?php echo $account_name; ?></td>
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
                                            $balance_assets = intval($amount_debit - $amount_credit);
                                            $characters = array(',', ' ', '-');
                                            $cleaned_assets = str_replace($characters, '', $balance_assets);
                                            echo htmlspecialchars(number_format($cleaned_assets, 2));
                                      
                                      ?>
                                    </td>

                                    <?php 
                                    $total_balance_assets += $balance_assets;
                                    $characters = array(',', ' ', '-');
                                    $cleaned_balance_assets = str_replace($characters, '', $total_balance_assets);
                                    ?>

                                  </tr>
                             

                        <?php }} ?>

                                <tr>
                                  <td>Total Assets</td>
                                  <td> 
                                          <?php 
                                            
                                            echo htmlspecialchars(number_format($cleaned_balance_assets, 2));
                                          ?>

                                  </td>
                              </tr>
                          
                      </tbody>

                      <thead>
                          <tr>
                            <th>Liabilities</th>
                            <th>Total</th>
                          </tr>
                      </thead>
                      <tbody>

                      <?php 
                         $trailgroupedEntries = [];
                         $trial_itemsRef =  $dbh->query("SELECT * FROM `trial-data`");
     
                         foreach ($trial_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
                             if ($item['transaction_id'] == $_GET['transaction_id']) {
                                 $account_name = $item['account_name'];
                                     if (!isset($trailgroupedEntries[$account_name])) {
                                         $trailgroupedEntries[$account_name][] = [];
                                         
                         }
                             $trailgroupedEntries[$account_name][] = $item;
                         }}
 
                         foreach ($trailgroupedEntries as $account_name => $account) {
                              $filteredArray = array_filter($account);
                              if (in_array($account_name, $array_liabilities)) { 
                        ?>

                              <tr>
                                <td><?php echo $account_name; ?></td>
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
                                            $balance_liabilities = intval($amount_debit - $amount_credit);
                                            $characters = array(',', ' ', '-');
                                            $cleaned_balance_liabilities = str_replace($characters, '', $balance_liabilities);
                                            echo htmlspecialchars(number_format($cleaned_balance_liabilities, 2));
                                      
                                      ?>
                                </td>

                              </tr>

                                          <?php 
                                           $total_balance_liabilities += $balance_liabilities;
                                           $characters = array(',', ' ', '-');
                                           $cleaned_balance_liabilities = str_replace($characters, '', $total_balance_liabilities);
                                          ?>
                              
                            <?php }} ?>


                            <tr>
                                <td>Total Liabilities</td>
                                <td> 
                                        <?php 
                                         
                                          echo htmlspecialchars(number_format($cleaned_balance_liabilities, 2));
                                        ?>

                                </td>
                              </tr>
                            
                      </tbody>
                     
                          
                    </tbody>

                    <thead>
                        <tr>
                          <th>Equity</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php
                      
                      $trailgroupedEntries = [];
                         $trial_itemsRef =  $dbh->query("SELECT * FROM `trial-data`");
     
                         foreach ($trial_itemsRef->fetchAll(PDO::FETCH_ASSOC) as $item) {
                             if ($item['transaction_id'] == $_GET['transaction_id']) {
                                 $account_name = $item['account_name'];
                                     if (!isset($trailgroupedEntries[$account_name])) {
                                         $trailgroupedEntries[$account_name][] = [];
                                         
                         }
                             $trailgroupedEntries[$account_name][] = $item;
                         }}
 
                         foreach ($trailgroupedEntries as $account_name => $account) {
                              $filteredArray = array_filter($account);
                              if (in_array($account_name, $array_equity)) { 
                        ?>

                                  <tr>
                                    <td><?php echo $account_name; ?></td>
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
                                            $balance_equity = intval($amount_debit - $amount_credit);
                                            $characters = array(',', ' ', '-');
                                            $cleaned_balance_equity = str_replace($characters, '', $balance_equity);
                                            echo htmlspecialchars(number_format($cleaned_balance_equity, 2));
                                      
                                      ?>
                                    </td>
                                  </tr>

                                            <?php 
                                             $total_balance_equity += $balance_equity;
                                             $characters = array(',', ' ', '-');
                                             $cleaned_balance_equity = str_replace($characters, '', $total_balance_equity);
                                            ?>
                            <?php }} ?>


                            <tr>
                                <td>Total Equity</td>
                                <td> 
                                        <?php 
                                         
                                          echo htmlspecialchars(number_format($cleaned_balance_equity, 2));
                                        ?>

                                </td>
                              </tr>
                     
                          
                    </tbody>

                    <thead>
                        <tr>
                          <th>Computation</th>
                          <th>Assets</th>
                        </tr>
                    </thead>

                    <tbody>
                      <tr>
                        <td><?php echo $cleaned_balance_liabilities ; echo " + " ; echo $cleaned_balance_equity ?></td>
                        <td> <?php 
                          $assets = $cleaned_balance_liabilities + $cleaned_balance_equity ;
                         echo htmlspecialchars(number_format($assets, 2));
                        ?> </td>
                      </tr>
                    </tbody>
                   
                    </table>

                        <script>
                            $(document).ready(function() {
                                $('#requests').DataTable({
                                  ordering: false
                                 });
                            });
                        </script>
                </div>
              </div>
            </div>
    </div>
</div>


<div class="main-panel">
  <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
      <div class="card shadow mb-4">
        <div class="card-body">
          <h4>Income Statement Tax</h4>

          <?php 
            $tax_value_pt = 0;
            $tax_value_ewt = 0;
            $tax_value_it = 0;

            
            $financialRef = $dbh->query("SELECT * FROM `financial-statement` WHERE transaction_id = '".$_GET['transaction_id']."'");
            $financialRef_depts = $financialRef->fetch(PDO::FETCH_ASSOC);

            $userRef = $dbh->query("SELECT * FROM users WHERE id = '".$financialRef_depts['customer_id']."'");
            $row_depts = $userRef->fetch(PDO::FETCH_ASSOC);

            $itemsRef_pt = $dbh->query("SELECT * FROM `tax` WHERE customer_id = '".$row_depts['id']."'");
            foreach ($itemsRef_pt->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
              if ($value['tax_name'] == 'Percentage Tax') {
                $tax_value_pt = $value['tax_value'];
              }
            }

            $itemsRef_ewt = $dbh->query("SELECT * FROM `etw_setting` WHERE transaction_id = '".$_GET['transaction_id']."'")->fetch(PDO::FETCH_ASSOC) ;
              $tax_value_ewt = $itemsRef_ewt['tax_value'];
            
            $itemsRef_it = $dbh->query("SELECT * FROM `tax` WHERE customer_id = '".$row_depts['id']."'");
            foreach ($itemsRef_it->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
              if ($value['tax_name'] == 'Income Tax') {
                $tax_value_it = $value['tax_value'];
              }
            }
          ?>

          <div class="table-responsive">
            <table class="table" id="request_tax" cellspacing="0">

            <thead>
              <th>Tax Name</th>
              <th>Net Income After Tax</th>
            </thead>

            <tbody>

                        <tr>
                            <td>Percentage Tax</td>
                            <td>
                              <?php 
                                $characters = array(',', ' ', '-');
                                $cleaned_number_net_income = str_replace($characters, '', $total_net_income);
                                $PTVAT =  $cleaned_number_total_revenue *  $tax_value_pt;
                                 echo  htmlspecialchars(number_format($PTVAT, 2));

                              ?>
                            </td>
                          </tr>

                          <!-- <tr>
                            <td>Expanded Withholding Tax</td>
                            <td>
                              <?php 
                                $characters = array(',', ' ', '-');
                                $cleaned_number_net_income = str_replace($characters, '', $total_net_income);
                                $EWTRATE = $cleaned_number_total_revenue * $tax_value_ewt ;
                                 echo  htmlspecialchars(number_format($EWTRATE, 2));

                              ?>
                            </td>
                          </tr> -->

                          <tr>
                            <td>Income Tax</td>
                            <td>
                              <?php 
                                $characters = array(',', ' ', '-');
                                $cleaned_number_net_income = str_replace($characters, '', $total_net_income);
                                  $ITRATE = $cleaned_number_total_revenue * $tax_value_it ;
                                 echo  htmlspecialchars(number_format($ITRATE, 2));

                              ?>
                            </td>
                          </tr>
            </tbody>

            </table>

            <script>
                            $(document).ready(function() {
                                $('#request_tax').DataTable({
                                  ordering: false
                                 });
                            });
                        </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>