<?php
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
session_start();
error_reporting(0);

try {
	$dbh = new PDO('mysql:host=localhost;dbname=gcm;charset=utf8mb4','root','');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
	die($e->getMessage());
}




if (isset($_POST['login'])) {
	try {
		$email = $_POST['email'];
    	$password = $_POST['password'];

	$select = $dbh->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
	$userData = $select->fetch(PDO::FETCH_ASSOC);
	if ($userData['department'] == 'Company Staff' ) {
		$_SESSION['id'] = $userData['id'];
		$_SESSION['name'] = $userData['name'];
		$_SESSION['email'] = $userData['email'];
		$_SESSION['username'] = $userData['username'];
		$_SESSION['password'] = $userData['password'];
		$_SESSION['department'] = $userData['department'];
		$_SESSION['customer_dept'] = $userData['customer_dept'];
		$_SESSION['profile_img'] = $userData['profile_img'];
		$_SESSION['bir'] = $userData['bir'];
		$_SESSION['dti'] = $userData['dti'];
		$_SESSION['mayors_permit'] = $userData['mayors_permit'];
		$_SESSION['sec'] = $userData['sec'];
		echo '<script>window.location.href="../staff/dashboard"</script>';
	}elseif ($userData['department'] == 'Company Customer') {
		$_SESSION['id'] = $userData['id'];
		$_SESSION['name'] = $userData['name'];
		$_SESSION['email'] = $userData['email'];
		$_SESSION['username'] = $userData['username'];
		$_SESSION['password'] = $userData['password'];
		$_SESSION['customer_dept'] = $userData['customer_dept'];
		$_SESSION['department'] = $userData['department'];
		$_SESSION['profile_img'] = $userData['profile_img'];
		$_SESSION['bir'] = $userData['bir'];
		$_SESSION['dti'] = $userData['dti'];
		$_SESSION['mayors_permit'] = $userData['mayors_permit'];
		$_SESSION['sec'] = $userData['sec'];
		echo '<script>window.location.href="../customer/dashboard"</script>';
	}elseif ($userData['department'] == 'Company Admin'){
		$_SESSION['id'] = $userData['id'];
		$_SESSION['name'] = $userData['name'];
		$_SESSION['email'] = $userData['email'];
		$_SESSION['username'] = $userData['username'];
		$_SESSION['password'] = $userData['password'];
		$_SESSION['customer_dept'] = $userData['customer_dept'];
		$_SESSION['department'] = $userData['department'];
		$_SESSION['profile_img'] = $userData['profile_img'];
		$_SESSION['bir'] = $userData['bir'];
		$_SESSION['dti'] = $userData['dti'];
		$_SESSION['mayors_permit'] = $userData['mayors_permit'];
		$_SESSION['sec'] = $userData['sec'];
		echo '<script>alert("Login Success")</script>';
		echo '<script>window.location.href="../admin/dashboard"</script>';
	}else {
		echo '<script>alert("Wrong credential")</script>';
		echo '<script>window.location.href="../login"</script>';
	}
	} catch (\Throwable $th) {
	  throw $th;
	}
}

if (isset($_POST['register'])) {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$profile_img = $_FILES['profile_img']['name'];
		$profile_img_tmp_name = $_FILES['profile_img']['tmp_name'];
		$image = $_FILES['profile_img'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		
	     move_uploaded_file($profile_img_tmp_name,"../uploads/$profile_img");
		
		 if ($_POST['customer_dept'] == 'Single Proprietor') {
			$dti = $_FILES['dti']['name'];
			$dti_tmp = $_FILES['dti']['tmp_name'];
			$bir = $_FILES['bir']['name'];

			$bir_tmp = $_FILES['bir']['tmp_name'];
			$mayors_permit = $_FILES['mayors_permit']['name'];
			$mayors_permit_tmp = $_FILES['mayors_permit']['tmp_name'];

			move_uploaded_file($dti_tmp,"../uploads/$dti");
			move_uploaded_file($bir_tmp,"../uploads/$bir");
			move_uploaded_file($mayors_permit_tmp,"../uploads/$mayors_permit");

			$sql = "INSERT INTO users ( `bir`, `customer_dept`, `department`, `dti`, `email`, `mayors_permit`, `name`, `password`, `profile_img`, `sec`, `timestamp`, `username`) 
			VALUES (:bir, :customer_dept, :department, :dti, :email, :mayors_permit, :name, :password, :profile_img, :sec, :timestamp, :username)";
			$stmt = $dbh->prepare($sql);

			$data = [
				'username'    => $_POST['username'],
				'email'  => $_POST['email'],
				'name'  => $_POST['name'],
				'department'  => $_POST['department'],
				'password'    =>  $_POST['password'],
				'customer_dept' => $_POST['customer_dept'],
				'profile_img'  =>  $profile_img,
				'dti'          =>  $dti,
				'mayors_permit' =>  $mayors_permit,
				'bir'          =>  $bir,
				'sec'          =>  'none',
				'timestamp'    => date("M-d-Y"),
				];

				if ($password == $confirm_password) {
					if ($stmt->execute($data)) {
						echo '<script>alert("Department Account Create")</script>';
						echo '<script>window.location.href="../admin/department"</script>';
					}
				}
				else {
					echo '<script>alert("Passwords do not match. Please try again")</script>';
					echo '<script>window.location.href="../admin/register"</script>';
				}
				
			
		 }

		 else if($_POST['customer_dept'] == 'Corporation'){
			$sec = $_FILES['sec']['name'];
			$sec_tmp = $_FILES['sec']['tmp_name'];
			$dti = $_FILES['dti']['name'];
			$dti_tmp = $_FILES['dti']['tmp_name'];
			$mayors_permit = $_FILES['mayors_permit']['name'];
			$mayors_permit_tmp = $_FILES['mayors_permit']['tmp_name'];

			move_uploaded_file($sec_tmp,"../uploads/$sec");
			move_uploaded_file($mayors_permit_tmp,"../uploads/$mayors_permit");
			move_uploaded_file($bir_tmp,"../uploads/$bir");

			$data = [
				'username'    => $_POST['username'],
				'email'  => $_POST['email'],
				'name'  => $_POST['name'],
				'department'  => $_POST['department'],
				'password'    =>  $_POST['password'],
				'customer_dept' => $_POST['customer_dept'],
				'profile_img'  =>  $profile_img,
				'dti'          =>  'none',
				'mayors_permit' =>  $mayors_permit,
				'bir'          =>  $bir,
				'sec'          =>  $sec_tmp,
				'timestamp'    => date("M-d-Y"),
				];


			$sql = "INSERT INTO users ( `bir`, `customer_dept`, `department`, `dti`, `email`, `mayors_permit`, `name`, `password`, `profile_img`, `sec`, `timestamp`, `username`) 
			VALUES (:bir, :customer_dept, :department, :dti, :email, :mayors_permit, :name, :password, :profile_img, :sec, :timestamp, :username)";
			$stmt = $dbh->prepare($sql);

			if ($password == $confirm_password) {
				if ($stmt->execute($data)) {
					echo '<script>alert("Department Account Create")</script>';
					echo '<script>window.location.href="../admin/department"</script>';
				}
			}
			else {
				echo '<script>alert("Passwords do not match. Please try again")</script>';
				echo '<script>window.location.href="../admin/register"</script>';
			}

		 }

		 else if($_POST['customer_dept'] == 'Partnership'){

			$mayors_permit = $_FILES['mayors_permit']['name'];
			$mayors_permit_tmp = $_FILES['mayors_permit']['tmp_name'];
			$bir = $_FILES['bir']['name'];
			$bir_tmp = $_FILES['bir']['tmp_name'];
			$sec = $_FILES['sec']['name'];
			$sec_tmp = $_FILES['sec']['tmp_name'];

			move_uploaded_file($mayors_permit_tmp,"../uploads/$mayors_permit");
			move_uploaded_file($bir_tmp,"../uploads/$bir");
			move_uploaded_file($sec_tmp,"../uploads/$sec");

			$data = [
				'username'    => $_POST['username'],
				'email'  => $_POST['email'],
				'name'  => $_POST['name'],
				'department'  => $_POST['department'],
				'password'    =>  $_POST['password'],
				'customer_dept' => $_POST['customer_dept'],
				'profile_img'  =>  $profile_img,
				'dti'          =>  'none',
				'mayors_permit' =>  $mayors_permit,
				'bir'          =>  $bir,
				'sec'          =>  $sec,
				'timestamp'    => date("M-d-Y"),
				];


				
			$sql = "INSERT INTO users ( `bir`, `customer_dept`, `department`, `dti`, `email`, `mayors_permit`, `name`, `password`, `profile_img`, `sec`, `timestamp`, `username`) 
			VALUES (:bir, :customer_dept, :department, :dti, :email, :mayors_permit, :name, :password, :profile_img, :sec, :timestamp, :username)";
			$stmt = $dbh->prepare($sql);

			if ($password == $confirm_password) {
				if ($stmt->execute($data)) {
					echo '<script>alert("Department Account Create")</script>';
					echo '<script>window.location.href="../admin/department"</script>';
				}
			}
			else {
				echo '<script>alert("Passwords do not match. Please try again")</script>';
				echo '<script>window.location.href="../admin/register"</script>';
			}
		 }
		 else {
			$data = [
				'username'    => $_POST['username'],
				'email'  => $_POST['email'],
				'name'  => $_POST['name'],
				'department'  => $_POST['department'],
				'password'    =>  $_POST['password'],
				'customer_dept' => 'none',
				'profile_img'  =>  $profile_img,
				'dti'          =>  'none',
				'mayors_permit' =>  'none',
				'bir'          =>  'none',
				'sec'          =>  'none',
				'timestamp'    => date("M-d-Y"),
				];

				$sql = "INSERT INTO users ( `bir`, `customer_dept`, `department`, `dti`, `email`, `mayors_permit`, `name`, `password`, `profile_img`, `sec`, `timestamp`, `username`) 
				VALUES (:bir, :customer_dept, :department, :dti, :email, :mayors_permit, :name, :password, :profile_img, :sec, :timestamp, :username)";
				$stmt = $dbh->prepare($sql);

				if ($password == $confirm_password) {
					if ($stmt->execute($data)) {
						echo '<script>alert("Department Account Create")</script>';
						echo '<script>window.location.href="../admin/department"</script>';
					}
				}
				else {
					echo '<script>alert("Passwords do not match. Please try again")</script>';
					echo '<script>window.location.href="../admin/register"</script>';
				}
		 }
	}
}


