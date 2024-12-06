<?php
include('db.php');
session_start();
require_once("../phpqrcode/qrlib.php");
// error_reporting(0);

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM `department` WHERE username = :username AND password = :password";
    $stmt = $dbh->prepare($query); 
    $stmt->execute(array(':username' => $username, ':password'=> $password));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($username == 'admin' && $password = 'admin') {
        header("Location: ../admin/dashboard.php");
    }else if($row["department"] == 'Supply Officer'){
        header("Location: ../admin/dashboard.php");
    }else if($row["department"] == 'Second Admin'){
        $query = "SELECT * FROM `department` WHERE username = :username AND password = :password";
        $stmt = $dbh->prepare($query); 
        $stmt->execute(array(':username' => $username, ':password'=> $password));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!!$row['auth_token']) {
            $_SESSION["id"] = $row["id"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["password"] = $row["password"];
            $_SESSION["department"] = $row["department"];
            $_SESSION["profile_img"] = $row["profile_img"];
            $_SESSION["auth_token"] = $row["auth_token"];
            echo '<script>alert("Login Success")</script>';
             echo '<script>window.location.href="../admin/dashboard.php"</script>';
        }else{
            echo '<script>alert("Wrong password or email")</script>';
            echo '<script>window.location.href="../login.php"</script>';
        }
    }else{
        $query = "SELECT * FROM `department` WHERE username = :username AND password = :password";
        $stmt = $dbh->prepare($query); 
        $stmt->execute(array(':username' => $username, ':password'=> $password));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!!$row['auth_token']) {
            $_SESSION["id"] = $row["id"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["password"] = $row["password"];
            $_SESSION["department"] = $row["department"];
            $_SESSION["profile_img"] = $row["profile_img"];
            $_SESSION["auth_token"] = $row["auth_token"];
            echo '<script>alert("Login Success")</script>';
             echo '<script>window.location.href="../department_user/dashboard.php"</script>';
        }else{
            echo '<script>alert("Wrong password or email")</script>';
            echo '<script>window.location.href="../login.php"</script>';
        }
    } 

    // try {
    //     $user = $auth->getUserByEmail("$email");

    //     try {
    //          $signInResult = $auth->signInWithEmailAndPassword($email, $password);
    //          $idToeknString = $signInResult->idToken();
            
    //          echo '<script>alert("Login Success")</script>';
    //          echo '<script>window.location.href="../department_user/dashboard.php"</script>';

    //          try {
    //              $verifiedIdToken = $auth->verifyIdToken($idTokenString);
    //          } catch (InvalidToken $e) {
    //              echo 'The token is invalid: '.$e->getMessage();
    //          }catch (\InvalidArgumentException $e) {
    //              echo 'The token could not be parsed: '.$e->getMessage();
    //          }

    //     } catch (Exception $e) {
    //      echo '<script>alert("Invalid Password")</script>';
    //      echo '<script>window.location.href="../login.php"</script>';
    //     }

    //  } catch (\Kreait\Firebase\Exception\Auth\EmailNotFound $e) {
    //      echo '<script>alert("Invalid Email")</script>';
    //      echo '<script>window.location.href="../login.php"</script>';
    //  }
}

