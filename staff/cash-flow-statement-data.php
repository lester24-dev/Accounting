<?php
include('../layout/nav_header.php');
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
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AddModal">Add +</button>
                  <a href="cash_flow_statement_data_pdf?transaction_id=<?php echo $_GET['transaction_id'] ?>" class="btn btn-danger">PDF</a>
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
                          <th>Action</th>
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
                    <td>
                    <?php
                      foreach ($filteredArray as $item) {
                                ?>
                         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#supplyModal<?php echo $item['data_id']?>">Update</button>
                         <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $item['data_id']?>">Delete</button> <br> <br>

                         <div class="modal fade" id="supplyModal<?php echo $item['data_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cash Flow Statement Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <form action="../db/db" method="GET">
                                <div class="form-group">
                                    <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                    <input type="hidden" name="data_id" value="<?php echo $item['data_id']?>">
                                    <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id']?>">
                                </div>
                                
                                <label for="">Operating Activities</label>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="operating_activities_name" name="operating_activities_name" value="<?php echo $item['operating_activities_name']?>" placeholder=">Operating Activities Account">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="operating_activities_amount<?php echo $item['data_id']?>" name="operating_activities_amount" value="<?php echo $item['operating_activities_amount']?>" placeholder=">Operating Activities Amount">    
                                        </div>
                                    </div>
                                </div>

                                <label for="">Investing Activities</label>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="investing_activities_name" name="investing_activities_name" value="<?php echo $item['investing_activities_name']?>" placeholder="Investing Activities Account">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="investing_activities_amount<?php echo $item['data_id']?>" name="investing_activities_amount" value="<?php echo $item['investing_activities_amount']?>" placeholder="Investing Activities Amount">
                                        </div>
                                    </div>
                                </div>
                                
                                <label for="">Financing Activities</label>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="financing_activities_name" name="financing_activities_name" value="<?php echo $item['financing_activities_name']?>" placeholder="Financing Activities Account">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="financing_activities_amount<?php echo $item['data_id']?>" name="financing_activities_amount" value="<?php echo $item['financing_activities_amount']?>" placeholder="Financing Activities Amount">
                                        </div>
                                    </div>
                                </div>    

                                </div>
                                <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="update_cash_data_staff">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </form>
                            </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteModal<?php echo $item['data_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <form action="../db/db" method="GET" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                    <input type="hidden" name="data_id" value="<?php echo $item['data_id']?>">
                                    <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id']?>">
                                    <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id'] ?>">
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger" name="delete_cash_data_staff">Delete</button>
                                </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        

                    <?php }
                    ?>
                   
                    </td>
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

<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cash Flow Statement Info</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
        </button>
         </div>
            <div class="modal-body">
             <form action="../db/db" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                    <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id']?>">
                </div>

                <div class="form-group">
                    <select name="operating_activities_date" id="operating_activities_date" class="form-control" required="required">
                        <?php
                         $stmt = $dbh->query("SELECT * FROM `journal-data`");
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
                        <option value="<?php echo $date; ?>"><?php echo $date; ?></option>

                        <?php }?>
                    </select>
                    
                </div>

                <label for="">Operating Activities</label>

                <div class="row">
                    <div class="col-md-6">

                            <div class="form-group">
                            <select name="operating_activities_name" id="operating_activities_name" class="form-control" required="required">
                                <?php
                              $stmt = $dbh->query("SELECT * FROM `trial-data`");
                              // Array to track unique entries
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
                                <option value="<?php echo $account_name; ?>"><?php echo $account_name; ?></option>
                                <?php 
                                foreach ($filteredArray as $item) {}
                                }?>
                            </select>
                            
                        </div>

                    </div>
                    <div class="col-md-6">

                            <div class="form-group">
                            <select name="operating_activities_amount" id="operating_activities_amount" class="form-control" required="required">
                                <?php

                                $stmt = $dbh->query("SELECT * FROM `trial-data`");
                                // Array to track unique entries
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
                                    $amount_debit = 0; $amount_credit = 0;
                                    foreach ($filteredArray as $item) {
                                      if ($item['type'] == 'debit') {
                                            $amount_debit += $item['account_price'];
                                        }
                                        elseif ($item['type'] == 'credit') {
                                            $amount_credit += $item['account_price'];
                                        }
                                    }
                                    $balance_debit = 0;
                                    $balance_debit = intval($amount_debit - $amount_credit);

                                    if ($balance_debit < 0) {
                                        echo '<option value="'.htmlspecialchars(number_format(0, 2)).'">'.htmlspecialchars(number_format(0, 2)).'</option>' ;
                                    } else {
                                        $characters = array(',', ' ', '-');
                                        echo '<option value="'.htmlspecialchars(number_format($balance_debit, 2)).'">'.htmlspecialchars(number_format($balance_debit, 2)).'</option>' ;
                                    }

                                    }

                                    ?>
                                    
                                    <?php

                                    $stmt = $dbh->query("SELECT * FROM `trial-data`");
                                    // Array to track unique entries
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
                                        $amount_debit = 0; $amount_credit = 0;
                                        foreach ($filteredArray as $item) {
                                        if ($item['type'] == 'debit') {
                                                $amount_debit += $item['account_price'];
                                            }
                                            elseif ($item['type'] == 'credit') {
                                                $amount_credit += $item['account_price'];
                                            }
                                        }


                                    $balance_credit = 0;
                                    $balance_credit = intval($amount_debit - $amount_credit);

                                    if ($balance_credit < 0) {
                                        $characters = array(',', ' ', '-');
                                        $cleaned_number_amount_credit = str_replace($characters, '', $balance_credit);
                                        echo '<option value="'.htmlspecialchars(number_format($cleaned_number_amount_credit, 2)).'">'.htmlspecialchars(number_format($cleaned_number_amount_credit, 2)).'</option>' ;
                                    } else {
                                        $characters = array(',', ' ', '-');
                                        echo '<option value="'.htmlspecialchars(number_format(0, 2)).'">'.htmlspecialchars(number_format(0, 2)).'</option>';
                                    }
                                ?>

                                <?php }?>
                            </select>
                            
                        </div>
                        
                    </div>
                </div>

               

               

                <label for="">Investing Activities</label>

                <div class="row">
                    <div class="col-md-6">

                            <div class="form-group">
                            <select name="investing_activities_name" id="investing_activities_name" class="form-control" required="required">
                               <?php
                               $stmt = $dbh->query("SELECT * FROM `trial-data`");
                               // Array to track unique entries
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
                                 <option value="<?php echo $account_name; ?>"><?php echo $account_name; ?></option>
                                 <?php 
                                 foreach ($filteredArray as $item) {}
                                 }?>
                            </select>
                            
                        </div>

                    </div>
                    <div class="col-md-6">

                            <div class="form-group">
                            <select name="investing_activities_amount" id="investing_activities_amount" class="form-control" required="required">
                            <?php
                                $stmt = $dbh->query("SELECT * FROM `trial-data`");
                                // Array to track unique entries
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
                                    $amount_debit = 0; $amount_credit = 0;
                                    foreach ($filteredArray as $item) {
                                      if ($item['type'] == 'debit') {
                                            $amount_debit += $item['account_price'];
                                        }
                                        elseif ($item['type'] == 'credit') {
                                            $amount_credit += $item['account_price'];
                                        }
                                    }
                                    $balance_debit = 0;
                                    $balance_debit = intval($amount_debit - $amount_credit);

                                    if ($balance_debit < 0) {
                                        echo '<option value="'.htmlspecialchars(number_format(0, 2)).'">'.htmlspecialchars(number_format(0, 2)).'</option>' ;
                                    } else {
                                        $characters = array(',', ' ', '-');
                                        echo '<option value="'.htmlspecialchars(number_format($balance_debit, 2)).'">'.htmlspecialchars(number_format($balance_debit, 2)).'</option>' ;
                                    }

                                    }

                                    ?>
                                    
                                    <?php

                                    $stmt = $dbh->query("SELECT * FROM `trial-data`");
                                    // Array to track unique entries
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
                                        $amount_debit = 0; $amount_credit = 0;
                                        foreach ($filteredArray as $item) {
                                        if ($item['type'] == 'debit') {
                                                $amount_debit += $item['account_price'];
                                            }
                                            elseif ($item['type'] == 'credit') {
                                                $amount_credit += $item['account_price'];
                                            }
                                        }


                                    $balance_credit = 0;
                                    $balance_credit = intval($amount_debit - $amount_credit);

                                    if ($balance_credit < 0) {
                                        $characters = array(',', ' ', '-');
                                        $cleaned_number_amount_credit = str_replace($characters, '', $balance_credit);
                                        echo '<option value="'.htmlspecialchars(number_format($cleaned_number_amount_credit, 2)).'">'.htmlspecialchars(number_format($cleaned_number_amount_credit, 2)).'</option>' ;
                                    } else {
                                        $characters = array(',', ' ', '-');
                                        echo '<option value="'.htmlspecialchars(number_format(0, 2)).'">'.htmlspecialchars(number_format(0, 2)).'</option>';
                                    }
                                ?>

                                <?php }?>
                            </select>
                            
                        </div>
                        
                    </div>
                </div>

                <label for="">Financing Activities</label>

                <div class="row">
                    <div class="col-md-6">

                            <div class="form-group">
                            <select name="financing_activities_name" id="financing_activities_name" class="form-control" required="required">
                            <?php
                              $stmt = $dbh->query("SELECT * FROM `trial-data`");
                              // Array to track unique entries
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
                                <option value="<?php echo $account_name; ?>"><?php echo $account_name; ?></option>
                                <?php 
                                foreach ($filteredArray as $item) {}
                                }?>
                            </select>
                            
                        </div>

                    </div>
                    <div class="col-md-6">

                            <div class="form-group">
                            <select name="financing_activities_amount" id="financing_activities_amount" class="form-control" required="required">
                                <?php
                                $stmt = $dbh->query("SELECT * FROM `trial-data`");
                               // Array to track unique entries
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
                                   $amount_debit = 0; $amount_credit = 0;
                                   foreach ($filteredArray as $item) {
                                     if ($item['type'] == 'debit') {
                                           $amount_debit += $item['account_price'];
                                       }
                                       elseif ($item['type'] == 'credit') {
                                           $amount_credit += $item['account_price'];
                                       }
                                   }
                                   $balance_debit = 0;
                                   $balance_debit = intval($amount_debit - $amount_credit);

                                   if ($balance_debit < 0) {
                                       echo '<option value="'.htmlspecialchars(number_format(0, 2)).'">'.htmlspecialchars(number_format(0, 2)).'</option>' ;
                                   } else {
                                       $characters = array(',', ' ', '-');
                                       echo '<option value="'.htmlspecialchars(number_format($balance_debit, 2)).'">'.htmlspecialchars(number_format($balance_debit, 2)).'</option>' ;
                                   }

                                   }

                                   ?>
                                   
                                   <?php

                                    $stmt = $dbh->query("SELECT * FROM `trial-data`");
                                   // Array to track unique entries
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
                                       $amount_debit = 0; $amount_credit = 0;
                                       foreach ($filteredArray as $item) {
                                       if ($item['type'] == 'debit') {
                                               $amount_debit += $item['account_price'];
                                           }
                                           elseif ($item['type'] == 'credit') {
                                               $amount_credit += $item['account_price'];
                                           }
                                       }


                                   $balance_credit = 0;
                                   $balance_credit = intval($amount_debit - $amount_credit);

                                   if ($balance_credit < 0) {
                                       $characters = array(',', ' ', '-');
                                       $cleaned_number_amount_credit = str_replace($characters, '', $balance_credit);
                                       echo '<option value="'.htmlspecialchars(number_format($cleaned_number_amount_credit, 2)).'">'.htmlspecialchars(number_format($cleaned_number_amount_credit, 2)).'</option>' ;
                                   } else {
                                       $characters = array(',', ' ', '-');
                                       echo '<option value="'.htmlspecialchars(number_format(0, 2)).'">'.htmlspecialchars(number_format(0, 2)).'</option>';
                                   }
                               ?>

                               <?php }?>
                            </select>
                            <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id'] ?>">
                        </div>
                        
                    </div>
                </div>
                                
               
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="create_request_number_cash_staff">Add</button>
                 </div>
             </form>
        </div>
         </div>
        </div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

