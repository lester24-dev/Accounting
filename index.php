<?php
require __DIR__.'./db/firebaseDB.php';
require_once 'link.php';
checkFDUser();

?>

<div class="row">
	  	<?php
			require_once $content;	 
		?>
</div>