if (isset($_POST['register'])) {
    //    try {
    //     $data = [
    //         'username'    => $_POST['username'],
    //         'email'  => $_POST['email'],
    //         'reciever_img'  =>  $_POST['reciever_img'],
    //         'department'  => $_POST['department'],
    //         'password'    =>  $_POST['password'],
    //         'timestamp'    => date("M-d-Y"),
    //         'disabled' => false,
    //         'emailVerified' => true,
    //         ];
    
    //        $createDepartmentUser = $auth->createUser($data);
    //        if ($createDepartmentUser) {
    //         $postdata = $realtimeDatabase->getReference('User')->push($data);
    //         echo '<script>alert("Department Account Create")</script>';
    //         echo '<script>window.location.href="../login.php"</script>';
    //        }
    // } catch (\Kreait\Firebase\Exception\Auth\EmailExists $e) {
    //     echo $e->getMessage(); // "The email address is already in use by another account"
    //     echo '<script>alert("Department Account Have already existed")</script>';
    //     echo '<script>window.location.href="../register.php"</script>';
    // }
    $profile_img = $_FILES['profile_img']['name'];
    $image_tmp = $_FILES['profile_img']['tmp_name'];
    move_uploaded_file($image_tmp,"../uploads/$profile_img");
    $user_activation_email_code = md5(rand());
    $data = [
        'name'       => $_POST['name'],
        'username'    => $_POST['username'],
        'email'  => $_POST['email'],
        'password'    =>  $_POST['password'],
        'department'  => $_POST['department'],
        'profile_img' => $profile_img,
        'auth_token'    => $user_activation_email_code,
        ];

        $query = "
    	INSERT INTO department 
    	(name, username, email, password, department, profile_img, auth_token) 
    	VALUES (:name, :username, :email, :password, :department, :profile_img, :auth_token)
    	";

        $statement = $dbh->prepare($query);
    	if ($statement->execute($data)) {
            
            if($dbh->lastInsertId() == 0)
            {
                echo '<script>alert("Department Account Have already existed")</script>';
                echo '<script>window.location.href="../register.php"</script>';
            } 
            else
            {

                echo '<script>alert("Department Account Create")</script>';
                echo '<script>window.location.href="../login.php"</script>';
            }
        }else {
            header('Location: ../register.php');
        }
}

if (isset($_POST['admin'])) {
    //    try {
    //     $data = [
    //         'username'    => $_POST['username'],
    //         'email'  => $_POST['email'],
    //         'reciever_img'  =>  $_POST['reciever_img'],
    //         'department'  => $_POST['department'],
    //         'password'    =>  $_POST['password'],
    //         'timestamp'    => date("M-d-Y"),
    //         'disabled' => false,
    //         'emailVerified' => true,
    //         ];
    
    //        $createDepartmentUser = $auth->createUser($data);
    //        if ($createDepartmentUser) {
    //         $postdata = $realtimeDatabase->getReference('User')->push($data);
    //         echo '<script>alert("Department Account Create")</script>';
    //         echo '<script>window.location.href="../login.php"</script>';
    //        }
    // } catch (\Kreait\Firebase\Exception\Auth\EmailExists $e) {
    //     echo $e->getMessage(); // "The email address is already in use by another account"
    //     echo '<script>alert("Department Account Have already existed")</script>';
    //     echo '<script>window.location.href="../register.php"</script>';
    // }
    $user_activation_email_code = md5(rand());
    $data = [
        'name'       => $_POST['name'],
        'username'    => $_POST['username'],
        'email'  => $_POST['email'],
        'password'    =>  $_POST['password'],
        'department'  => $_POST['department'],
        'profile_img' => 'none',
        'auth_token'    => $user_activation_email_code,
        ];

        $query = "
    	INSERT INTO department 
    	(name, username, email, password, department, profile_img, auth_token) 
    	VALUES (:name, :username, :email, :password, :department, :profile_img, :auth_token)
    	";

        $statement = $dbh->prepare($query);
    	if ($statement->execute($data)) {
            
            if($dbh->lastInsertId() == 0)
            {
                echo '<script>alert("Office Account Have already existed")</script>';
                echo '<script>window.location.href="../register.php"</script>';
            } 
            else
            {

                echo '<script>alert("Office Account Create")</script>';
                echo '<script>window.location.href="../login.php"</script>';
            }
        }else {
            header('Location: ../login.php');
        }
}