if (isset($_POST['create_journal_staff'])) {
	$transaction_id = rand(1000000000, 9999999999);
    $title = $_POST['title'];
    $staff_id = $_SESSION['id'];
    $customer_id = $_POST['customer_id'];
    $creation = $_SESSION['id'];
    $year  = $_POST['year'];
    $rq_number = $_POST['rq_number'];


	$data = [
        "title" => $title,
        "staff_id" => $staff_id,
        "creation" => $creation,
		"dates"    => date('Y-M-d'),
        "customer_id" => $customer_id,
		"status"    => "Pending",
        "transaction_id" => $transaction_id,
        "year" => $year

    ];

    $data_ledger = [
        "title" => $title . ' Ledger',
        "staff_id" => $staff_id,
        "creation" => $creation,
		"dates"    => date('Y-M-d'),
        "customer_id" => $customer_id,
		"status"    => "Pending",
        "transaction_id" => $transaction_id,
        "year" => $year,

    ];

    $data_trial = [
        "title" => $title . ' Trial Balance',
        "staff_id" => $staff_id,
        "creation" => $creation,
		"dates"    => date('Y-M-d'),
        "customer_id" => $customer_id,
		"status"    => "Pending",
        "transaction_id" => $transaction_id,
        "year" => $year

    ];

    $data_financial = [
        "title" => $title . ' Financial Statement',
        "staff_id" => $staff_id,
        "creation" => $creation,
		"dates"    => date('Y-M-d'),
        "customer_id" => $customer_id,
		"status"    => "Pending",
        "transaction_id" => $transaction_id,
        "year" => $year

    ];


	$data_cash_flow = [
        "title" => $title . ' Cash Flow Statement',
        "staff_id" => $staff_id,
        "creation" => $creation,
        "customer_id" => $customer_id,
        "transaction_id" => $transaction_id,
        "year" => $year,
        "status" => "Pending",
        "timestamp"    => date('Y-m-d')

    ];

    $data_dept_notif = [
        'title'  => 'New transaction has been created by '. $_SESSION['name']. ' and the id is ' .$transaction_id,
        'department_id' => $customer_id,
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
        'type'        => 'journal',
        'profile_img'  => $_SESSION['profile_img']
    ];

	$sql_journal = "INSERT INTO journal (`creation`, `customer_id`, `dates`, `staff_id`, `status`, `title`, `transaction_id`, `year`) 
			VALUES (:creation, :customer_id, :dates, :staff_id, :status, :title, :transaction_id, :year)";
	$stmt_journal = $dbh->prepare($sql_journal);
	$stmt_journal->execute($data);

	$sql_ledger = "INSERT INTO ledger (`creation`, `customer_id`, `dates`, `staff_id`, `status`, `title`, `transaction_id`, `year`) 
			VALUES (:creation, :customer_id, :dates, :staff_id, :status, :title, :transaction_id, :year)";
	$stmt_ledger = $dbh->prepare($sql_ledger);
	$stmt_ledger->execute($data_ledger);

	$sql_trial = "INSERT INTO trial (`creation`, `customer_id`, `dates`, `staff_id`, `status`, `title`, `transaction_id`, `year`) 
			VALUES (:creation, :customer_id, :dates, :staff_id, :status, :title, :transaction_id, :year)";
	$stmt_trial = $dbh->prepare($sql_trial);
	$stmt_trial->execute($data_trial);

	$sql_financial_statement = "INSERT INTO `financial-statement` (`creation`, `customer_id`, `dates`, `staff_id`, `status`, `title`, `transaction_id`, `year`) 
			VALUES (:creation, :customer_id, :dates, :staff_id, :status, :title, :transaction_id, :year)";
	$stmt_financial_statement = $dbh->prepare($sql_financial_statement);
	$stmt_financial_statement->execute($data_financial);

	$sql_cash = "INSERT INTO `cash-flow-statement` (`creation`, `customer_id`, `dates`, `staff_id`, `status`, `title`, `transaction_id`, `year`) 
			VALUES (:creation, :customer_id, :dates, :staff_id, :status, :title, :transaction_id, :year)";
	$stmt_cash = $dbh->prepare($sql_cash);
	$stmt_cash->execute($data_cash_flow);


	$sql_dept_notif = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
			VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
	$stmt_dept_notif = $dbh->prepare($sql_dept_notif);
	$stmt_dept_notif->execute($data_dept_notif);

	$userRef = $dbh->query("SELECT * FROM users WHERE id = '".$customer_id."'");
	$row_depts = $userRef->fetch(PDO::FETCH_ASSOC);


	$url = '../staff/journal?rq_number='.$rq_number.'&transaction_id='.$transaction_id.'&year='.$year.'&type='.$row_depts['customer_dept'];
    header('Location:'.$url);
}



