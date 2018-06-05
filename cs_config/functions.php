<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once("constants.php");

function init(){

	global $server;
	try {
		$dbh = new PDO ("mysql:host=$server[0];port=$server[4];dbname=$server[1];","$server[2]","$server[3]");
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->exec("SET CHARACTER SET utf8");
		return $dbh;
	} catch (PDOException $e) {
	  		return null;
	} catch (Exception $e) {
		return null;
	}
		
		
		
}


function verify_user_login($usr,$psw){
	$connection=init();
	if ($connection!=null) {
		try {
			$sql="CALL USP_CS_Admin_Login('".$usr."', '".$psw."');";
			$sqlob=$connection->prepare($sql);
			$sqlob->execute();
			$sqlob->setFetchMode(PDO::FETCH_ASSOC);
	  		$num= $sqlob->rowCount();
			if($num>0){
			   $r = $sqlob->fetch();
			   if (intval($r["result"])==1) {
			   	session_start();
				   $_SESSION["state"]="accept";
				   $_SESSION['session-time']=time();
				   $_SESSION['user']=array();
				   $_SESSION['user']["id"]=$r["id"];
				   $_SESSION['user']["name"]=$r["name"];
				   $_SESSION['user']["last"]=$r["last"];
			   }
			   
			   return intval($r["result"]);
			}
		} catch (PDOException $e) {
	  		return -1;
		} catch (Exception $e) {
			return -1;
		}
		
	}else{
		return -1;
	}
}

function get_session_state(){
	session_start();
	if ($_SESSION['state']!="accept" or !isset($_SESSION['state'])) {
		return 0;
	}
	return 1;
}


function is_accept_timeout(){
	global $timeout;
	$finaldate=get_session_time($_SESSION['session-time']);
	if($finaldate>=$timeout){
		session_start();
		session_destroy();
		return 0;
	}
	else{
		$_SESSION['session-time']=time();
		return 1;
	}
}

function get_session_time($time){
	$newtime = time();
	$finaldate=$newtime-$time;
	return $finaldate;
}


function get_response_object_generic(){
	$a= (object) [
    'type' => 0,
    'message' => '',
    'data'=>array(),
  ];
  return $a;
}


//Products

function get_product_list(){
	$conn=init();
	$sql="CALL USP_CS_Admin_Get_ProductList();";
	$sqlob=$conn->prepare($sql);
	$sqlob->execute();
	$sqlob->setFetchMode(PDO::FETCH_ASSOC);
	return $sqlob->fetchAll();
}


function get_product_by_id($id){
	$conn=init();
	$sql="CALL USP_CS_Admin_Get_ProductById('".$id."');";
	$sqlob=$conn->prepare($sql);
	$sqlob->execute();
	$sqlob->setFetchMode(PDO::FETCH_ASSOC);
	return $sqlob->fetchAll();
}


function create_product($name,$desc,$price,$imgs){
	try{
		$conn=init();
		$icon=save_image($imgs['imageIcon'],'cs_icons');
		$sql="CALL USP_CS_Admin_Create_Product('".$name."','".$desc."','".$price."','".$icon."',@id);";

		$sqlob=$conn->prepare($sql);

		if ($sqlob===FALSE) {

			return array("Error al crear el producto.","info");
		}
		if ($sqlob->execute() === TRUE) {
			$r = $conn->query("SELECT @id AS id")->fetch(PDO::FETCH_ASSOC);
    		
			$id=$r['id'];
			$asc=assoc_images_product($id,$imgs,$conn);	

			if ($asc=='true') {
				# code...
				return array("Producto añadido exitosamente.","success");
			}else{
				return array("Error al crear el producto. ","info");
			}
	    	
		} else {
		   return array("Error al crear el producto. ","info"); //. $conn->error;
		}
	} catch (PDOException $e) {
	   return array("Error al crear el producto. ","info");
	} catch (Exception $e) {
	   return array("Error al crear el producto. ","info");
	}
}


