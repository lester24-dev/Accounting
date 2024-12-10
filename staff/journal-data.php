<?php
include('../layout/nav_header.php');
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
                    <h4 class="card-title">Journal Entries</h4>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AddModal">Add +</button>
                  <a href="journal_data_pdf?transaction_id=<?php echo $_GET['transaction_id']; ?>&id=<?php echo $_GET['customer_id'] ?>" class="btn btn-danger">PDF</a>
                </p>
                  <div class="table-responsive">
                    <table class="table" id="request" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Account Debit</th>
                          <th>Amount Debit</th>
                          <th>Account Credit</th>
                          <th>Amount Credit</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
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
                    <tr>

                        <td><?php echo $date; ?></td>
                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                            <?php echo $item['account_debit']; ?> <br> <br>
                            <?php }
                             ?>
                        </td>
                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                            <?php echo '&#8369;'.htmlspecialchars(number_format($item['amount_debit'], 2)); ?> <br> <br>
                            <?php }
                        ?>
                        </td>
                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                        <?php echo $item['account_credit']; ?> <br> <br>
                        <?php }
                        ?>
                        </td>
                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                            <?php echo '&#8369;'.htmlspecialchars(number_format($item['amount_credit'], 2)); ?> <br> <br>
                            <?php }
                        ?>
                        </td>
                        <td>
                        <?php
                            foreach ($filteredArray as $key => $item) {
                                ?>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#supplyModal<?php echo $item['id'] ?>">Update</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $item['data_id'] ?>">Delete</button> <br> <br>
                       
                        <div class="modal fade" id="supplyModal<?php echo $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Journal Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <form action="../db/db" method="GET">

                                </script>
                                <div class="form-group">
                                    <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                    <input type="hidden" name="data_id" value="<?php echo $item['data_id'] ?>">
                                    <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id']?>">
                                    <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id']?>">
                                    <input type="hidden" name="key" value="<?php echo $item['id']?>">
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="account_debit" id="account_debit" class="form-control" required="required">
                                                <option value="<?php echo $item['account_debit']?>"><?php echo $item['account_debit']?></option>
                                                <?php 
                                                       $stmt = $dbh->query("SELECT * FROM account");
                                                       // Loop through the items to find the one with the matching name
                                                       foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
                                                            if ($key['account_name'] != 'Expanded Withholding Tax') {
                                                                # code...
                                                            
                                                                                        
                                                         ?>
                                                        <option value="<?php echo $key['account_name'] ?>"><?php echo $key['account_name'] ?></option>
                                                                                    
                                                    <?php
                                                          }  }   
                                                        ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="amount_debit<?php echo $item['data_id']?>" name="amount_debit" value="<?php echo $item['amount_debit']?>" placeholder="Amount Debit">    
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="account_credit" id="account_credit" class="form-control" required="required">
                                                <option value="<?php echo $item['account_credit']?>"><?php echo $item['account_credit']?></option>
                                                <?php 
                                                      $stmt = $dbh->query("SELECT * FROM account");
                                                      // Loop through the items to find the one with the matching name
                                                      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
                                                            if ($key['account_name'] != 'Expanded Withholding Tax') {
                                                                # code...
                                                            
                                                                                        
                                                         ?>
                                                        <option value="<?php echo $key['account_name'] ?>"><?php echo $key['account_name'] ?></option>
                                                                                    
                                                    <?php
                                                          }  }   
                                                        ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="amount_credit<?php echo $item['data_id']?>" name="amount_credit" value="<?php echo $item['amount_credit']?>" placeholder="Amount Credit">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- <input type="date" class="form-control" id="date" name="date" value='<?php echo $item['date'] ?>' placeholder="Date:"> -->
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="update_journal_data_staff">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </form>    
                            </div>
                            </div>
                            </div>
                        </div>


                        <div class="modal fade" id="deleteModal<?php echo $item['data_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="hidden" name="data_id" value="<?php echo $item['data_id'] ?>">
                                    <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id']?>">
                                    <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id']?>">
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger" name="delete_journal_data_staff">Delete</button>
                                </div>
                                </form>
                            </div>
                            </div>
                        </div>
                       
                       
                       <?php }
                        ?>
                        
                        </td>
                  </tr>

                    <?php }?>
                        
                          
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

