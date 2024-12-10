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
                                $row_dept = $userRef->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <h4 class="card-title">Name: <?php echo $row_depts['name'] ?></h4>
                    <h4 class="card-title">Journal Entries</h4>
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
                            <?php echo $item['account_debit']; ?> <br> <br>
                            <?php }
                             ?>
                        </td>
                        <td> 
                            <?php
                            foreach ($filteredArray as $item) {
                                ?>
                            <?php echo htmlspecialchars(number_format($item['amount_debit'], 2)); ?> <br> <br>
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
                            <?php echo htmlspecialchars(number_format($item['amount_credit'], 2)); ?> <br> <br>
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
             <form action="../db/firebaseDB" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                    <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id']?>">
                </div>
                                
                <div class="form-group">
                    <input type="date" class="form-control" id="date" name="date" placeholder="Account Date:">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" id="account_debit" name="account_debit"  placeholder="Account Debit:">
                </div>
                            
                <div class="form-group">
                    <input type="text" class="form-control" id="amount_debit" name="amount_debit"  placeholder="Amount Debit:">
                </div>

                <div class="form-group">
                     <input type="text" class="form-control" id="account_credit" name="account_credit"  placeholder="Account Credit:">
                </div>

                <div class="form-group">
                     <input type="text" class="form-control" id="amount_credit" name="amount_credit"  placeholder="Amount Credit:">
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="create_request_number_journal_admin">Add</button>
                 </div>
             </form>
        </div>
         </div>
        </div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
 <script src="../src/tableHTMLExport.js"></script>

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
