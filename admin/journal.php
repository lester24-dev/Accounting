<?php
include('../layout/admin_nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">


    

                    <div class="col-lg-16 grid-margin stretch-card">
                        <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="../db/firebaseDB" method="post">

                            <?php

                                $rq_number = $_GET['rq_number'];

                                for ($i = 1; $i <= $rq_number ; $i++) { 
                                    ?>

                                    <script>
                                       document.addEventListener("DOMContentLoaded", function() {
                                            const input = document.getElementById('debit<?php echo $i; ?>');
                                            const input1 = document.getElementById('credit<?php echo $i ?>');
                                          

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

                            <h4 class="card-title">Create Journal Item <?php echo $i ?></h4>

                            <div class="form-group">
                                <input type="text" class="form-control" id="journal_name" name="journal_name[]"  placeholder="Name:">
                            </div>

                            <div class="form-group">
                                <input type="hidden" class="form-control" id="transaction_id" name="transaction_id[]" value="<?php echo $_GET['transaction_id'] ?>">
                                <input type="hidden" class="form-control" id="rq_number" name="rq_number[]" value="<?php echo $_GET['rq_number'] ?>">
                                <input type="hidden" class="form-control" id="index" name="index" value="<?php echo $i ?>">
                                <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $rq_number ?>">
                                <input type="hidden" class="form-control" id="department_id" name="department_id" value="<?php echo $_GET['department_id'] ?>">
                            </div>

                            <div class="form-group">
                                <input type="date" class="form-control" id="date" name="date[]" placeholder="Date:">
                                <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $rq_number ?>">
                            </div>
                            
                            <div class="form-group">
                                <input type="text" class="form-control" id="debit<?php echo $i ?>" name="debit[]" placeholder="Debit:">
                                <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $rq_number ?>">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="credit<?php echo $i ?>" name="credit[]" placeholder="Credit:">
                                <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $rq_number ?>">
                            </div>
                        
                            <?php
                                        }

                            ?>

                            <hr>

                            <script>

                                        document.addEventListener("DOMContentLoaded", function() {
                                            const cash = document.getElementById('cash');
                                            const sales_revenue = document.getElementById('sales_revenue');
                                            const expenses = document.getElementById('expenses');
                                            const accounts_receivable = document.getElementById('accounts_receivable');
                                            const accrued_liabilities = document.getElementById('accrued_liabilities');

                                            accounts_receivable.addEventListener("input", function(e) {
                                            const value = e.target.value;

                                            // Remove non-numeric characters except for the decimal point
                                            const cleanedValue = value.replace(/[^0-9.]/g, '');

                                            // Format the number as currency
                                            const formattedValue = formatToCurrency(cleanedValue);

                                            // Update the input field with the formatted value
                                            accounts_receivable.value = formattedValue;
                                        });

                                        accrued_liabilities.addEventListener("input", function(e) {
                                            const value = e.target.value;

                                            // Remove non-numeric characters except for the decimal point
                                            const cleanedValue = value.replace(/[^0-9.]/g, '');

                                            // Format the number as currency
                                            const formattedValue = formatToCurrency(cleanedValue);

                                            // Update the input field with the formatted value
                                            accrued_liabilities.value = formattedValue;
                                        });

                                            cash.addEventListener("input", function(e) {
                                            const value = e.target.value;

                                            // Remove non-numeric characters except for the decimal point
                                            const cleanedValue = value.replace(/[^0-9.]/g, '');

                                            // Format the number as currency
                                            const formattedValue = formatToCurrency(cleanedValue);

                                            // Update the input field with the formatted value
                                            cash.value = formattedValue;
                                        });

                                        sales_revenue.addEventListener("input", function(e) {
                                            const value = e.target.value;

                                            // Remove non-numeric characters except for the decimal point
                                            const cleanedValue = value.replace(/[^0-9.]/g, '');

                                            // Format the number as currency
                                            const formattedValue = formatToCurrency(cleanedValue);

                                            // Update the input field with the formatted value
                                            sales_revenue.value = formattedValue;
                                        });

                                        expenses.addEventListener("input", function(e) {
                                            const value = e.target.value;

                                            // Remove non-numeric characters except for the decimal point
                                            const cleanedValue = value.replace(/[^0-9.]/g, '');

                                            // Format the number as currency
                                            const formattedValue = formatToCurrency(cleanedValue);

                                            // Update the input field with the formatted value
                                            expenses.value = formattedValue;
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

                            
                            <h4 class="card-title">Transaction Info</h4>

                            <div class="form-group">
                                <input type="text" class="form-control" id="cash" name="cash" placeholder="Cash:">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="accounts_receivable" name="accounts_receivable" placeholder="Accounts Receivable:">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="accrued_liabilities" name="accrued_liabilities" placeholder="Accrued Liabilities:">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="sales_revenue" name="sales_revenue" placeholder="Sales Revenue:">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="expenses" name="expenses" placeholder="Expenses:">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="create_request_journal_admin" style="background-color:#008000;">Create Data</button>
                            </div>


                            </form>
                        </div>
                            
                        </div>
                    </div>
   
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>