if (isset($_POST['create_supply'])) {
    if (isset($_POST['name'])) {
        $image = $_FILES['image_supply']['name'];
        $image_tmp = $_FILES['image_supply']['tmp_name'];
        move_uploaded_file($image_tmp,"../uploads/$image");

        // if ($_POST['category'] == 'Bondpaper (Short)') {
        //     $size = '8.5 x 11 inches';
        // }elseif($_POST['category'] == 'Bondpaper (Long)'){
        //     $size = '8.5 x 14 inches';
        // }elseif($_POST['category'] == 'Folders (Short)'){
        //     $size = '9 x 12 inches';
        // }elseif($_POST['category'] == 'Folders (Long)'){
        //     $size = '9 x 14 inches';
        // }elseif($_POST['category'] == 'Binders (Round-Ring - 850 page)'){
        //     $size = '5 inches';
        // }elseif($_POST['category'] == 'Binders (Long)'){
        //     $size = '8.5 x 14 inches';
        // }elseif($_POST['category'] == 'Crayons 8 Count'){
        //     $size = '8';
        // }elseif($_POST['category'] == 'Crayons 16 Count'){
        //     $size = '16';
        // }elseif($_POST['category'] == 'Crayons 24 Count'){
        //     $size = '24';
        // }elseif($_POST['category'] == 'Crayons 32 Count'){
        //     $size = '32';
        // }elseif($_POST['category'] == 'Crayons 48 Count'){
        //     $size = '48';
        // }elseif($_POST['category'] == 'Crayons 64 Count'){
        //     $size = '64';
        // }elseif($_POST['category'] == 'Crayons 96 Count'){
        //     $size = '96';
        // }elseif($_POST['category'] == 'Crayons 120 Count'){
        //     $size = '120';
        // }elseif($_POST['category'] == 'Crayons 152 Count'){
        //     $size = '152';
        // }elseif($_POST['category'] == 'Pencil'){
        //     $size = '18 cm';
        // }elseif($_POST['category'] == 'Ballpen'){
        //     $size = '13 – 14 cm';
        // }
    
        $data = [
            'name'    => $_POST['name'],
            'size'    => $_POST['size'],
            'brand'   => $_POST['brand'],
            'total_supply'  =>  $_POST['total_supply'],
            'add_supply'    => 0,
            'minus_supply' => 0,
            'image_supply'    => $image,
            'qr_code' => 0,
            'category' => $_POST['category'],
            ];
    
            $query = "
            INSERT INTO supplies (name, size, brand, total_supply, add_supply, minus_supply, image_supply, qr_code, category) 
            VALUES (:name, :size, :brand, :total_supply, :add_supply, :minus_supply, :image_supply, :qr_code, :category)
            ";
    
            $statement = $dbh->prepare($query);
            if ($statement->execute($data)) {
                if($dbh->lastInsertId() == 0)
                {
                    echo '<script>alert("School Supplies Have already existed")</script>';
                    echo '<script>window.location.href="../admin/inventory.php"</script>';
                } 
                else
                {
    
                    echo '<script>alert("School Supplies Create")</script>';
                    echo '<script>window.location.href="../admin/inventory.php"</script>';
                }            
            }else {
            }
    }
}

if (isset($_GET['delete_supply'])) {
    $id = $_GET['id'];
    $stmt = $dbh->prepare( "DELETE FROM supplies WHERE id =:id" );
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        echo '<script>alert("School Supplies Have Delete")</script>';
        echo '<script>window.location.href="../admin/inventory.php"</script>';
    }
    if( ! $stmt->rowCount() ) echo "Deletion failed";
}

if (isset($_POST['update_department'])) {
   try {
    $image = $_FILES['profile_img']['name'];
    $image_tmp = $_FILES['profile_img']['tmp_name'];

    $sql  = "SELECT * FROM department WHERE id = '".$_POST['id']."'";
    $result_image = $dbh->query($sql, PDO::FETCH_ASSOC);

   foreach($result_image as $tr_row){

    if ($image == NULL ) {
        $image =  $tr_row['profile_img'];
    }else{

    }
   }

   $query = "UPDATE `department` SET `name` = :name, `username` = :username, `email` = :email, `department` = :department, `password` = :password, `profile_img` = :profile_img WHERE `id` = :id";
   $pdoResult = $dbh->prepare($query); 
   $pdoResult->bindParam(":name", $_POST['name']);
   $pdoResult->bindParam(":username", $_POST['username']);
   $pdoResult->bindParam(":email", $_POST['email']);
   $pdoResult->bindParam(":department", $_POST['department']);
   $pdoResult->bindParam(":password", $_POST['password']);
   $pdoResult->bindParam(":profile_img", $image);
   $pdoResult->bindParam(":id", $_POST['id']);
   $result = $pdoResult->execute();

   if($image == NULL)
   {
    echo '<script>alert("Image Have already existed")</script>';
    echo '<script>window.location.href="../department_user/profile.php"</script>';		
   }
   else
   {
   $image = $_FILES['profile_img']['name'];
   $image_tmp = $_FILES['profile_img']['tmp_name']; 
   move_uploaded_file($image_tmp,"../uploads/".$image);
   echo '<script>alert("Department Profile Update")</script>';
   echo '<script>window.location.href="../department_user/profile.php"</script>';	
   }	

   } catch (\Throwable $th) {
    //throw $th;
   }
}

