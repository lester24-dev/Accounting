<?php


$view = (isset($_GET['v']) && $_GET['v'] != '') ? $_GET['v'] : '';

switch ($view) {
	case 'login' :
		$content 	= 'login.php';		
		$pageTitle 	= 'View Event Details';
		break;

	case 'register' :
		$content 	= 'register.php';		
		$pageTitle 	= 'Calendar';
		break;

    default :
		$content 	= 'login.php';		
		$pageTitle 	= 'Dashboard';    

}

?>