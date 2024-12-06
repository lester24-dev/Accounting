<?php
include('../layout/nav_header.php');
error_reporting(0);
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-lg-16 grid-margin stretch-card">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="../db/db?transaction_id=<?php echo $_GET['transaction_id'] ?>&department_id=<?php echo $_GET['department_id'] ?>" method="post">
                        
                        <?php 
                        $rq_number = $_GET['rq_number'];
                        for ($i=1; $i <= $rq_number ; $i++) { 
                        ?>
                         <h4 class="card-title">Create Sale Forcast Item <?php echo $i ?></h4>
                         
                         <div class="form-group">
                           <input type="hidden" class="form-control" id="rq_number" name="rq_number[]" value="<?php echo $_GET['rq_number'] ?>">
                           <input type="hidden" class="form-control" id="index" name="index" value="<?php echo $i ?>">
                           <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $rq_number ?>">
                           <input type="hidden" class="form-control" id="department_id" name="department_id" value="<?php echo $_GET['department_id'] ?>">
                           <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $_GET['customer_id'] ?>">
                         </div>

                         <div class="form-group">
                             <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="year[]" id="year[]" required>
                                <option>Year List</option>
                                <?php 
                                $currentYear = date("Y");
                                for ($year = 2000; $year <= $currentYear; $year++) {
                                ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php }?>
                                </select>
                                <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $i ?>">
                         </div>

                      

                        
                         <div class="form-group">
                            <input type="text" name="forecast_value[]" id="forecast_value" class="form-control">
                            <input type="hidden" class="form-control" id="i" name="i[]" value="<?php echo $i ?>">
                        </div>
                        

                        <?php
                        }
                        ?>
                        <div class="modal-footer">
                                <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="create_request_forecast_staff" style="background-color:#008000;">Create Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