<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Journal Info</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
        </button>
         </div>
            <div class="modal-body">
             <form action="../db/db" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                    <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id']?>">
                    <input type="hidden" name="customer_id" value="<?php echo $_GET['customer_id']?>">
                </div>
                                
                <div class="form-group">
                    <input type="date" class="form-control" id="date" name="date" placeholder="Account Date:">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="account_debit" id="account_debit1" class="form-control" required="required">
                                <option value="Account Debit">Account Debit</option>
                                <?php 
                                $stmt = $dbh->query("SELECT * FROM account");
                                // Loop through the items to find the one with the matching name
                                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
                                        if ($key['account_name'] != 'Expanded Withholding Tax') {
                                                                    
                                    ?>
                                    <option value="<?php echo $key['account_name'] ?>"><?php echo $key['account_name'] ?></option>
                                                                
                                <?php
                                    }  }   
                                    ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="amount_debit1" name="amount_debit"  placeholder="Amount Debit:">
                        </div>
                    </div>
                </div>
                            
                

                <div class="form-group" id="etw_debits" style="display:none;">
                    <select name="etw_debit" id="etw_debit" class="form-control">
                                    <option value="">--ETW List--</option>
                                    <?php 
                                    $stmt = $dbh->query("SELECT * FROM etw ");
                                    // Loop through the items to find the one with the matching name
                                    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
                                        if ($_GET['type'] == 'Corporation') {
                                           echo '<option value="'.$value['corp'].'">'.$value['corp'].'</option>';
                                        }
                                        else {
                                            echo '<option value="'.$value['ind'].'">'.$value['ind'].'</option>';
                                        }
                                    }
                                    ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <select name="account_credit" id="account_credit" class="form-control" required="required">
                            <option value="Account Credit">Account Credit</option>
                            <?php 
                            $stmt = $dbh->query("SELECT * FROM account ");
                            // Loop through the items to find the one with the matching name
                            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
                                    if ($key['account_name'] != 'Expanded Withholding Tax') {                  
                                ?>
                                <option value="<?php echo $key['account_name'] ?>"><?php echo $key['account_name'] ?></option>
                                                            
                            <?php
                                }  }   
                                ?>
                        </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="amount_credit1" name="amount_credit"  placeholder="Amount Credit:">
                        </div>
                    </div>
                </div>

               
                

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="create_request_number_journal_staff">Add</button>
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
    const input = document.getElementById("amount_credit<?php echo $item['data_id']?>");
    const input1 = document.getElementById("amount_debit<?php echo $item['data_id']?>");

    input.addEventListener("input", function(e) {
        const value = e.target.value;

        // Remove non-numeric characters except for the decimal point
        const cleanedValue = value.replace(/[^0-9.]/g, '');

        // Format the number as currency
        const formattedValue = formatToCurrency(cleanedValue);

        // Update the input field with the formatted value
        input.value = formattedValue;
    });

    input1.addEventListener("input", function(e) {
        const value = e.target.value;

        // Remove non-numeric characters except for the decimal point
        const cleanedValue = value.replace(/[^0-9.]/g, '');

        // Format the number as currency
        const formattedValue = formatToCurrency(cleanedValue);

        // Update the input field with the formatted value
        input1.value = formattedValue;
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById("amount_credit1");
    const input1 = document.getElementById("amount_debit1");

    input.addEventListener("input", function(e) {
        const value = e.target.value;

        // Remove non-numeric characters except for the decimal point
        const cleanedValue = value.replace(/[^0-9.]/g, '');

        // Format the number as currency
        const formattedValue = formatToCurrency(cleanedValue);

        // Update the input field with the formatted value
        input.value = formattedValue;
    });

    input1.addEventListener("input", function(e) {
        const value = e.target.value;

        // Remove non-numeric characters except for the decimal point
        const cleanedValue = value.replace(/[^0-9.]/g, '');

        // Format the number as currency
        const formattedValue = formatToCurrency(cleanedValue);

        // Update the input field with the formatted value
        input1.value = formattedValue;
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

<script>

document.addEventListener("DOMContentLoaded", function() {

    const wpt = ['Professional Services Expense', 'Commission Expense', 'Rent Expense', 'Subcontractor or Contractor Expense', 'Management and Consultancy Fees', "Director's Fee",
            'Bookkeeping Services Expense', 'Supplies or Materials Expense', 'Advertising and Media Expense', 'Processing or Tolling Fees', 'Income Distributions', 'Raw Material Purchases'];

                                    const etw_debits = document.getElementById('etw_debits');
                                    const account_debit = document.getElementById('account_debit1');

                                    account_debit.addEventListener('change', () => {
                                    const selectedValue  = account_debit.value;
                                    console.log(selectedValue);
                                    
                                    if (wpt.includes(selectedValue)) {
                                        etw_debits.style.display = 'block';
                                        
                                    } else {
                                        etw_debits.style.display = 'none';
                                    }

                                    })
})
    
</script>