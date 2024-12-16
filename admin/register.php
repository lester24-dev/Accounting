<?php
include('../layout/admin_nav_header.php')
?>


<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Profile</h4>
                  <form action="../db/db.php" method="POST" enctype="multipart/form-data" onsubmit="return validatePasswords()">

                  <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="name" id="exampleInputUsername1" placeholder="Name" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="username" id="exampleInputUsername1" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email" id="exampleInputEmail1" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <select class="form-control form-control-lg" id="department" name="department" required>
                    <option>Department</option>
                    <option value="Company Customer">Company Customer</option>
                    <option value="Company Staff">Company Staff</option>
                  </select>
                </div>
                <div class="form-group" id="customer_dept" style="display: none;">
                  <select class="form-control form-control-lg" id="customer_depts" name="customer_dept" >
                    <option>Company Type</option>
                    <option value="None">none</option>
                    <option value="Single Proprietor">Single Proprietor</option>
                    <option value="Corporation">Corporation </option>
                    <option value="Partnership">Partnership </option>
                  </select>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <div class="form-group" >
                  <label for="" style="font-size:15px;">Profile Picture</label>
                  <input type="file" class="form-control form-control-lg" name="profile_img" id="profile_img" accept="image/*" >
                </div>
                <div class="form-group" id="dtis" style="display: none;">
                  <label for="" style="font-size:15px;">DTI </label>
                  <input type="file" class="form-control form-control-lg" name="dti"  accept="image/*" >
                </div>
                <div class="form-group" id="mayors_permit" style="display: none;">
                  <label for="" style="font-size:15px;">Mayors Permit </label>
                  <input type="file" class="form-control form-control-lg" name="mayors_permit" accept="image/*" >
                </div>
                <div class="form-group" id="bir" style="display: none;">
                  <label for="" style="font-size:15px;">BIR Certifcate of Registration </label>
                  <input type="file" class="form-control form-control-lg" name="bir" accept="image/*" >
                </div>
                <div class="form-group" id="sec" style="display: none;">
                  <label for="" style="font-size:15px;">SEC Certificate </label>
                  <input type="file" class="form-control form-control-lg" name="sec" accept="image/*" >
                </div>

                    
                 <div class="modal-footer">
                        <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="register" style="background-color:#008000;">Create Account</button>
                    </div>
                  </form>
                  
              </div>
            </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>


<script>
  const department = document.getElementById('department');
  const company_type = document.getElementById('customer_dept');
  const dtis = document.getElementById('dtis');
  const mayors_permits = document.getElementById('mayors_permit');
  const birs = document.getElementById('bir');
  const secs = document.getElementById('sec');

  department.addEventListener('change', () => {
  const selectedValue  = department.value;
    console.log(selectedValue);
  if (selectedValue  === 'Company Customer') {
    company_type.style.display = 'block';
  } 
  else {
    company_type.style.display = 'none';
    dtis.style.display = 'none';
    mayors_permits.style.display = 'none';
    birs.style.display = 'none';
    secs.style.display = 'none';
  }
});

</script>


<script>
 const company_types = document.getElementById('customer_depts');
  const dti = document.getElementById('dtis');
  const mayors_permit = document.getElementById('mayors_permit');
  const bir = document.getElementById('bir');
  const sec = document.getElementById('sec');

  company_types.addEventListener('change', () => {
    const selectedValue  = company_types.value;
    console.log(selectedValue);

  if (company_types.value === 'Single Proprietor') {
    dti.style.display = 'block';
    mayors_permit.style.display = 'block';
    bir.style.display = 'block';
    sec.style.display = 'none';
  } 
 else if  (company_types.value === 'Corporation')
  {
    sec.style.display = 'block';
    mayors_permit.style.display = 'block';
    bir.style.display = 'block';
    dti.style.display = 'none';
  }
  else if  (company_types.value === 'Partnership')
  {
    sec.style.display = 'block';
    mayors_permit.style.display = 'block';
    bir.style.display = 'block';
    dti.style.display = 'none';
  }
  else{
    dti.style.display = 'none';
    mayors_permit.style.display = 'none';
    bir.style.display = 'none';
    sec.style.display = 'none';
  }
});

function validatePasswords() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
</script>
