<?php 

include("../config.php");

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
mysqli_set_charset($con, "utf8");

//mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
$result = mysqli_query($con,(string)$sql);
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