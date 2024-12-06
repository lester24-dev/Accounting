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
                    <h4 class="card-title">General Ledger</h4>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AddModal">Add +</button>
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
                                    <?php } ?>

                                </tr>

                                <?php 
                                    $characters = array(',', '.', ' ', '-');
                                    $cleaned_number_debit = str_replace($characters, '', $item['amount_debit']);
                                    $cleaned_number_credit = str_replace($characters, '', $item['amount_credit']);
                                    $debit += $item['amount_debit'];
                                    $credit += $item['amount_credit'];
                                    $balances += str_replace($characters, '', $balance);

                                    ?>

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

<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ledger Info</h5>
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
                    <input type="date" class="form-control" id="date" name="date" placeholder="Account Date:">
                </div>

                <div class="form-group">
                <select name="account_debit" id="account_debit" class="form-control" required="required">
                    <option value="">Account Debit</option>
                                    <?php 
                                       $stmt = $dbh->query("SELECT * FROM account");
                          
                                       // Loop through the items to find the one with the matching name
                                       foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
                                                                        
                                        ?>
                    <option value="<?php echo $key['account_name'] ?>"><?php echo $key['account_name'] ?></option>
                                                                    
                     <?php
                                        }   
                    ?>
                 </select>
                </div>
                            
                <div class="form-group">
                    <input type="text" class="form-control" id="amount_debit1" name="amount_debit"  placeholder="Amount Debit:">
                </div>

                <div class="form-group">
                <select name="account_credit" id="account_credit" class="form-control" required="required">
                                    <option value="">Account Credit</option>
                                    <?php 
                                        $stmt = $dbh->query("SELECT * FROM account");
                          
                                        // Loop through the items to find the one with the matching name
                                        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $key) {
                                                                        
                                        ?>
                                        <option value="<?php echo $key['account_name'] ?>"><?php echo $key['account_name'] ?></option>
                                                                    
                                    <?php
                                        }   
                                        ?>
                </select>
                </div>

                <div class="form-group">
                     <input type="text" class="form-control" id="amount_credit1" name="amount_credit"  placeholder="Amount Credit:">
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="create_request_number_ledger_staff">Add</button>
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
    const input = document.getElementById("amount_credit");
    const input1 = document.getElementById("amount_debit");

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