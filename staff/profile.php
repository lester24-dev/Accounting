<?php
include('../layout/nav_header.php');
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
                          <input type="text" class="form-control form-control-lg" name="name" value="<?php echo $_SESSION['name']; ?>" id="name" placeholder="Name" required>
                        </div>
                        <div class="col-md-6">
                          <input type="text" class="form-control form-control-lg" name="username"  value="<?php echo $_SESSION['username']; ?>" id="username" placeholder="Username" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                           <input type="email" class="form-control form-control-lg" name="email" value="<?php echo $_SESSION['email']; ?>"  id="email" placeholder="Email" required>
                        </div>
                        <div class="col-md-6">
                           <input type="password" class="form-control form-control-lg" id="password" name="password" value="<?php echo $_SESSION['password']; ?>" placeholder="Password" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                    <input type="file" class="form-control form-control-lg" name="profile_img" id="profile_img">
                    </div>
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

</script>