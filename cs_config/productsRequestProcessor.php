<?php 
	if (isset($_POST['addProductBtn'])) {		

		$globalMessage=create_product($_POST['name'],$_POST['description'],$_POST['price'],$_FILES);
	}
	if (isset($_POST['updateProductBtn'])) {		

		$globalMessage=update_product($_POST['id'],$_POST['name'],$_POST['description'],$_POST['price'],$_FILES['imageIcon']);
	}
 ?>