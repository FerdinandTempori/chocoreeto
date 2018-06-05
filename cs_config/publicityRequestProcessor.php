<?php 
	if (isset($_POST['addPublicityBtn'])) {	
		$state=(isset($_POST['state'])?1:0);
		$globalMessage=create_publicity($_POST['position'],1,$_POST['redirect'],$state,$_FILES);
	}

 ?>