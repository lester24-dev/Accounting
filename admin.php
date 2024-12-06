<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Philippine State College of Aeronautics: PhilSCA Flying School</title>
  <!-- base:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="/vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
              </div>
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
              <form class="pt-3" action="db/firebaseDB.php" method="POST" enctype="multipart/form-data">
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
                  <select class="form-control form-control-lg" id="exampleFormControlSelect2" name="department" required>
                    <option>Department</option>
                    <option value="Second Admin">Second Admin</option>
                    <option value="Supply Officer">Supply Officer</option>
                  
                  </select>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password" required>
                </div>
                <!-- <div class="form-group">
                  <input type="file" class="form-control form-control-lg" name="profile_img" id="profile_img" required>
                </div> -->
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="admin" style="background-color:#008000;">REGISTER NOW!</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="login.php" style="color:#008000;">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src=".js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
</body>

</html>