<?php 

foreach ($groupedEntries as $date => $items) {
    $filteredArray = array_filter($items);

    foreach ($filteredArray as $value) {
       
        ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const operating_activities_amount = document.getElementById("operating_activities_amount<?php echo $item['data_id']?>");
    const investing_activities_amount = document.getElementById("investing_activities_amount<?php echo $item['data_id']?>");
    const financing_acitivities_amount = document.getElementById("financing_activities_amount<?php echo $item['data_id']?>");

    operating_activities_amount.addEventListener("input", function(e) {
        const value = e.target.value;

        // Remove non-numeric characters except for the decimal point
        const cleanedValue = value.replace(/[^0-9.]/g, '');

        // Format the number as currency
        const formattedValue = formatToCurrency(cleanedValue);

        // Update the input field with the formatted value
        operating_activities_amount.value = formattedValue;
    });

    investing_activities_amount.addEventListener("input", function(e) {
        const value = e.target.value;

        // Remove non-numeric characters except for the decimal point
        const cleanedValue = value.replace(/[^0-9.]/g, '');

        // Format the number as currency
        const formattedValue = formatToCurrency(cleanedValue);

        // Update the input field with the formatted value
        investing_activities_amount.value = formattedValue;
    });

    financing_acitivities_amount.addEventListener("input", function(e) {
        const value = e.target.value;

        // Remove non-numeric characters except for the decimal point
        const cleanedValue = value.replace(/[^0-9.]/g, '');

        // Format the number as currency
        const formattedValue = formatToCurrency(cleanedValue);

        // Update the input field with the formatted value
        financing_acitivities_amount.value = formattedValue;
    });

    function formatToCurrency(value) {
        // Convert the value to a number and format it with commas
        const number = parseFloat(value);
        if (isNaN(number)) {
            return '';
        }

        // Use toLocaleString to format the number with commas and decimal places
        return number.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
});

</script>

        <?php
    }


}

?>