<?php 

include("../config.php");

$idMensaje = $_GET['idMensaje'];//1
$calificacion = $_GET['calificacion'];//1
$fecha=  date("Y/m/d H:i");
//Creamos la conexión

//generamos la consulta
  
$existe = "SELECT id_mensaje FROM calificacion_mensajes WHERE id_mensaje =  $idMensaje ";
$res = mysqli_query($con,$existe);
$row1 = mysqli_fetch_array($res,MYSQLI_ASSOC);

if(count($row1)==0){
$sql = "
INSERT INTO calificacion_mensajes( 
	id_calificacion, 
	id_mensaje, 
	Fecha_calificacion) VALUES (
	$calificacion,
	$idMensaje,
	'$fecha'
	)
";
echo $sql;
mysqli_set_charset($con, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$result = mysqli_query($con,(string)$sql);
if(!$result){
	echo("Error description: " . mysqli_error($con));
	echo "hay un error en la base de datos";
	die();
		}
} else {

	$updatecali = " UPDATE `calificacion_mensajes` SET `id_calificacion` = $calificacion WHERE `id_mensaje` = $idMensaje";
	echo $updatecali;
	$resultup = mysqli_query($con,$updatecali);

	if(!$resultup){
		echo("Error description: " . mysqli_error($con));
		echo "hay un error en la base de datos";
		die();
				}


}


    
//desconectamos la base de datos
$close = mysqli_close($con) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  
header('Location:' . getenv('HTTP_REFERER'));

?>