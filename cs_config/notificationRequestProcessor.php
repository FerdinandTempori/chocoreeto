<?php 
	if (isset($_POST['sendNotificationBtn'])) {	
		$globalMessage=send_notification($_POST['title'],$_POST['message'],'chocolate');
		if ($globalMessage[2]==0) {
			$a=create_notification($_POST['title'],$_POST['message'],'Fallado');
		}else{
			$a=create_notification($_POST['title'],$_POST['message'],'Completado');
		}
	}

 ?>