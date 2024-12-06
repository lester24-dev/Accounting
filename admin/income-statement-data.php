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
                          <th>Update</th>
                          <th>Delete</th>
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
                    <td>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#supplyModal<?php echo $item['data_id']; ?>">Update</button>
                    </td>
                    <td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $item['transaction_id']; ?>">Delete</button>
                    </td>
                    </tr>

                    <div class="modal fade" id="supplyModal<?php echo $item['data_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Journal Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <form action="../db/firebaseDB" method="GET">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="journal_name" name="journal_name" value="<?php echo $item['journal_name']?>" placeholder="Journal Title">
                                    <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                    <input type="hidden" name="data_id" value="<?php echo $item['data_id']?>">
                                    <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id']?>">
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" class="form-control" id="debit" name="debit" value="<?php echo $item['debit']?>" placeholder="Debit">
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" id="credit" name="credit" value="<?php echo $item['credit']?>" placeholder="Credit:">
                                </div>

                               
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" name="update_journal_data_admin">Update</button>
                                </div>
                                </form>
                            </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteModal<?php echo $item['transaction_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <form action="../db/firebaseDB" method="GET" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="hidden" name="staff_id" value="<?php echo $_SESSION['id']?>">
                                    <input type="hidden" name="data_id" value="<?php echo $item['data_id']?>">
                                    <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id']?>">
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger" name="delete_journal_data_admin">Delete</button>
                                </div>
                                </form>
                            </div>
                            </div>
                        </div>

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
                    <input type="text" class="form-control" id="journal_name" name="journal_name[]" placeholder="Journal Name">
                    <input type="hidden" name="staff_id[]" value="<?php echo $_SESSION['id']?>">
                    <input type="hidden" name="transaction_id[]" value="<?php echo $_GET['transaction_id']?>">
                    <input type="hidden" class="form-control" id="i" name="i[]" value="1">
                </div>
                                
                    <div class="form-group">
                          <input type="text" class="form-control" id="debit1" name="debit[]" placeholder="Debit">
                    </div>

                     <div class="form-group">
                        <input type="text" class="form-control" id="credit1" name="credit[]" placeholder="Credit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="create_request_number_journal_admin">Add</button>
                 </div>
             </form>
        </div>
         </div>
        </div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById("credit1");
    const input1 = document.getElementById("debit1");

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
    const input = document.getElementById("credit");
    const input1 = document.getElementById("debit");

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