function update_product($id,$name,$desc,$price,$img){
	try{
		$conn=init();
		$icon=save_image($img,'cs_icons');
		$sql="CALL USP_CS_Admin_Update_Product('".$id."','".$name."','".$desc."','".$price."','".$icon."');";

		$sqlob=$conn->prepare($sql);

		if ($sqlob===FALSE) {

			return array("Error al actualizar el producto.","info");
		}
		if ($sqlob->execute() === TRUE) {

			return array("Producto actualizado exitosamente.","success");
			
		} else {
		   return array("Error al actualizar el producto. ","info"); //. $conn->error;
		}
	} catch (PDOException $e) {
	   return array("Error al actualizar el producto. ","info");
	} catch (Exception $e) {
	   return array("Error al actualizar el producto. ","info");
	}
}


function delete_product_by_id($id){
	try{
		$conn=init();
		$sql="CALL USP_CS_Admin_Delete_ProductById('".$id."');";
		$sqlob=$conn->prepare($sql);
		if ($sqlob===FALSE) {
			return array(0,"Error al dar de baja producto.");
		}
		if ($sqlob->execute() === TRUE) {
	    	return array(1,"Producto eliminado exitosamente.");
		} else {
		    return array(0,"Error al dar de baja producto."); //. $conn->error;
		}
	} catch (PDOException $e) {
	   return array(0,"Error al dar de baja producto.");
	} catch (Exception $e) {
	   return array(0,"Error al dar de baja producto.");
	}
}


//ProductsImage

function get_product_images_by_id($id){
	$conn=init();
	$sql="CALL USP_CS_Admin_Get_Images_ProductById('".$id."');";
	$sqlob=$conn->prepare($sql);
	$sqlob->execute();
	$sqlob->setFetchMode(PDO::FETCH_ASSOC);
	$imag=$sqlob->fetchAll();
	$images=array();
	foreach ($imag as $key) {
		array_push($images, $key['image']);
	}
	return $images;
}

function create_image_product_by_id($id,$img){
	try{
		$conn=init();
		$sql="CALL USP_CS_Admin_Create_Image_ProductById('".$id."','".$img."');";
		$sqlob=$conn->prepare($sql);
		if ($sqlob===FALSE) {
			return array(0,"Error añadir imagen del producto.");
		}
		if ($sqlob->execute() === TRUE) {
	    	return array(1,"Imagen del producto asociado exitosamente.");
		} else {
		    return array(0,"Error añadir imagen del producto."); //. $conn->error;
		}
	} catch (PDOException $e) {
	   return array(0,"Error añadir imagen del producto.");
	} catch (Exception $e) {
	   return array(0,"Error añadir imagen del producto.");
	}
}


function assoc_images_product($id,$files,$conn){

	foreach ($files as $key => $value) {

		if ($key=="imageIcon") {
			continue;
		}

		$img=save_image($value,'cs_icons');

		if ($img=='') {
			continue;
		}

		$sql="CALL USP_CS_Admin_Assoc_Images_Product('".$id."','".$img."');";

		$sqlob=$conn->prepare($sql);

		if ($sqlob===FALSE) {
			return 'false';
		}

		$sqlob->execute();
	}
	return 'true';
}


function save_image($file,$folder,$dir=""){
	$imglext=explode(".",$file['name']);
	$nameAssoc=$imglext[0];
	$imglext=$imglext[count($imglext)-1];
	$imglurl=$folder."/".$nameAssoc.date("Y-m-d-h-i-s").".".$imglext;
	if($file['name']!=''){
		move_uploaded_file($file['tmp_name'], $dir.$imglurl);
		return $imglurl;
	}
	return '';
}