if (isset($_POST['create_request_journal_staff'])) {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		foreach ($_POST["account_debit"] as $key => $value) { 

			$account_debit = $_POST['account_debit'][$key];
            $account_credit = $_POST['account_credit'][$key];
            $transaction_id = $_POST['transaction_id'][$key]; 
            $date = $_POST['date'][$key];
            $amount_debit = $_POST['amount_debit'][$key];
            $amount_credit = $_POST['amount_credit'][$key];

            $characters = array(',', ' ');
            $cleaned_number_amount_debit = str_replace($characters, '', $amount_debit);
            $cleaned_number_amount_credit = str_replace($characters, '', $amount_credit);

			if ($account_debit == ' N/A') {
				$real_account_debit = '';
			}else {
				$real_account_debit = $account_debit;
			}

			if ($account_credit == ' N/A') {
				$real_account_credit = '';
			}else {
				$real_account_credit = $account_credit;
			}


            $data = [   
                'account_debit' => $real_account_debit,
                'account_credit' => $real_account_credit,
                'transaction_id'   => $transaction_id,
                'date'     => date('M d, Y', strtotime($date)),
                'amount_debit'   => $cleaned_number_amount_debit,
                'amount_credit'  => $cleaned_number_amount_credit,
                'data_id' => rand(1000000000, 9999999999)
            ];


                $data_trial = [   
                    'account_name' => $real_account_debit,
                    'transaction_id'   => $transaction_id,
                    'date'     => date('M d, Y', strtotime($date)),
                    'account_price'   => $cleaned_number_amount_debit,
                    'data_id' => rand(1000000000, 9999999999),
                    'type'   => 'debit'
                ];



				$sql_journal = "INSERT INTO `journal-data` (`account_credit`, `account_debit`, `amount_credit`, `amount_debit`, `data_id`, `date`, `transaction_id`) 
				VALUES (:account_credit, :account_debit, :amount_credit, :amount_debit, :data_id, :date, :transaction_id)";
				$stmt_journal = $dbh->prepare($sql_journal);
				$stmt_journal->execute($data);


				$sql_trial = "INSERT INTO `trial-data` (`account_name`, `account_price`, `data_id`, `date`, `transaction_id`, `type`) 
				VALUES (:account_name, :account_price, :data_id, :date, :transaction_id, :type)";
				$stmt_trial = $dbh->prepare($sql_trial);
				$stmt_trial->execute($data_trial);

				
			$wtp = ['Professional Services Expense', 'Commission Expense', 'Rent Expense', 'Subcontractor or Contractor Expense', 'Management and Consultancy Fees', "Director's Fee",
            'Bookkeeping Services Expense', 'Supplies or Materials Expense', 'Advertising and Media Expense', 'Processing or Tolling Fees', 'Income Distributions', 'Raw Material Purchases'];
	
				if (in_array($account_debit, $wtp)) {
	
					$total_amount_etw_credit = $cleaned_number_amount_debit * $_POST['etw_debit'][$key];
					// $data1 = [   
					// 	'account_debit' => 'N/A',
					// 	'account_credit' => 'Withholding Tax Payable ('.$_POST['account_debit'][$key].')',
					// 	'transaction_id'   => $transaction_id,
					// 	'date'     => date('M d, Y', strtotime($date)),
					// 	'amount_debit'   => 0,
					// 	'amount_credit'  => $total_amount_etw_credit,
					// 	'data_id' => rand(1000000000, 9999999999)
					// ];
	
					// $total_amount_etw_credit2 = $cleaned_number_amount_debit - $total_amount_etw_credit;

					$data2 = [
						'account_debit' => '',
						'account_credit' => 'Expanded Withholding Tax',
						'transaction_id'   => $transaction_id,
						'date'     => date('M d, Y', strtotime($date)),
						'amount_debit'   => 0,
						'amount_credit'  => $total_amount_etw_credit,
						'data_id' => rand(1000000000, 9999999999)
					];
	
					$data_trial1 = [   
						'account_name' => 'Expanded Withholding Tax',
						'transaction_id'   => $transaction_id,
						'date'     => date('M d, Y', strtotime($date)),
						'account_price'   => $total_amount_etw_credit,
						'data_id' => rand(1000000000, 9999999999),
						'type'   => 'debit'
					];
		

					// $sql_journal1 = "INSERT INTO `journal-data` (`account_credit`, `account_debit`, `amount_credit`, `amount_debit`, `data_id`, `date`, `transaction_id`) 
					// VALUES (:account_credit, :account_debit, :amount_credit, :amount_debit, :data_id, :date, :transaction_id)";
					// $stmt_journal1 = $dbh->prepare($sql_journal1);
					// $stmt_journal1->execute($data1);

					$sql_journal2 = "INSERT INTO `journal-data` (`account_credit`, `account_debit`, `amount_credit`, `amount_debit`, `data_id`, `date`, `transaction_id`) 
					VALUES (:account_credit, :account_debit, :amount_credit, :amount_debit, :data_id, :date, :transaction_id)";
					$stmt_journal2 = $dbh->prepare($sql_journal2);
					$stmt_journal2->execute($data2);


					$sql_trial = "INSERT INTO `trial-data` (`account_name`, `account_price`, `data_id`, `date`, `transaction_id`, `type`) 
					VALUES (:account_name, :account_price, :data_id, :date, :transaction_id, :type)";
					$stmt_trial = $dbh->prepare($sql_trial);
					$stmt_trial->execute($data_trial1);
				}
		}

		foreach ($_POST["account_credit"] as $key => $value) {
			$account_credit = $_POST['account_credit'][$key];
            $transaction_id = $_POST['transaction_id'][$key]; 
            $date = $_POST['date'][$key];
            $amount_credit = $_POST['amount_credit'][$key];

            $characters = array(',', ' ');
            $cleaned_number_amount_credit = str_replace($characters, '', $amount_credit);

			if ($account_credit == ' N/A') {
				$real_account_credit = '';
			}else {
				$real_account_credit = $account_credit;
			}

            $data_trial1 = [   
                'account_name' => $real_account_credit,
                'transaction_id'   => $transaction_id,
                'date'     => date('M d, Y', strtotime($date)),
                'account_price'   => $cleaned_number_amount_credit,
                'data_id' => rand(1000000000, 9999999999),
                'type'   => 'credit'
            ];

				$sql_trial = "INSERT INTO `trial-data` (`account_name`, `account_price`, `data_id`, `date`, `transaction_id`, `type`) 
				VALUES (:account_name, :account_price, :data_id, :date, :transaction_id, :type)";
				$stmt_trial = $dbh->prepare($sql_trial);
				$stmt_trial->execute($data_trial1);



				$url = '../staff/journal-entry?transaction_id='.$transaction_id;
				header('Location:'.$url);
		}
	}
}


