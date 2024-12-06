<?php 
include("../db/db.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES['profile_img'])) {

        $profile_img = $_FILES['profile_img']['name'];
		$profile_img_tmp_name = $_FILES['profile_img']['tmp_name'];
		$image = $_FILES['profile_img'];
		
	     move_uploaded_file($profile_img_tmp_name,"../uploads/$profile_img");


         $sql = "UPDATE `users` SET `profile_img`= :profile_img WHERE id = :id";

         $stmt = $dbh->prepare($sql);
         $stmt->execute([
             'profile_img'    => $profile_img,
             'id'          => $_SESSION['id']
         ]);

         $_SESSION['profile_img'] = $_SESSION['profile_img'];

    } else if (isset($_FILES['dti'])) {

        $dti = $_FILES['dti']['name'];
		$dti_tmp_name = $_FILES['dti']['tmp_name'];
		$image = $_FILES['dti'];
		
	     move_uploaded_file($dti_tmp_name,"../uploads/$dti");


         $sql = "UPDATE `users` SET `dti`= :dti WHERE id = :id";

         $stmt = $dbh->prepare($sql);
         $stmt->execute([
             'dti'    => $dti,
             'id'          => $_SESSION['id']
         ]);

         $_SESSION['dti'] = $_SESSION['dti'];

    }else if (isset($_FILES['mayors_permit'])) {

        $mayors_permit = $_FILES['mayors_permit']['name'];
		$mayors_permit_tmp_name = $_FILES['mayors_permit']['tmp_name'];
		$image = $_FILES['mayors_permit'];
		
	     move_uploaded_file($mayors_permit_tmp_name,"../uploads/$mayors_permit");


         $sql = "UPDATE `users` SET `mayors_permit`= :mayors_permit WHERE id = :id";

         $stmt = $dbh->prepare($sql);
         $stmt->execute([
             'mayors_permit'    => $mayors_permit,
             'id'          => $_SESSION['id']
         ]);
         $_SESSION['mayors_permit'] = $_SESSION['mayors_permit'];

    }else if (isset($_FILES['bir'])) {

        $bir = $_FILES['bir']['name'];
		$bir_tmp_name = $_FILES['bir']['tmp_name'];
		$image = $_FILES['bir'];
		
	     move_uploaded_file($bir_tmp_name,"../uploads/$bir");


         $sql = "UPDATE `users` SET `bir`= :bir WHERE id = :id";

         $stmt = $dbh->prepare($sql);
         $stmt->execute([
             'bir'    => $bir,
             'id'          => $_SESSION['id']
         ]);

         $_SESSION['bir'] = $_SESSION['bir'];

    }else if (isset($_FILES['sec'])) {

        $sec = $_FILES['sec']['name'];
		$sec_tmp_name = $_FILES['sec']['tmp_name'];
		$image = $_FILES['sec'];
		
	     move_uploaded_file($sec_tmp_name,"../uploads/$sec");


         $sql = "UPDATE `users` SET `sec`= :sec WHERE id = :id";

         $stmt = $dbh->prepare($sql);
         $stmt->execute([
             'sec'    => $sec,
             'id'          => $_SESSION['id']
         ]);


         $_SESSION['sec'] = $_SESSION['sec'];

    }else {
       
        $sql = "UPDATE `users` SET `email`= :email, `name`= :name, `password`= :password, `username`= :username WHERE id = :id";

        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            'name'    => $_POST['name'],
            'email'    => $_POST['email'],
            'username'    => $_POST['username'],
            'password'    => $_POST['password'],
            'id'          => $_SESSION['id']
        ]);

        $_SESSION['name'] = $_POST['name'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['status'] = $_POST['status'];
        $_SESSION['department'] = $_SESSION['department'];
        $_SESSION['customer_dept'] = $_SESSION['customer_dept'];
        $_SESSION['bir'] = $_SESSION['bir'];
        $_SESSION['dti'] = $_SESSION['dti'];
        $_SESSION['mayors_permit'] = $_SESSION['mayors_permit'];
        $_SESSION['sec'] = $_SESSION['sec'];
    }

}


?>