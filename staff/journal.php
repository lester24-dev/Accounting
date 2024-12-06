<?php
include('../layout/nav_header.php');
?>

<div class="main-panel">
    <div class="content-wrapper">


    

                    <div class="col-lg-16 grid-margin stretch-card">
                        <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="../db/db" method="post">

                            <?php

                                $rq_number = $_GET['rq_number'];

                                for ($i = 1; $i <= $rq_number ; $i++) { 
                                    ?>

                                <script>
                                       document.addEventListener("DOMContentLoaded", function() {
                                        const input = document.getElementById('amount_debit<?php echo $i; ?>');
                                            const input1 = document.getElementById('amount_credit<?php echo $i ?>');
                                          

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

                                    const wpt = ['Prepaid Taxes', 'Tax Receivables', 'Withholding Tax Payable', 'Payroll Tax Payable', 'Federal Income Tax Payable', 'State Income Tax Payable',
                                                'Social Security Tax Payable', 'Medicare Tax Payable', 'Sales Tax Payable', 'Non-Resident Tax Payable', 'VAT Payable', 'Other Tax Payables', 'Income Tax Expense',
                                                'Payroll Tax Expense', 'Tax Withholding Expense', 'VAT Expense', 'Retained Earnings', 'Owner’s Equity'];

                                    const etw_debits = document.getElementById('etw_debits<?php echo $i; ?>');
                                    const account_debit = document.getElementById('account_debit<?php echo $i; ?>');

                                    account_debit.addEventListener('change', () => {
                                    const selectedValue  = account_debit.value;
                                    console.log(selectedValue);
                                    
                                    if (wpt.includes(selectedValue)) {
                                        etw_debits.style.display = 'block';
                                        
                                    } else {
                                        etw_debits.style.display = 'none';
                                    }

                                    })


                                    const wpts = ['Professional Services Expense', 'Commission Expense', 'Rent Expense', 'Subcontractor or Contractor Expense', 'Management and Consultancy Fees', "Director's Fee",
                                                'Bookkeeping Services Expense', 'Supplies or Materials Expense', 'Advertising and Media Expense', 'Processing or Tolling Fees', 'Income Distributions', 'Raw Material Purchases'];

                                    const etw_credits = document.getElementById('etw_credits<?php echo $i; ?>');
                                    const account_credit = document.getElementById('account_credit<?php echo $i; ?>');

                                    account_credit.addEventListener('change', () => {
                                    const selectedValue  = account_credit.value;
                                    console.log(selectedValue);
                                    
                                    if (wpts.includes(selectedValue)) {
                                        etw_credits.style.display = 'block';
                                        
                                    } else {
                                        etw_credits.style.display = 'none';
                                    }

                                    })

                                 })
                                   

                                    
                            </script>


                            <h4 class="card-title">Create Journal Item <?php echo $i ?></h4>

                            <div class="form-group">
                                <input type="hidden" class="form-control" id="transaction_id" name="transaction_id[]" value="<?php echo $_GET['transaction_id'] ?>">
                                <input type="hidden" class="form-control" id="rq_number" name="rq_number[]" value="<?php echo $_GET['rq_number'] ?>">
                                <input type="hidden" class="form-control" id="index" name="index" value="<?php echo $i ?>">
                                <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $rq_number ?>">
                            </div>

                            <div class="form-group">
                                <input type="date" class="form-control" id="date" name="date[]" placeholder="Account Date:">
                                <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $rq_number ?>">
                            </div>
                            
                            <div class="form-group">
                                <select name="account_debit[]" id="account_debit<?php echo $i; ?>" class="form-control" required="required">
                                    <option value="">Account Debit</option>
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
                                <input type="text" class="form-control" id="amount_debit<?php echo $i; ?>" name="amount_debit[]" placeholder="Amount Debit:">
                                <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $rq_number ?>">
                            </div>


                            <div class="form-group" id="etw_debits<?php echo $i; ?>" style="display:none;">
                                <select name="etw_debit[]" id="etw_debit<?php echo $i; ?>" class="form-control">
                                    <option value="">--ETW List--</option>
                                    <?php 
                                     $stmt = $dbh->query("SELECT * FROM etw");
                          
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

                            <div class="form-group">
                                <select name="account_credit[]" id="account_credit<?php echo $i; ?>" class="form-control" required="required">
                                    <option value="">Account Credit</option>
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
                                <input type="text" class="form-control" id="amount_credit<?php echo $i; ?>" name="amount_credit[]" placeholder="Amount Credit:">
                                <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $rq_number ?>">
                            </div>


                            <?php
                                        }

                            ?>


                            <hr>

                           

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="create_request_journal_staff" style="background-color:#008000;">Create Data</button>
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