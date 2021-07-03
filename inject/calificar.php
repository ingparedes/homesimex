<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$server = "localhost";
$user = "root";
$pass = "";
$bd = "simexamerica";

$idMensaje = $_GET['idMensaje'];//1
$calificacion = $_GET['calificacion'];//1
$fecha=  date("Y/m/d H:i");
//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

//generamos la consulta
  
$existe = "SELECT id_mensaje FROM calificacion_mensajes WHERE id_mensaje =  $idMensaje ";
$res = mysqli_query($conexion,$existe);
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
mysqli_set_charset($conexion, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$result = mysqli_query($conexion,(string)$sql);
if(!$result){
	echo("Error description: " . mysqli_error($conexion));
	echo "hay un error en la base de datos";
	die();
		}
} else {

	$updatecali = " UPDATE `calificacion_mensajes` SET `id_calificacion` = $calificacion WHERE `id_mensaje` = $idMensaje";
	echo $updatecali;
	$resultup = mysqli_query($conexion,$updatecali);

	if(!$resultup){
		echo("Error description: " . mysqli_error($conexion));
		echo "hay un error en la base de datos";
		die();
				}


}


    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  
header('Location:' . getenv('HTTP_REFERER'));

?>