if (isset($_POST['update_supply'])) {
    try {
        $image = $_FILES['image_supply']['name'];
        $image_tmp = $_FILES['image_supply']['tmp_name'];
        $total_supply = abs($_POST['total_supply'] + $_POST['add_supply']);
    
        $sql  = "SELECT * FROM school_supplies WHERE id = '".$_POST['id']."'";
        $result_image = $dbh->query($sql, PDO::FETCH_ASSOC);
    
       foreach($result_image as $tr_row){
    
        if ($image == NULL ) {
            $image =  $tr_row['image_supply'];
        }else{
    
        }
       }
    
       $query = "UPDATE `supplies` SET `name` = :name, `size` = :size, `brand` = :brand, `total_supply` = :total_supply, `add_supply` = :add_supply, `minus_supply` = :minus_supply, `image_supply` = :image_supply WHERE `id` = :id";
       $pdoResult = $dbh->prepare($query); 
       $pdoResult->bindParam(":name", $_POST['name']);
       $pdoResult->bindParam(":size", $_POST['size']);
       $pdoResult->bindParam(":brand", $_POST['brand']);
       $pdoResult->bindParam(":total_supply", abs($_POST['total_supply'] + $_POST['add_supply']));
       $pdoResult->bindParam(":add_supply", $_POST['add_supply']);
       $pdoResult->bindParam(":minus_supply", $_POST['minus_supply']);
       $pdoResult->bindParam(":image_supply", $image);
       $pdoResult->bindParam(":id", $_POST['id']);
       $result = $pdoResult->execute();
    
       if($image == NULL)
       {
        echo '<script>alert("Image Have already existed")</script>';
        echo '<script>window.location.href="../admin/inventory.php"</script>';		
       }
       else
       {
       $image = $_FILES['image_supply']['name'];
       $image_tmp = $_FILES['image_supply']['tmp_name']; 
       move_uploaded_file($image_tmp,"../uploads/".$image);
       echo '<script>alert("Supply Update")</script>';
       echo '<script>window.location.href="../admin/inventory.php"</script>';	
       }	
    
       } catch (\Throwable $th) {
        //throw $th;
       }
}

if (isset($_POST['create_request_number'])) {
    $rq_number = $_POST["rq_number"];
    $request_id =   $id = rand(1000000000, 9999999999);
    $department_id = $_POST['department_id'];
    $title = $_POST['title'];
    $status = "Pending";

    $data = [
        'request_id'     => $request_id,
        'department_id'  => $department_id,
        'title'   => $title,
        'status'    => $status,
        'message'  => $_POST['message'],
        'dates'    => date("Y-m-d h:i:s")
        ];

        $query = "
        INSERT INTO request (request_id, department_id, title, status, message, dates) 
        VALUES (:request_id, :department_id, :title, :status, :message, :dates)
        ";
        $statement = $dbh->prepare($query);


        $inv_queryss = "SELECT * FROM department WHERE id = :id";
        $inv_stmtsss = $dbh->prepare($inv_queryss); 
        $inv_stmtsss->bindParam(':id', $department_id, PDO::PARAM_INT);
        $inv_stmtsss->execute();
        $row = $inv_stmtsss->fetch(PDO::FETCH_ASSOC);
        $message = "New request from ".$row['name']." and request id is, ".$request_id.".!";

        $notif_data = [
            'title'  => $title,
            'department_id' => $department_id,
            'request_id'    => $request_id,
            'message'     => $message
        ];

        $notif_query = "
        INSERT INTO admin_notification (title, department_id, request_id, message) 
        VALUES (:title, :department_id, :request_id, :message)
        ";
        $notif_statement = $dbh->prepare($notif_query);


        if ($statement->execute($data) && $notif_statement->execute($notif_data)) {
            header('Location: ../department_user/request_form.php?rq_number='.$rq_number);
        }    
}

