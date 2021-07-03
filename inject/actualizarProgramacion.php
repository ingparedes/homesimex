<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$server = "localhost";
$user = "root";
$pass = "";
$bd = "simexamerica";

$idMensaje = $_GET['idMensaje'];//1
$opcion = $_GET['opcion'];//1
if($opcion==1)
{
	$fecha=  date("Y/m/d H:i");
	$estado = 1;	
}
else{
	$fecha="2000-01-01 00:00:00";
	$estado = 0;

}
//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

//generamos la consulta
/*$sql = "
UPDATE 
`mensajes` 
SET 
`fechareal_start`= $fecha, estado = $estado
WHERE 
`id_inyect`=$idMensaje
";
*/
$sql = "UPDATE `simexamerica`.`mensajes` SET `fechareal_start` = '$fecha', `enviado` = '$estado' WHERE `id_inyect` = $idMensaje";

echo $sql;
mysqli_set_charset($conexion, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$result = mysqli_query($conexion,(string)$sql);
if(!$result){
	echo("Error description: " . mysqli_error($conexion));
	echo "hay un error en la base de datos";
	die();
}


    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  
header('Location:' . getenv('HTTP_REFERER'));

?>