if (isset($_POST['create_sales_forecast_staff'])) {
	$transaction_id = rand(1000000000, 9999999999);
    $title = $_POST['title'];
    $staff_id = $_SESSION['id'];
    $customer_id = $_POST['customer_id'];
    $creation = $_SESSION['id'];
    $year  = $_POST['year'];
	$future_sales = 0;

	if (isset($_FILES['csvFile']) && $_POST['excel_answer'] == 'Yes') {
		$data = [
			"title" => $title,
			"staff_id" => $staff_id,
			"creation" => $creation,
			"customer_id" => $customer_id,
			"transaction_id" => $transaction_id,
			"year" => $year,
			"status" => "Pending",
			"dates"    => date('Y-m-d')
	
		];
	
		$data_admin_notif = [
			'title'  => 'New transaction has been created by '. $_SESSION['name'] . ' and the id is ' .$transaction_id ,
			'department_id' => $customer_id,
			'request_id'    => $transaction_id,
			'status'        => 'unseen',
			'type'        => 'journal',
			'profile_img'  => $_SESSION['profile_img']
		];
	
		$data_dept_notif = [
			'title'  => 'New transaction has been created by '. $_SESSION['name']. ' and the id is ' .$transaction_id,
			'department_id' => $customer_id,
			'request_id'    => $transaction_id,
			'status'        => 'unseen',
			'type'        => 'sale',
			'profile_img'  => $_SESSION['profile_img']
		];
	
		$sql_sale = "INSERT INTO `sale-forecast` (`creation`, `customer_id`, `dates`, `staff_id`, `status`, `title`, `transaction_id`, `year`) 
		VALUES (:creation, :customer_id, :dates, :staff_id, :status, :title, :transaction_id, :year)";
		$stmt_sale = $dbh->prepare($sql_sale);
		$stmt_sale->execute($data);
	
		$sql_dept_notif = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
				VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
		$stmt_dept_notif = $dbh->prepare($sql_dept_notif);
		$stmt_dept_notif->execute($data_dept_notif);
	
		$sql_admin_notif = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
				VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
		$stmt_admin_notif = $dbh->prepare($sql_admin_notif);
		$stmt_admin_notif->execute($data_admin_notif);


		$spreadsheet = PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['csvFile']['tmp_name']); 
		$worksheet = $spreadsheet->getActiveSheet();  
		$worksheet_arr = $worksheet->toArray(); 


		$fileName = $_FILES["csvFile"]["name"];
		$fileExtension = explode('.', $fileName);
      	$fileExtension = strtolower(end($fileExtension));
		$newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;
		$targetDirectory = "../csv/" . $newFileName;
		move_uploaded_file($_FILES['csvFile']['tmp_name'], $targetDirectory);

		 // Remove header row 
		 unset($worksheet_arr[0]); 

		foreach ($worksheet_arr as $key => $value) {
				$firstValue = (float)$value[1];
				$lastValue = (float)$value[1];
				
				$year_forecast = $value[0] + 1 ;
				$years = count($worksheet_arr) - 1;
				$agr = pow($lastValue / $firstValue, 1 / $years) - 1;
				// Predict future sales for 5 years
				$current_sales = $lastValue;
				$future_years = 5;
				$future_sales += $current_sales * pow(1 + $agr, $future_years);
				$future = round($future_sales, 2);
	
				$sql_sale = "INSERT INTO `time_series_forecasts` (`date`, `original_value`, `forecast_value`, `seriesName`, `transaction_id`) 
				VALUES (:date, :original_value, :forecast_value, :seriesName, :transaction_id)";
				$stmt_sale = $dbh->prepare($sql_sale);
				$stmt_sale->bindParam(':date', $value[0]);
				$stmt_sale->bindParam(':original_value', $value[1]);
				$stmt_sale->bindParam(':seriesName', $year_forecast);
				$stmt_sale->bindParam(':forecast_value', $future);
				$stmt_sale->bindParam(':transaction_id', $transaction_id);
				$stmt_sale->execute();
		}
		$url = '../staff/sales_forecast_data?transaction_id='.$transaction_id.'&customer_id='.$_POST['customer_id'].'&title='.$title;
		header('Location:'.$url);
	}
	else {
		$rq_number = $_POST['rq_number'];
		$data = [
			"title" => $title,
			"staff_id" => $staff_id,
			"creation" => $creation,
			"customer_id" => $customer_id,
			"transaction_id" => $transaction_id,
			"year" => $year,
			"status" => "Pending",
			"dates"    => date('Y-m-d')
	
		];
	
		$data_admin_notif = [
			'title'  => 'New transaction has been created by '. $_SESSION['name'] . ' and the id is ' .$transaction_id ,
			'department_id' => $customer_id,
			'request_id'    => $transaction_id,
			'status'        => 'unseen',
			'type'        => 'journal',
			'profile_img'  => $_SESSION['profile_img']
		];
	
		$data_dept_notif = [
			'title'  => 'New transaction has been created by '. $_SESSION['name']. ' and the id is ' .$transaction_id,
			'department_id' => $customer_id,
			'request_id'    => $transaction_id,
			'status'        => 'unseen',
			'type'        => 'sale',
			'profile_img'  => $_SESSION['profile_img']
		];
	
		$sql_sale = "INSERT INTO `sale-forecast` (`creation`, `customer_id`, `dates`, `staff_id`, `status`, `title`, `transaction_id`, `year`) 
		VALUES (:creation, :customer_id, :dates, :staff_id, :status, :title, :transaction_id, :year)";
		$stmt_sale = $dbh->prepare($sql_sale);
		$stmt_sale->execute($data);
	
		$sql_dept_notif = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
				VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
		$stmt_dept_notif = $dbh->prepare($sql_dept_notif);
		$stmt_dept_notif->execute($data_dept_notif);
	
		$sql_admin_notif = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
				VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
		$stmt_admin_notif = $dbh->prepare($sql_admin_notif);
		$stmt_admin_notif->execute($data_admin_notif);
		
		$url = '../staff/sale_forecast_create?rq_number='.$rq_number.'&transaction_id='.$transaction_id.'&year='.$year.'&data_number='.$_POST['data_number'].'&customer_id='.$_POST['customer_id'].'&title='.$title;
		header('Location:'.$url);
	}

   
}

// Moving Average Forecast Function
function movingAverageForecast($data, $windowSize) {
    $forecast = [];
    $dataCount = count($data);

    if ($dataCount < $windowSize) {
        throw new Exception("Window size cannot be greater than the number of data points.");
    }

    for ($i = $windowSize; $i < $dataCount; $i++) {
        $sum = 0;
        for ($j = $i - $windowSize; $j < $i; $j++) {
            $sum += $data[$j];
        }
        $forecast[] = $sum / $windowSize;  // Simple moving average forecast
    }

    return $forecast;
}


if (isset($_POST['create_request_forecast_staff'])) {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $windowSize = intval(3);
        $allForecasts = [];
        $timeSeriesData = [];
        $dataToInsert = [];
        $forecastData = [];
        $year = '';

       foreach ($_POST['year'] as $key => $value) {
        // $timeSeriesData = array_map('floatval', explode(',', $_POST['data'][$key]));
        //   $forecastedData = movingAverageForecast($_POST['forecast_value'], $windowSize);
            $year = $_POST['year'][$key] + 1;
			// $sum += $_POST['forecast_value'][$key];
			$starting_value = $_POST['forecast_value'][0];
			$ending_value = end($_POST['forecast_value']);
			$years = count($_POST['year']) - 1;
			$agr = pow($ending_value / $starting_value, 1 / $years) - 1;
			// Predict future sales for 5 years
			$current_sales = end($_POST['forecast_value']);
			$future_years = 5;
			$future_sales += $current_sales * pow(1 + $agr, $future_years);


            $dataToInsert = [
                'date' => $_POST['year'][$key],
                'seriesName' => $year,
                'original_value' => $_POST['forecast_value'][$key],
                'forecast_value' =>  round($future_sales, 2),
				'transaction_id' => $_GET['transaction_id']
            ];

			$sql_sale = "INSERT INTO `time_series_forecasts` (`date`, `original_value`, `forecast_value`, `seriesName`, `transaction_id`) 
			VALUES (:date, :original_value, :forecast_value, :seriesName, :transaction_id)";
			$stmt_sale = $dbh->prepare($sql_sale);
			$stmt_sale->execute($dataToInsert);

    }
        
	$url = '../staff/sales_forecast_data?transaction_id='.$_GET['transaction_id'].'&customer_id='.$_POST['customer_id'].'&title='.$_GET['title'];
	header('Location:'.$url);
    }
}




if (isset($_POST['create_ewt'])) {
	$title = $_POST['title'];
    $tax_rate = $_POST['tax_rate'];
    $ind = $_POST['ind'];
    $corp = $_POST['corp'];
	$total_percentage_corp = $_POST['corp'] / 100;
	$total_percentage_ind = $_POST['ind'] / 100;

    $data = [
        "title" => $title,
        "tax_rate"     => $tax_rate,
        "ind"     => $total_percentage_ind,
        "corp"     => $total_percentage_corp

    ];

	$sql_sale = "INSERT INTO `etw` ( `corp`, `ind`, `tax_rate`, `title`) 
	VALUES (:corp, :ind, :tax_rate, :title)";
	$stmt_sale = $dbh->prepare($sql_sale);
	$stmt_sale->execute($data);

	$url = '../admin/ewt';
    header('Location:'.$url);
}