if (isset($_POST['approved_request'])) {
    $approved = "Approved";
    $finished = "Finished";

    $get_sup = $dbh->prepare("select * from supplies where name='$_POST[name]'");
    $get_sup->setFetchMode(PDO:: FETCH_ASSOC);
    $get_sup->execute();
    $row_sup=$get_sup->fetch();

    $get_dept = $dbh->prepare("select * from department where id='$_SESSION[id]'");
    $get_dept->setFetchMode(PDO:: FETCH_ASSOC);
    $get_dept->execute();
    $row_dept=$get_dept->fetch();

    $total_supply = abs($row_sup['total_supply'] - $_POST['qty']);
    $minus_supply = abs($row_sup['minus_supply'] + $_POST['qty']);

    $query = "UPDATE `supplies` SET `total_supply` = :total_supply, `minus_supply` = :minus_supply WHERE `name` = :name";
    $pdoResult = $dbh->prepare($query); 
    $pdoResult->bindParam(":total_supply", $total_supply);
    $pdoResult->bindParam(":minus_supply", $minus_supply);
    $pdoResult->bindParam(":name", $_POST['name']);

    $querys = "UPDATE `request` SET `status` = :status WHERE `request_id` = :request_id";
    $pdoResults = $dbh->prepare($querys); 
    $pdoResults->bindParam(":status", $finished);
    $pdoResults->bindParam(":request_id", $_POST['request_id']);

    $selectStmtQuery = $dbh->prepare("UPDATE `items` SET `status` = :status WHERE `id` = :id");
    $selectStmtQuery->bindParam(":status", $approved);
    $selectStmtQuery->bindParam(":id", $_POST['id']);

    $message = "Request ID: " . $_POST['request_id'] . " that you request an item " .$_POST['name']. " has been approved";

    $notif_data = [
        'title'  =>     'Notification to: ' . $row_dept['name'] . "",
        'department_id' => $_SESSION['id'],
        'request_id'    => $_POST['request_id'],
        'message'     => $message,
    ];

    $notif_query = "
    INSERT INTO department_notification (title, department_id, request_id, message) 
    VALUES (:title, :department_id, :request_id, :message)
    ";
    $notif_statement = $dbh->prepare($notif_query);

    if ($_POST['data_count'] > 1) {
        if($pdoResult->execute() && $notif_statement->execute($notif_data) && $selectStmtQuery->execute()){
            echo '<script>alert("Request Approved "'.$_POST["name"].'" ")</script>';
            echo '<script>window.location.href="../admin/request_modal.php?rq_number='.$_POST["request_id"].'"</script>';	
        }
    }else{
        if($pdoResult->execute() && $pdoResults->execute() && $notif_statement->execute($notif_data) && $selectStmtQuery->execute()){
            $path = "../qr_code/";
            $qr_code = $path.time().".png";
            QRcode::png($_POST['request_id'], $qr_code, 'H', 20, 5);
            $queryss = "UPDATE `request` SET `qr_code` = :qr_code WHERE `request_id` = :request_id";
            $pdoResultss = $dbh->prepare($queryss); 
            $pdoResultss->bindParam(":qr_code", $qr_code);
            $pdoResultss->bindParam(":request_id", $_POST['request_id']);
            $pdoResultss->execute();
            echo '<script>alert("Request Approved")</script>';
            echo '<script>window.location.href="../admin/request.php"</script>';	
        }
    }
    
}