function delete_image_product_by_id($id,$img){
	try{
		$conn=init();
		$sql="CALL USP_CS_Admin_Delete_Image_ProductById('".$id."','".$img."');";
		$sqlob=$conn->prepare($sql);
		if ($sqlob===FALSE) {
			return array(0,"Error eliminar imagen del producto.");
		}
		if ($sqlob->execute() === TRUE) {
	    	return array(1,"Imagen del producto eliminado exitosamente.");
		} else {
		    return array(0,"Error eliminar imagen del producto."); //. $conn->error;
		}
	} catch (PDOException $e) {
	   return array(0,"Error eliminar imagen del producto.");
	} catch (Exception $e) {
	   return array(0,"Error eliminar imagen del producto.");
	}
}



//Publicity


function get_publicity_list(){
	$conn=init();
	$sql="CALL USP_CS_Admin_Get_PublicityList();";
	$sqlob=$conn->prepare($sql);
	$sqlob->execute();
	$sqlob->setFetchMode(PDO::FETCH_ASSOC);
	return $sqlob->fetchAll();
}

function get_publicity_by_position($id){
	$conn=init();
	$sql="CALL USP_CS_Admin_Get_PublicityByPosition('".$id."');";
	$sqlob=$conn->prepare($sql);
	$sqlob->execute();
	$sqlob->setFetchMode(PDO::FETCH_ASSOC);
	return $sqlob->fetchAll();
}

function create_publicity($position,$typeR,$redirect,$state,$image){
	try{
		$conn=init();
		$icon=save_image($image['imageBanner'],'cs_banners');
		$sql="CALL USP_CS_Admin_Create_Publicity('".$position."','".$typeR."','".$redirect."','".$state."','".$icon."');";

		$sqlob=$conn->prepare($sql);

		if ($sqlob===FALSE) {

			return array("Error al crear publicidad.","info");
		}
		if ($sqlob->execute() === TRUE) {
			
			return array("Publicidad añadida exitosamente.","success");
			
	    	
		} else {
		   return array("Error al crear publicidad. ","info"); //. $conn->error;
		}
	} catch (PDOException $e) {
	   return array("Error al crear publicidad. ","info");
	} catch (Exception $e) {
	   return array("Error al crear publicidad. ","info");
	}
}




//Notifications


function get_notification_list(){
	$conn=init();
	$sql="CALL USP_CS_Admin_Get_NotificationList();";
	$sqlob=$conn->prepare($sql);
	$sqlob->execute();
	$sqlob->setFetchMode(PDO::FETCH_ASSOC);
	return $sqlob->fetchAll();
}

function create_notification($title,$body,$state){
	try{
		$conn=init();
		$sql="CALL USP_CS_Admin_Create_Notification('".$title."','".$body."','".$state."');";

		$sqlob=$conn->prepare($sql);

		if ($sqlob===FALSE) {

			return array(0,"Error al registrar notificacion.","info");
		}
		if ($sqlob->execute() === TRUE) {
			
			return array(0,"Notificacion registrada exitosamente.","success");
			
	    	
		} else {
		   return  array(0,"Error al registrar notificacion.","info"); //. $conn->error;
		}
	} catch (PDOException $e) {
	   return  array(0,"Error al registrar notificacion.","info");
	} catch (Exception $e) {
	   return  array(0,"Error al registrar notificacion.","info");
	}
}

function send_notification($title,$body,$topic){
	global $serverApiKey;
	global $senderId;
	     $msg = array
          (
		'body' 	=> $body,
		'title'	=> $title,
             	'icon'	=> 'myicon',/*Default Icon*/
              	'sound' => 'mySound'/*Default sound*/
          );
	$fields = array
			(
				'to'		=> '/topics/chocolate',
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' . $serverApiKey,
				'Sender: id='.$senderId,
				'Content-Type: application/json'
			);
	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
	$resultj=json_decode($result);


	if (isset($resultj->{'failure'})) {
		return array("Ocurrio un error al enviar la notificacion.","info",0);
	}else {
		return array("Notificacion enviada exitosamente.","success",1);
	}
}


 ?>