if (isset($_POST['create_tax'])) {
	
	$tax_name = $_POST['tax_name'];
    $id = $_POST['id'];
	$total_percentage = $_POST['tax_percentage'] / 100;

    $data = [
        "tax_name" => $tax_name,
        "tax_percentage" => $tax_percentage,
        "tax_value"     => $total_percentage,
		"customer_id"     => $_POST['id'],

    ];

	$sql_tax = "INSERT INTO `tax` (`tax_name`, `tax_percentage`, `tax_value`, `customer_id`) 
	VALUES (:tax_name, :tax_percentage, :tax_value, :customer_id)";
	$stmt_sale = $dbh->prepare($sql_tax);
	$stmt_sale->execute($data);

	$url = '../admin/tax?id='.$id;
    header('Location:'.$url);
}


if (isset($_POST['update_tax'])) {
	$tax_name = $_POST['tax_name'];
    $tax_id = $_POST['tax_id'];
	$customer_id = $_POST['customer_id'];
	$tax_percentage = $_POST['tax_percentage'];
	$total_percentage = $_POST['tax_percentage'] / 100;

	$sql_date = 'UPDATE tax SET tax_name= :tax_name, tax_percentage= :tax_percentage, tax_value= :tax_value WHERE id = :id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
        'tax_name'    => $tax_name,
        'tax_percentage'  =>  $tax_percentage,
        'tax_value'  =>  $total_percentage,
		'id' => $tax_id
    ]);

	$url = '../admin/tax?id='.$customer_id;
    header('Location:'.$url);
}


if (isset($_GET['update_transaction_journal_staff'])) {
	$title = $_GET['title'];
    $customer_id = $_GET['customer_id'];
    $year = $_GET['year'];
    $transaction_id = $_GET['transaction_id'];

	$sql_date = 'UPDATE journal SET customer_id= :customer_id, title= :title, year= :year WHERE transaction_id = :transaction_id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
         'title'    => $title,
        'customer_id'  =>  $customer_id,
        'year'  =>  $year,
		'transaction_id' => $transaction_id
    ]);

	echo '<script>alert("Update Success")</script>';
    echo '<script>window.location.href="../staff/journal-entry"</script>';
}


if (isset($_GET['delete_transaction_journal_staff'])) {
	$sql_journal = "DELETE FROM journal WHERE transaction_id = :transaction_id";

	$stmt_journal = $dbh->prepare($sql_journal);
    $stmt_journal->execute([
        ':transaction_id' => $_GET['transaction_id'], // ID of the record to delete
    ]);

	$sql_journal_data = "DELETE FROM `journal-data` WHERE transaction_id = :transaction_id";

	$stmt_journal_data = $dbh->prepare($sql_journal_data);
    $stmt_journal_data->execute([
        ':transaction_id' => $_GET['transaction_id'], // ID of the record to delete
    ]);

	$sql_ledger = "DELETE FROM ledger WHERE transaction_id = :transaction_id";

	$stmt_ledger = $dbh->prepare($sql_ledger);
    $stmt_ledger->execute([
        ':transaction_id' => $_GET['transaction_id'], // ID of the record to delete
    ]);

	$sql_trial = "DELETE FROM trial WHERE transaction_id = :transaction_id";

	$stmt_trial = $dbh->prepare($sql_trial);
    $stmt_trial->execute([
        ':transaction_id' => $_GET['transaction_id'], // ID of the record to delete
    ]);

	$sql_trial_data = "DELETE FROM `trial-data` WHERE transaction_id = :transaction_id";

	$stmt_trial_data = $dbh->prepare($sql_trial_data);
    $stmt_trial_data->execute([
        ':transaction_id' => $_GET['transaction_id'], // ID of the record to delete
    ]);

	$sql_financial = "DELETE FROM `financial-statement` WHERE transaction_id = :transaction_id";

	$stmt_financial = $dbh->prepare($sql_financial);
    $stmt_financial->execute([
        ':transaction_id' => $_GET['transaction_id'], // ID of the record to delete
    ]);

	
	$sql_cash = "DELETE FROM `cash-flow-statement` WHERE transaction_id = :transaction_id";

	$stmt_cash = $dbh->prepare($sql_cash);
    $stmt_cash->execute([
        ':transaction_id' => $_GET['transaction_id'], // ID of the record to delete
    ]);

	$sql_cash_data = "DELETE FROM `cash-flow-statement-data` WHERE transaction_id = :transaction_id";

	$stmt_cash_data = $dbh->prepare($sql_cash_data);
    $stmt_cash_data->execute([
        ':transaction_id' => $_GET['transaction_id'], // ID of the record to delete
    ]);
	
	$url = '../staff/journal-entry';
     header('Location:'.$url);
}

if (isset($_GET['update_journal_data_staff'])) {
	
	$account_debit = $_GET['account_debit'];
    $account_credit = $_GET['account_credit'];
    $amount_debit = $_GET['amount_debit']; 
    $amount_credit = $_GET['amount_credit'];
    $transaction_id = $_GET['transaction_id'];
    $data_id = $_GET['data_id'];
	$customer_id = $_GET['customer_id'];
	$keys = $_GET['key'];

    $characters = array(',', ' ');
    $cleaned_number_debit = str_replace($characters, '', $amount_debit);
    $cleaned_number_credit = str_replace($characters, '', $amount_credit);


	$stmt_journal = $dbh->query("SELECT * FROM `journal-data`");
	foreach ($stmt_journal->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
		if ($value['transaction_id'] == $transaction_id && $value['data_id'] == $data_id) {

			$update_journal = "UPDATE `journal-data` SET `account_credit`= :account_credit, `account_debit`= :account_debit, `amount_credit`= :amount_credit, `amount_debit`= :amount_debit WHERE `id`= :id";
		    $stmt_journal = $dbh->prepare($update_journal);

			$stmt_journal->execute([
				'account_credit'  => $account_credit,
				'account_debit'  => $account_debit,
				'amount_credit'   => $cleaned_number_credit,
				'amount_debit'    => $cleaned_number_debit,
				'id'              => $keys
		   ]);
	   
		}
	}

	$stmt_trial = $dbh->query("SELECT * FROM `trial-data`");
	foreach ($stmt_trial->fetchAll(PDO::FETCH_ASSOC) as $key => $value) {
		if ($value['transaction_id'] == $transaction_id && $value['data_id'] == $data_id) {

			if ($value['type'] == 'credit') {
				$update_trial = "UPDATE `trial-data` SET `account_name`= :account_name,`account_price`= :account_price WHERE `id`= :id";
				$stmt = $dbh->prepare($update_trial);
				$stmt->execute([
					'account_name'  => $account_credit,
                    'account_price'   => $cleaned_number_credit,
					'id'              => $value['data_id']
			]);
			}

			if ($value['type'] == 'debit') {
				
				$update_trial = "UPDATE `trial-data` SET `account_name`= :account_name, `account_price`= :account_price WHERE `id`= :id";
				$stmt = $dbh->prepare($update_trial);
				$stmt->execute([
					'account_name'  => $account_credit,
                    'account_price'   => $cleaned_number_credit,
					'id'              => $value['data_id']
			]);
			}
	   
		}
	}
	echo '<script>alert("Update Success")</script>';
    $url = '../staff/journal-data?transaction_id='.$transaction_id.'&customer_id='.$customer_id;
    header('Location:'.$url);
}

if (isset($_GET['delete_journal_data_staff'])) {

	$sql_journal_data = "DELETE FROM `journal-data` WHERE data_id = :data_id";

	$stmt_journal_data = $dbh->prepare($sql_journal_data);
    $stmt_journal_data->execute([
        ':data_id' => $_GET['data_id'], // ID of the record to delete
    ]);


	$sql_trial_data = "DELETE FROM `trial-data` WHERE data_id = :data_id";

	$stmt_trial_data = $dbh->prepare($sql_trial_data);
    $stmt_trial_data->execute([
        ':data_id' => $_GET['data_id'], // ID of the record to delete
    ]);

	$url = '../staff/journal-data?transaction_id='.$_GET['transaction_id'].'&customer_id='.$_GET['customer_id'];
    header('Location:'.$url);
}