if (isset($_POST['create_request'])) {
    $request_id =   $id = rand(1000000000, 9999999999);
    $department_id = $_POST['department_id'];
    $supply_id = $_POST['supply_id'];
    $title = $_POST['title'];
    $qty = $_POST['qty'];
    $units = $_POST['units'];


        $selectStmtQuery = "SELECT * FROM request ORDER BY id DESC LIMIT 1";
        $selectStmt = $dbh->query($selectStmtQuery); 
        $selectStmt->execute();
        $row = $selectStmt->fetch(PDO::FETCH_ASSOC);

        $inv_queryss = "SELECT * FROM request WHERE id = :id";
        $inv_stmtsss = $dbh->prepare($inv_queryss); 
        $inv_stmtsss->bindParam(':id', $row['id'], PDO::PARAM_INT);
        $inv_stmtsss->execute();
        $row = $inv_stmtsss->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $inv_query = "SELECT * FROM supplies WHERE id = :id";
            $inv_stmts = $dbh->prepare($inv_query); 
            $inv_stmts->bindParam(':id', $supply_id, PDO::PARAM_INT);
            $inv_stmts->execute();
            $inv_result = $inv_stmts->fetch();
            
            $data2 = [
                'request_id' => $row['request_id'],
                'name'   => $supply_id,
                'qty'    => $qty,
                'units'      => $units,
                'status'      => "Pending",
                "request_pid" => $row['id']
                ];
        
                $query2 = "
                INSERT INTO items (request_id, name, qty, units, status, request_pid) 
                VALUES (:request_id, :name, :qty, :units, :status, :request_pid)
                ";
                $statement = $dbh->prepare($query2);

                if ($statement->execute($data2)) {

                    if ($_POST['rq_number'] != 1) {
                        $index = abs((int)$_POST['rq_number'] - 1);
                        echo '<script>alert("Item name" '. $_POST['name'].'"Is Save")</script>';
                        echo '<script>window.location.href="../department_user/request_form.php?rq_number='.$index.'"</script>';
                    }else if ((int)$_POST['rq_number'] == 1) {
                        echo '<script>alert("Request Finished")</script>';
                        echo '<script>window.location.href="../department_user/request.php"</script>';
                    }
            }
    
           
        } else {
           
        }

}

if (isset($_POST['disapproved_request'])) {
    $canceled = "Canceled";
    $title = "Notification From Admin";
    $message = "Your request is out of stock, will update when we get supply. Thank You!";
    $finished = "Finished";
    
    $selectStmtQuery = $dbh->prepare("UPDATE `items` SET `status` = :status WHERE `id` = :id");
    $selectStmtQuery->bindParam(":status", $canceled);
    $selectStmtQuery->bindParam(":id", $_POST['id']);

    $message = "Request ID: " . $_POST['request_id'] . " that you request an item " .$_POST['name']. " has benn canceled";

    $notif_data = [
        'title'  =>        $title,
        'department_id' => $_SESSION['id'],
        'request_id'    => $_POST['request_id'],
        'message'     => $message,
    ];

    $notif_query = "
    INSERT INTO department_notification (title, department_id, request_id, message) 
    VALUES (:title, :department_id, :request_id, :message)
    ";
    $notif_statement = $dbh->prepare($notif_query);

    $querys = "UPDATE `request` SET `status` = :status WHERE `request_id` = :request_id";
    $pdoResults = $dbh->prepare($querys); 
    $pdoResults->bindParam(":status", $finished);
    $pdoResults->bindParam(":request_id", $_POST['request_id']);


    if ($_POST['data_count'] > 1) {
        if($notif_statement->execute($notif_data) && $selectStmtQuery->execute()){
            echo '<script>alert("Request Item Canceled "'.$_POST["name"].'" ")</script>';
            echo '<script>window.location.href="../admin/request_modal.php?rq_number='.$_POST["request_id"].'"</script>';	
        }
    }else{
        if($pdoResults->execute() && $notif_statement->execute($notif_data) && $selectStmtQuery->execute()){
            echo '<script>alert("Request Finished")</script>';
            echo '<script>window.location.href="../admin/request.php"</script>';	
        }
    }
}

?>