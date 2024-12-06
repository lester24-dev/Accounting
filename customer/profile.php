<?php
include('../layout/customer_nav_header.php');
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-16 grid-margin stretch-card">
              <div class="card shadow mb-4">
                <div class="card-body">
                  <h4 class="card-title">Profile</h4>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                          <input type="text" class="form-control form-control-lg" name="name" id="name" value="<?php echo $_SESSION['name']; ?>" id="name" placeholder="Name" required>
                        </div>
                        <div class="col-md-6">
                          <input type="text" class="form-control form-control-lg" id="username" name="username"  value="<?php echo $_SESSION['username']; ?>" id="username" placeholder="Username" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                            <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?php echo $_SESSION['email']; ?>"  id="email" placeholder="Email" required>
                         </div>
                         <div class="col-md-6">
                            <input type="password" class="form-control form-control-lg" id="password" name="password" value="<?php echo $_SESSION['password']; ?>" placeholder="Password" required>
                         </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="">Profile Image</label>
                          <input type="file" class="form-control form-control-lg" name="profile_img" id="profile_img" accept="image/*">
                        </div>
                        <?php 
                          if ($_SESSION['customer_dept'] == 'Single Proprietor') {?>
                        <div class="col-md-6">
                          <label for="">DTI</label>
                          <input type="file" class="form-control form-control-lg" name="dti" id="dti" accept="image/*">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="">Mayors Permit</label>
                          <input type="file" class="form-control form-control-lg" name="mayors_permit" id="mayors_permit" accept="image/*">
                        </div>
                        <div class="col-md-6">
                          <label for="">BIR Certifcate of Registration</label>
                          <input type="file" class="form-control form-control-lg" name="bir" id="bir" accept="image/*"> 
                        </div>
                      </div>
                    </div>
                    <?php }else{ ?>
                      <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="">Mayors Permit</label>
                          <input type="file" class="form-control form-control-lg" name="mayors_permit" id="mayors_permit" accept="image/*">
                        </div>
                        <div class="col-md-6">
                          <label for="">BIR Certifcate of Registration</label>
                          <input type="file" class="form-control form-control-lg" name="bir" id="bir" accept="image/*">
                        </div>
                        <div class="col-md-6">
                          <label for="">SEC Certificate</label>
                          <input type="file" class="form-control form-control-lg" name="sec" id="sec" accept="image/*">
                        </div>
                      </div>
                    </div>

                    <?php }?>
              </div>
        </div>
    </div>
</div>


<script>
document.getElementById("name").addEventListener("keyup", updateData);
document.getElementById("email").addEventListener("keyup", updateData);
document.getElementById("username").addEventListener("keyup", updateData);
document.getElementById("password").addEventListener("keyup", updateData);
  
  function updateData(){
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_data", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange   
 = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);   
 // Handle the response
        }
    };
    xhr.send("name=" + name + '&email=' + email + '&username=' + username + '&password=' + password );
}

</script>

<script>
  document.getElementById('profile_img').addEventListener('change', function() {
    var formData = new FormData();
    formData.append('profile_img', this.files[0]);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_data', true); // Replace 'upload.php' with the actual PHP script URL
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function() {
      if (xhr.status === 200) {
              console.log('Image successfully uploaded:', xhr.responseText);
          } else {
              console.error('Error uploading image:', xhr.statusText);
          }
    };

    xhr.send(formData);
});

document.getElementById('dti').addEventListener('change', function() {
    var formData = new FormData();
    formData.append('dti', this.files[0]);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_data', true); // Replace 'upload.php' with the actual PHP script URL
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function() {
      if (xhr.status === 200) {
              console.log('Image successfully uploaded:', xhr.responseText);
          } else {
              console.error('Error uploading image:', xhr.statusText);
          }
    };

    xhr.send(formData);
});

document.getElementById('mayors_permit').addEventListener('change', function() {
    var formData = new FormData();
    formData.append('mayors_permit', this.files[0]);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_data', true); // Replace 'upload.php' with the actual PHP script URL
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function() {
      if (xhr.status === 200) {
              console.log('Image successfully uploaded:', xhr.responseText);
          } else {
              console.error('Error uploading image:', xhr.statusText);
          }
    };

    xhr.send(formData);
});

document.getElementById('bir').addEventListener('change', function() {
    var formData = new FormData();
    formData.append('bir', this.files[0]);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_data', true); // Replace 'upload.php' with the actual PHP script URL
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function() {
      if (xhr.status === 200) {
              console.log('Image successfully uploaded:', xhr.responseText);
          } else {
              console.error('Error uploading image:', xhr.statusText);
          }
    };

    xhr.send(formData);
});

document.getElementById('sec').addEventListener('change', function() {
    var formData = new FormData();
    formData.append('sec', this.files[0]);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_data', true); // Replace 'upload.php' with the actual PHP script URL
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onload = function() {
      if (xhr.status === 200) {
              console.log('Image successfully uploaded:', xhr.responseText);
          } else {
              console.error('Error uploading image:', xhr.statusText);
          }
    };

    xhr.send(formData);
});
</script>