if (isset($_POST['create_request_number_cash_staff'])) {
	
	$transaction_id = $_POST['transaction_id']; 
    $date = $_POST['operating_activities_date'];
    $data_id = rand(1000000000, 9999999999);
    $customer_id = $_POST['customer_id'];
    $operating_activities_name = $_POST['operating_activities_name'];
    $investing_activities_name = $_POST['investing_activities_name'];
    $financing_activities_name = $_POST['financing_activities_name'];
    $amount_operating_activities = $_POST['operating_activities_amount'];
    $investing_activities_amount = $_POST['investing_activities_amount'];
    $financing_activities_amount = $_POST['financing_activities_amount'];

    $characters = array(',', ' ');
    $cleaned_number_operating_activities = str_replace($characters, '', $amount_operating_activities);
    $cleaned_number_investing_activitiest = str_replace($characters, '', $investing_activities_amount);
    $cleaned_number_financing_activities = str_replace($characters, '', $financing_activities_amount);

    $data = [   
        'operating_activities_name' => $operating_activities_name,
		'operating_activities_amount'   => $cleaned_number_operating_activities,
        'investing_activities_name' => $investing_activities_name,
		'investing_activities_amount'  => $cleaned_number_investing_activitiest,
        'financing_activities_name' => $financing_activities_name,
		'financing_activities_amount'  => $cleaned_number_financing_activities,
		'data_id' => $data_id,
        'transaction_id'   => $transaction_id,
        'date'     => date('M d, Y', strtotime($date))
        ];

		$sql = "INSERT INTO `cash-flow-statement-data` (`operating_activities_name`, `operating_activities_amount`, `investing_activities_name`, `investing_activities_amount`, `financing_activities_name`, `financing_activities_amount`, `data_id`, `transaction_id`, `date`)
		 VALUES (:operating_activities_name, :operating_activities_amount, :investing_activities_name, :investing_activities_amount, :financing_activities_name, :financing_activities_amount, :data_id, :transaction_id, :date)";
		$stmt_sale = $dbh->prepare($sql);
		$stmt_sale->execute($data);
		$url = '../staff/cash-flow-statement-data?transaction_id='.$transaction_id.'&customer_id='.$customer_id;
		header('Location:'.$url);
}


if (isset($_GET['update_cash_data_staff'])) {
	$operating_activities_name = $_GET['operating_activities_name'];
    $investing_activities_name = $_GET['investing_activities_name'];
    $financing_acitivities_name = $_GET['financing_activities_name']; 
    $operating_activities_amount = $_GET['operating_activities_amount'];
    $investing_activities_amount = $_GET['investing_activities_amount'];
    $financing_acitivities_amount = $_GET['financing_activities_amount'];
    $data_id = $_GET['data_id'];
    $transaction_id = $_GET['transaction_id'];

    $characters = array(',', ' ');
    $cleaned_number_operating_activities = str_replace($characters, '', $operating_activities_amount);
    $cleaned_number_investing_activities = str_replace($characters, '', $investing_activities_amount);
    $cleaned_number_financing_acitivities = str_replace($characters, '', $financing_acitivities_amount);


	$sql_update = "UPDATE `cash-flow-statement-data` SET `operating_activities_name`= :operating_activities_name, `operating_activities_amount`= :operating_activities_amount, `investing_activities_name`= :investing_activities_name, `investing_activities_amount`= :investing_activities_amount, `financing_activities_name`= :financing_activities_name, `financing_activities_amount`= :financing_activities_amount WHERE `data_id`= :data_id ";
	$stmt = $dbh->prepare($sql_update);
	$stmt->execute([
		'operating_activities_name'  => $operating_activities_name,
        'investing_activities_name'  => $investing_activities_name,
        'financing_activities_name'    => $financing_acitivities_name,
        'operating_activities_amount'   => $cleaned_number_operating_activities,
        'investing_activities_amount'   => $cleaned_number_investing_activities,
        'financing_activities_amount'   => $cleaned_number_financing_acitivities,
		'data_id'                       => $data_id
	]);

	echo '<script>alert("Update Success")</script>';
    $url = '../staff/cash-flow-statement-data?transaction_id='.$transaction_id.'&customer_id='.$_GET['customer_id'];
    header('Location:'.$url);
}

if (isset($_GET['update_transaction_cash_staff'])) {
	
	$title = $_GET['title'];
    $customer_id = $_GET['customer_id'];
    $year = $_GET['year'];
    $transaction_id = $_GET['transaction_id'];


	$sql_date = 'UPDATE `cash-flow-statement` SET customer_id= :customer_id, title= :title, year= :year WHERE transaction_id = :transaction_id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
         'title'    => $title,
        'customer_id'  =>  $customer_id,
        'year'  =>  $year,
		'transaction_id' => $transaction_id
    ]);

	echo '<script>alert("Update Success")</script>';
    echo '<script>window.location.href="../staff/cash-flow-statement"</script>';
}


if (isset($_GET['delete_cash_data_staff'])) {
	$sql_cash = "DELETE FROM `cash-flow-statement-data` WHERE transaction_id = :transaction_id";

	$stmt_cash = $dbh->prepare($sql_cash);
    $stmt_cash->execute([
        ':transaction_id' => $_GET['transaction_id'], // ID of the record to delete
    ]);

	$url = '../staff/cash-flow-statement-data?transaction_id='.$_GET['transaction_id'].'&customer_id='.$_GET['customer_id'];
	header('Location:'.$url);
}

if (isset($_POST['create_account_staff'])) {
	$transaction_id = rand(1000000000, 9999999999);
    $account_name = $_POST['account_name'];
    $account_type = $_POST['account_type'];

    $data = [
        "account_name" => $account_name,
        "account_type" => $account_type,

    ];

	$sql = "INSERT INTO `account`(`account_name`, `account_type`) VALUES (:account_name, :account_type)";
	$stmt_sale = $dbh->prepare($sql);
	$stmt_sale->execute($data);

	$url = '../staff/account';
    header('Location:'.$url);
}


if (isset($_GET['update_account_staff'])) {
	$account_name = $_GET['account_name'];
    $account_type = $_GET['account_type'];
    $account_id  =  $_GET['account_id'];

	$sql = "UPDATE `account` SET `account_name`= :account_name,`account_type`= :account_type WHERE `account_id` = :account_id";
	$stmt_sale = $dbh->prepare($sql);
	$stmt_sale->execute(
		[
			'account_name'    => $account_name,
			'account_type'  =>  $account_type,
			'account_id'	=> $account_id
		]
	);

	$url = '../staff/account';
    header('Location:'.$url);

}


if (isset($_GET['delete_account_staff'])) {
	$sql_account = "DELETE FROM `account` WHERE account_id = :account_id";

	$stmt_cash = $dbh->prepare($sql_account);
    $stmt_cash->execute([
        ':account_id' => $_GET['account_id'], // ID of the record to delete
    ]);

	$url = '../staff/account';
    header('Location:'.$url);
}

