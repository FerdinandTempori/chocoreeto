
<?php 

session_start();
require_once("cs_config/functions.php");

if (get_session_State()==0) {
	header("Location: http://".$relURI."");
	die();
}

if (is_accept_timeout()==0) {	
	header("Location: http://".$relURI."?timeout");
	die();
}
if (!empty($_GET))
require_once("cs_config/".$_GET['p']."RequestProcessor.php");

 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content = "width=device-width, user-scalable= no, initial-scale=1, maximum-scale=1, minimum-scale=1">
	<title>Chocolate Shop App Manager</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/mainStyle.css">
<link rel="stylesheet" href="css/menuStyle.css">
<link rel="stylesheet" href="css/dropzone.css">
<link rel="stylesheet" href="css/<?php echo $_GET['p']; ?>Style.css">
</head>
<body>	
	<?php include_once("cs_components/menu.php"); ?>

	<div class="container body-content main">
		<div id="msg">
			<?php 
			//Mensaje de errores
			if (isset($globalMessage)): ?>
				<div class="alert alert-<?php echo $globalMessage[1] ?> alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <?php echo $globalMessage[0] ?>
				</div>
			<?php
			unset($globalMessage);
			 endif ?>
		</div>
	
		<?php 
		//inclusion de paginas
		if (empty($_GET)) {
			include_once("cs_pages/welcome.php");
		}else{
			include_once("cs_pages/".$_GET['p'].".php");
		}
		 ?>
		 
		<div class="margin-top-60px"></div>	
	</div>
	
	<div id="modals">
		
	</div>

<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>

<?php foreach ($partialScripts as $key => $value) {
	echo $value;
}; ?>
</body>
</html>
