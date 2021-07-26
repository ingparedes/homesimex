<?php 

include("../config.php");
date_default_timezone_set('America/Bogota');
$idMensaje = $_GET['idMensaje'];//1
$sqlutc = "SELECT dif_horaria FROM mensajes WHERE id_inyect = '" . $idMensaje ."';";
$res_sql = mysqli_query($con, $sqlutc);
$sqlutc = mysqli_fetch_assoc($res_sql);

$opcion = $_GET['opcion'];//1
if($opcion==1)
{
	$fecha=  date('Y-m-d H:i:s');
	$minus = 300 + $sqlutc["dif_horaria"];
	$minutc = $minus.' minutes';
	$nuevafecha = strtotime ($minutc , strtotime($fecha)) ;
	$fechaSalidaFn	= date ( 'Y-m-d H:i:s' , $nuevafecha );
	$estado = 1;	
}
else{
	$fechaSalidaFn="2000-01-01 00:00:00";
	$estado = 0;

}

$sqlupdate = "UPDATE mensajes SET fechareal_start = '$fechaSalidaFn', enviado = $estado WHERE id_inyect = $idMensaje";

//echo $sql;
mysqli_set_charset($con, "utf8");
//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$result = mysqli_query($con, (string)$sqlupdate);
$eliminarEvent = mysqli_query($con,"DROP EVENT evento_$idMensaje");
$updatemsu = mysqli_query($con,"UPDATE mensajes_usuarios SET enviado = $estado WHERE id_mensaje = $idMensaje");

if(!$result){
	echo("Error description: " . mysqli_error($con));
	echo "hay un error en la base de datos";
	die();
}


    
//desconectamos la base de datos
$close = mysqli_close($con) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  
header('Location:' . getenv('HTTP_REFERER'));

?>