if (isset($_POST['create_request_number_journal_staff'])) {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$transaction_id = $_POST['transaction_id']; 
		$customer_id = $_POST['customer_id']; 
        $date = $_POST['date'];
        $data_id = rand(1000000000, 9999999999);
        $account_debit = $_POST['account_debit'];
        $account_credit = $_POST['account_credit'];
        $amount_debit = $_POST['amount_debit'];
        $amount_credit = $_POST['amount_credit'];

        $characters = array(',', ' ');
        $cleaned_number_debit = str_replace($characters, '', $amount_debit);
        $cleaned_number_credit = str_replace($characters, '', $amount_credit);

		if ($account_debit == ' N/A') {
			$real_account_debit = '';
		}else {
			$real_account_debit = $account_debit;
		}

		if ($account_credit == ' N/A') {
			$real_account_credit = '';
		}else {
			$real_account_credit = $account_credit;
		}

        $data = [   
            'account_debit' => $real_account_debit,
            'account_credit' => $real_account_credit,
            'transaction_id'   => $transaction_id,
            'date'     => date('M d, Y', strtotime($date)),
            'amount_debit'   => $cleaned_number_debit,
            'amount_credit'  => $cleaned_number_credit,
            'data_id' => $data_id
            ];


            $data_trial = [   
                'account_name' => $real_account_debit,
                'transaction_id'   => $transaction_id,
                'date'     => date('M d, Y', strtotime($date)),
                'account_price'   => $cleaned_number_debit,
                'data_id' => $data_id,
                'type'    => 'debit'
            ];

			$data_trial2 = [   
                'account_name' => $real_account_credit,
                'transaction_id'   => $transaction_id,
                'date'     => date('M d, Y', strtotime($date)),
                'account_price'   => $cleaned_number_credit,
                'data_id' => $data_id,
                'type'    => 'credit'
            ];
			

			$sql_journal2 = "INSERT INTO `journal-data` (`account_credit`, `account_debit`, `amount_credit`, `amount_debit`, `data_id`, `date`, `transaction_id`) 
			VALUES (:account_credit, :account_debit, :amount_credit, :amount_debit, :data_id, :date, :transaction_id)";
			$stmt_journal2 = $dbh->prepare($sql_journal2);
			$stmt_journal2->execute($data);

			$sql_trial = "INSERT INTO `trial-data` (`account_name`, `account_price`, `data_id`, `date`, `transaction_id`, `type`) 
			VALUES (:account_name, :account_price, :data_id, :date, :transaction_id, :type)";
			$stmt_trial = $dbh->prepare($sql_trial);
			$stmt_trial->execute($data_trial);

			$sql_trial2 = "INSERT INTO `trial-data` (`account_name`, `account_price`, `data_id`, `date`, `transaction_id`, `type`) 
			VALUES (:account_name, :account_price, :data_id, :date, :transaction_id, :type)";
			$stmt_trial2 = $dbh->prepare($sql_trial2);
			$stmt_trial2->execute($data_trial2);

		
			$wtp = ['Professional Services Expense', 'Commission Expense', 'Rent Expense', 'Subcontractor or Contractor Expense', 'Management and Consultancy Fees', "Director's Fee",
            'Bookkeeping Services Expense', 'Supplies or Materials Expense', 'Advertising and Media Expense', 'Processing or Tolling Fees', 'Income Distributions', 'Raw Material Purchases'];

            if (in_array($account_debit, $wtp)) {

                $total_amount_etw_credit = $cleaned_number_debit * $_POST['etw_debit'];
                // $data1 = [   
                //     'account_debit' => 'N/A',
                //     'account_credit' => 'Withholding Tax Payable ('.$_POST['account_debit'].')',
                //     'transaction_id'   => $transaction_id,
                //     'date'     => date('M d, Y', strtotime($date)),
                //     'amount_debit'   => 0,
                //     'amount_credit'  => $total_amount_etw_credit,
                //     'data_id' => $data_id
                // ];

                // $total_amount_etw_credit2 = $cleaned_number_debit - $total_amount_etw_credit;
                $data2 = [
                    'account_debit' => '',
                    'account_credit' => 'Expanded Withholding Tax',
                    'transaction_id'   => $transaction_id,
                    'date'     => date('M d, Y', strtotime($date)),
                    'amount_debit'   => 0,
                    'amount_credit'  => $total_amount_etw_credit,
                    'data_id' => $data_id
                ];

                $data_trial2 = [   
                    'account_name' => 'Expanded Withholding Tax',
                    'transaction_id'   => $transaction_id,
                    'date'     => date('M d, Y', strtotime($date)),
                    'account_price'   => $total_amount_etw_credit,
                    'data_id' => $data_id,
                    'type'    => 'credit'
                ];


				// $sql_journal1 = "INSERT INTO `journal-data` (`account_credit`, `account_debit`, `amount_credit`, `amount_debit`, `data_id`, `date`, `transaction_id`) 
				// VALUES (:account_credit, :account_debit, :amount_credit, :amount_debit, :data_id, :date, :transaction_id)";
				// $stmt_journal1 = $dbh->prepare($sql_journal1);
				// $stmt_journal1->execute($data1);

				$sql_journal2 = "INSERT INTO `journal-data` (`account_credit`, `account_debit`, `amount_credit`, `amount_debit`, `data_id`, `date`, `transaction_id`) 
				VALUES (:account_credit, :account_debit, :amount_credit, :amount_debit, :data_id, :date, :transaction_id)";
				$stmt_journal2 = $dbh->prepare($sql_journal2);
				$stmt_journal2->execute($data2);
	
				$sql_trial = "INSERT INTO `trial-data` (`account_name`, `account_price`, `data_id`, `date`, `transaction_id`, `type`) 
				VALUES (:account_name, :account_price, :data_id, :date, :transaction_id, :type)";
				$stmt_trial = $dbh->prepare($sql_trial);
				$stmt_trial->execute($data_trial2);
            }


			$url = '../staff/journal-data?transaction_id='.$transaction_id.'&customer_id='.$customer_id;
    		header('Location:'.$url);
		}
}



if (isset($_GET['update_status_journal'])) {
    $transaction_id = $_GET['transaction_id'];

	$userRef_customer_id = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['customer_id']."'");
	$row_depts_customer_id = $userRef_customer_id->fetch(PDO::FETCH_ASSOC);

	$userRef_staff_id = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['staff_id']."'");
	$row_depts_staff_id = $userRef_staff_id->fetch(PDO::FETCH_ASSOC);

	$sql_date = 'UPDATE journal SET status= :status WHERE transaction_id = :transaction_id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
        'status' => "Approved",
		'transaction_id' => $transaction_id
    ]);

	$data_dept_notif_stmt_customer_id = [
        'title'  => 'New transaction has been created by '. $row_depts_customer_id['name']. ' and the id is ' .$transaction_id. ' has been approved by Admin',
        'department_id' => $row_depts_customer_id['id'],
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
		'type'        => 'journal',
        'profile_img'  => $row_depts_customer_id['profile_img']
    ];

	$data_dept_notif_stmt_staff_id = [
        'title'  => 'New transaction has been created by '. $row_depts_staff_id['name']. ' and the id is ' .$transaction_id. ' has been approved by Admin',
        'department_id' => $row_depts_staff_id['id'],
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
		'type'        => 'journal',
        'profile_img'  => $row_depts_staff_id['profile_img']
    ];

	$sql_dept_notif_customer_id = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
			VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
	$stmt_dept_notif_customer_id = $dbh->prepare($sql_dept_notif_customer_id);
	$stmt_dept_notif_customer_id->execute($data_dept_notif_stmt_customer_id);

	$sql_dept_notif_staff_id = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
			VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
	$stmt_dept_notif_staff_id = $dbh->prepare($sql_dept_notif_staff_id);
	$stmt_dept_notif_staff_id->execute($data_dept_notif_stmt_staff_id);


    echo '<script>alert("Update Success")</script>';
    $url = '../admin/journal-entry';
    header('Location:'.$url);
}

