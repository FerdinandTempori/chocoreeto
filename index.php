<?php 
require_once("cs_config/functions.php");

if (!empty($_POST)) {
	if (isset($_POST["user"])&& isset($_POST["password"])) {
		$result=verify_user_login($_POST["user"],$_POST["password"]);
		if($result==1){
			header("Location: AppManager.php");
			die();
		}else if($result==0){
		$globalMessage=array("Error de autenticación. Por favor intentelo de nuevo.","warning");
		}else if($result==-1){
			$globalMessage=array("Error al conectarse al servidor. Contacte al administrador.","danger");
		}
	}else{
		$globalMessage=array("Error de autenticación. Por favor intentelo de nuevo.","warning");
	}
 }

 if (isset($_GET['timeout'])) {
 	$globalMessage=array("La sesion ha expirado.","info");
 }

  ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content = "width=device-width, user-scalable= no, initial-scale=1, maximum-scale=1, minimum-scale=1">
	<title>Chocolate Shop</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mainStyle.css">
	<link rel="stylesheet" href="css/loginStyle.css">
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header navbar-left">
		      <a class="navbar-brand" href="#">
		        <img alt="logo" class="navbar-logo" src="resources/logo.png">
		      </a>
		    </div>

		</div>
	</nav>	
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

	<div class="container margin-top-50px">
		
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 ">
				<form id="login" action="" method="POST">	
					<div class="row">													
						<div class="col-xs-8 col-xs-offset-2 login-box">
							<div class="margin-top-50px"></div>	
							<div class="row">
								<div class="col-xs-12 col-md-4 col-md-offset-4">
									<img src="resources/logo.png" alt="logo" class="img img-responsive ">
								</div>
							</div>
							<div class="margin-top-50px"></div>
							<div class="row">
								<div class="col-xs-10 col-xs-offset-1">
									<div class="form-group">
										<label for="user"><span>Usuario</span></label>
										<input type="text" name="user" id="user" class="form-control">
	  								</div>
	  								<div class="form-group">
										<label for="password" ><span>Contraseña</span></label>
										<input type="password" name="password" id="password" class="form-control">
									</div>
									<div class="margin-top-25px"></div>
									<div class="row">
										<div class="col-xs-8 col-xs-offset-2">
											<button class="btn btn-success center-block btn-lg btn-fill" type="submit">Entrar</button>
										</div>										
									</div>
									<div class="margin-top-50px"></div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>