if (isset($_GET['update_status_ledger'])) {
    $transaction_id = $_GET['transaction_id'];

	$userRef_customer_id = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['customer_id']."'");
	$row_depts_customer_id = $userRef_customer_id->fetch(PDO::FETCH_ASSOC);

	$userRef_staff_id = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['staff_id']."'");
	$row_depts_staff_id = $userRef_staff_id->fetch(PDO::FETCH_ASSOC);

    $sql_date = 'UPDATE ledger SET status= :status WHERE transaction_id = :transaction_id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
        'status' => "Approved",
		'transaction_id' => $transaction_id
    ]);

	$data_dept_notif_stmt_customer_id = [
        'title'  => 'New transaction has been created by '. $row_depts_customer_id['name']. ' and the id is ' .$transaction_id. ' has been approved by Admin',
        'department_id' => $row_depts_customer_id['id'],
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
		'type'        => 'journal',
        'profile_img'  => $row_depts_customer_id['profile_img']
    ];

	$data_dept_notif_stmt_staff_id = [
        'title'  => 'New transaction has been created by '. $row_depts_staff_id['name']. ' and the id is ' .$transaction_id. ' has been approved by Admin',
        'department_id' => $row_depts_staff_id['id'],
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
		'type'        => 'journal',
        'profile_img'  => $row_depts_staff_id['profile_img']
    ];

	$sql_dept_notif_customer_id = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
			VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
	$stmt_dept_notif_customer_id = $dbh->prepare($sql_dept_notif_customer_id);
	$stmt_dept_notif_customer_id->execute($data_dept_notif_stmt_customer_id);

	$sql_dept_notif_staff_id = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
			VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
	$stmt_dept_notif_staff_id = $dbh->prepare($sql_dept_notif_staff_id);
	$stmt_dept_notif_staff_id->execute($data_dept_notif_stmt_staff_id);

    echo '<script>alert("Update Success")</script>';
    $url = '../admin/ledger';
    header('Location:'.$url);
}

if (isset($_GET['update_status_trial'])) {
    $transaction_id = $_GET['transaction_id'];

	$userRef_customer_id = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['customer_id']."'");
	$row_depts_customer_id = $userRef_customer_id->fetch(PDO::FETCH_ASSOC);

	$userRef_staff_id = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['staff_id']."'");
	$row_depts_staff_id = $userRef_staff_id->fetch(PDO::FETCH_ASSOC);


	$sql_date = 'UPDATE trial SET status= :status WHERE transaction_id = :transaction_id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
        'status' => "Approved",
		'transaction_id' => $transaction_id
    ]);

	$data_dept_notif = [
        'title'  => 'New transaction has been created by '. $_SESSION['name']. ' and the id is ' .$transaction_id. ' has been approved by Admin',
        'department_id' => $_SESSION['id'],
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
		'type'        => 'trial',
        'profile_img'  => $_SESSION['profile_img']
    ];

	$data_dept_notif_stmt_customer_id = [
        'title'  => 'New transaction has been created by '. $row_depts_customer_id['name']. ' and the id is ' .$transaction_id. ' has been approved by Admin',
        'department_id' => $row_depts_customer_id['id'],
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
		'type'        => 'journal',
        'profile_img'  => $row_depts_customer_id['profile_img']
    ];

	$data_dept_notif_stmt_staff_id = [
        'title'  => 'New transaction has been created by '. $row_depts_staff_id['name']. ' and the id is ' .$transaction_id. ' has been approved by Admin',
        'department_id' => $row_depts_staff_id['id'],
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
		'type'        => 'journal',
        'profile_img'  => $row_depts_staff_id['profile_img']
    ];

	$sql_dept_notif_customer_id = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
			VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
	$stmt_dept_notif_customer_id = $dbh->prepare($sql_dept_notif_customer_id);
	$stmt_dept_notif_customer_id->execute($data_dept_notif_stmt_customer_id);

	$sql_dept_notif_staff_id = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
			VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
	$stmt_dept_notif_staff_id = $dbh->prepare($sql_dept_notif_staff_id);
	$stmt_dept_notif_staff_id->execute($data_dept_notif_stmt_staff_id);

    echo '<script>alert("Update Success")</script>';
    $url = '../admin/trial';
    header('Location:'.$url);
}

if (isset($_GET['update_status_cash'])) {
    $transaction_id = $_GET['transaction_id'];

	$userRef_customer_id = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['customer_id']."'");
	$row_depts_customer_id = $userRef_customer_id->fetch(PDO::FETCH_ASSOC);

	$userRef_staff_id = $dbh->query("SELECT * FROM users WHERE id = '".$_GET['staff_id']."'");
	$row_depts_staff_id = $userRef_staff_id->fetch(PDO::FETCH_ASSOC);

	$sql_date = 'UPDATE `cash-flow-statement` SET status= :status WHERE transaction_id = :transaction_id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
        'status' => "Approved",
		'transaction_id' => $transaction_id
    ]);

	$data_dept_notif_stmt_customer_id = [
        'title'  => 'New transaction has been created by '. $row_depts_customer_id['name']. ' and the id is ' .$transaction_id. ' has been approved by Admin',
        'department_id' => $row_depts_customer_id['id'],
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
		'type'        => 'journal',
        'profile_img'  => $row_depts_customer_id['profile_img']
    ];

	$data_dept_notif_stmt_staff_id = [
        'title'  => 'New transaction has been created by '. $row_depts_staff_id['name']. ' and the id is ' .$transaction_id. ' has been approved by Admin',
        'department_id' => $row_depts_staff_id['id'],
        'request_id'    => $transaction_id,
        'status'        => 'unseen',
		'type'        => 'journal',
        'profile_img'  => $row_depts_staff_id['profile_img']
    ];

	$sql_dept_notif = "INSERT INTO `department_notification` ( `department_id`, `profile_img`, `request_id`, `status`, `title`, `type`) 
			VALUES (:department_id, :profile_img, :request_id, :status, :title, :type)";
	$stmt_dept_notif = $dbh->prepare($sql_dept_notif);
	$stmt_dept_notif->execute($data_dept_notif);

    echo '<script>alert("Update Success")</script>';
    $url = '../admin/cash-flow-statement';
    header('Location:'.$url);
}

if (isset($_GET['update_sale_forecast_staff'])) {
	$title = $_GET['title'];
    $customer_id = $_GET['customer_id'];
    $year = $_GET['year'];
    $transaction_id = $_GET['transaction_id'];

	$sql_date = 'UPDATE `cash-flow-statement` SET customer_id= :customer_id, title= :title, year= :year WHERE transaction_id = :transaction_id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
         'title'    => $title,
        'customer_id'  =>  $customer_id,
        'year'  =>  $year,
		'transaction_id' => $transaction_id
    ]);

	echo '<script>alert("Update Success")</script>';
    echo '<script>window.location.href="../staff/cash-flow-statement"</script>';
}

if (isset($_GET['update_transaction_ledger_staff'])) {
	$title = $_GET['title'];
    $customer_id = $_GET['customer_id'];
    $year = $_GET['year'];
    $transaction_id = $_GET['transaction_id'];

	$sql_date = 'UPDATE `ledger` SET customer_id= :customer_id, title= :title, year= :year WHERE transaction_id = :transaction_id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
         'title'    => $title,
        'customer_id'  =>  $customer_id,
        'year'  =>  $year,
		'transaction_id' => $transaction_id
    ]);

	echo '<script>alert("Update Success")</script>';
    echo '<script>window.location.href="../staff/ledger"</script>';
}

if (isset($_GET['update_transaction_trial_staff'])) {
	$title = $_GET['title'];
    $customer_id = $_GET['customer_id'];
    $year = $_GET['year'];
    $transaction_id = $_GET['transaction_id'];

	$sql_date = 'UPDATE `trial` SET customer_id= :customer_id, title= :title, year= :year WHERE transaction_id = :transaction_id';
    $stmt = $dbh->prepare($sql_date);

	$stmt->execute([
         'title'    => $title,
        'customer_id'  =>  $customer_id,
        'year'  =>  $year,
		'transaction_id' => $transaction_id
    ]);

	echo '<script>alert("Update Success")</script>';
    echo '<script>window.location.href="../staff/trial"</script>';
}

?>